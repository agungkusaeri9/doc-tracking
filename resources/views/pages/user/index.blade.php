@extends('layouts.app')
@section('content')
    <div class="row mb-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Filter</h4>
                    <form action="javascript:void(0)" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="role_select">Pilih Role</label>
                                    <select name="role_select" id="role_select" class="form-control">

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
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
                    <h4 class="card-title mb-3">Users</h4>
                    @can('User Create')
                    <a href="{{ route('users.create') }}" class="btn my-2 mb-3 btn-sm py-2 btn-primary btnAdd">Tambah User</a>
                    @endcan
                    <div class="table-responsive">
                        <table class="table dtTable table-hover" id="dTable">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>NIP</th>
                                    <th>Unit Kerja</th>
                                    <th>Jabatan</th>
                                    <th>Role</th>
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
                        url: '{{ route('users.data') }}',
                        data: function(d) {
                            d.role_select = $('#role_select').val();
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
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'username',
                            name: 'username'
                        },
                        {
                            data: 'nip',
                            name: 'nip'
                        },
                        {
                            data: 'unit_kerja',
                            name: 'unit_kerja'
                        },
                        {
                            data: 'jabatan',
                            name: 'jabatan'
                        },
                        {
                            data: 'role',
                            name: 'role'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ]
                });

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
                            var url = "{{ route('users.destroy', ':id') }}";
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

                // get roles
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


                // get roles
                let getUnitKerja = function(id) {
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

                // looping role di filter
                let data_roles = getRoles();
                $('#role_select').empty();
                $('#role_select').append(
                    `<option value="">Semua</option>`
                );
                data_roles.forEach(unit_kerja => {
                    $('#role_select').append(
                        `<option value="${unit_kerja.id}">${unit_kerja.name}</option>`);
                });

                // looping unit_kerja di filter
                let data_unit_kerja = getUnitKerja();
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
