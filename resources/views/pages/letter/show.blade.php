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
    <div class="row mt-3 bg-white">
        <div class="col-md-12">
            <div class="rangkasurat">
                <table width="100%" class="tbl-kop">
                    <tr>
                        <td class="td-gambar">
                            <div class="text-left">
                                <img src="{{ asset('assets/images/polindra.png') }}" class="gambar" />
                            </div>
                        </td>
                        <td class="tengah">
                            <div class="jd1">KEMENTRIAN PENDIDIKAN, KEBUDAYAAN, <br> RISET DAN TEKNOLOGI</div>
                            <div class="jd2">POLITEKNIK NEGERI INDRAMAYU</div>
                            <div class="jd3">Jalan Raya Lohbener Lama Nomor 8 Lohbener - Indramayu 45353</div>
                            <div class="jd3">Telepon/Faximile: (0234) 5746</div>
                            <div class="jd3">Laman: https://www.polindra.ac.id e-mail: info@polindra.ac.id</div>
                        </td>
                    </tr>
                </table>
                <div class="body mt-4">
                    {!! $item->body !!}
                </div>
            </div>
            <table class="mt-5">
                <tr>
                    <td colspan="2" style="width:85%">

                    </td>
                    <td>
                        @if ($item->tte_created_user_id)
                            <div class="ttd-tempat-jabatan">
                                <p>27 April 2023 <br>
                                    Direktur</p>
                            </div>
                            <div class="ttd-qrcode">
                                {{-- <img src="{{ asset('assets/images/qr_code_umum.png') }}" alt=""
                                    class="img-fluid gambar-tte"> --}}
                                    {!! QrCode::size(80)->generate('https://techvblogs.com/blog/generate-qr-code-laravel-8') !!}
                            </div>
                            <div class="tte-nama-gelar">
                                <p>{{ $item->tte_created_user->name ?? '-' }}</p>
                                <p>NIP {{ $item->tte_created_user->nip ?? '-' }}</p>
                            </div>
                        @endif
                    </td>
                </tr>
            </table>
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
