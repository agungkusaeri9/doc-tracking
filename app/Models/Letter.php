<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Letter extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $casts = [
        'tte_created' => 'datetime',
        'tanggal' => 'datetime'
    ];

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


    public function scopeInboxbyuserCount($query)
    {
        return $query->where('to_user_id', auth()->id())->count();
    }

    public function scopeOutboxbyuserCount($query)
    {
        return $query->where('from_user_id', auth()->id())->count();
    }


    public function to()
    {
        return $this->belongsTo(User::class, 'to_user_id', 'id');
    }

    public function from()
    {
        return $this->belongsTo(User::class, 'from_user_id', 'id');
    }

    public function tte_created_user()
    {
        return $this->belongsTo(User::class, 'tte_created_user_id', 'id');
    }

    public function qrcode()
    {
        return asset('storage/' . $this->qrcode);
    }

    public function disposisi()
    {
        return $this->hasOne(LetterDisposisi::class, 'letter_id', 'id');
    }
}
