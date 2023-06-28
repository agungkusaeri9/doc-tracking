<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Document;
use App\Models\DocumentAttachment;
use App\Models\DocumentDetails;
use App\Models\Notification;
use App\Models\UnitKerja;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class DocumentController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:Surat Umum Create')->only(['store','create']);
        $this->middleware('can:Surat Masuk TTE')->only(['tte_create']);
        // $this->middleware('can:Surat Keluar TTE')->only(['store','create']);
    }

    public function create()
    {
        $unit_kerjas = UnitKerja::orderBy('name', 'ASC')->get();
        $categories = Category::orderBy('name', 'ASC')->get();
        return view('pages.document.create', [
            'title' => 'Buat Surat Khusus',
            'unit_kerjas' => $unit_kerjas,
            'categories' => $categories
        ]);
    }

    public function store()
    {
        request()->validate([
            'kode_hal' => ['required'],
            'category_id' => ['required'],
            'to_unit_kerja_id' => ['required'],
            'to_tembusan_unit_kerja_id' => ['required'],
            'hal' => ['required'],
            'deskripsi' => ['required'],
            'keterangan' => ['required'],
            'body' => ['required'],
            'lampiran.*' => 'required|mimes:jpg,jpeg,png,pdf,docx|max:20000',
            [
                'lampiran.*.required' => 'Please upload an image',
                'lampiran.*.mimes' => 'Only jpeg,png and pdf, docx images are allowed',
                'lampiran.*.max' => 'Sorry! Maximum allowed size for an image is 20MB',
            ],

        ]);


        // cek kategori surat
        $category = explode('-', request('category_id'));
        if ($category[1] === 'Surat Tugas' || $category[1] === 'surat tugas') {
            request()->validate([
                'visum_umum' => ['required', 'mimes:pdf,docx'],
                'spd' => ['required', 'mimes:pdf,docx']
            ]);
        }

        DB::beginTransaction();
        try {
            $nomor_surat = Document::getNewCode(request('category_id'));

            $data = request()->only(['kode_hal', 'to_unit_kerja_id', 'to_tembusan_unit_kerja_id', 'hal', 'deskripsi', 'keterangan', 'body', 'category_id']);

            // cek nama kategori
            if ($category[1] === 'Surat Tugas' || $category[1] === 'surat tugas') {
                $data['visum_umum'] = request()->file('visum_umum')->store('document', 'public');
                $data['spd'] = request()->file('spd')->store('document', 'public');
            }

            $data['from_user_id'] = auth()->id();
            $data['uuid'] = Uuid::uuid4();
            $data['no_surat'] = $nomor_surat;
            $data['category_id'] = $category[0];
            $document = Document::create($data);
            $lampiran = request()->file('lampiran');
            $detail_item = request('detail_item');
            $detail_qty = request('detail_qty');
            $detail_harga = request('detail_harga');
            $detail_keterangan = request('detail_keterangan');

            if ($lampiran) {
                // insert lampiran
                foreach ($lampiran as $lamp) {

                    $document->attachments()->create([
                        'file' => $lamp->store('document', 'public')
                    ]);
                }
            }


            // // insert document detail
            // if (count($detail_item) > 0) {
            //     foreach ($detail_item as $key => $item) {
            //         $qty = $detail_qty[$key];
            //         $harga = $detail_harga[$key];
            //         $total = $qty * $harga;
            //         $document->details()->create([
            //             'item' => $item,
            //             'qty' => $detail_qty[$key],
            //             'harga' => $detail_harga[$key],
            //             'keterangan' => $detail_keterangan[$key],
            //             'total' => $total
            //         ]);
            //     }
            // }

            // send notifikasi
            Notification::create([
                'judul' => auth()->user()->name . ' mengirimkan jenis surat khusus kepada  unit anda.',
                'jenis' => 'khusus',
                'from' => auth()->id(),
                'to' => $document->to_unit_kerja_id,
                'surat_id' => $document->id
            ]);

            DB::commit();
            return redirect()->route('dashboard')->with('success', 'Document Created successfully.');
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
            return redirect()->route('documents.create')->with('error', 'System Error!');
        }
    }

    public function show($uuid)
    {
        $item = Document::where('uuid', $uuid)->first();
        return view('pages.document.show', [
            'title' => 'Detail Surat',
            'item' => $item
        ]);
    }

    public function show_inbox($uuid)
    {
        $item = Document::where('uuid', $uuid)->first();
        return view('pages.document.show-inbox', [
            'title' => 'Detail Surat',
            'item' => $item
        ]);
    }

    public function edit($uuid)
    {
        $item = Document::where('uuid', $uuid)->first();
        $unit_kerjas = UnitKerja::orderBy('name', 'ASC')->get();
        $categories = Category::orderBy('name', 'ASC')->get();
        return view('pages.document.edit', [
            'title' => 'Buat Surat Khusus',
            'unit_kerjas' => $unit_kerjas,
            'categories' => $categories,
            'item' => $item
        ]);
    }

    public function update($uuid)
    {
        request()->validate([
            'kode_hal' => ['required'],
            'category_id' => ['required'],
            'to_unit_kerja_id' => ['required'],
            'to_tembusan_unit_kerja_id' => ['required'],
            'hal' => ['required'],
            'deskripsi' => ['required'],
            'keterangan' => ['required'],
            'body' => ['required'],
            // 'lampiran.*' => 'required|mimes:jpg,jpeg,png,pdf,docx|max:20000',
            // [
            //     'lampiran.*.required' => 'Please upload an image',
            //     'lampiran.*.mimes' => 'Only jpeg,png and pdf, docx images are allowed',
            //     'lampiran.*.max' => 'Sorry! Maximum allowed size for an image is 20MB',
            // ],

        ]);

        // cek kategori surat
        if (request()->file('spd') || request()->file('visum_umum')) {
            $category = explode('-', request('category_id'));
            if ($category[1] === 'Surat Tugas' || $category[1] === 'surat tugas') {
                request()->validate([
                    'visum_umum' => ['required', 'mimes:pdf,docx'],
                    'spd' => ['required', 'mimes:pdf,docx']
                ]);
            }
        }

        $item = Document::where('uuid', $uuid)->first();
        DB::beginTransaction();
        try {
            $data = request()->only(['kode_hal', 'to_unit_kerja_id', 'to_tembusan_unit_kerja_id', 'hal', 'deskripsi', 'keterangan', 'body', 'category_id']);


            if (request()->file('visum_umum')) {
                if ($item->visum_umum)
                    Storage::disk('public')->delete($item->visum_umum);

                $data['visum_umum'] = request()->file('visum_umum')->store('document', 'public');
            }

            if (request()->file('spd')) {
                if ($item->spd)
                    Storage::disk('public')->delete($item->spd);

                $data['spd'] = request()->file('spd')->store('document', 'public');
            }

            $category = explode('-', request('category_id'));
            $data['category_id'] = $category[0];
            $data['from_user_id'] = auth()->id();
            $item->update($data);
            $lampiran = request()->file('lampiran');
            $detail_item = request('detail_item');
            $detail_qty = request('detail_qty');
            $detail_harga = request('detail_harga');
            $detail_keterangan = request('detail_keterangan');

            // send notifikasi
            Notification::create([
                'judul' => auth()->user()->name . ' merubah surat khusus yang dikirim kepada unit anda.',
                'jenis' => 'khusus',
                'from' => auth()->id(),
                'to' => $item->to_unit_kerja_id,
                'surat_id' => $item->id
            ]);

            DB::commit();
            return redirect()->route('outbox.index', [
                'jenis=document'
            ])->with('success', 'Document Updated successfully.');
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
            return redirect()->route('documents.create')->with('error', 'System Error!');
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $document = Document::findOrFail($id);
            foreach ($document->attachments as $lampiran) {
                Storage::disk('public')->delete($lampiran->file);
                DocumentAttachment::destroy($lampiran->id);
            }
            $document->delete();
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
        $item = Document::where('uuid', $uuid)->firstOrFail();
        $users = User::whereNotIn('id', [auth()->id()])->get();
        return view('pages.document.tte', [
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

        $item = Document::where('uuid', $uuid)->firstOrFail();

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
        $output_file = 'qr-code/document/' . $uuid . '.png';
        Storage::disk('public')->put($output_file, $image);

        $item->update([
            'tte_created_user_id' => auth()->id(),
            'tte_created' => Carbon::now(),
            'qrcode' => $output_file
        ]);

        return redirect()->route('documents.tte.index', [
            'uuid' => $uuid
        ])->with('success', 'TTE created successfully');
    }

    public function tte_download($uuid)
    {
        $item = Document::where('uuid', $uuid)->firstOrFail();
        // $qrcode = QrCode::size(400)->generate($item->uuid);\
        $pdf = Pdf::loadView('pages.tte.document.download', [
            'item' => $item
        ]);

        return $pdf->download($item->uuid . '.pdf');
    }
}
