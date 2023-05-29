@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
@endpush
@push('scripts')
    <script src="{{ asset('assets/sweetalert2/sweetalert2.all.min.js') }}"></script>
    @if (session('success'))
        <script>
            $(function() {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    showConfirmButton: true,
                    timer: 1500
                })
            })
        </script>
    @elseif(session('error'))
        <script>
            $(function() {
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Gagal!',
                    text: '{{ session('error') }}',
                    showConfirmButton: true,
                    timer: 1500
                })
            })
        </script>
    @endif
@endpush
