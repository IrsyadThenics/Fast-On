<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PelangganPbpd extends Model
{
    protected $table = 'pelanggan_pbpd';
    protected $guarded = [];

    // Schema hanya memiliki created_at, tidak memiliki updated_at.
    public const UPDATED_AT = null;

    protected function casts(): array
    {
        return [
            'bp' => 'decimal:2',
            'rab' => 'decimal:2',
            'total_biaya' => 'decimal:2',
            'tgl_mohon' => 'date',
            'tgl_bayar' => 'date',
            'hasil_konstruksi_paths' => 'array',
            'hasil_transaksi_paths' => 'array',
            'hasil_jaringan_paths' => 'array',
            'berkas_pendukung_paths' => 'array',
            'berkas_ijin_paths' => 'array',
            'hasil_konstruksi_at' => 'datetime',
            'hasil_transaksi_at' => 'datetime',
            'hasil_jaringan_at' => 'datetime',
        ];
    }

    public function ulp()         { return $this->belongsTo(Ulp::class); }
    public function permintaan()  { return $this->hasOne(PermintaanMaterial::class, 'pelanggan_id'); }
    public function pengirimanVendor() { return $this->hasOne(PengirimanVendor::class, 'pelanggan_id'); }
    public function laporanVendor() { return $this->hasOne(LaporanVendor::class, 'pelanggan_id'); }
    public function pengirimanKonstruksi() { return $this->hasOne(PengirimanKonstruksi::class, 'pelanggan_id'); }
    public function perencanaan() { return $this->hasOne(PerencanaanData::class, 'pelanggan_id'); }
    public function konstruksi()  { return $this->hasOne(KonstruksiData::class, 'pelanggan_id'); }
    public function checklist()   { return $this->hasMany(ChecklistVendor::class, 'pelanggan_id'); }
    public function berkas()      { return $this->hasMany(Berkas::class, 'pelanggan_id'); }
    public function riwayat()     { return $this->hasMany(RiwayatTahap::class, 'pelanggan_id'); }

    /** Pindah tahap sekaligus mencatat riwayatnya. */
    public function pindahTahap(string $ke, ?int $userId = null): void
    {
        $dari = $this->tahap;
        $this->update(['tahap' => $ke]);
        $this->riwayat()->create(['dari_tahap' => $dari, 'ke_tahap' => $ke, 'oleh' => $userId]);
    }
}
