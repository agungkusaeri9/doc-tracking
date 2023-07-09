<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $casts = [
        'tte_created' => 'datetime',
        'tte_visum_umum_created' => 'datetime',
        'tte_spd_created' => 'datetime'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function unit_kerja()
    {
        return $this->belongsTo(UnitKerja::class, 'to_unit_kerja_id', 'id');
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
        return $query->where('from_user_id', auth()->id());
    }

    public function scopeInboxbyuser($query)
    {
        return $query->where('to_unit_kerja_id', auth()->user()->unit_kerja->id ?? 0);
    }

    public function tte_created_user()
    {
        return $this->belongsTo(User::class, 'tte_created_user_id', 'id');
    }

    public function tte_visum_umum_created_user()
    {
        return $this->belongsTo(User::class, 'tte_visum_umum_created_user_id', 'id');
    }
    public function tte_spd_created_user()
    {
        return $this->belongsTo(User::class, 'tte_visum_umum_created_user_id', 'id');
    }

    public function qrcode()
    {
        return asset('storage/' . $this->qrcode);
    }

    public function qrcodeVisumUmum()
    {
        return asset('storage/' . $this->visum_umum_qrcode);
    }
    public function qrcodeSpd()
    {
        return asset('storage/' . $this->visum_umum_qrcode);
    }

    public static function getNewCode($category_id)
    {
        $latest = Document::latest()->first();
        $category = Category::findOrFail($category_id);
        if (!$latest) {
            $kode = '0001/PL42/' . $category->no_surat . '/' . Carbon::now()->format('Y');
        } else {
            $kode_lama = \Str::before($latest->no_surat, '/PL42');
            $kode_baru = str_pad($kode_lama + 1, 4, '0', STR_PAD_LEFT);
            $kode = $kode_baru . '/' . 'PL42/' . $category->code . '/' . Carbon::now()->format('Y');
        }

        return $kode;
    }

    public function disposisi()
    {
        return $this->hasOne(DocumentDisposisi::class, 'document_id', 'id');
    }
}
