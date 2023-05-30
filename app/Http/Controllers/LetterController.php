<?php

namespace App\Http\Controllers;

use App\Models\Letter;
use App\Models\LetterAttachments;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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

            // send notifikasi
            Notification::create([
                'judul' => auth()->user()->name . ' mengirimkan jenis surat umum kepada anda.',
                'jenis' => 'umum',
                'from' => auth()->id(),
                'to' => $letter->to_user_id,
                'surat_id' => $letter->id
            ]);

            DB::commit();
            return redirect()->route('dashboard')->with('success', 'Letter Created successfully.');
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
            return redirect()->route('letters.create')->with('error', 'System Error!');
        }
    }

    public function show($id_encrypt)
    {
        $id = Crypt::decryptString($id_encrypt);
        $item = Letter::findOrFail($id);
        return view('pages.letter.show', [
            'title' => 'Detail Surat',
            'item' => $item
        ]);
    }

    public function show_inbox($id_encrypt)
    {
        $id = Crypt::decryptString($id_encrypt);
        $item = Letter::findOrFail($id);
        return view('pages.letter.show-inbox', [
            'title' => 'Detail Surat',
            'item' => $item
        ]);
    }


    public function edit($id_encrypt)
    {
        $id = Crypt::decryptString($id_encrypt);
        $item = Letter::findOrFail($id);
        $users = User::whereNotIn('id', [auth()->id()])->get();
        return view('pages.letter.edit', [
            'title' => 'Edit Surat',
            'item' => $item,
            'users' => $users
        ]);
    }

    public function update($id_encrypt)
    {
        $id = decrypt($id_encrypt);

        request()->validate([
            'tanggal' => ['required'],
            'to_user_id' => ['required'],
            'hal' => ['required'],
            'deskripsi' => ['required'],
            'keterangan' => ['required'],
            'body' => ['required'],
            // 'lampiran.*' => 'required|mimes:jpg,jpeg,png,pdf,docx|max:20000',
            // [
            //     'lampiran.*.required' => 'Please upload an image',
            //     'lampiran.*.mimes' => 'Only jpeg,png and pdf, docx images are allowed',
            //     'lampiran.*.max' => 'Sorry! Maximum allowed size for an image is 20MB',
            // ]
        ]);

        DB::beginTransaction();
        try {

            $item = Letter::findOrFail($id);

            $data = request()->except(['lampiran']);
            $data['from_user_id'] = auth()->id();
            $item->update($data);
            // $lampiran = request()->file('lampiran');
            // // insert lampiran
            // foreach ($lampiran as $lamp) {
            //     $letter->attachments()->create([
            //         'file' => $lamp->store('letter', 'public')
            //     ]);
            // }

             // send notifikasi
             Notification::create([
                'judul' => auth()->user()->name . ' merubah surat umum yang dikirim kepada anda.',
                'jenis' => 'umum',
                'from' => auth()->id(),
                'to' => $item->to_user_id,
                'surat_id' => $item->id
            ]);

            DB::commit();
            return redirect()->route('outbox.index',[
                'jenis=letter'
            ])->with('success', 'Letter Updated successfully.');
        } catch (\Throwable $th) {
            // throw $th;
            DB::rollBack();
            return redirect()->route('letters.create')->with('error', 'System Error!');
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $letter = Letter::findOrFail($id);
            foreach($letter->attachments as $lampiran)
            {
                Storage::disk('public')->delete($lampiran->file);
                LetterAttachments::destroy($lampiran->id);
            }
            $letter->delete();
            // hapus attachments
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Letter Deleted successfully.']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'System Error!']);
        }
    }

}
