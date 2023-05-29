@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('inbox.index') . '?jenis=document' }}"
                        class="btn btn-sm text-white btn-warning mb-3">Kembali</a>
                    <h5 class="mb-3 mr-5">Detail Surat</h5>
                    <ul class="list-unstyled">
                        <li class="list-item mb-2">
                            <b>NO. Surat</b>
                            <br>
                            <span>{{ $item->no_surat }}</span>
                        </li>
                        <li class="list-item mb-2">
                            <b>Kode Hal</b>
                            <br>
                            <span>{{ $item->kode_hal }}</span>
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

                        <li class="list-item mb-2">
                            <b>Tanggal Submit</b>
                            <br>
                            <span>{{ $item->created_at }}</span>
                        </li>

                        @foreach ($item->attachments as $key => $lampiran)
                            <li class="list-item mb-2">
                                <b>Lampiran {{ $key + 1 }}</b>
                                <br>
                                <a href="{{ route('document-attachments.download', [
                                    'id' => encrypt($lampiran->id),
                                ]) }}"
                                    class="btn btn-success btn-sm">Download</a>
                            </li>
                        @endforeach

                        <h6 class="mt-5">Detail</h6>
                        <table class="table table-hover table-striped mt-4">
                            <tr>
                                <th>No.</th>
                                <th>Item</th>
                                <th>Qty</th>
                                <th>Keterangan</th>
                                <th>Harga</th>
                                <th>Total</th>
                            </tr>
                            @forelse ($item->details as $detail)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $detail->item }}</td>
                                <td>{{ $detail->qty }}</td>
                                <td>{{ $detail->keterangan }}</td>
                                <td>Rp {{ number_format($detail->harga ,0,'.','.')}}</td>
                                <td>Rp {{ number_format($detail->total ,0,'.','.')}}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak Ada!</td>
                            </tr>
                            @endforelse
                        </table>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
<x-Admin.Sweetalert />
