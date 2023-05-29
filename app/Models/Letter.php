<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Letter extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function attachments()
    {
        return $this->hasMany(LetterAttachments::class);
    }

    public function scopeOutboxbyuser($query)
    {
        return $query->where('from_user_id', auth()->id());
    }
    public function scopeInboxbyuser($query)
    {
        return $query->where('to_user_id', auth()->id());
    }

    public function to()
    {
        return $this->belongsTo(User::class,'to_user_id','id');
    }
}
