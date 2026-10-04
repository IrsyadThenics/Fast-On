<?php

namespace App\Http\Controllers;

use App\Models\PelangganPbpd;

class DashboardController extends Controller
{
    public function index()
    {
        $ulpId = auth()->user()->ulpId();
        $base = PelangganPbpd::query()
            ->when($ulpId, fn ($q) => $q->where('ulp_id', $ulpId))
            ->where('status', '!=', 'MOHON')
            ->whereNotIn('jenis_transaksi', ['BN', 'BALIK NAMA', 'PS', 'PENERANGAN SEMENTARA']);

        $rows = (clone $base)->with('ulp')->latest('id')->get();
        $tahap = $rows->groupBy(fn ($row) => $row->tahap ?: 'BELUM DITENTUKAN')->map->count()->sortDesc();
        $tujuan = $rows->groupBy(fn ($row) => $row->tujuan_perluasan ?: 'BELUM DIKIRIM')->map->count()->sortDesc();
        $transaksi = $rows->groupBy(fn ($row) => $row->jenis_transaksi ?: 'LAINNYA')->map->count()->sortDesc();
        $ulp = $rows->groupBy(fn ($row) => $row->asal_ulp ?: 'TANPA ULP')->map->count()->sortDesc();

        return view('dashboard', [
            'total' => $rows->count(),
            'belumDiproses' => $rows->where('tahap', 'ULP')->count(),
            'perencanaan' => $rows->where('tahap', 'PERENCANAAN')->count(),
            'vendor' => $rows->whereIn('tahap', ['VENDOR_TIANG', 'VENDOR_KONSTRUKSI'])->count(),
            'selesai' => $rows->where('tahap', 'SELESAI')->count(),
            'tahap' => $tahap,
            'tujuan' => $tujuan,
            'transaksi' => $transaksi,
            'ulp' => $ulp,
            'terbaru' => $rows->take(8),
        ]);
    }
}
