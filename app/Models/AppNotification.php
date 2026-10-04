<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppNotification extends Model
{
    protected $table = 'app_notifications';
    protected $guarded = [];

    protected function casts(): array
    {
        return ['read_at' => 'datetime'];
    }

    public function user() { return $this->belongsTo(User::class); }
    public function pelanggan() { return $this->belongsTo(PelangganPbpd::class); }
}
