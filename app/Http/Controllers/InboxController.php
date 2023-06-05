<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Letter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class InboxController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:Surat Masuk Index')->only(['index']);
    }

    public function index()
    {
        $tahun_sekarang = Carbon::now()->format('Y');
        return view('pages.inbox.index', [
            'title' => 'Data Surat Masuk',
            'tahun_sekarang' => $tahun_sekarang
        ]);
    }

    public function data(Request $request)
    {
        if (request()->ajax()) {
            $jenis = request('jenis');
            $tahun = request('tahun');
            if ($jenis === 'document') {
                if ($tahun)
                    $data = Document::whereYear('created_at', $tahun)->with(['unit_kerja'])->inboxbyuser()->latest();
                else
                    $data = Document::with(['unit_kerja'])->inboxbyuser()->latest();

                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($model) {
                        $link_detail = route('documents.inbox.show', [
                            'uuid' => $model->uuid
                        ]);
                        $link_create_tte = route('documents.tte.index', [
                            'uuid' => $model->uuid ?? 0
                        ]);
                        if (auth()->user()->getPermissions('Surat Masuk TTE')) {
                            $tte = "<a href='$link_create_tte' class='btn btn-sm py-2 text-white btn-secondary mx-1' ><i class='fas fa fa-eye'></i> TTE</a>";
                        } {
                            $tte = "";
                        }
                        if (auth()->user()->getPermissions('Surat Masuk Show')) {
                            $detail = "<a href='$link_detail' class='btn btn-sm py-2 btn-warning mx-1' data-id='$model->id' data-name='$model->name'><i class='fas fa fa-edit'></i> View</a>";
                        }
                        return $tte  . $detail;
                    })
                    ->addColumn('unit_kerja', function ($model) {
                        return $model->unit_kerja->name ?? '-';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            } else {

                if ($tahun)
                    $data = Letter::whereYear('created_at', $tahun)->inboxbyuser()->latest();

                else
                    $data = Letter::inboxbyuser()->latest();

                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($model) {
                        $link_detail = route('letters.inbox.show', [
                            'uuid' => $model->uuid
                        ]);
                        $link_create_tte = route('letters.tte.index', [
                            'uuid' => $model->uuid ?? 0
                        ]);
                       if(auth()->user()->getPermissions('Surat Masuk TTE'))
                       {
                        $tte = "<a href='$link_create_tte' class='btn btn-sm py-2 text-white btn-secondary mx-1' ><i class='fas fa fa-eye'></i> TTE</a>";
                       }else{
                        $tte = "";
                       }
                       if(auth()->user()->getPermissions('Surat Masuk Show'))
                       {
                        $detail = "<a href='$link_detail' class='btn btn-sm py-2 btn-warning mx-1' data-id='$model->id' data-name='$model->name'><i class='fas fa fa-edit'></i> View</a>";
                       }else{
                        $detail = "";
                       }
                        return $tte . $detail;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
        }
    }
}
