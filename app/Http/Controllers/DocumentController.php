<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Document;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DocumentController extends Controller
{
    public function create()
    {
        $unit_kerjas = UnitKerja::orderBy('name','ASC')->get();
        $categories = Category::orderBy('name','ASC')->get();
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
            $data = request()->only(['kode_hal','to_unit_kerja_id','to_tembusan_unit_kerja_id','hal','deskripsi','keterangan','body','category_id']);

            $data['from_user_id'] = auth()->id();
            $document = Document::create($data);
            $lampiran = request()->file('lampiran');
            $detail_item = request('detail_item');
            $detail_qty = request('detail_qty');
            $detail_harga = request('detail_harga');
            $detail_keterangan = request('detail_keterangan');

            if(count($lampiran) > 0)
            {
                // insert lampiran
                foreach ($lampiran as $lamp) {

                    $document->attachments()->create([
                        'file' => $lamp->store('document', 'public')
                    ]);
                }
            }


            // insert document detail
            if(count($detail_item) > 0)
            {
                foreach($detail_item as $key => $item){
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
}
