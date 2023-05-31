<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $casts = [
        'tte_created' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function unit_kerja()
    {
        return $this->belongsTo(UnitKerja::class,'to_unit_kerja_id','id');
    }

    public function attachments()
    {
        return $this->hasMany(DocumentAttachment::class);
    }

    public function details()
    {
        return $this->hasMany(DocumentDetails::class);
    }

    public function scopeOutboxbyuser($query)
    {
        return $query->where('from_user_id',auth()->id());
    }

    public function scopeInboxbyuser($query)
    {
        return $query->where('to_unit_kerja_id',auth()->user()->unit_kerja->id ?? 0);
    }

    public function tte_created_user()
    {
        return $this->belongsTo(User::class, 'tte_created_user_id', 'id');
    }

    public function qrcode()
    {
        return asset('storage/' . $this->qrcode);
    }
}
