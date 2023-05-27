@extends('admin.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Detail Category : {{ $category->name }}</h4>
                    <a href="javascript:void(0)" class="btn my-2 mb-3 btn-sm py-2 btn-primary btnAdd">Tambah Detail</a>
                    <div class="table-responsive">
                        <table class="table dtTable table-hover" id="dTable">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Kolom</th>
                                    <th>Urutan</th>
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
                        <input type="number" hidden name="category_id" value="{{ $category->id }}">
                        <div class="form-group">
                            <label for="column_name">Nama Kolom</label>
                            <input type="text" class="form-control" name="column_name" id="column_name">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="order">Urutan</label>
                            <input type="number" class="form-control" name="order" id="order">
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
                let category_id = '{{ $category->id }}';
                let otable = $('#dTable').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: '{{ route('category-details.data') }}' + '?category_id=' + category_id,
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'column_name',
                            name: 'column_name'
                        },
                        {
                            data: 'order',
                            name: 'order'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ]
                });

                $('.btnAdd').on('click', function() {
                    $('#myModal .modal-title').text('Tambah Data');
                    $('#myModal').modal('show');
                })

                $('#myModal #myForm').on('submit', function(e) {
                    e.preventDefault();
                    let form = $('#myModal #myForm');
                    $.ajax({
                        url: '{{ route('category-details.store') }}',
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
                    $('#myForm #column_name').val(detail.column_name);
                    $('#myForm #order').val(detail.order);
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
                            var url = "{{ route('category-details.destroy', ':id') }}";
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

                // get detail
                let getDetail = function(id) {
                    let data;
                    var urlDetail = "{{ route('category-details.show', ':id') }}";
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
