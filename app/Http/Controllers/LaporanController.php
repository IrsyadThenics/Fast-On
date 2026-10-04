<?php

namespace App\Http\Controllers;

use App\Models\PelangganPbpd;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $ulpId = auth()->user()->ulpId();
        $base = PelangganPbpd::query()
            ->when($ulpId, fn ($q) => $q->where('ulp_id', $ulpId))
            ->where('tahap', '!=', 'ULP')
            ->whereNotIn('jenis_transaksi', ['BN', 'BALIK NAMA', 'PS', 'PENERANGAN SEMENTARA']);

        $data = (clone $base)->with('ulp')
            ->when($request->filled('tahap'), fn ($q) => $q->where('tahap', $request->tahap))
            ->when($request->filled('jenis'), fn ($q) => $q->where('jenis_transaksi', $request->jenis))
            ->orderByDesc('id')->paginate(30)->withQueryString();

        return view('laporan.index', [
            'data' => $data,
            'total' => (clone $base)->count(),
            'perTahap' => (clone $base)->selectRaw('tahap, COUNT(*) as jumlah')->groupBy('tahap')->orderBy('tahap')->pluck('jumlah', 'tahap'),
            'perJenis' => (clone $base)->selectRaw('jenis_transaksi, COUNT(*) as jumlah')->groupBy('jenis_transaksi')->orderBy('jenis_transaksi')->pluck('jumlah', 'jenis_transaksi'),
            'tahapPilihan' => (clone $base)->whereNotNull('tahap')->distinct()->orderBy('tahap')->pluck('tahap'),
            'jenisPilihan' => (clone $base)->whereNotNull('jenis_transaksi')->distinct()->orderBy('jenis_transaksi')->pluck('jenis_transaksi'),
        ]);
    }
}
