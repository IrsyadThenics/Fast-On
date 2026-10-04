<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermintaanMaterial extends Model
{
    protected $table = 'permintaan_material';
    protected $guarded = [];
    public $timestamps = false;

    protected function casts(): array
    {
        return ['dikirim_at' => 'datetime'];
    }

    public function pelanggan()
    {
        return $this->belongsTo(PelangganPbpd::class, 'pelanggan_id');
    }
}
