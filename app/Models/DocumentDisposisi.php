<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentDisposisi extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function units()
    {
        return $this->hasMany(DocumentDisposisiUnit::class, 'document_disposisi_id', 'id');
    }
}
