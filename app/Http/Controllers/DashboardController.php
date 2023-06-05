<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Document;
use App\Models\Letter;
use App\Models\UnitKerja;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:Dashboard')->only(['index']);
    }

    public function index()
    {
        // $total_inbox_letter = Letter::scopeInboxbyuser->count();
        // $total_inbox_document = Document::scopeInboxbyuser->count();
        // $total_outbox_letter = Letter::scopeOutboxbyuser->count();
        // $total_outbox_document = Document::scopeInboxbyuser->count();
        // $count = [
        //     'inbox' => $total_inbox_document + $total_inbox_document,
        //     'outbox' => $total_outbox_document + $total_outbox_letter
        // ];

        $count = [
            'surat' => Letter::count() + Document::count(),
            'user' => User::count(),
            'unit_kerja' => UnitKerja::count(),
            'category' => Category::count()
        ];
        return view('pages.dashboard',[
            'title' => 'Dashboard',
            'count' => $count
        ]);
    }

}
