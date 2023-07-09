<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LetterDisposisi extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function penerimas()
    {
        return $this->hasMany(LetterDisposisiUser::class, 'letter_disposisi_id', 'id');
    }
}
