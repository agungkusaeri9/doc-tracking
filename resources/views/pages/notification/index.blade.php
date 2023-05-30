@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Notifikasi</h4>
                    <div class="table-responsive">
                        <table class="table dtTable table-hover" id="dTable">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Tanggal</th>
                                    <th>Judul</th>
                                    <th>Jenis Surat</th>
                                    <th>Nama Pengirim</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
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
                let otable = $('#dTable').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: {
                        url: '{{ route('notifications.data') }}',
                        data: function(d) {
                            d.unit_kerja_select = $('#unit_kerja_select').val();
                        }
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'tanggal',
                            name: 'tanggal'
                        },
                        {
                            data: 'judul',
                            name: 'judul'
                        },
                        {
                            data: 'jenis',
                            name: 'jenis'
                        },
                        {
                            data: 'pengirim',
                            name: 'pengirim'
                        },

                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ]
                });
            })
        </script>
    @endslot
</x-Admin.Datatable>
