<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
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
        return $query->where('to_unit_kerja_id',auth()->unit_kerja->id ?? 0);
    }
}
