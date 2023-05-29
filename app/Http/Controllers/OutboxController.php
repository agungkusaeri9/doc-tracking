<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Letter;
use Illuminate\Http\Request;
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
            if($jenis === 'document')
                $data = Document::outboxbyuser();
            else
                $data = Letter::outboxbyuser();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($model) {
                    $action = "<button class='btn btn-sm py-2 btn-info btnEdit mx-1' data-id='$model->id' data-name='$model->name'><i class='fas fa fa-edit'></i> Edit</button><button class='btn btn-sm py-2 btn-danger btnDelete mx-1' data-id='$model->id' data-name='$model->name'><i class='fas fa fa-trash'></i> Hapus</button>";
                    return $action;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
}
