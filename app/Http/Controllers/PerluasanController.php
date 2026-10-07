<?php

namespace App\Http\Controllers;

use App\Models\PelangganPbpd;
use App\Models\Ulp;
use App\Models\Vendor;
use Illuminate\Http\Request;

class PerluasanController extends Controller
{
    public function index(Request $request, string $tujuan)
    {
        abort_unless(in_array($tujuan, ['JTM', 'JTR', 'TANPA_PERLUASAN'], true), 404);

        $ulpUser = auth()->user()->ulpId();
        $role = auth()->user()->role;
        $canEditRab = (bool) $role?->ulp_id || $role?->role_code === '5180REN';
        $canEditMaterial = (bool) $role?->ulp_id;
        $canSendVendor = $role?->role_code === '5180REN';
        $canSendKonstruksi = $role?->role_code === '5180KON';
        $canUploadTransaksi = $role?->role_code === '5180TEL';
        $canUploadJaringan = $role?->role_code === '5180JAR';
        $canViewMaterial = $canEditRab || in_array($role?->role_code, ['5180KON', '5180TEL', '5180JAR'], true);
        // ULP tetap melihat data miliknya setelah diteruskan ke tahap/vendor berikutnya.
        $visibleTahaps = in_array($role?->type, ['UP3', 'ULP'], true)
            ? ['PERENCANAAN', 'VENDOR_TIANG', 'VENDOR_KONSTRUKSI']
            : ['PERENCANAAN'];
        $judul = match ($tujuan) {
            'JTM' => 'Perluasan JTM',
            'JTR' => 'Perluasan JTR',
            default => 'Tanpa Perluasan',
        };

        $query = PelangganPbpd::with(['ulp', 'permintaan', 'pengirimanVendor.vendor', 'laporanVendor', 'pengirimanKonstruksi.vendor'])
            ->whereIn('tahap', $visibleTahaps)
            // Data lama bisa tersimpan dengan spasi, sedangkan kiriman baru
            // menggunakan underscore. Samakan format saat ditampilkan.
            ->whereRaw("UPPER(REPLACE(tujuan_perluasan, ' ', '_')) = ?", [$tujuan])
            ->when($ulpUser, fn ($q) => $q->where('ulp_id', $ulpUser))
            ->when($request->filled('cari'), function ($q) use ($request) {
                $term = '%' . $request->input('cari') . '%';
                $q->where(function ($inner) use ($term) {
                    $inner->where('no_agenda', 'like', $term)
                        ->orWhere('id_pelanggan', 'like', $term)
                        ->orWhere('nama_pelanggan', 'like', $term)
                        ->orWhere('alamat', 'like', $term);
                });
            })
            ->when($request->filled('ulp'), fn ($q) => $q->where('ulp_id', $request->input('ulp')))
            ->when($request->filled('jenis'), fn ($q) => $q->where('jenis_transaksi', $request->input('jenis')))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->input('status')))
            ->when($request->filled('tahap'), fn ($q) => $q->where('tahap', $request->input('tahap')));

        $data = (clone $query)->orderByDesc('id')->paginate(20)
            ->withQueryString();

        $ulps = $ulpUser
            ? Ulp::whereKey($ulpUser)->get()
            : Ulp::orderBy('nama')->get();
        $jenisPilihan = (clone $query)->select('jenis_transaksi')->whereNotNull('jenis_transaksi')->distinct()->orderBy('jenis_transaksi')->pluck('jenis_transaksi');
        $statusPilihan = (clone $query)->select('status')->whereNotNull('status')->distinct()->orderBy('status')->pluck('status');
        $tahapPilihan = collect($visibleTahaps);

        $vendors = Vendor::with('user')->where('jenis', 'TIANG')->orderBy('nama')->get();
        $vendorsKonstruksi = Vendor::with('user')->where('jenis', 'KONSTRUKSI')->orderBy('nama')->get();

        return view('perluasan.index', compact('data', 'judul', 'tujuan', 'canEditRab', 'canEditMaterial', 'canViewMaterial', 'canSendVendor', 'canSendKonstruksi', 'canUploadTransaksi', 'canUploadJaringan', 'vendors', 'vendorsKonstruksi', 'ulps', 'jenisPilihan', 'statusPilihan', 'tahapPilihan'));
    }
}
