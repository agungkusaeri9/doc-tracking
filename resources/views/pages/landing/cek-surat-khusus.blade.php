<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <title>Cek Surat</title>
    <style>
        body {
            background: #E7ECF8;
            height: 100vh;
        }

        .logo {
            height: 80px;
            width: 80px;
        }

        header {
            background: #4575bd;
        }

        header h2 {
            font-size: 20px;
            color: white;
        }

        .bg-putih {
            background: white;
            height: 50px;
        }

        .bg-gedung {
            background-image: url("{{ asset('assets/images/gedung.png') }}");
            background-repeat: no-repeat;
            background-size: cover;
            height: 450px;
            margin-top: 120px;
            background-color: #E7ECF8;
            border: 1px solid rgb(56, 54, 54);
        }
    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12" style="background: #4575bd;">
                <header class="d-flex justify-content-start py-2">
                    <img src="{{ asset('assets/images/polindra.png') }}" class="img-fluid logo" alt="">
                    <h2 class="align-self-center ml-3">E-Surat <br>
                        Polindra</h2>
                </header>
            </div>
        </div>
        <div class="row bg-putih">
            <div class="col-12">

            </div>
        </div>


    </div>

    <div class="container">
        <div class="row justify-content-center mx-5">
            <div class="col-md-10 bg-gedung">
                <div class="ol-md-10">
                    <div class="row justify-content-center mt-4">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header py-4 bg-primary">
                                    <h3 class="text-center text-white">Surat Keluar</h3>
                                </div>
                                <div class="card-body mx-5">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th>No Surat</th>
                                            <td>{{ $item->no_surat ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Surat</th>
                                            <td>{{ $item->created_at->translatedFormat('d M Y') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Penandatangan</th>
                                            <td>{{ $item->tte_created_user->name ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Perihal</th>
                                            <td>{{ $item->hal }}</td>
                                        </tr>
                                        <tr>
                                            <th>Unit Kerja</th>
                                            <td>{{ $item->unit_kerja->name ?? '-' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"
        integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous">
    </script>
    -->
</body>

</html>
