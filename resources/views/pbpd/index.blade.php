@extends('layouts.app')

@section('title', 'Data PB/PD')
@section('judul', 'Data PB/PD')

@section('isi')
    @if (session('success'))
        <div class="box" style="color:#176b35">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="box" style="color:#a61b1b">{{ session('error') }}</div>
    @endif

    <form class="box filter" method="GET" action="{{ route('pbpd.index') }}">
        <input type="text" name="cari" value="{{ request('cari') }}"
               placeholder="Cari nama / no agenda / alamat">

        @if ($ulps->isNotEmpty())
            <select name="ulp">
                <option value="">Semua ULP</option>
                @foreach ($ulps as $u)
                    <option value="{{ $u->id }}" @selected(request('ulp') == $u->id)>{{ $u->nama }}</option>
                @endforeach
            </select>
        @endif

        <select name="jenis">
            <option value="">Semua jenis transaksi</option>
            <option value="PERUBAHAN DAYA" @selected(request('jenis') == 'PERUBAHAN DAYA')>Perubahan Daya</option>
            <option value="PASANG BARU" @selected(request('jenis') == 'PASANG BARU')>Pasang Baru</option>
            <option value="CETAK PK" @selected(request('jenis') == 'CETAK PK')>Cetak PK</option>
            <option value="PENGESAHAN PDL" @selected(request('jenis') == 'PENGESAHAN PDL')>Pengesahan PDL</option>
            <option value="PDL AWAL" @selected(request('jenis') == 'PDL AWAL')>PDL Awal</option>
        </select>

        <select name="status">
            <option value="">Semua status</option>
            @foreach ($statuss as $s)
                <option value="{{ $s }}" @selected(request('status') == $s)>{{ $s }}</option>
            @endforeach
        </select>

        <select name="tahap">
            <option value="">Semua tahap</option>
            @foreach ($tahaps as $t)
                <option value="{{ $t }}" @selected(request('tahap') == $t)>{{ $t }}</option>
            @endforeach
        </select>

        @if (request('import'))
            <input type="hidden" name="import" value="{{ request('import') }}">
            <span class="pill">File upload #{{ request('import') }}</span>
        @endif

        <button type="submit" class="btn">Filter</button>
        <a href="{{ route('pbpd.index') }}" class="btn btn-abu">Reset</a>
    </form>

    <div class="box kartu">
        <div class="kartu-judul">
            <span>RECORD, JUMLAH TRANSAKSI PB/PD</span>
            <span class="pill">{{ $data->total() }} data</span>
        </div>

        @if ($canKirim)
            <div style="display:flex;justify-content:flex-end;margin-bottom:12px">
                <button type="button" class="btn" id="openSendModal" disabled>Kirim data terpilih</button>
            </div>
        @endif

        <div class="scroll">
            <table class="tabel tabel-biru">
                <thead>
                    <tr>
                        @if ($canKirim)
                            <th rowspan="2"><input type="checkbox" id="checkAll" title="Pilih semua"></th>
                        @endif
                        <th rowspan="2">NO.</th>
                        <th rowspan="2">ASAL ULP</th>
                        <th rowspan="2">DETAIL</th>
                        <th colspan="2" class="grup">SYARAT</th>
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
                        <th class="sub">BERKAS PENDUKUNG</th>
                        <th class="sub">BERKAS IJIN</th>
                        <th class="sub">TARIF</th>
                        <th class="sub">DAYA</th>
                        <th class="sub">TARIF</th>
                        <th class="sub">DAYA</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $row)
                        <tr>
                            @if ($canKirim)
                                <td>
                                    <input type="checkbox" class="pilih-pbpd" value="{{ $row->id }}"
                                           @disabled($row->tahap !== 'ULP' || empty($row->berkas_pendukung_paths) || empty($row->berkas_ijin_paths))
                                </td>
                            @endif
                            <td>{{ $data->firstItem() + $loop->index }}.</td>
                            <td><b>{{ $row->asal_ulp }}</b></td>
                            <td>
                                <button
                                    type="button"
                                    class="ikon-dtl tombol-detail"
                                    title="Detail"
                                    data-id="{{ $row->id }}"
                                    data-rab-url="{{ route('pbpd.rab.update', $row->id) }}"
                                    data-no-agenda="{{ $row->no_agenda }}"
                                    data-idpel="{{ $row->id_pelanggan }}"
                                    data-nama="{{ $row->nama_pelanggan }}"
                                    data-alamat="{{ $row->alamat }}"
                                    data-transaksi="{{ $row->jenis_transaksi }}"
                                    data-status="{{ $row->status }}"
                                    data-bp="{{ $row->bp }}"
                                    data-total-biaya="{{ $row->total_biaya }}"
                                    data-tgl-mohon="{{ $row->tgl_mohon }}"
                                    data-tgl-bayar="{{ $row->tgl_bayar }}"
                                    data-rab="{{ $row->rab }}"
                                    data-pendukung-files="{{ base64_encode(json_encode($row->berkas_pendukung_paths ?? [])) }}"
                                    data-ijin-files="{{ base64_encode(json_encode($row->berkas_ijin_paths ?? [])) }}"
                                    data-pendukung-url="{{ route('pbpd.syarat.file', ['pelanggan' => $row->id, 'jenis' => 'pendukung', 'index' => 0]) }}"
                                    data-ijin-url="{{ route('pbpd.syarat.file', ['pelanggan' => $row->id, 'jenis' => 'ijin', 'index' => 0]) }}"
                                >📋</button>
                            </td>
                            <td><button type="button" class="ikon-syarat tombol-syarat" data-id="{{ $row->id }}" data-jenis="pendukung" data-files="{{ base64_encode(json_encode($row->berkas_pendukung_paths ?? [])) }}" data-file-url="{{ route('pbpd.syarat.file', ['pelanggan' => $row->id, 'jenis' => 'pendukung', 'index' => 0]) }}" title="Berkas Pendukung">📎</button></td>
                            <td><button type="button" class="ikon-syarat tombol-syarat" data-id="{{ $row->id }}" data-jenis="ijin" data-files="{{ base64_encode(json_encode($row->berkas_ijin_paths ?? [])) }}" data-file-url="{{ route('pbpd.syarat.file', ['pelanggan' => $row->id, 'jenis' => 'ijin', 'index' => 0]) }}" title="Berkas Ijin">📎</button></td>
                            <td>
                                <span class="pill pill-ungu">
                                    {{ [
                                        'PB' => 'Pasang Baru',
                                        'PD' => 'Perubahan Daya',
                                        'BN' => 'Balik Nama',
                                        'PASANG BARU' => 'Pasang Baru',
                                        'PERUBAHAN DAYA' => 'Perubahan Daya',
                                        'CETAK PK' => 'Cetak PK',
                                        'PENGESAHAN PDL' => 'Pengesahan PDL',
                                        'PDL AWAL' => 'PDL Awal',
                                    ][$row->jenis_transaksi] ?? $row->jenis_transaksi }}
                                </span>
                            </td>
                            <td>
                                <span class="pill {{ $row->status === 'BAYAR' ? 'pill-hijau' : 'pill-kuning' }}">
                                    {{ ucfirst(strtolower($row->status)) }}
                                </span>
                            </td>
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
                        <tr><td colspan="{{ $canKirim ? 19 : 18 }}" style="text-align:center">Tidak ada data.</td></tr>
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

    @if ($canKirim)
        <div id="sendModal" class="detail-modal" hidden>
            <div class="detail-modal-box" role="dialog" aria-modal="true" aria-labelledby="sendModalTitle">
                <button type="button" class="detail-modal-close" id="closeSendModal" aria-label="Tutup">&times;</button>
                <h3 id="sendModalTitle">Kirim data terpilih ke...</h3>
                <form method="POST" action="{{ route('pbpd.kirim') }}" id="sendForm">
                    @csrf
                    <div id="selectedPelanggan"></div>
                    <label for="tujuanKirim">Tujuan pengiriman</label>
                    <select name="tujuan" id="tujuanKirim" required style="width:100%;margin:8px 0 16px;padding:9px;border:1px solid #b9c7d5;border-radius:6px">
                        <option value="">Pilih tujuan</option>
                        <option value="JTM">Perluasan JTM</option>
                        <option value="JTR">Perluasan JTR</option>
                        <option value="TANPA_PERLUASAN">Tanpa Perluasan</option>
                    </select>
                    <div id="expansionNeeds" hidden>
                        <table class="kebutuhan-tabel">
                            <thead>
                                <tr><th>KETERANGAN</th><th>JENIS</th><th>JUMLAH</th><th>SATUAN</th></tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>JUMLAH TIANG</th>
                                    <td><select name="jenis_tiang"><option value="">Pilih</option><option>Beton</option><option>Besi</option><option>Lainnya</option></select></td>
                                    <td><input name="jml_tiang" type="number" min="0" placeholder="Isi jumlah sendiri"></td>
                                    <td>BUAH</td>
                                </tr>
                                <tr>
                                    <th>JUMLAH KONDUKTOR</th>
                                    <td><select name="jenis_konduktor"><option value="">Pilih</option><option>AAAC</option><option>BC</option><option>LVTC</option><option>Lainnya</option></select></td>
                                    <td><input name="jml_konduktor" type="number" min="0" placeholder="Isi jumlah meter"></td>
                                    <td>METER</td>
                                </tr>
                                <tr>
                                    <th>JUMLAH TRAFO</th>
                                    <td><select name="jenis_trafo"><option value="">Pilih</option><option>Distribusi</option><option>Portable</option><option>Lainnya</option></select></td>
                                    <td><input name="jml_trafo" type="number" min="0" placeholder="Isi jumlah sendiri"></td>
                                    <td>BUAH</td>
                                </tr>
                                <tr>
                                    <th>JUMLAH KWH METER</th>
                                    <td><select name="jenis_kwh_meter"><option value="">Pilih</option><option>Prabayar</option><option>Pascabayar</option><option>Lainnya</option></select></td>
                                    <td><input name="jml_kwh_meter" type="number" min="0" placeholder="Isi jumlah meter"></td>
                                    <td>METER</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <button type="submit" class="btn">Kirim sekarang</button>
                </form>
            </div>
        </div>
    @endif

    <div id="detailModal" class="detail-modal" hidden>
        <div class="detail-modal-box" role="dialog" aria-modal="true" aria-labelledby="detailModalTitle">
            <button type="button" class="detail-modal-close" aria-label="Tutup">&times;</button>
            <h3 id="detailModalTitle">Detail Data PB/PD</h3>

            <div class="detail-grid">
                <div><small>No Agenda</small><b id="detailNoAgenda"></b></div>
                <div><small>IDPEL</small><b id="detailIdpel"></b></div>
                <div><small>Nama Pelanggan</small><b id="detailNama"></b></div>
                <div><small>Transaksi</small><b id="detailTransaksi"></b></div>
                <div><small>Status</small><b id="detailStatus"></b></div>
                <div><small>BP (Total Biaya)</small><b id="detailBp"></b></div>
                <div><small>Total Biaya</small><b id="detailTotalBiaya"></b></div>
                <div><small>Tanggal Mohon</small><b id="detailTglMohon"></b></div>
                <div><small>Tanggal Bayar</small><b id="detailTglBayar"></b></div>
                <div><small>RAB</small><b id="detailRabValue"></b></div>
                <div class="detail-full"><small>Alamat</small><b id="detailAlamat"></b></div>
            </div>

            @if ($canEditRab)
                <form id="rabForm" method="POST" class="detail-rab-form">
                    @csrf
                    <label for="rabInput">RAB</label>
                    <div class="detail-rab-input">
                        <span>Rp</span>
                        <input id="rabInput" name="rab" type="number" min="0" step="0.01" placeholder="Masukkan RAB">
                    </div>
                    <button type="submit" class="btn">Simpan RAB</button>
                </form>
            @endif
        </div>
    </div>

    <div id="syaratModal" class="detail-modal" hidden>
        <div class="detail-modal-box" role="dialog" aria-modal="true" aria-labelledby="syaratModalTitle">
            <button type="button" class="detail-modal-close" id="closeSyaratModal" aria-label="Tutup">&times;</button>
            <h3 id="syaratModalTitle">Berkas Syarat</h3>
            <div id="syaratFiles" class="syarat-files">-</div>
            @if ($canUploadSyarat)
                <form id="syaratUploadForm" method="POST" action="#" enctype="multipart/form-data" class="syarat-upload-form">
                    @csrf
                    <input type="file" name="berkas[]" multiple required accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png">
                    <button type="submit" class="btn">Upload Berkas/Foto</button>
                </form>
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
        .kebutuhan-tabel { width:100%; margin:0 0 16px; border:1px solid #c8d6e5; border-radius:6px; overflow:hidden; font-size:12px; }
        .kebutuhan-tabel th, .kebutuhan-tabel td { padding:8px; border-bottom:1px solid #dce5ee; text-align:left; }
        .kebutuhan-tabel thead th { background:#eef3f8; color:#536477; }
        .kebutuhan-tabel tbody tr:last-child th, .kebutuhan-tabel tbody tr:last-child td { border-bottom:0; }
        .kebutuhan-tabel select, .kebutuhan-tabel input { width:100%; padding:6px; border:1px solid #c8d6e5; border-radius:4px; background:#fff8ee; }
        .ikon-syarat { padding:4px 8px; background:#e8eef5; color:#0b3d6b; }
        .syarat-files { display:grid; gap:8px; padding:12px; border:1px solid #d6e2ee; border-radius:6px; }
        .syarat-files a { color:#0b3d6b; overflow-wrap:anywhere; }
        .syarat-upload-form { display:flex; gap:10px; align-items:center; margin-top:16px; flex-wrap:wrap; }
        .syarat-upload-form input[type=file] { flex:1; min-width:220px; padding:8px; border:1px solid #b9c7d5; border-radius:6px; }
        @media (max-width:600px) { .detail-grid { grid-template-columns:1fr; } .detail-full { grid-column:auto; } .detail-rab-form { align-items:stretch; flex-direction:column; } }
    </style>

    <script>
        (() => {
            const modal = document.getElementById('detailModal');
            const rabForm = document.getElementById('rabForm');
            const setText = (id, value) => { document.getElementById(id).textContent = value || '-'; };

            document.querySelectorAll('.tombol-detail').forEach((button) => {
                button.addEventListener('click', () => {
                    setText('detailNoAgenda', button.dataset.noAgenda);
                    setText('detailIdpel', button.dataset.idpel);
                    setText('detailNama', button.dataset.nama);
                    setText('detailAlamat', button.dataset.alamat);
                    setText('detailTransaksi', button.dataset.transaksi);
                    setText('detailStatus', button.dataset.status);
                    setText('detailBp', button.dataset.bp ? Number(button.dataset.bp).toLocaleString('id-ID') : '-');
                    setText('detailTotalBiaya', button.dataset.totalBiaya ? Number(button.dataset.totalBiaya).toLocaleString('id-ID') : '-');
                    setText('detailTglMohon', button.dataset.tglMohon ? new Date(button.dataset.tglMohon).toLocaleDateString('id-ID') : '-');
                    setText('detailTglBayar', button.dataset.tglBayar ? new Date(button.dataset.tglBayar).toLocaleDateString('id-ID') : '-');
                    setText('detailRabValue', button.dataset.rab ? Number(button.dataset.rab).toLocaleString('id-ID') : '-');
                    if (rabForm) {
                        document.getElementById('rabInput').value = button.dataset.rab || '';
                        rabForm.action = button.dataset.rabUrl;
                    }
                    modal.hidden = false;
                });
            });

            const closeModal = () => { modal.hidden = true; };
            document.querySelector('#detailModal .detail-modal-close').addEventListener('click', closeModal);
            modal.addEventListener('click', (event) => { if (event.target === modal) closeModal(); });
            document.addEventListener('keydown', (event) => { if (event.key === 'Escape') closeModal(); });

            const syaratModal = document.getElementById('syaratModal');
            const syaratUploadForm = document.getElementById('syaratUploadForm');
            document.querySelectorAll('.tombol-syarat').forEach((button) => {
                button.addEventListener('click', () => {
                    const jenis = button.dataset.jenis;
                    document.getElementById('syaratModalTitle').textContent = jenis === 'ijin' ? 'Berkas Ijin' : 'Berkas Pendukung';
                    let files = [];
                    try { files = JSON.parse(button.dataset.files ? atob(button.dataset.files) : '[]'); } catch (error) { files = []; }
                    const filesBox = document.getElementById('syaratFiles');
                    filesBox.innerHTML = files.length
                        ? files.map((path, index) => `<a href="${button.dataset.fileUrl.replace(/\/0$/, '/' + index)}" target="_blank" rel="noopener">📄 ${String(path).split('/').pop() || 'Berkas ' + (index + 1)}</a>`).join('')
                        : '<span>Belum ada berkas.</span>';
                    if (syaratUploadForm) syaratUploadForm.action = `{{ url('/pbpd') }}/${button.dataset.id}/syarat/${jenis}`;
                    syaratModal.hidden = false;
                });
            });
            const closeSyaratModal = () => { syaratModal.hidden = true; };
            document.getElementById('closeSyaratModal').addEventListener('click', closeSyaratModal);
            syaratModal.addEventListener('click', (event) => { if (event.target === syaratModal) closeSyaratModal(); });

            const sendModal = document.getElementById('sendModal');
            const sendButton = document.getElementById('openSendModal');
            const checkAll = document.getElementById('checkAll');
            const checks = [...document.querySelectorAll('.pilih-pbpd')];
            const selectedPelanggan = document.getElementById('selectedPelanggan');
            const tujuanKirim = document.getElementById('tujuanKirim');
            const expansionNeeds = document.getElementById('expansionNeeds');
            const updateExpansionNeeds = () => {
                if (tujuanKirim && expansionNeeds) expansionNeeds.hidden = !['JTM', 'JTR'].includes(tujuanKirim.value);
            };
            if (tujuanKirim) tujuanKirim.addEventListener('change', updateExpansionNeeds);
            const updateSendButton = () => {
                if (sendButton) sendButton.disabled = !checks.some((check) => check.checked);
            };
            checks.forEach((check) => check.addEventListener('change', updateSendButton));
            if (checkAll) {
                checkAll.addEventListener('change', () => {
                    checks.filter((check) => !check.disabled).forEach((check) => { check.checked = checkAll.checked; });
                    updateSendButton();
                });
            }
            if (sendButton) {
                sendButton.addEventListener('click', () => {
                    selectedPelanggan.innerHTML = checks.filter((check) => check.checked)
                        .map((check) => `<input type="hidden" name="pelanggan[]" value="${check.value}">`).join('');
                    sendModal.hidden = false;
                });
                document.getElementById('closeSendModal').addEventListener('click', () => { sendModal.hidden = true; });
                sendModal.addEventListener('click', (event) => { if (event.target === sendModal) sendModal.hidden = true; });
            }
        })();
    </script>
@endsection
