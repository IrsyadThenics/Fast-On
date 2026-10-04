@extends('layouts.app')
@section('title', 'Dashboard')
@section('judul', 'Dashboard')
@section('isi')
    <div class="dashboard-intro">
        <div><h2>Dashboard {{ auth()->user()->role?->type === 'ULP' && auth()->user()->role?->ulp?->nama ? auth()->user()->role?->ulp?->nama : 'UP3' }}</h2><p>Ringkasan data dan progres PB/PD yang menjadi tanggung jawab Anda.</p></div>
        <a href="{{ route('laporan') }}" class="dashboard-action">Lihat Laporan</a>
    </div>

    <div class="dashboard-cards">
        <div class="dashboard-card"><small>Total Data</small><strong>{{ number_format($total, 0, ',', '.') }}</strong><span>Data dalam cakupan Anda</span></div>
        <div class="dashboard-card warning"><small>Belum Diproses ULP</small><strong>{{ number_format($belumDiproses, 0, ',', '.') }}</strong><span>Masih menunggu pengiriman</span></div>
        <div class="dashboard-card info"><small>Perencanaan</small><strong>{{ number_format($perencanaan, 0, ',', '.') }}</strong><span>Sedang diproses</span></div>
        <div class="dashboard-card vendor"><small>Di Vendor</small><strong>{{ number_format($vendor, 0, ',', '.') }}</strong><span>Vendor tiang/konstruksi</span></div>
        <div class="dashboard-card success"><small>Selesai</small><strong>{{ number_format($selesai, 0, ',', '.') }}</strong><span>Proses selesai</span></div>
    </div>

    <div class="dashboard-columns">
        <div class="box"><h3>Progres Tahap</h3>@forelse($tahap as $nama => $jumlah)<div class="bar-row"><div><span>{{ $nama }}</span><b>{{ $jumlah }}</b></div><i><em style="width:{{ $total ? round($jumlah / $total * 100, 1) : 0 }}%"></em></i></div>@empty<p>Belum ada data.</p>@endforelse</div>
        <div class="box"><h3>Tujuan Perluasan</h3>@forelse($tujuan as $nama => $jumlah)<div class="summary-row"><span>{{ str_replace('_', ' ', $nama) }}</span><b>{{ $jumlah }}</b></div>@empty<p>Belum ada data.</p>@endforelse</div>
        <div class="box"><h3>Jenis Transaksi</h3>@forelse($transaksi as $nama => $jumlah)<div class="summary-row"><span>{{ $nama }}</span><b>{{ $jumlah }}</b></div>@empty<p>Belum ada data.</p>@endforelse</div>
        @if (auth()->user()->role?->type === 'UP3')<div class="box"><h3>Data per ULP</h3>@forelse($ulp as $nama => $jumlah)<div class="summary-row"><span>{{ $nama }}</span><b>{{ $jumlah }}</b></div>@empty<p>Belum ada data.</p>@endforelse</div>@endif
    </div>

    <div class="box"><div class="section-head"><h3>Data Terbaru</h3><a href="{{ route('pbpd.index') }}">Buka Data PB/PD</a></div><div class="scroll"><table class="tabel tabel-biru dashboard-table"><thead><tr><th>NO AGENDA</th><th>ASAL ULP</th><th>NAMA PELANGGAN</th><th>TRANSAKSI</th><th>TAHAP</th><th>TUJUAN</th></tr></thead><tbody>@forelse($terbaru as $row)<tr><td>{{ $row->no_agenda }}</td><td>{{ $row->asal_ulp }}</td><td>{{ $row->nama_pelanggan }}</td><td>{{ $row->jenis_transaksi }}</td><td><span class="stage-pill">{{ $row->tahap }}</span></td><td>{{ str_replace('_', ' ', $row->tujuan_perluasan ?: '-') }}</td></tr>@empty<tr><td colspan="6" class="empty-cell">Belum ada data.</td></tr>@endforelse</tbody></table></div></div>

    <style>.dashboard-intro{display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:18px;padding:20px 22px;border-radius:10px;background:#0b3d6b;color:#fff}.dashboard-intro h2{margin:0 0 5px}.dashboard-intro p{margin:0;color:#cfe2f3}.dashboard-action{padding:9px 14px;border-radius:6px;background:#fff;color:#0b3d6b;text-decoration:none;font-weight:600;white-space:nowrap}.dashboard-cards{display:grid;grid-template-columns:repeat(5,minmax(0,1fr));gap:12px;margin-bottom:16px}.dashboard-card{padding:16px;border:1px solid #cfe0ef;border-top:4px solid #0b5ea8;border-radius:9px;background:#fff}.dashboard-card.warning{border-top-color:#d88a00}.dashboard-card.info{border-top-color:#2779b9}.dashboard-card.vendor{border-top-color:#7652a8}.dashboard-card.success{border-top-color:#159447}.dashboard-card small,.dashboard-card strong,.dashboard-card span{display:block}.dashboard-card small{color:#637487}.dashboard-card strong{margin:6px 0;font-size:27px;color:#0b3d6b}.dashboard-card span{font-size:12px;color:#7a8997}.dashboard-columns{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:14px}.dashboard-columns .box{margin-bottom:0}.dashboard-columns h3,.section-head h3{margin-top:0;color:#0b3d6b}.bar-row,.summary-row{margin:10px 0}.bar-row>div,.summary-row{display:flex;justify-content:space-between;gap:10px;font-size:13px}.bar-row b,.summary-row b{color:#0b3d6b}.bar-row i{display:block;height:7px;margin-top:5px;border-radius:5px;background:#e5edf4;overflow:hidden}.bar-row em{display:block;height:100%;border-radius:5px;background:#0b5ea8}.section-head{display:flex;align-items:center;justify-content:space-between;gap:12px}.section-head a{color:#0b5ea8;font-weight:600}.stage-pill{display:inline-block;padding:3px 7px;border-radius:10px;background:#eaf4fc;color:#0b3d6b;font-size:11px;font-weight:600}.empty-cell{text-align:center}@media(max-width:1100px){.dashboard-cards{grid-template-columns:repeat(3,minmax(0,1fr))}.dashboard-columns{grid-template-columns:repeat(2,minmax(0,1fr))}}@media(max-width:650px){.dashboard-intro{align-items:flex-start;flex-direction:column}.dashboard-cards,.dashboard-columns{grid-template-columns:1fr}.section-head{align-items:flex-start;flex-direction:column}}</style>
@endsection
