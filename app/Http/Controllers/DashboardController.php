<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Letter;
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
        return view('pages.dashboard',[
            'title' => 'Dashboard'
        ]);
    }

}
