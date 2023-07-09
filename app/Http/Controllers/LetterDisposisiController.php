<?php

namespace App\Http\Controllers;

use App\Models\Letter;
use Illuminate\Http\Request;

class LetterDisposisiController extends Controller
{

    public $intruksi;
    public function __construct()
    {

        $this->middleware('can:Letter Disposisi');

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
        $letter = Letter::with('disposisi.penerimas')->where('uuid', $uuid)->first();

        return view('pages.disposisi.letter.index', [
            'title' => 'Disposisi Personal',
            'letter' => $letter,
            'intruksi' => $this->intruksi
        ]);
    }

    public function update($uuid)
    {

        request()->validate([
            'sifat_surat' => ['required'],
            'intruksi' => ['required']
        ]);

        $letter = Letter::with('disposisi')->where('uuid', $uuid)->firstOrFail();
        if ($letter->disposisi) {
            $letter->disposisi()->update([
                'sifat_surat' => request('sifat_surat'),
                'intruksi' => request('intruksi')
            ]);
        } else {
            $letter->disposisi()->create([
                'sifat_surat' => request('sifat_surat'),
                'intruksi' => request('intruksi')
            ]);
        }

        return redirect()->back()->with('success', 'Disposisi berhasil disimpan.');
    }
}
