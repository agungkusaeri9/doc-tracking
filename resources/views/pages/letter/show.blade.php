@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('outbox.index') . '?jenis=letter' }}"
                        class="btn btn-sm text-white btn-warning mb-3">Kembali</a>
                    <h5 class="mb-3 mr-5">Detail Surat</h5>
                    <ul class="list-unstyled">
                        <li class="list-item mb-2">
                            <b>Hal</b>
                            <br>
                            <span>{{ $item->hal }}</span>
                        </li>
                        <li class="list-item mb-2">
                            <b>Kepada</b>
                            <br>
                            <span>{{ $item->to->name ?? '-' }}</span>
                        </li>
                        <li class="list-item mb-2">
                            <b>Tanggal</b>
                            <br>
                            <span>{{ $item->tanggal }}</span>
                        </li>
                        <li class="list-item mb-2">
                            <b>Deskripsi</b>
                            <br>
                            <span>{{ $item->deskripsi }}</span>
                        </li>
                        <li class="list-item mb-2">
                            <b>Keterangan</b>
                            <br>
                            <span>{{ $item->keterangan }}</span>
                        </li>
                        @foreach ($item->attachments as $key => $lampiran)
                            <li class="list-item mb-2">
                                <b>Lampiran {{ $key + 1 }}</b>
                                <br>
                                <a href="{{ route('letter-attachments.download', [
                                    'id' => encrypt($lampiran->id),
                                ]) }}"
                                    class="btn btn-success btn-sm">Download</a>
                            </li>
                        @endforeach
                        @if ($item->tte_created_user_id)
                            <li class="list-item mb-2">
                                <b>Pembuat TTE</b>
                                <br>
                                <span>{{ $item->tte_created_user->name ?? '-' }}</span>
                            </li>
                            <li class="list-item mb-2">
                                <b>Tanggal TTE</b>
                                <br>
                                <span>{{ $item->tte_created->translatedFormat('H:i:s d-m-Y') ?? '-' }}</span>
                            </li>
                            <li class="list-item mb-2">
                                <b>Download File TTE</b>
                                <br>
                                <a href="{{ route('letters.tte-download', [
                                    'uuid' => $item->uuid,
                                ]) }}"
                                    class="btn btn-success btn-sm">Download</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
<x-Admin.Sweetalert />

@push('styles')
    <style>
        .rangkasurat {
            font-family: 'Times New Roman', Times, serif;
            padding-left: 50px;
            padding-right: 30px;
            background: white;
        }

        .tbl-kop {
            border-bottom: 3px solid #000;
            padding: 2px;
        }

        .tengah {
            text-align: center;
        }

        .jd1 {
            font-size: 18px;
        }

        .jd2 {
            font-size: 16px;
            font-weight: bold;
        }

        .td-gambar {
            width: 25%;
            text-align: left;
        }

        .jd3 {
            font-size: 14px;
        }

        .text-left {
            align-content: flex-start;
            align-items: flex-start;
        }

        .gambar {
            height: 140px;
            margin-left: -10px;
        }

        /* .tte-nama-gelar{
                        margin-top: 70px;
                    } */
        .gambar-tte {
            border-radius: 0 !important;
            height: 80px !important;
            width: 80px !important;
            margin: 5px 0;
        }
    </style>
@endpush
