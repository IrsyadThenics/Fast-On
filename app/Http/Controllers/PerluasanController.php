<?php

namespace App\Http\Controllers;

use App\Models\PelangganPbpd;
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
        $visibleTahaps = $role?->type === 'UP3'
            ? ['PERENCANAAN', 'VENDOR_TIANG', 'VENDOR_KONSTRUKSI']
            : ['PERENCANAAN'];
        $judul = match ($tujuan) {
            'JTM' => 'Perluasan JTM',
            'JTR' => 'Perluasan JTR',
            default => 'Tanpa Perluasan',
        };

        $data = PelangganPbpd::with(['ulp', 'permintaan', 'pengirimanVendor.vendor', 'laporanVendor', 'pengirimanKonstruksi.vendor'])
            ->whereIn('tahap', $visibleTahaps)
            ->where('tujuan_perluasan', $tujuan)
            ->when($ulpUser, fn ($q) => $q->where('ulp_id', $ulpUser))
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        $vendors = Vendor::with('user')->where('jenis', 'TIANG')->orderBy('nama')->get();
        $vendorsKonstruksi = Vendor::with('user')->where('jenis', 'KONSTRUKSI')->orderBy('nama')->get();

        return view('perluasan.index', compact('data', 'judul', 'tujuan', 'canEditRab', 'canEditMaterial', 'canViewMaterial', 'canSendVendor', 'canSendKonstruksi', 'canUploadTransaksi', 'canUploadJaringan', 'vendors', 'vendorsKonstruksi'));
    }
}
