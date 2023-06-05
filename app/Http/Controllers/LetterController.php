<?php

namespace App\Http\Controllers;

use App\Models\Letter;
use App\Models\LetterAttachments;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade as PDF;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Ramsey\Uuid\Uuid;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class LetterController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:Surat Umum Create')->only(['store','create']);
    }

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
            $data['uuid'] = Uuid::uuid4();
            $letter = Letter::create($data);
            $lampiran = request()->file('lampiran');
            // cek apakah ada lampiran
            // insert lampiran
            if ($lampiran) {
                foreach ($lampiran as $lamp) {
                    $letter->attachments()->create([
                        'file' => $lamp->store('letter', 'public')
                    ]);
                }
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

    public function show($uuid)
    {
        $item = Letter::with(['tte_created_user'])->where('uuid', $uuid)->first();
        return view('pages.letter.show', [
            'title' => 'Detail Surat',
            'item' => $item
        ]);
    }

    public function show_inbox($uuid)
    {
        $item = Letter::where('uuid', $uuid)->first();
        return view('pages.letter.show-inbox', [
            'title' => 'Detail Surat',
            'item' => $item
        ]);
    }


    public function edit($uuid)
    {
        $item = Letter::where('uuid', $uuid)->first();
        $users = User::whereNotIn('id', [auth()->id()])->get();
        return view('pages.letter.edit', [
            'title' => 'Edit Surat',
            'item' => $item,
            'users' => $users
        ]);
    }

    public function update($uuid)
    {
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

            $item = Letter::where('uuid', $uuid)->first();

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
            return redirect()->route('outbox.index', [
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
            foreach ($letter->attachments as $lampiran) {
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

    public function tte($uuid)
    {
        $item = Letter::where('uuid', $uuid)->firstOrFail();
        $users = User::whereNotIn('id', [auth()->id()])->get();
        return view('pages.letter.tte', [
            'title' => 'TTE surat',
            'users' => $users,
            'item' => $item
        ]);
    }

    public function tte_create($uuid)
    {
        request()->validate([
            'tte_pin' => ['required']
        ]);

        $item = Letter::where('uuid', $uuid)->firstOrFail();

        // cek pin TTE
        if (!Hash::check(request()->tte_pin, auth()->user()->tte_pin)) {
            return redirect()->back()->with('error', 'PIN TTE Invalid.');
        }

        $url_qrcode = route('cek-letter', [
            'uuid' => $uuid
        ]);
        $image = QrCode::format('png')
            // ->merge('img/t.jpg', 0.1, true)
            ->size(200)->errorCorrection('H')
            ->generate($url_qrcode);
        $output_file = 'qr-code/letter/' . $uuid . '.png';
        Storage::disk('public')->put($output_file, $image);

        $item->update([
            'tte_created_user_id' => auth()->id(),
            'tte_created' => Carbon::now(),
            'qrcode' => $output_file
        ]);


        return redirect()->route('letters.tte.index', [
            'uuid' => $uuid
        ])->with('success', 'TTE created successfully');
    }

    public function tte_download($uuid)
    {
        $item = Letter::where('uuid', $uuid)->firstOrFail();
        // $qrcode = QrCode::size(400)->generate($item->uuid);\
        $pdf = FacadePdf::loadView('pages.tte.letter.download', [
            'item' => $item
        ]);

        return $pdf->download($item->uuid . '.pdf');
    }
}
