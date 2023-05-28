<?php

namespace App\Http\Controllers;

use App\Models\Letter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LetterController extends Controller
{
    public function create()
    {
        $users = User::whereNotIn('id', [auth()->id()])->get();
        return view('pages.letter.create', [
            'title' => 'Buat Surat',
            'users' => $users
        ]);
    }

    public function store()
    {
        request()->validate([
            'tanggal' => ['required'],
            'to_user_id' => ['required'],
            'hal' => ['required'],
            'deskripsi' => ['required'],
            'keterangan' => ['required'],
            'body' => ['required'],
            'lampiran.*' => 'required|mimes:jpg,jpeg,png,pdf,docx|max:20000',
            [
                'lampiran.*.required' => 'Please upload an image',
                'lampiran.*.mimes' => 'Only jpeg,png and pdf, docx images are allowed',
                'lampiran.*.max' => 'Sorry! Maximum allowed size for an image is 20MB',
            ]
        ]);

        DB::beginTransaction();
        try {
            $data = request()->except(['lampiran']);
            $data['from_user_id'] = auth()->id();
            $letter = Letter::create($data);
            $lampiran = request()->file('lampiran');
            // insert lampiran
            foreach ($lampiran as $lamp) {
                $letter->attachments()->create([
                    'file' => $lamp->store('letter', 'public')
                ]);
            }
            DB::commit();
            return redirect()->route('dashboard')->with('success', 'Letter Created successfully.');
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
            return redirect()->route('letters.create')->with('error', 'System Error!');
        }
    }
}
