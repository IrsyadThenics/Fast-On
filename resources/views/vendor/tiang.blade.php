@extends('layouts.app')

@section('title', 'Agenda Vendor Tiang')
@section('judul', 'Agenda Vendor Tiang')

@section('isi')
    @if (session('success'))
        <div class="box" style="color:#176b35">{{ session('success') }}</div>
    @endif

    @if (!$showHistory)
    <div class="box kartu">
        <div class="kartu-judul">
            <span>AGENDA VENDOR TIANG</span>
            <span class="pill">{{ $data->count() }} data</span>
        </div>

        @forelse ($data as $row)
            @php $kirim = $row->pengirimanVendor; @endphp
            <div class="vendor-card">
                <div class="vendor-card-head">
                    <div>
                        <b>{{ $row->no_agenda }}</b>
                        <strong>{{ $row->nama_pelanggan }}</strong>
                        <span>ULP: {{ $row->ulp?->nama }} - {{ $row->jenis_transaksi }}</span>
                    </div>
                    <span class="pill pill-ungu">{{ $row->jenis_transaksi }}</span>
                </div>

                <div class="vendor-berkas">
                    <b>Berkas Pekerjaan</b>
                    @if ($kirim?->wo_tiang_path)
                        <a href="{{ route('vendor.tiang.wo', $row->id) }}" target="_blank">📄 WO Tiang</a>
                    @else
                        <span>Belum ada berkas WO tiang.</span>
                    @endif
                </div>

                <form method="POST" action="{{ route('vendor.tiang.report', $row->id) }}" enctype="multipart/form-data" class="vendor-report">
                    @csrf
                    <b>Kirim Laporan</b>
                    <label><input type="checkbox" name="pekerjaan_lengkap" value="1"> Dokumen pekerjaan lengkap</label>
                    <label><input type="checkbox" name="pekerjaan_sesuai_wo" value="1"> Pekerjaan sesuai WO</label>
                    <label><input type="checkbox" name="foto_terlampir" value="1"> Foto dokumentasi terlampir</label>
                    <label><input type="checkbox" name="siap_dilanjutkan" value="1"> Siap ditindaklanjuti Perencanaan</label>
                    <textarea name="catatan" placeholder="Catatan (opsional)"></textarea>
                    <input type="file" name="berkas[]" multiple accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png">
                    <button type="submit" class="btn">Kirim ke Perencanaan</button>
                </form>
            </div>
        @empty
            <div style="text-align:center;padding:30px">Belum ada agenda vendor tiang.</div>
        @endforelse
    </div>
    @endif

    <div id="historyPanel" class="box history-panel" @if (!$showHistory) hidden @endif>
        <div class="kartu-judul">
            <span>RIWAYAT PENGIRIMAN</span>
            <button type="button" class="history-close" id="closeHistory">Tutup</button>
        </div>
        @forelse ($riwayat as $row)
            @php $laporan = $row->laporanVendor; @endphp
            <div class="history-item">
                <div>
                    <b>{{ $row->no_agenda }}</b>
                    <strong>{{ $row->nama_pelanggan }}</strong>
                    <span>ULP: {{ $row->ulp?->nama }} · {{ $laporan?->dikirim_at?->format('d/m/Y H:i') }}</span>
                </div>
                <span class="pill pill-hijau">Terkirim ke Perencanaan</span>
            </div>
            <form method="POST" action="{{ route('vendor.tiang.report', $row->id) }}" enctype="multipart/form-data" class="history-edit-form">
                @csrf
                <b>Edit Laporan</b>
                <label><input type="checkbox" name="pekerjaan_lengkap" value="1" @checked($laporan?->pekerjaan_lengkap)> Dokumen pekerjaan lengkap</label>
                <label><input type="checkbox" name="pekerjaan_sesuai_wo" value="1" @checked($laporan?->pekerjaan_sesuai_wo)> Pekerjaan sesuai WO</label>
                <label><input type="checkbox" name="foto_terlampir" value="1" @checked($laporan?->foto_terlampir)> Foto dokumentasi terlampir</label>
                <label><input type="checkbox" name="siap_dilanjutkan" value="1" @checked($laporan?->siap_dilanjutkan)> Siap ditindaklanjuti Perencanaan</label>
                <textarea name="catatan" placeholder="Catatan (opsional)">{{ $laporan?->catatan }}</textarea>
                <input type="file" name="berkas[]" multiple accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png">
                <button type="submit" class="btn">Simpan Perubahan</button>
            </form>
        @empty
            <div style="text-align:center;padding:24px">Belum ada riwayat pengiriman.</div>
        @endforelse
    </div>

    <style>
        .vendor-card { margin-top:16px; padding:18px; border:1px solid #ccd8e5; border-radius:10px; background:#f8fbfe; }
        .vendor-card-head { display:flex; justify-content:space-between; gap:16px; padding-bottom:14px; border-bottom:1px solid #dce5ee; }
        .vendor-card-head b, .vendor-card-head strong, .vendor-card-head span { display:block; }
        .vendor-card-head strong { margin:5px 0; color:#0b3d6b; }
        .vendor-card-head span { color:#536477; font-size:13px; }
        .vendor-berkas, .vendor-report { display:grid; gap:10px; margin-top:14px; padding:16px; border:1px solid #ccd8e5; border-radius:8px; background:#fff; }
        .vendor-berkas a { padding:10px; border-radius:6px; background:#eef3f8; color:#0b3d6b; text-decoration:none; }
        .vendor-berkas span { color:#718096; font-size:13px; }
        .vendor-report label { color:#536477; font-size:13px; }
        .vendor-report textarea { min-height:70px; padding:9px; border:1px solid #b9c7d5; border-radius:6px; }
        .vendor-report input[type=file] { padding:8px; border:1px solid #b9c7d5; border-radius:6px; }
        .history-button { float:right; margin-top:-48px; padding:9px 14px; border:0; border-radius:8px; background:#2947a8; color:#fff; cursor:pointer; }
        .history-panel { margin-top:16px; }
        .history-panel[hidden] { display:none; }
        .history-close { padding:6px 10px; border:0; border-radius:6px; background:#e8eef5; color:#223; cursor:pointer; }
        .history-item { display:flex; justify-content:space-between; align-items:center; gap:16px; padding:14px 0; border-bottom:1px solid #dce5ee; }
        .history-item:last-child { border-bottom:0; }
        .history-item b, .history-item strong, .history-item span { display:block; }
        .history-item strong { margin:4px 0; color:#0b3d6b; }
        .history-item div span { color:#637487; font-size:13px; }
        .history-edit-form { display:grid; gap:9px; margin:0 0 16px; padding:14px; border:1px solid #dce5ee; border-radius:8px; background:#fff; }
        .history-edit-form label { color:#536477; font-size:13px; }
        .history-edit-form textarea { min-height:60px; padding:9px; border:1px solid #b9c7d5; border-radius:6px; }
        .history-edit-form input[type=file] { padding:8px; border:1px solid #b9c7d5; border-radius:6px; }
        @media (max-width:600px) { .history-button { float:none; margin:12px 0 0; } .history-item { align-items:flex-start; flex-direction:column; } }
    </style>
    <script>
        (() => {
            const panel = document.getElementById('historyPanel');
            const openHistory = document.getElementById('openHistory');
            if (openHistory) openHistory.addEventListener('click', () => { panel.hidden = false; panel.scrollIntoView({ behavior: 'smooth' }); });
            document.getElementById('closeHistory').addEventListener('click', () => { panel.hidden = true; });
        })();
    </script>
@endsection
