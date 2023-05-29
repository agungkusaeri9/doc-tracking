<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Letter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class OutboxController extends Controller
{
    public function index()
    {
        return view('pages.outbox.index', [
            'title' => 'Data Surat Keluar'
        ]);
    }

    public function data(Request $request)
    {
        if (request()->ajax()) {
            $jenis = request('jenis');
            if ($jenis === 'document') {
                $data = Document::with(['unit_kerja'])->outboxbyuser();
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($model) {
                        $link_show = route('documents.show',[
                            'id' => Crypt::encryptString($model->id,5)
                        ]);
                        $link_edit = route('documents.edit',[
                            'id' => Crypt::encryptString($model->id,5)
                        ]);
                        $action = "<a href='$link_show' class='btn btn-sm py-2 text-white btn-warning btnShow mx-1' ><i class='fas fa fa-eye'></i> Show</a><a href='$link_edit' class='btn btn-sm py-2 btn-info btnEdit mx-1' data-id='$model->id' data-name='$model->name'><i class='fas fa fa-edit'></i> Edit</a><button class='btn btn-sm py-2 btn-danger btnDelete mx-1' data-id='$model->id' data-name='$model->name' data-jenis='document'><i class='fas fa fa-trash'></i> Hapus</button>";
                        return $action;
                    })
                    ->addColumn('unit_kerja', function ($model) {
                        return $model->unit_kerja->name ?? '-';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            } else {
                $data = Letter::outboxbyuser();

                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($model) {
                        $link_show = route('letters.show',[
                            'id' => Crypt::encryptString($model->id,5)
                        ]);
                        $link_edit = route('letters.edit',[
                            'id' => Crypt::encryptString($model->id,5)
                        ]);
                        $action = "<a href='$link_show' class='btn btn-sm py-2 text-white btn-warning btnShow mx-1' ><i class='fas fa fa-eye'></i> Show</a><a href='$link_edit' class='btn btn-sm py-2 btn-info btnEdit mx-1' data-id='$model->id' data-name='$model->name'><i class='fas fa fa-edit'></i> Edit</a><button class='btn btn-sm py-2 btn-danger btnDelete mx-1' data-id='$model->id' data-name='$model->name' data-jenis='document'><i class='fas fa fa-trash'></i> Hapus</button>";
                        return $action;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
        }
    }

    public function show($id)
    {
        $id = Crypt::decryptString($id);
        if($jenis === 'document'){
            $item = Document::findOrFail($id);
            return view('pages.outbox.show',[
                'title' => 'Detail Surat keluar',
                'item' => $item
            ]);
        }else{
            $item = Letter::findOrFail($id);
            return view('pages.outbox.show-letter',[
                'title' => 'Detail Surat keluar',
                'item' => $item
            ]);
        }
    }

    public function edit_letter($id)
    {
        $id = Crypt::decryptString($id);
        if($jenis === 'document'){
            $item = Document::findOrFail($id);
            return view('pages.outbox.show',[
                'title' => 'Detail Surat keluar',
                'item' => $item
            ]);
        }else{
            $item = Letter::findOrFail($id);
            $users = User::whereNotIn('id',[auth()->id()])->get();
            return view('pages.outbox.edit-letter',[
                'title' => 'Edit Surat keluar',
                'item' => $item,
                'users' => $users
            ]);
        }
    }

}
