<?php

namespace App\Imports;

use App\Models\PelangganPbpd;
use App\Models\Ulp;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class PelangganPbpdImport implements ToCollection
{
    public int $baru = 0;
    public int $diperbarui = 0;
    public array $gagal = [];

    public function __construct(private int $importId, private ?int $ulpDefault = null) {}

    public function collection(Collection $rows): void
    {
        $rows = $rows->map(fn($r) => $r->toArray())->values()->all();

        // 1. Cari baris header: baris pertama yang punya sel berisi "agenda"
        $h = null;
        foreach (array_slice($rows, 0, 20, true) as $i => $r) {
            foreach ($r as $c) {
                if (str_contains($this->k($c), 'agenda')) {
                    $h = $i;
                    break 2;
                }
            }
        }
        if ($h === null) {
            $this->gagal[] = 'Header "NO AGENDA" tidak ditemukan di 20 baris pertama file';
            return;
        }

        // 2. Susun nama kolom (mendukung header 2 baris: LAMA/BARU + TARIF/DAYA)
        $head = $rows[$h];
        $sub  = $rows[$h + 1] ?? [];
        $dua  = in_array('tarif', array_map(fn($c) => $this->k($c), $sub), true);

        $kolom = [];
        $grup  = '';
        foreach ($head as $c => $nama) {
            $n = $this->k($nama);
            if ($n !== '') {
                $grup = in_array($n, ['lama', 'baru'], true) ? $n : '';
            }
            $s = $this->k($sub[$c] ?? '');
            $kolom[$c] = ($dua && $grup && $s) ? $grup . $s : $n;
        }
        $mulai = $h + ($dua ? 2 : 1);

        $ulps = Ulp::all();

        // 3. Baca data
        foreach (array_slice($rows, $mulai, null, true) as $i => $r) {
            $d = [];
            foreach ($kolom as $c => $key) {
                if ($key !== '') $d[$key] = $r[$c] ?? null;
            }
            if (! array_filter($d, fn($v) => $v !== null && $v !== '')) continue; // baris kosong

            $baris = $i + 1; // nomor baris di Excel

            $noAgenda = $this->angka($this->ambil($d, ['noagenda', 'agenda', 'nomoragenda']));
            if (! $noAgenda) {
                $this->gagal[] = "Baris $baris: no agenda kosong";
                continue;
            }

            $teks = strtoupper(trim((string) $this->ambil($d, ['unittujuan', 'ulp', 'namaup'])));
            $ulp = $ulps->first(fn($u) => $u->kode === $teks
                || strtoupper($u->nama) === $teks
                || strtoupper($u->nama) === 'ULP ' . $teks);

            // cadangan: coba NAMAUP kalau UNITTUJUAN tidak cocok
            if (! $ulp) {
                $nm = strtoupper(trim((string) $this->ambil($d, ['namaup'])));
                $ulp = $ulps->first(fn($u) => strtoupper($u->nama) === $nm);
            }
            $ulpId = $ulp?->id ?? $this->ulpDefault;

            if (! $ulpId) {
                $this->gagal[] = "Baris $baris: ULP '$teks' tidak dikenali";
                continue;
            }

            $bayar = $this->ambil($d, ['tglbayar']);
            $jenis = $this->jenis($this->ambil($d, [
                'jenistransaksi', 'jenis', 'transaksi', 'jenislayanan',
            ]));
            $statusPermohonan = strtoupper(preg_replace(
                '/\s+/',
                ' ',
                trim((string) $this->ambil($d, ['statuspermohonan']))
            ));
            $statusTransaksi = ['CETAK PK', 'PENGESAHAN PDL', 'PDL AWAL'];
            $transaksi = $jenis;
            if ($jenis !== 'PS' && in_array($statusPermohonan, $statusTransaksi, true)) {
                $transaksi = $statusPermohonan;
            }

            $data = [
                'import_id'       => $this->importId,
                'ulp_id'          => $ulpId,
                'id_pelanggan'    => $this->angka($this->ambil($d, ['idpel'])),
                'bp'              => $this->angka($this->ambil($d, ['totalbiaya'])),
                'total_biaya'     => $this->angka($this->ambil($d, ['totalbiaya'])),
                'tgl_mohon'       => $this->tanggal($this->ambil($d, ['tglmohon'])),
                'tgl_bayar'       => $this->tanggal($bayar),
                'asal_ulp'        => preg_replace('/^ULP\s+/i', '', trim((string) $this->ambil($d, ['namaup']))) ?: null,
                'jenis_transaksi' => $transaksi,
                'status'          => $bayar ? 'BAYAR' : 'MOHON',
                'nama_pelanggan'  => $this->ambil($d, ['nama', 'namapelanggan']),
                'alamat'          => preg_replace('/\s+/', ' ', trim((string) $this->ambil($d, ['alamat']))) ?: null,
                'tarif_lama'      => $this->ambil($d, ['tariflama', 'lamatarif']),
                'daya_lama'       => $this->daya($this->ambil($d, ['dayalama', 'lamadaya'])),
                'tarif_baru'      => $this->ambil($d, ['tarif', 'tarifbaru', 'barutarif']),
                'daya_baru'       => $this->daya($this->ambil($d, ['daya', 'dayabaru', 'barudaya'])),
                'keterangan'      => $this->ambil($d, ['durasiharikerja', 'keterangan', 'ket']),
            ];

            $ada = PelangganPbpd::where('no_agenda', $noAgenda)->first();
            if ($ada) {
                $ada->update($data); // tahap tidak diubah
                $this->diperbarui++;
            } else {
                PelangganPbpd::create($data + ['no_agenda' => $noAgenda, 'tahap' => 'ULP']);
                $this->baru++;
            }
        }
    }

    /** "No. Agenda" -> "noagenda" */
    private function k($v): string
    {
        return preg_replace('/[^a-z0-9]/', '', strtolower((string) $v));
    }

    private function ambil(array $d, array $keys)
    {
        foreach ($keys as $key) {
            if (isset($d[$key]) && $d[$key] !== '') return $d[$key];
        }
        return null;
    }

    private function angka($v): ?string
    {
        if ($v === null || $v === '') return null;
        $s = is_numeric($v) ? sprintf('%.0f', $v) : preg_replace('/\D/', '', (string) $v);
        return $s === '' ? null : $s;
    }

    private function jenis($v): ?string
    {
        $v = strtoupper(preg_replace('/\s+/', ' ', trim((string) $v)));
        return match (true) {
            str_contains($v, 'BALIK') => 'BN',
            str_contains($v, 'PENGESAHAN') => 'PENGESAHAN PDL',
            str_contains($v, 'PDL AWAL') => 'PDL AWAL',
            str_contains($v, 'CETAK PK') => 'CETAK PK',
            str_contains($v, 'DAYA'), $v === 'PD' => 'PERUBAHAN DAYA',
            str_contains($v, 'SEMENTARA') => 'PS',
            str_contains($v, 'BARU'), $v === 'PB' => 'PASANG BARU',
            default => $v ?: null,
        };
    }

    private function daya($v): ?string
    {
        $v = preg_replace('/\D/', '', (string) $v);
        return $v === '' ? null : $v;
    }

    private function tanggal($v): ?string
    {
        if ($v instanceof \DateTimeInterface) return $v->format('Y-m-d');
        if ($v === null || trim((string) $v) === '') return null;

        $v = trim((string) $v);
        try {
            if (is_numeric($v)) {
                return ExcelDate::excelToDateTimeObject((float) $v)->format('Y-m-d');
            }

            return Carbon::createFromFormat('d/m/Y', $v)->format('Y-m-d');
        } catch (\Throwable) {
            try {
                return Carbon::parse($v)->format('Y-m-d');
            } catch (\Throwable) {
                return null;
            }
        }
    }
}
