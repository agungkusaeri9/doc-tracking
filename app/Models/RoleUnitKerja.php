<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class RoleUnitKerja extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
