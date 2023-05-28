@extends('admin.layouts.app')
@section('content')
    <div class="row mb-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Filter</h4>
                    <form action="javascript:void(0)" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="unit_kerja_select">Pilih Unit Kerja</label>
                                    <select name="unit_kerja_select" id="unit_kerja_select" class="form-control">

                                    </select>
                                </div>
                            </div>
                            <div class="col-md align-self-center">
                                <button class="btn btn-secondary text-white py-3 px-4  btnFilter"><i
                                        class="fas fa-filter"></i>
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
                    <h4 class="card-title mb-3">Jabatan</h4>
                    <a href="javascript:void(0)" class="btn my-2 mb-3 btn-sm py-2 btn-primary btnAdd">Tambah Jabatan</a>
                    <div class="table-responsive">
                        <table class="table dtTable table-hover" id="dTable">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Jabatan</th>
                                    <th>Unit Kerja</th>
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

    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="javascript:void(0)" method="post" id="myForm">
                    <div class="modal-body">
                        @csrf
                        <input type="number" id="id" name="id" hidden>
                        <div class="form-group">
                            <label for="nama">Jabatan</label>
                            <input type="text" class="form-control" name="nama" id="nama">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="unit_kerja_id">Unit Kerja</span></label>
                            <select name="unit_kerja_id" id="unit_kerja_id" class="form-control">

                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
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
                        url: '{{ route('jabatans.data') }}',
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
                            data: 'nama',
                            name: 'nama'
                        },
                        {
                            data: 'unit_kerja',
                            name: 'unit_kerja'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ]
                });


                // btn create
                $('.btnAdd').on('click', function() {
                    let data_unit_kerja = getUnitKerjas();
                    // looping unit kerja
                    $('#myModal #unit_kerja_id').empty();
                    $('#myModal #unit_kerja_id').append(
                        `<option value="">Pilih</option>`
                    );
                    data_unit_kerja.forEach(unit_kerja => {
                        $('#myModal #unit_kerja_id').append(
                            `<option value="${unit_kerja.id}">${unit_kerja.name}</option>`);
                    });
                    $('#myModal .modal-title').text('Tambah Data');
                    $('#myModal').modal('show');
                })

                // btn submit
                $('#myModal #myForm').on('submit', function(e) {
                    e.preventDefault();
                    let form = $('#myModal #myForm');
                    $.ajax({
                        url: '{{ route('jabatans.store') }}',
                        type: 'POST',
                        dataType: 'JSON',
                        data: form.serialize(),
                        success: function(response) {
                            swal(response);
                            otable.ajax.reload();
                            $('#myModal').modal('hide');
                        },
                        error: function(response) {
                            let errors = response.responseJSON?.errors
                            $(form).find('.text-danger.text-small').remove()
                            if (errors) {
                                for (const [key, value] of Object.entries(errors)) {
                                    $(`[name='${key}']`).parent().append(
                                        `<sp class="text-danger text-small">${value}</sp>`)
                                    $(`[name='${key}']`).addClass('is-invalid')
                                }
                            }
                        }
                    })
                })

                // edit
                $('body').on('click', '.btnEdit', function() {
                    let id = $(this).data('id');
                    let detail = getDetail(id);
                    $('#myForm #id').val(detail.id);
                    $('#myForm #nama').val(detail.nama);

                    // looping unit kerja
                    let data_unit_kerja = getUnitKerjas();
                    $('#myModal #unit_kerja_id').empty();
                    $('#myModal #unit_kerja_id').append(
                        `<option value="">Pilih</option>`
                    );
                    data_unit_kerja.forEach(unit_kerja => {
                        let isSelected = unit_kerja.id == detail.unit_kerja_id ? 'selected' : '';
                        $('#myModal #unit_kerja_id').append(
                            `<option ${isSelected} value="${unit_kerja.id}">${unit_kerja.name}</option>`
                        );
                    });
                    $('#myModal .modal-title').text('Edit Data');
                    $('#myModal').modal('show');
                })

                // hapus
                $('body').on('click', '.btnDelete', function(e) {
                    e.preventDefault();
                    let id = $(this).data('id');
                    Swal.fire({
                        title: 'Apakah Yakin?',
                        text: `Data yang dihapus tidak bisa dikembalikan!`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yakin'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var url = "{{ route('jabatans.destroy', ':id') }}";
                            url = url.replace(':id', id);
                            $.ajax({
                                url: url,
                                type: 'DELETE',
                                dataType: 'JSON',
                                success: function(response) {
                                    swal(response);
                                    otable.ajax.reload();
                                    $('#myModal').modal('hide');

                                },
                                error: function(response) {
                                    swal(response);
                                }
                            })
                        }
                    })
                })

                // get unit_kerjas
                let getUnitKerjas = function(id) {
                    let data;
                    $.ajax({
                        url: '{{ route('unit-kerjas.get-json') }}',
                        type: 'JSON',
                        method: 'GET',
                        async: false,
                        success: function(response) {
                            data = response;
                        }
                    })

                    return data;
                }

                // looping unit kerja di filter
                let data_unit_kerja = getUnitKerjas();
                $('#unit_kerja_select').empty();
                $('#unit_kerja_select').append(
                    `<option value="">Semua</option>`
                );
                data_unit_kerja.forEach(unit_kerja => {
                    $('#unit_kerja_select').append(
                        `<option value="${unit_kerja.id}">${unit_kerja.name}</option>`);
                });

                // filter
                $('.btnFilter').on('click', function() {
                    otable.draw();
                });

                // get detail
                let getDetail = function(id) {
                    let data;
                    var urlDetail = "{{ route('jabatans.show', ':id') }}";
                    urlDetail = urlDetail.replace(':id', id);
                    $.ajax({
                        url: urlDetail,
                        type: 'JSON',
                        method: 'GET',
                        async: false,
                        success: function(response) {
                            data = response;
                        }
                    })

                    return data;
                }

                $('#myModal').on('hidden.bs.modal', function() {
                    let form = $('#myModal #myForm');
                    $('.text-danger').addClass('d-none');
                    $('.is-invalid').removeClass('is-invalid');
                    form.trigger('reset');
                })

                function swal(response) {
                    Swal.fire({
                        position: 'center',
                        icon: response.status,
                        title: response.message,
                        showConfirmButton: true,
                        timer: 1500
                    })
                }
            })
        </script>
    @endslot
</x-Admin.Datatable>
