@extends('layouts.app')
@section('content')
    <div class="row mb-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Filter</h5>
                    <form action="" method="get">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="jenis">Pilih Jenis</label>
                                    <select name="jenis" id="jenis" class="form-control">
                                        <option @selected(request('jenis') === 'letter') value="letter">Umum</option>
                                        <option @selected(request('jenis') === 'document') value="document">Khusus</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tahun">Pilih Tahun</label>
                                    <select name="tahun" id="tahun" class="form-control">
                                      <option value="">Semua</option>
                                      @for ($i = $tahun_sekarang - 5; $i < $tahun_sekarang + 10; $i++)
                                      <option @selected($i == request('tahun')) value="{{ $i }}">{{ $i }}</option>
                                      @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-md align-self-center">
                                <button class="btn py-3 text-white btn-secondary btnFilter"><i class="fas fa-filter"></i>
                                    Filter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Surat Masuk</h4>
                    <div class="table-responsive">
                        <table class="table dtTable table-hover" id="dTable">
                            <thead>
                                @if (request('jenis') === 'document')
                                <tr>
                                    <th widtth="10">No.</th>
                                    <th>Nomor Surat</th>
                                    <th>Unit Kerja</th>
                                    <th>Deskripsi</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                                @else

                                    <tr>
                                        <th widtth="10">No.</th>
                                        <th>Hal</th>
                                        <th>Deskripsi</th>
                                        <th>Keterangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                @endif
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<x-Admin.Sweetalert />
<x-Admin.Datatable>
    @slot('script')
        <script>
            $(function() {
                let jenis = '{{ request('jenis') }}';
                let tahun = '{{ request('tahun') }}';
                if (jenis === 'document') {
                    let otable = $('#dTable').DataTable({
                        processing: true,
                        serverSide: true,
                        responsive: true,
                        ajax: '{{ route('inbox.data') }}' + '?jenis=' + jenis + '&tahun=' + tahun,
                        columns: [{
                                data: 'DT_RowIndex',
                                name: 'DT_RowIndex',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'no_surat',
                                name: 'no_surat'
                            },
                            {
                                data: 'unit_kerja',
                                name: 'unit_kerja'
                            },
                            {
                                data: 'deskripsi',
                                name: 'deskripsi'
                            },
                            {
                                data: 'keterangan',
                                name: 'keterangan'
                            },
                            {
                                data: 'action',
                                name: 'action',
                                orderable: false,
                                searchable: false
                            }
                        ]
                    });
                } else {
                    let otable = $('#dTable').DataTable({
                        processing: true,
                        serverSide: true,
                        responsive: true,
                        ajax: '{{ route('inbox.data') }}' + '?jenis=' + jenis + '&tahun=' + tahun,
                        columns: [{
                                data: 'DT_RowIndex',
                                name: 'DT_RowIndex',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'hal',
                                name: 'hal'
                            },
                            {
                                data: 'deskripsi',
                                name: 'deskripsi'
                            },
                            {
                                data: 'keterangan',
                                name: 'keterangan'
                            },
                            {
                                data: 'action',
                                name: 'action',
                                orderable: false,
                                searchable: false
                            }
                        ]
                    });

                }
            })
        </script>
    @endslot
</x-Admin.Datatable>
