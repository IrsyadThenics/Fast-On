@extends('layouts.app')

@section('title', $judul)
@section('judul', $judul)

@section('isi')
    <div class="box kartu">
        <div class="kartu-judul">
            <span>DATA {{ strtoupper($judul) }}</span>
            <span class="pill">{{ $data->total() }} data</span>
        </div>

        <div class="scroll">
            <table class="tabel tabel-biru">
                <thead>
                    <tr>
                        <th rowspan="2"><input type="checkbox" title="Pilih semua"></th>
                        <th rowspan="2">NO.</th>
                        <th rowspan="2">ASAL ULP</th>
                        <th rowspan="2">DETAIL</th>
                        <th rowspan="2">TRANSAKSI</th>
                        <th rowspan="2">STATUS</th>
                        <th rowspan="2">NO AGENDA</th>
                        <th rowspan="2">NAMA PELANGGAN</th>
                        <th rowspan="2">IDPEL</th>
                        <th rowspan="2">TOTAL BIAYA</th>
                        <th rowspan="2">TANGGAL MOHON</th>
                        <th rowspan="2">TANGGAL BAYAR</th>
                        <th colspan="2" class="grup">LAMA</th>
                        <th colspan="2" class="grup">BARU</th>
                        <th rowspan="2">DURASI HARI KERJA</th>
                    </tr>
                    <tr>
                        <th class="sub">TARIF</th>
                        <th class="sub">DAYA</th>
                        <th class="sub">TARIF</th>
                        <th class="sub">DAYA</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $row)
                        @php $m = $row->permintaan; $pv = $row->pengirimanVendor; $pk = $row->pengirimanKonstruksi; @endphp
                        <tr>
                            <td><input type="checkbox" value="{{ $row->id }}"></td>
                            <td>{{ $data->firstItem() + $loop->index }}.</td>
                            <td><b>{{ $row->asal_ulp }}</b></td>
                            <td>
                                <button
                                    type="button"
                                    class="ikon-dtl tombol-detail-perluasan"
                                    title="Detail"
                                    data-id="{{ $row->id }}"
                                    data-rab-url="{{ route('pbpd.rab.update', $row->id) }}"
                                    data-vendor-url="{{ route('pbpd.vendor.send', $row->id) }}"
                                    data-report-file-url="{{ route('vendor.tiang.report.file', ['pelanggan' => $row->id, 'index' => 0]) }}"
                                    data-laporan-files="{{ base64_encode(json_encode($row->laporanVendor?->berkas_paths ?? [])) }}"
                                    data-result-file-url="{{ route('vendor.tiang.result.file', ['pelanggan' => $row->id, 'index' => 0]) }}"
                                    data-result-delete-url="{{ route('vendor.tiang.result.delete', ['pelanggan' => $row->id, 'index' => 0]) }}"
                                    data-result-files="{{ base64_encode(json_encode($row->laporanVendor?->berkas_hasil_paths ?? [])) }}"
                                    data-no-agenda="{{ $row->no_agenda }}"
                                    data-idpel="{{ $row->id_pelanggan }}"
                                    data-nama="{{ $row->nama_pelanggan }}"
                                    data-alamat="{{ $row->alamat }}"
                                    data-transaksi="{{ $row->jenis_transaksi }}"
                                    data-status="{{ $row->status }}"
                                    data-tahap="{{ $row->tahap }}"
                                    data-bp="{{ $row->bp }}"
                                    data-total-biaya="{{ $row->total_biaya }}"
                                    data-tgl-mohon="{{ $row->tgl_mohon }}"
                                    data-tgl-bayar="{{ $row->tgl_bayar }}"
                                    data-rab="{{ $row->rab }}"
                                    data-detail-url="{{ route('pbpd.detail.update', $row->id) }}"
                                    data-jenis-tiang="{{ $m?->jenis_tiang }}"
                                    data-jml-tiang="{{ $m?->jml_tiang }}"
                                    data-jenis-konduktor="{{ $m?->jenis_konduktor }}"
                                    data-jml-konduktor="{{ $m?->jml_konduktor }}"
                                    data-jenis-trafo="{{ $m?->jenis_trafo }}"
                                    data-jml-trafo="{{ $m?->jml_trafo }}"
                                    data-jenis-kwh-meter="{{ $m?->jenis_kwh_meter }}"
                                    data-jml-kwh-meter="{{ $m?->jml_kwh_meter }}"
                                    data-vendor-id="{{ $pv?->vendor_id }}"
                                    data-kelayakan="{{ $pv?->status_kelayakan }}"
                                    data-konstruksi-vendor="{{ $pk?->vendor?->nama }}"
                                    data-konstruksi-user="{{ $pk?->vendor?->user?->user_id }}"
                                    data-konstruksi-lengkap="{{ $pk?->pekerjaan_lengkap ? 'Ya' : 'Tidak' }}"
                                    data-konstruksi-sesuai="{{ $pk?->pekerjaan_sesuai_wo ? 'Ya' : 'Tidak' }}"
                                    data-konstruksi-foto="{{ $pk?->foto_terlampir ? 'Ya' : 'Tidak' }}"
                                    data-konstruksi-siap="{{ $pk?->siap_dilanjutkan ? 'Ya' : 'Tidak' }}"
                                    data-konstruksi-catatan="{{ $pk?->catatan }}"
                                    data-konstruksi-laporan-files="{{ base64_encode(json_encode($pk?->laporan_paths ?? [])) }}"
                                    data-konstruksi-laporan-file-url="{{ route('vendor.konstruksi.report.file', ['pelanggan' => $row->id, 'index' => 0]) }}"
                                    data-konstruksi-hasil-file-url="{{ route('vendor.konstruksi.result.file', ['pelanggan' => $row->id, 'index' => 0]) }}"
                                    data-konstruksi-hasil-konstruksi-files="{{ base64_encode(json_encode($row->hasil_konstruksi_paths ?? [])) }}"
                                    data-transaksi-hasil-file-url="{{ route('pbpd.transaksi.result.file', ['pelanggan' => $row->id, 'index' => 0]) }}"
                                    data-transaksi-hasil-files="{{ base64_encode(json_encode($row->hasil_transaksi_paths ?? [])) }}"
                                    data-jaringan-hasil-file-url="{{ route('pbpd.jaringan.result.file', ['pelanggan' => $row->id, 'index' => 0]) }}"
                                    data-jaringan-hasil-files="{{ base64_encode(json_encode($row->hasil_jaringan_paths ?? [])) }}"
                                    data-laporan-lengkap="{{ $row->laporanVendor?->pekerjaan_lengkap ? 'Ya' : 'Tidak' }}"
                                    data-laporan-sesuai="{{ $row->laporanVendor?->pekerjaan_sesuai_wo ? 'Ya' : 'Tidak' }}"
                                    data-laporan-foto="{{ $row->laporanVendor?->foto_terlampir ? 'Ya' : 'Tidak' }}"
                                    data-laporan-siap="{{ $row->laporanVendor?->siap_dilanjutkan ? 'Ya' : 'Tidak' }}"
                                    data-laporan-catatan="{{ $row->laporanVendor?->catatan }}"
                                    data-laporan-exists="{{ $row->laporanVendor ? '1' : '0' }}"
                                >📋</button>
                            </td>
                            <td>
                                <span class="pill pill-ungu">
                                    {{ [
                                        'PB' => 'Pasang Baru',
                                        'PD' => 'Perubahan Daya',
                                        'PASANG BARU' => 'Pasang Baru',
                                        'PERUBAHAN DAYA' => 'Perubahan Daya',
                                        'CETAK PK' => 'Cetak PK',
                                        'PENGESAHAN PDL' => 'Pengesahan PDL',
                                        'PDL AWAL' => 'PDL Awal',
                                    ][$row->jenis_transaksi] ?? $row->jenis_transaksi }}
                                </span>
                            </td>
                            <td><span class="pill pill-hijau">{{ ucfirst(strtolower($row->status)) }}</span></td>
                            <td>{{ $row->no_agenda }}</td>
                            <td>{{ $row->nama_pelanggan }}</td>
                            <td>{{ $row->id_pelanggan }}</td>
                            <td>{{ $row->total_biaya !== null ? number_format($row->total_biaya, 0, ',', '.') : '-' }}</td>
                            <td>{{ $row->tgl_mohon?->format('d/m/Y') ?? '-' }}</td>
                            <td>{{ $row->tgl_bayar?->format('d/m/Y') ?? '-' }}</td>
                            <td>{{ $row->tarif_lama }}</td>
                            <td>{{ $row->daya_lama }} VA</td>
                            <td><b>{{ $row->tarif_baru }}</b></td>
                            <td><b>{{ $row->daya_baru }} VA</b></td>
                            <td>{{ $row->keterangan }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="17" style="text-align:center">Belum ada data dikirim.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="kartu-kaki">
            Records {{ $data->firstItem() ?? 0 }} to {{ $data->lastItem() ?? 0 }} of {{ $data->total() }}
        </div>

        <div class="halaman">
            @if ($data->previousPageUrl())
                <a class="btn btn-abu" href="{{ $data->previousPageUrl() }}">« Sebelumnya</a>
            @endif
            <span>Halaman {{ $data->currentPage() }} dari {{ $data->lastPage() }}</span>
            @if ($data->nextPageUrl())
                <a class="btn btn-abu" href="{{ $data->nextPageUrl() }}">Berikutnya »</a>
            @endif
        </div>
    </div>

    <div id="detailModalPerluasan" class="detail-modal" hidden>
        <div class="detail-modal-box" role="dialog" aria-modal="true" aria-labelledby="detailModalPerluasanTitle">
            <button type="button" class="detail-modal-close" id="closeDetailPerluasan" aria-label="Tutup">&times;</button>
            <h3 id="detailModalPerluasanTitle">Detail Data PB/PD</h3>
            <div class="detail-grid">
                <div><small>No Agenda</small><b id="perluasanNoAgenda"></b></div>
                <div><small>IDPEL</small><b id="perluasanIdpel"></b></div>
                <div><small>Nama Pelanggan</small><b id="perluasanNama"></b></div>
                <div><small>Transaksi</small><b id="perluasanTransaksi"></b></div>
                <div><small>Status</small><b id="perluasanStatus"></b></div>
                <div><small>BP (Total Biaya)</small><b id="perluasanBp"></b></div>
                <div><small>Total Biaya</small><b id="perluasanTotalBiaya"></b></div>
                <div><small>Tanggal Mohon</small><b id="perluasanTglMohon"></b></div>
                <div><small>Tanggal Bayar</small><b id="perluasanTglBayar"></b></div>
                <div><small>RAB</small><b id="perluasanRabValue"></b></div>
                <div class="detail-full"><small>Alamat</small><b id="perluasanAlamat"></b></div>
            </div>
            @if ($canViewMaterial)
            @if ($canViewMaterial && $tujuan !== 'TANPA_PERLUASAN')
                <form id="detailFormPerluasan" method="POST">
                    @csrf
                    <div class="detail-edit-table">
                        <label>RAB <input id="rabInputPerluasan" name="rab" type="number" min="0" step="0.01" placeholder="Masukkan RAB" @disabled(!$canEditRab)></label>
                        <label>Jenis Tiang <select id="jenisTiangPerluasan" name="jenis_tiang" @disabled(!$canEditMaterial)><option value="">Pilih</option><option>Beton</option><option>Besi</option><option>Lainnya</option></select></label>
                        <label>Jumlah Tiang <input id="jmlTiangPerluasan" name="jml_tiang" type="number" min="0" @disabled(!$canEditMaterial)></label>
                        <label>Jenis Konduktor <select id="jenisKonduktorPerluasan" name="jenis_konduktor" @disabled(!$canEditMaterial)><option value="">Pilih</option><option>AAAC</option><option>BC</option><option>LVTC</option><option>Lainnya</option></select></label>
                        <label>Jumlah Konduktor <input id="jmlKonduktorPerluasan" name="jml_konduktor" type="number" min="0" @disabled(!$canEditMaterial)></label>
                        <label>Jenis Trafo <select id="jenisTrafoPerluasan" name="jenis_trafo" @disabled(!$canEditMaterial)><option value="">Pilih</option><option>Distribusi</option><option>Portable</option><option>Lainnya</option></select></label>
                        <label>Jumlah Trafo <input id="jmlTrafoPerluasan" name="jml_trafo" type="number" min="0" @disabled(!$canEditMaterial)></label>
                        <label>Jenis KWH Meter <select id="jenisKwhPerluasan" name="jenis_kwh_meter" @disabled(!$canEditMaterial)><option value="">Pilih</option><option>Prabayar</option><option>Pascabayar</option><option>Lainnya</option></select></label>
                        <label>Jumlah KWH Meter <input id="jmlKwhPerluasan" name="jml_kwh_meter" type="number" min="0" @disabled(!$canEditMaterial)></label>
                    </div>
                    @if ($canEditRab)
                        <button type="submit" class="btn">Simpan RAB &amp; Kebutuhan</button>
                    @endif
                </form>
            @endif

            @if ($canSendVendor)
                <form id="vendorFormPerluasan" method="POST" action="#" enctype="multipart/form-data" class="vendor-form">
                    @csrf
                    <h4>Kirim ke Vendor Tiang</h4>
                    <label>Tujuan kirim ke PT
                        <select id="vendorIdPerluasan" name="vendor_id" required>
                            <option value="">-- Pilih PT --</option>
                            @foreach ($vendors as $vendor)
                                <option value="{{ $vendor->id }}">{{ $vendor->nama }} ({{ $vendor->user?->user_id }})</option>
                            @endforeach
                        </select>
                    </label>
                    <div class="vendor-kelayakan">
                        <span>Status kelayakan</span>
                        <label><input type="radio" name="status_kelayakan" value="LAYAK" required> LAYAK</label>
                        <label><input type="radio" name="status_kelayakan" value="TIDAK LAYAK"> TIDAK LAYAK</label>
                    </div>
                    <label>Upload berkas WO tiang
                        <input type="file" name="wo_tiang" accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png">
                    </label>
                    <button type="submit" class="btn">⚠ Kirim ke Vendor</button>
                </form>
            @endif

            @if ($canSendKonstruksi)
                <form id="constructionForm" method="POST" action="#" enctype="multipart/form-data" class="vendor-form">
                    @csrf
                    <h4>Kirim ke Vendor Konstruksi</h4>
                    <label>Tujuan kirim ke PT
                        <select id="constructionVendorId" name="vendor_id" required>
                            <option value="">-- Pilih PT --</option>
                            @foreach ($vendorsKonstruksi as $vendor)
                                <option value="{{ $vendor->id }}">{{ $vendor->nama }} ({{ $vendor->user?->user_id }})</option>
                            @endforeach
                        </select>
                    </label>
                    <label>Upload berkas pengiriman
                        <input type="file" name="berkas[]" multiple required accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png">
                    </label>
                    <button type="submit" class="btn">Kirim ke Vendor Konstruksi</button>
                </form>
            @endif

            @if ($canSendVendor)
                <div class="vendor-report-result" id="vendorReportResult">
                    <h4>Laporan dari Vendor</h4>
                    <div><span>Dokumen pekerjaan lengkap</span><b id="laporanLengkap">-</b></div>
                    <div><span>Pekerjaan sesuai WO</span><b id="laporanSesuai">-</b></div>
                    <div><span>Foto dokumentasi terlampir</span><b id="laporanFoto">-</b></div>
                    <div><span>Siap ditindaklanjuti Perencanaan</span><b id="laporanSiap">-</b></div>
                    <div><span>Catatan</span><b id="laporanCatatan">-</b></div>
                    <div><span>Berkas laporan</span><b id="laporanFiles">-</b></div>
                </div>
            @endif
            @endif
            <div class="planning-result-box">
                <h4>Berkas Hasil Perencanaan</h4>
                <div id="resultFiles">-</div>
                @if ($canSendVendor)
                    <div id="resultWaitingMessage" class="result-waiting-message" hidden>Menunggu laporan dari vendor terlebih dahulu.</div>
                    <form id="resultUploadForm" method="POST" action="{{ request()->url() }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="pelanggan_id" id="resultPelangganId">
                        <input type="file" name="berkas_hasil[]" multiple required accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png">
                        <button type="submit" class="btn">Upload Berkas Hasil</button>
                    </form>
                @endif
            </div>
            <div class="planning-result-box construction-result-upload-box">
                <h4>Berkas Hasil Konstruksi</h4>
                <div id="constructionResultFiles">-</div>
                @if ($canSendKonstruksi)
                    <form id="constructionResultUploadForm" method="POST" action="#" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="berkas_hasil_konstruksi[]" multiple required accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png">
                        <button type="submit" class="btn">Upload Berkas/Foto Konstruksi</button>
                    </form>
                @endif
            </div>
            <div class="planning-result-box transaksi-result-upload-box">
                <h4>Berkas Hasil Transaksi</h4>
                <div id="transaksiResultFiles">-</div>
                @if ($canUploadTransaksi)
                    <form id="transaksiResultUploadForm" method="POST" action="#" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="berkas_hasil_transaksi[]" multiple required accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png">
                        <button type="submit" class="btn">Upload Berkas/Foto Transaksi</button>
                    </form>
                @endif
            </div>
            <div class="planning-result-box jaringan-result-upload-box">
                <h4>Berkas Hasil Jaringan</h4>
                <div id="jaringanResultFiles">-</div>
                @if ($canUploadJaringan && $tujuan !== 'TANPA_PERLUASAN')
                    <form id="jaringanResultUploadForm" method="POST" action="#" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="berkas_hasil_jaringan[]" multiple required accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png">
                        <button type="submit" class="btn">Upload Berkas/Foto Jaringan</button>
                    </form>
                @endif
            </div>
            @if ($canSendKonstruksi)
            <div class="construction-report-box" id="constructionReportBox">
                <h4>Laporan Hasil Pekerjaan Vendor Konstruksi</h4>
                <div class="detail-grid">
                    <div><small>Vendor</small><b id="constructionReportVendor">-</b></div>
                    <div><small>User Vendor</small><b id="constructionReportUser">-</b></div>
                    <div><small>Pekerjaan lengkap</small><b id="constructionReportLengkap">-</b></div>
                    <div><small>Pekerjaan sesuai WO</small><b id="constructionReportSesuai">-</b></div>
                    <div><small>Foto dokumentasi</small><b id="constructionReportFoto">-</b></div>
                    <div><small>Siap dilanjutkan</small><b id="constructionReportSiap">-</b></div>
                    <div class="detail-full"><small>Catatan</small><b id="constructionReportCatatan">-</b></div>
                    <div class="detail-full"><small>Berkas laporan</small><div id="constructionReportFiles">-</div></div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <style>
        .detail-modal { position:fixed; inset:0; z-index:20; display:grid; place-items:center; padding:20px; background:rgba(0,0,0,.45); }
        .detail-modal[hidden] { display:none; }
        .detail-modal-box { position:relative; width:min(620px, 100%); max-height:90vh; overflow:auto; padding:24px; border-radius:10px; background:#fff; box-shadow:0 12px 40px rgba(0,0,0,.25); }
        .detail-modal-box h3 { margin:0 0 18px; color:#0b3d6b; }
        .detail-modal-close { position:absolute; top:10px; right:10px; padding:2px 9px; background:#e8eef5; color:#223; font-size:20px; }
        .detail-grid { display:grid; grid-template-columns:repeat(2, minmax(0, 1fr)); gap:12px; }
        .detail-grid div { padding:10px; border:1px solid #d6e2ee; border-radius:6px; }
        .detail-grid small, .detail-grid b { display:block; }
        .detail-grid small { margin-bottom:4px; color:#637487; }
        .detail-grid b { overflow-wrap:anywhere; }
        .detail-full { grid-column:1 / -1; }
        .detail-rab-form { display:flex; align-items:end; gap:10px; margin-top:18px; }
        .detail-rab-form label { display:block; flex:1; font-weight:600; }
        .detail-rab-input { display:flex; align-items:center; margin-top:5px; border:1px solid #b9c7d5; border-radius:6px; overflow:hidden; }
        .detail-rab-input span { padding:8px; background:#eef3f8; }
        .detail-rab-input input { width:150px; padding:8px; border:0; outline:0; }
        .detail-edit-table { display:grid; grid-template-columns:repeat(2, minmax(0, 1fr)); gap:10px; margin:18px 0; }
        .detail-edit-table label { font-weight:600; color:#536477; }
        .detail-edit-table input, .detail-edit-table select { display:block; width:100%; margin-top:5px; padding:8px; border:1px solid #b9c7d5; border-radius:5px; background:#fff8ee; }
        .vendor-form { margin-top:20px; padding-top:16px; border-top:1px solid #d6e2ee; display:grid; gap:10px; }
        .vendor-form h4 { margin:0; color:#0b3d6b; }
        .vendor-form label { display:grid; gap:5px; font-weight:600; color:#536477; }
        .vendor-form select, .vendor-form input[type=file] { width:100%; padding:8px; border:1px solid #b9c7d5; border-radius:5px; background:#fff; }
        .vendor-kelayakan { display:flex; gap:12px; align-items:center; flex-wrap:wrap; color:#536477; }
        .vendor-kelayakan label { display:inline-flex; align-items:center; gap:4px; }
        .vendor-report-result { display:grid; gap:8px; margin-top:16px; padding:14px; border:1px solid #c8d6e5; border-radius:8px; background:#eef7ff; }
        .vendor-report-result h4 { margin:0 0 4px; color:#0b3d6b; }
        .vendor-report-result div { display:flex; justify-content:space-between; gap:12px; color:#536477; }
        .vendor-report-result b { color:#223; }
        .planning-result-box { display:grid; gap:10px; margin-top:16px; padding:14px; border:1px solid #c8d6e5; border-radius:8px; background:#f7fbff; }
        .planning-result-box h4 { margin:0; color:#0b3d6b; }
        .planning-result-box a { color:#0b3d6b; }
        .construction-report-box { display:grid; gap:10px; margin-top:16px; padding:14px; border:1px solid #c8d6e5; border-radius:8px; background:#f3f8ff; }
        .construction-report-box h4 { margin:0; color:#0b3d6b; }
        .construction-report-box a { color:#0b3d6b; }
        .planning-result-box input[type=file] { padding:8px; border:1px solid #b9c7d5; border-radius:6px; background:#fff; }
        .result-file-row { display:flex; align-items:center; justify-content:space-between; gap:10px; margin:4px 0; }
        .result-delete { padding:4px 8px; border:0; border-radius:4px; background:#a61b1b; color:#fff; cursor:pointer; font-size:12px; }
        .result-waiting-message { padding:10px; border-radius:6px; background:#fff5d6; color:#795900; }
        @media (max-width:600px) { .detail-grid { grid-template-columns:1fr; } .detail-full { grid-column:auto; } .detail-rab-form { align-items:stretch; flex-direction:column; } }
    </style>

    <script>
        (() => {
            const modal = document.getElementById('detailModalPerluasan');
            const form = document.getElementById('detailFormPerluasan');
            const vendorForm = document.getElementById('vendorFormPerluasan');
            const constructionForm = document.getElementById('constructionForm');
            const constructionResultUploadForm = document.getElementById('constructionResultUploadForm');
            const transaksiResultUploadForm = document.getElementById('transaksiResultUploadForm');
            const jaringanResultUploadForm = document.getElementById('jaringanResultUploadForm');
            const constructionReportBox = document.getElementById('constructionReportBox');
            const resultUploadForm = document.getElementById('resultUploadForm');
            const resultWaitingMessage = document.getElementById('resultWaitingMessage');
            const setText = (id, value) => { document.getElementById(id).textContent = value || '-'; };
            const money = (value) => value ? Number(value).toLocaleString('id-ID') : '-';
            const date = (value) => value ? new Date(value).toLocaleDateString('id-ID') : '-';

            document.querySelectorAll('.tombol-detail-perluasan').forEach((button) => {
                button.addEventListener('click', () => {
                    setText('perluasanNoAgenda', button.dataset.noAgenda);
                    setText('perluasanIdpel', button.dataset.idpel);
                    setText('perluasanNama', button.dataset.nama);
                    setText('perluasanAlamat', button.dataset.alamat);
                    setText('perluasanTransaksi', button.dataset.transaksi);
                    setText('perluasanStatus', button.dataset.status);
                    setText('perluasanBp', money(button.dataset.bp));
                    setText('perluasanTotalBiaya', money(button.dataset.totalBiaya));
                    setText('perluasanTglMohon', date(button.dataset.tglMohon));
                    setText('perluasanTglBayar', date(button.dataset.tglBayar));
                    setText('perluasanRabValue', money(button.dataset.rab));
                    modal.hidden = false;
                    if (resultUploadForm) document.getElementById('resultPelangganId').value = button.dataset.id;
                    if (form) {
                        document.getElementById('rabInputPerluasan').value = button.dataset.rab || '';
                        form.action = button.dataset.detailUrl;
                        document.getElementById('jenisTiangPerluasan').value = button.dataset.jenisTiang || '';
                        document.getElementById('jmlTiangPerluasan').value = button.dataset.jmlTiang || '';
                        document.getElementById('jenisKonduktorPerluasan').value = button.dataset.jenisKonduktor || '';
                        document.getElementById('jmlKonduktorPerluasan').value = button.dataset.jmlKonduktor || '';
                        document.getElementById('jenisTrafoPerluasan').value = button.dataset.jenisTrafo || '';
                        document.getElementById('jmlTrafoPerluasan').value = button.dataset.jmlTrafo || '';
                        document.getElementById('jenisKwhPerluasan').value = button.dataset.jenisKwhMeter || '';
                        document.getElementById('jmlKwhPerluasan').value = button.dataset.jmlKwhMeter || '';
                    }
                    if (vendorForm) {
                        vendorForm.hidden = button.dataset.tahap !== 'PERENCANAAN';
                        vendorForm.action = button.dataset.vendorUrl;
                        document.getElementById('vendorIdPerluasan').value = button.dataset.vendorId || '';
                        vendorForm.querySelectorAll('input[name="status_kelayakan"]').forEach((radio) => {
                            radio.checked = radio.value === button.dataset.kelayakan;
                        });
                    }
                    if (constructionForm) {
                        constructionForm.action = `{{ url('/pbpd') }}/${button.dataset.id}/kirim-konstruksi`;
                    }
                    let constructionResultFiles = [];
                    try { constructionResultFiles = JSON.parse(button.dataset.konstruksiHasilKonstruksiFiles ? atob(button.dataset.konstruksiHasilKonstruksiFiles) : '[]'); } catch (error) { constructionResultFiles = []; }
                    const constructionResultFilesBox = document.getElementById('constructionResultFiles');
                    if (constructionResultFilesBox) constructionResultFilesBox.innerHTML = constructionResultFiles.length
                        ? constructionResultFiles.map((path, index) => `<a href="${button.dataset.konstruksiHasilFileUrl.replace(/\/0$/, '/' + index)}" target="_blank" rel="noopener">📄 ${String(path).split('/').pop() || 'Berkas hasil konstruksi ' + (index + 1)}</a>`).join('<br>')
                        : '-';
                    if (constructionResultUploadForm) {
                        constructionResultUploadForm.action = `{{ url('/vendor/konstruksi') }}/${button.dataset.id}/hasil-konstruksi`;
                    }
                    let transaksiResultFiles = [];
                    try { transaksiResultFiles = JSON.parse(button.dataset.transaksiHasilFiles ? atob(button.dataset.transaksiHasilFiles) : '[]'); } catch (error) { transaksiResultFiles = []; }
                    const transaksiResultFilesBox = document.getElementById('transaksiResultFiles');
                    if (transaksiResultFilesBox) transaksiResultFilesBox.innerHTML = transaksiResultFiles.length
                        ? transaksiResultFiles.map((path, index) => `<a href="${button.dataset.transaksiHasilFileUrl.replace(/\/0$/, '/' + index)}" target="_blank" rel="noopener">📄 ${String(path).split('/').pop() || 'Berkas hasil transaksi ' + (index + 1)}</a>`).join('<br>')
                        : '-';
                    if (transaksiResultUploadForm) {
                        transaksiResultUploadForm.action = `{{ url('/pbpd') }}/${button.dataset.id}/hasil-transaksi`;
                    }
                    let jaringanResultFiles = [];
                    try { jaringanResultFiles = JSON.parse(button.dataset.jaringanHasilFiles ? atob(button.dataset.jaringanHasilFiles) : '[]'); } catch (error) { jaringanResultFiles = []; }
                    const jaringanResultFilesBox = document.getElementById('jaringanResultFiles');
                    if (jaringanResultFilesBox) jaringanResultFilesBox.innerHTML = jaringanResultFiles.length
                        ? jaringanResultFiles.map((path, index) => `<a href="${button.dataset.jaringanHasilFileUrl.replace(/\/0$/, '/' + index)}" target="_blank" rel="noopener">📄 ${String(path).split('/').pop() || 'Berkas hasil jaringan ' + (index + 1)}</a>`).join('<br>')
                        : '-';
                    if (jaringanResultUploadForm) {
                        jaringanResultUploadForm.action = `{{ url('/pbpd') }}/${button.dataset.id}/hasil-jaringan`;
                    }
                    if (constructionReportBox) {
                        setText('constructionReportVendor', button.dataset.konstruksiVendor);
                        setText('constructionReportUser', button.dataset.konstruksiUser);
                        setText('constructionReportLengkap', button.dataset.konstruksiLengkap);
                        setText('constructionReportSesuai', button.dataset.konstruksiSesuai);
                        setText('constructionReportFoto', button.dataset.konstruksiFoto);
                        setText('constructionReportSiap', button.dataset.konstruksiSiap);
                        setText('constructionReportCatatan', button.dataset.konstruksiCatatan);
                        let constructionReportFiles = [];
                        try { constructionReportFiles = JSON.parse(button.dataset.konstruksiLaporanFiles ? atob(button.dataset.konstruksiLaporanFiles) : '[]'); } catch (error) { constructionReportFiles = []; }
                        const constructionReportFilesBox = document.getElementById('constructionReportFiles');
                        if (constructionReportFilesBox) constructionReportFilesBox.innerHTML = constructionReportFiles.length
                            ? constructionReportFiles.map((path, index) => `<a href="${button.dataset.konstruksiLaporanFileUrl.replace(/\/0$/, '/' + index)}" target="_blank" rel="noopener">📄 ${String(path).split('/').pop() || 'Berkas laporan ' + (index + 1)}</a>`).join('<br>')
                            : '-';
                    }
                    const reportResult = document.getElementById('vendorReportResult');
                    if (reportResult) {
                        setText('laporanLengkap', button.dataset.laporanLengkap);
                        setText('laporanSesuai', button.dataset.laporanSesuai);
                        setText('laporanFoto', button.dataset.laporanFoto);
                        setText('laporanSiap', button.dataset.laporanSiap);
                        setText('laporanCatatan', button.dataset.laporanCatatan);
                        let files = [];
                        try { files = JSON.parse(button.dataset.laporanFiles ? atob(button.dataset.laporanFiles) : '[]'); } catch (error) { files = []; }
                        const filesBox = document.getElementById('laporanFiles');
                        if (filesBox) filesBox.innerHTML = files.length
                            ? files.map((path, index) => `<a href="${button.dataset.reportFileUrl.replace(/\/0$/, '/' + index)}" target="_blank">📄 Berkas laporan ${index + 1}</a>`).join('<br>')
                            : '-';
                    }
                    const resultFilesBox = document.getElementById('resultFiles');
                    let resultFiles = [];
                    try { resultFiles = JSON.parse(button.dataset.resultFiles ? atob(button.dataset.resultFiles) : '[]'); } catch (error) { resultFiles = []; }
                    if (resultFilesBox) resultFilesBox.innerHTML = resultFiles.length
                            ? resultFiles.map((path, index) => `<div class="result-file-row"><a href="${button.dataset.resultFileUrl.replace(/\/0$/, '/' + index)}" target="_blank">📄 Berkas hasil ${index + 1}</a>${resultUploadForm ? `<form method="POST" action="${button.dataset.resultDeleteUrl.replace(/\/0$/, '/' + index)}"><input type="hidden" name="_token" value="{{ csrf_token() }}"><button type="submit" class="result-delete" onclick="return confirm('Hapus berkas ini?')">Hapus</button></form>` : ''}</div>`).join('')
                            : '-';
                    if (resultUploadForm) {
                        const hasVendorReport = button.dataset.laporanExists === '1';
                        resultUploadForm.hidden = !hasVendorReport;
                        resultUploadForm.action = `{{ url('/vendor/tiang') }}/${button.dataset.id}/hasil`;
                        if (resultWaitingMessage) resultWaitingMessage.hidden = hasVendorReport;
                    }
                });
            });

            document.getElementById('closeDetailPerluasan').addEventListener('click', () => { modal.hidden = true; });
            modal.addEventListener('click', (event) => { if (event.target === modal) modal.hidden = true; });
            document.addEventListener('keydown', (event) => { if (event.key === 'Escape') modal.hidden = true; });
        })();
    </script>
@endsection
