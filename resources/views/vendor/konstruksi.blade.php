@extends('layouts.app')
@section('title', 'Agenda Vendor Konstruksi')
@section('judul', 'Agenda Vendor Konstruksi')
@section('isi')
    @if (!$showHistory)
        <div class="box kartu">
            <div class="kartu-judul"><span>AGENDA VENDOR KONSTRUKSI</span><span class="pill">{{ $data->count() }} data</span></div>
            @forelse ($data as $row)
                <div class="vendor-card">
                    <b>{{ $row->no_agenda }}</b>
                    <strong>{{ $row->nama_pelanggan }}</strong>
                    <span>ULP: {{ $row->ulp?->nama }} · {{ $row->jenis_transaksi }}</span>
                    <div class="vendor-berkas">
                        <b>Berkas Pengiriman</b>
                        @foreach (($row->pengirimanKonstruksi?->berkas_paths ?? []) as $i => $path)
                            <span>📄 Berkas {{ $i + 1 }}</span>
                        @endforeach
                    </div>
                    <form class="vendor-report-form" method="POST" action="{{ route('vendor.konstruksi.report', $row->id) }}" enctype="multipart/form-data">
                        @csrf
                        <b>Kirim Laporan</b>
                        <label><input type="checkbox" name="pekerjaan_lengkap" value="1"> Dokumen pekerjaan lengkap</label>
                        <label><input type="checkbox" name="pekerjaan_sesuai_wo" value="1"> Pekerjaan sesuai WO</label>
                        <label><input type="checkbox" name="foto_terlampir" value="1"> Foto dokumentasi terlampir</label>
                        <label><input type="checkbox" name="siap_dilanjutkan" value="1"> Siap dilanjutkan</label>
                        <textarea name="catatan" placeholder="Catatan (opsional)"></textarea>
                        <input type="file" name="berkas_laporan[]" multiple required accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png">
                        <button type="submit" class="btn">Kirim Laporan</button>
                    </form>
                </div>
            @empty
                <div class="empty">Belum ada agenda vendor konstruksi.</div>
            @endforelse
        </div>
    @endif
    <div class="box kartu" @if (!$showHistory) hidden @endif>
        <div class="kartu-judul"><span>RIWAYAT PENGIRIMAN</span></div>
        @forelse ($riwayat as $row)
            @php($pengiriman = $row->pengirimanKonstruksi)
            <div class="history-item">
                <div>
                    <b>{{ $row->no_agenda }}</b>
                    <strong>{{ $row->nama_pelanggan }}</strong>
                    <span>ULP: {{ $row->ulp?->nama }}</span>
                    <form class="history-edit-form" method="POST" action="{{ route('vendor.konstruksi.report', $row->id) }}" enctype="multipart/form-data">
                        @csrf
                        <b>Edit Laporan</b>
                        <label><input type="checkbox" name="pekerjaan_lengkap" value="1" @checked($pengiriman?->pekerjaan_lengkap)> Dokumen lengkap</label>
                        <label><input type="checkbox" name="pekerjaan_sesuai_wo" value="1" @checked($pengiriman?->pekerjaan_sesuai_wo)> Pekerjaan sesuai WO</label>
                        <label><input type="checkbox" name="foto_terlampir" value="1" @checked($pengiriman?->foto_terlampir)> Foto terlampir</label>
                        <label><input type="checkbox" name="siap_dilanjutkan" value="1" @checked($pengiriman?->siap_dilanjutkan)> Siap dilanjutkan</label>
                        <textarea name="catatan" placeholder="Catatan">{{ $pengiriman?->catatan }}</textarea>
                        <input type="file" name="berkas_laporan[]" multiple accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png">
                        <button type="submit" class="btn">Simpan Perubahan</button>
                    </form>
                    <form method="POST" action="{{ route('vendor.konstruksi.report.delete', $row->id) }}" onsubmit="return confirm('Hapus laporan ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-hapus">Hapus Laporan</button>
                    </form>
                </div>
                <span class="pill pill-hijau">Terkirim</span>
            </div>
        @empty
            <div class="empty">Belum ada riwayat pengiriman.</div>
        @endforelse
    </div>
    <style>
        .vendor-card { margin-top:16px; padding:18px; border:1px solid #ccd8e5; border-radius:10px; background:#f8fbfe; }
        .vendor-card b,.vendor-card strong,.vendor-card>span { display:block; }.vendor-card strong{margin:5px 0;color:#0b3d6b}.vendor-card>span{color:#536477;font-size:13px}
        .vendor-berkas{display:grid;gap:8px;margin-top:14px;padding:14px;border:1px solid #ccd8e5;border-radius:8px;background:#fff}.empty{text-align:center;padding:28px;color:#637487}
        .vendor-report-form{display:grid;gap:8px;margin-top:14px;padding:14px;border:1px solid #ccd8e5;border-radius:8px;background:#fff}.vendor-report-form label{font-size:13px}.vendor-report-form textarea{min-height:70px;padding:8px;border:1px solid #ccd8e5;border-radius:5px}.vendor-report-form input[type=file]{padding:8px;border:1px solid #ccd8e5;border-radius:5px}
        .history-item{display:flex;justify-content:space-between;gap:16px;padding:14px 0;border-bottom:1px solid #dce5ee}.history-item b,.history-item strong,.history-item div span{display:block}.history-item strong{margin:4px 0;color:#0b3d6b}.history-item div span{color:#637487;font-size:13px}
        .history-edit-form{display:grid;gap:7px;margin-top:12px;padding:12px;border:1px solid #ccd8e5;border-radius:8px;background:#f8fbfe}.history-edit-form textarea{min-height:60px;padding:7px;border:1px solid #ccd8e5;border-radius:5px}.history-edit-form input[type=file]{padding:6px;border:1px solid #ccd8e5;border-radius:5px}.btn-hapus{margin-top:8px;background:#a61b1b!important}
    </style>
@endsection
