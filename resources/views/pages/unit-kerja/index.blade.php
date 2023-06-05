@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Unit Kerjas</h4>
                    @can('Unit Kerja Create')
                        <a href="javascript:void(0)" class="btn my-2 mb-3 btn-sm py-2 btn-primary btnAdd">Tambah Unit Kerja</a>
                    @endcan
                    <div class="table-responsive">
                        <table class="table dtTable table-hover" id="dTable">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Name</th>
                                    <th>Kelompok</th>
                                    <th>Kategori Role</th>
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
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" id="name">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="parent_id">Kelompok</span></label>
                            <select name="parent_id" id="parent_id" class="form-control">

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

    <div class="modal fade" id="modalSetRole" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="javascript:void(0)" method="post" id="formSetRole">
                    <div class="modal-body">
                        @csrf
                        <input type="number" name="id" id="id" hidden>
                        <input type="number" name="role_unit_kerja_id" id="role_unit_kerja_id" hidden>
                        <div class="form-group">
                            <label for="role_id">Pilih Role</span></label>
                            <select name="role_id" id="role_id" class="form-control">

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
                    ajax: '{{ route('unit-kerjas.data') }}',
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'child',
                            name: 'child'
                        },
                        {
                            data: 'role_category',
                            name: 'role_category'
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
                    $('#myModal #parent_id').empty();
                    $('#myModal #parent_id').append(
                        `<option value="">Tidak Ada</option>`
                    );
                    data_unit_kerja.forEach(unit_kerja => {
                        $('#myModal #parent_id').append(
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
                        url: '{{ route('unit-kerjas.store') }}',
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
                    $('#myForm #name').val(detail.name);

                    // looping unit kerja
                    let data_unit_kerja = getUnitKerjas();
                    $('#myModal #parent_id').empty();
                    $('#myModal #parent_id').append(
                        `<option value="">Tidak Ada</option>`
                    );
                    data_unit_kerja.forEach(unit_kerja => {
                        let isSelected = unit_kerja.id == detail.parent_id ? 'selected' : '';
                        $('#myModal #parent_id').append(
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
                            var url = "{{ route('unit-kerjas.destroy', ':id') }}";
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

                // btn setRole
                $('body').on('click', '.btnSetRole', function() {
                    let id = $(this).data('id');
                    let role_unit_kerja_id = $(this).data('roleunitid')
                    let role_id = $(this).data('roleid');
                    let data_roles = getRoles();

                    // looping unit kerja
                    $('#modalSetRole #role_id').empty();
                    $('#modalSetRole #role_id').append(
                        `<option value="">Tidak Ada</option>`
                    );
                    data_roles.forEach(role => {
                        isSelected = role.id == role_id ? 'selected' : '';
                        $('#modalSetRole #role_id').append(
                            `<option ${isSelected} value="${role.id}">${role.name}</option>`);
                    });
                    $('#formSetRole #id').val(id);
                    $('#formSetRole #role_unit_kerja_id').val(role_unit_kerja_id);

                    $('#modalSetRole .modal-title').text('Set Role');
                    $('#modalSetRole').modal('show');
                })

                // btn submit set role
                $('#modalSetRole #formSetRole').on('submit', function(e) {
                    e.preventDefault();
                    let form = $('#modalSetRole #formSetRole');
                    $.ajax({
                        url: '{{ route('unit-kerjas.set-role') }}',
                        type: 'POST',
                        dataType: 'JSON',
                        data: form.serialize(),
                        success: function(response) {
                            swal(response);
                            otable.ajax.reload();
                            $('#modalSetRole').modal('hide');
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

                // get get roles
                let getRoles = function(id) {
                    let data;
                    $.ajax({
                        url: '{{ route('roles.get-json') }}',
                        type: 'JSON',
                        method: 'GET',
                        async: false,
                        success: function(response) {
                            data = response;
                        }
                    })

                    return data;
                }

                // get detail
                let getDetail = function(id) {
                    let data;
                    var urlDetail = "{{ route('unit-kerjas.show', ':id') }}";
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
