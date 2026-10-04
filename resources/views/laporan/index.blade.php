@extends('layouts.app')
@section('title', 'Laporan')
@section('judul', 'Laporan')
@section('isi')
    <div class="grid statistik">
        <div class="stat-card"><small>Total Data</small><strong>{{ number_format($total, 0, ',', '.') }}</strong></div>
        @foreach ($perTahap as $tahap => $jumlah)<div class="stat-card"><small>{{ $tahap }}</small><strong>{{ number_format($jumlah, 0, ',', '.') }}</strong></div>@endforeach
    </div>
    <div class="box"><h3>Ringkasan Transaksi</h3><div class="ringkasan">
        @forelse ($perJenis as $jenis => $jumlah)<span>{{ $jenis }}: <b>{{ number_format($jumlah, 0, ',', '.') }}</b></span>@empty<span>Belum ada data.</span>@endforelse
    </div></div>
    <div class="box">
        <form class="filter" method="GET"><select name="tahap"><option value="">Semua tahap</option>@foreach ($tahapPilihan as $tahap)<option value="{{ $tahap }}" @selected(request('tahap') === $tahap)>{{ $tahap }}</option>@endforeach</select><select name="jenis"><option value="">Semua transaksi</option>@foreach ($jenisPilihan as $jenis)<option value="{{ $jenis }}" @selected(request('jenis') === $jenis)>{{ $jenis }}</option>@endforeach</select><button type="submit" class="btn">Filter</button></form>
        @php($showSyarat = auth()->user()->role?->type !== 'UP3')
        <div class="scroll"><table class="tabel tabel-biru"><thead>
            <tr><th rowspan="2">NO.</th><th rowspan="2">ASAL ULP</th><th rowspan="2">DETAIL</th>@if($showSyarat)<th colspan="2" class="grup">SYARAT</th>@endif<th rowspan="2">TRANSAKSI</th><th rowspan="2">STATUS</th><th rowspan="2">NO AGENDA</th><th rowspan="2">NAMA PELANGGAN</th><th rowspan="2">IDPEL</th><th rowspan="2">TOTAL BIAYA</th><th rowspan="2">TANGGAL MOHON</th><th rowspan="2">TANGGAL BAYAR</th><th colspan="2" class="grup">LAMA</th><th colspan="2" class="grup">BARU</th><th rowspan="2">DURASI HARI KERJA</th></tr>
            <tr>@if($showSyarat)<th class="sub">BERKAS PENDUKUNG</th><th class="sub">BERKAS IJIN</th>@endif<th class="sub">TARIF</th><th class="sub">DAYA</th><th class="sub">TARIF</th><th class="sub">DAYA</th></tr>
        </thead><tbody>
            @forelse ($data as $row)<tr><td>{{ $data->firstItem() + $loop->index }}.</td><td><b>{{ $row->asal_ulp }}</b></td><td><a class="detail-link" href="{{ route('pbpd.index', ['cari' => $row->no_agenda]) }}">📋</a></td>@if($showSyarat)<td>{{ count($row->berkas_pendukung_paths ?? []) ? '📎' : '-' }}</td><td>{{ count($row->berkas_ijin_paths ?? []) ? '📎' : '-' }}</td>@endif<td>{{ $row->jenis_transaksi }}</td><td>{{ $row->status }}</td><td>{{ $row->no_agenda }}</td><td>{{ $row->nama_pelanggan }}</td><td>{{ $row->id_pelanggan }}</td><td>{{ $row->total_biaya !== null ? number_format($row->total_biaya, 0, ',', '.') : '-' }}</td><td>{{ $row->tgl_mohon?->format('d/m/Y') ?? '-' }}</td><td>{{ $row->tgl_bayar?->format('d/m/Y') ?? '-' }}</td><td>{{ $row->tarif_lama }}</td><td>{{ $row->daya_lama }} VA</td><td><b>{{ $row->tarif_baru }}</b></td><td><b>{{ $row->daya_baru }} VA</b></td><td>{{ $row->keterangan }}</td></tr>@empty<tr><td colspan="{{ $showSyarat ? 19 : 17 }}" style="text-align:center">Belum ada data laporan.</td></tr>@endforelse
        </tbody></table></div><div class="halaman">{{ $data->links() }}</div>
    </div>
    <style>.statistik{margin-bottom:16px}.stat-card{padding:18px;border:1px solid #d6e2ee;border-radius:10px;background:#fff}.stat-card small,.stat-card strong{display:block}.stat-card small{color:#637487}.stat-card strong{margin-top:6px;font-size:24px;color:#0b3d6b}.ringkasan{display:flex;gap:10px;flex-wrap:wrap}.ringkasan span{padding:8px 12px;border-radius:6px;background:#eef5fb;color:#536477}.filter{display:flex;gap:10px;margin-bottom:16px}.filter select{padding:8px;border:1px solid #b9c7d5;border-radius:5px;background:#fff}.btn{background:#0b3d6b}.halaman{margin-top:16px}</style>
@endsection
