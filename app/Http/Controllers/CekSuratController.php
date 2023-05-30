<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Letter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class CekSuratController extends Controller
{
    public function umum()
    {
        // $id= Crypt::decryptString($id_encrypt);
        // $item = Letter::findOrFail($id);
        $item = Letter::first();
        return view('pages.landing.cek-surat-umum',[
            'title' => 'Detail Surat Umum',
            'item' => $item
        ]);
    }

    public function khusus()
    {
        // $id= Crypt::decryptString($id_encrypt);
        // $item = Document::findOrFail($id);
        $item = Document::first();
        return view('pages.landing.cek-surat-khusus',[
            'title' => 'Detail Surat Khusus',
            'item' => $item
        ]);
    }
}
