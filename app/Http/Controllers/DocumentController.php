<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Document;
use App\Models\DocumentAttachment;
use App\Models\DocumentDetails;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
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

        DB::beginTransaction();
        try {
            $data = request()->only(['kode_hal', 'to_unit_kerja_id', 'to_tembusan_unit_kerja_id', 'hal', 'deskripsi', 'keterangan', 'body', 'category_id']);

            $data['from_user_id'] = auth()->id();
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


            // insert document detail
            if (count($detail_item) > 0) {
                foreach ($detail_item as $key => $item) {
                    $qty = $detail_qty[$key];
                    $harga = $detail_harga[$key];
                    $total = $qty * $harga;
                    $document->details()->create([
                        'item' => $item,
                        'qty' => $detail_qty[$key],
                        'harga' => $detail_harga[$key],
                        'keterangan' => $detail_keterangan[$key],
                        'total' => $total
                    ]);
                }
            }
            DB::commit();
            return redirect()->route('dashboard')->with('success', 'Document Created successfully.');
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
            return redirect()->route('documents.create')->with('error', 'System Error!');
        }
    }

    public function show($id_encrypt)
    {
        $id = Crypt::decryptString($id_encrypt);
        $item = Document::findOrFail($id);
        return view('pages.document.show', [
            'title' => 'Detail Surat',
            'item' => $item
        ]);
    }

    public function show_inbox($id_encrypt)
    {
        $id = Crypt::decryptString($id_encrypt);
        $item = Document::findOrFail($id);
        return view('pages.document.show-inbox', [
            'title' => 'Detail Surat',
            'item' => $item
        ]);
    }

    public function edit($id_encrypt)
    {
        $id = Crypt::decryptString($id_encrypt);
        $item = Document::findOrFail($id);
        $unit_kerjas = UnitKerja::orderBy('name', 'ASC')->get();
        $categories = Category::orderBy('name', 'ASC')->get();
        return view('pages.document.edit', [
            'title' => 'Buat Surat Khusus',
            'unit_kerjas' => $unit_kerjas,
            'categories' => $categories,
            'item' => $item
        ]);
    }

    public function update($id_encrypt)
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

        $id = decrypt($id_encrypt);
        $item = Document::with('details')->findOrFail($id);
        DB::beginTransaction();
        try {
            $data = request()->only(['kode_hal', 'to_unit_kerja_id', 'to_tembusan_unit_kerja_id', 'hal', 'deskripsi', 'keterangan', 'body', 'category_id']);

            $data['from_user_id'] = auth()->id();
            $item->update($data);
            $lampiran = request()->file('lampiran');
            $detail_item = request('detail_item');
            $detail_qty = request('detail_qty');
            $detail_harga = request('detail_harga');
            $detail_keterangan = request('detail_keterangan');



            // insert document detail
            if (count($detail_item) > 0) {

                // dd($item);
                // hapus detail semua
                DocumentDetails::where('document_id',$item->id)->delete();

                // create baru
                foreach ($detail_item as $key => $detail) {
                    $qty = $detail_qty[$key];
                    $harga = $detail_harga[$key];
                    $total = $qty * $harga;
                    $item->details()->create([
                        'item' => $detail,
                        'qty' => $detail_qty[$key],
                        'harga' => $detail_harga[$key],
                        'keterangan' => $detail_keterangan[$key],
                        'total' => $total
                    ]);
                }
            }
            DB::commit();
            return redirect()->route('outbox.index',[
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
            foreach($document->attachments as $lampiran)
            {
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
}
