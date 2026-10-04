<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImportExcel extends Model
{
    protected $table = 'import_excel';
    protected $guarded = [];

    // Schema hanya memiliki created_at, tidak memiliki updated_at.
    public const UPDATED_AT = null;
}
