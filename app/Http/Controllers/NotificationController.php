<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Letter;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:Notifikasi Index')->only(['index']);
        $this->middleware('can:Notifikasi Show')->only(['show']);
    }

    public function index()
    {

        return view('pages.notification.index', [
            'title' => 'Notifikasi',
        ]);
    }

    public function data(Request $request)
    {
        if (request()->ajax()) {
            $data = Notification::where('to', auth()->id())->orWhere('to', auth()->user()->unit_kerja_id)->latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($model) {
                    if(cek_user_permission('Notifikasi Show'))
                    {
                        $link_read = route('notifications.read', [
                            'id' => Crypt::encryptString($model->id)
                        ]);
                        $action = "<a href='$link_read' class='btn btn-sm py-2 btn-primary  mx-1' >Lihat Detail</a>";
                    }else{
                        $action = '<span class="text-danger font-italic">Tidak Ada Akses</span>';
                    }

                    return $action;
                })
                ->addColumn('tanggal', function ($model) {
                    return $model->created_at->translatedFormat('H:i:s d-m-Y');
                })
                ->addColumn('pengirim', function ($model) {
                    return $model->pengirim->name ?? '-';
                })
                ->addColumn('status', function ($model) {

                    if ($model->status == 1)
                        $status = '<span class="badge badge-success">Sudah Dilihat</span>';
                    else
                        $status = '<span class="badge badge-warning">Belum Dilihat</span>';


                    return $status;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
    }

    public function read($id_encrypt)
    {
        $id = Crypt::decryptString($id_encrypt);
        $notif = Notification::findOrFail($id);

        $notif->status == 0 ?  $notif->update(['status' => 1]) : NULL;
        if ($notif->jenis === 'umum') {
            $letter = Letter::findOrFail($notif->surat_id);
            return redirect()->route('letters.inbox.show', [
                'uuid' => $letter->uuid,
            ]);
        } else {
            $document = Document::findOrFail($notif->surat_id);
            return redirect()->route('documents.inbox.show', [
                'uuid' => $document->uuid,
            ]);
        }
    }
}
