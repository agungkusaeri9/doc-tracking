<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;

class DocumentDisposisiController extends Controller
{
    public $intruksi;
    public function __construct()
    {

        $this->middleware('can:Document Disposisi');

        $this->intruksi = $instruksi = [
            'Agar mewakili/Hadir undangan dengan',
            'Agendakan',
            'Ajukan Pendapat/Saran',
            'Arsip Elektronik',
            'Asii ke saya',
            'Catatkan/jadwalkan/ingatkan',
            'Diagendakan',
            'Dikoordinasikan',
            'Dipelajar',
            'Diperhatikan',
            'Disetujui',
            'Diteruskan',
            'Ditinjaklanjuti',
            'Setuju/ACC'
        ];
    }
    public function index($uuid)
    {
        $document = Document::with('disposisi.units')->where('uuid', $uuid)->first();

        return view('pages.disposisi.document.index', [
            'title' => 'Disposisi Personal',
            'document' => $document,
            'intruksi' => $this->intruksi
        ]);
    }

    public function update($uuid)
    {

        request()->validate([
            'sifat_surat' => ['required'],
            'intruksi' => ['required']
        ]);

        $document = Document::with('disposisi')->where('uuid', $uuid)->firstOrFail();
        if ($document->disposisi) {
            $document->disposisi()->update([
                'sifat_surat' => request('sifat_surat'),
                'intruksi' => request('intruksi')
            ]);
        } else {
            $document->disposisi()->create([
                'sifat_surat' => request('sifat_surat'),
                'intruksi' => request('intruksi')
            ]);
        }

        return redirect()->back()->with('success', 'Disposisi berhasil disimpan.');
    }
}
