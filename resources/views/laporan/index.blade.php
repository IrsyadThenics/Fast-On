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
        <div class="scroll"><table class="tabel tabel-biru"><thead><tr><th>NO AGENDA</th><th>ASAL ULP</th><th>NAMA PELANGGAN</th><th>TRANSAKSI</th><th>STATUS</th><th>TAHAP</th><th>TOTAL BIAYA</th></tr></thead><tbody>
            @forelse ($data as $row)<tr><td>{{ $row->no_agenda }}</td><td>{{ $row->asal_ulp }}</td><td>{{ $row->nama_pelanggan }}</td><td>{{ $row->jenis_transaksi }}</td><td>{{ $row->status }}</td><td>{{ $row->tahap }}</td><td>{{ $row->total_biaya !== null ? number_format($row->total_biaya, 0, ',', '.') : '-' }}</td></tr>@empty<tr><td colspan="7" style="text-align:center">Belum ada data laporan.</td></tr>@endforelse
        </tbody></table></div><div class="halaman">{{ $data->links() }}</div>
    </div>
    <style>.statistik{margin-bottom:16px}.stat-card{padding:18px;border:1px solid #d6e2ee;border-radius:10px;background:#fff}.stat-card small,.stat-card strong{display:block}.stat-card small{color:#637487}.stat-card strong{margin-top:6px;font-size:24px;color:#0b3d6b}.ringkasan{display:flex;gap:10px;flex-wrap:wrap}.ringkasan span{padding:8px 12px;border-radius:6px;background:#eef5fb;color:#536477}.filter{display:flex;gap:10px;margin-bottom:16px}.filter select{padding:8px;border:1px solid #b9c7d5;border-radius:5px;background:#fff}.btn{background:#0b3d6b}.halaman{margin-top:16px}</style>
@endsection
