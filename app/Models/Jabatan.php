<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function unit_kerja()
    {
        return $this->belongsTo(UnitKerja::class,'unit_kerja_id','id');
    }
}
