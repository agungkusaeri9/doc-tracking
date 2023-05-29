<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Letter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class InboxController extends Controller
{
    public function index()
    {
        return view('pages.inbox.index', [
            'title' => 'Data Surat Masuk'
        ]);
    }

    public function data(Request $request)
    {
        if (request()->ajax()) {
            $jenis = request('jenis');
            if($jenis === 'document'){
                $data = Document::with(['unit_kerja'])->inboxbyuser();
                return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($model) {
                    $link_detail = route('documents.inbox.show',[
                        'id' => Crypt::encryptString($model->id)
                    ]);
                    $action = "<a href='$link_detail' class='btn btn-sm py-2 btn-warning mx-1' data-id='$model->id' data-name='$model->name'><i class='fas fa fa-edit'></i> View</a>";
                    return $action;
                })
                ->addColumn('unit_kerja', function($model){
                    return $model->unit_kerja->name ?? '-';
                })
                ->rawColumns(['action'])
                ->make(true);
            }else{
                $data = Letter::inboxbyuser();

                return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($model) {
                    $link_detail = route('letters.inbox.show',[
                        'id' => Crypt::encryptString($model->id)
                    ]);
                    $action = "<a href='$link_detail' class='btn btn-sm py-2 btn-warning mx-1' data-id='$model->id' data-name='$model->name'><i class='fas fa fa-edit'></i> View</a>";
                    return $action;
                })
                ->rawColumns(['action'])
                ->make(true);
            }

        }
    }
}
