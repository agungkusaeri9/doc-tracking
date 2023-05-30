<html>

<head>
    <title>KOP SURAT</title>
    <style type="text/css">
        body {
            font-family: 'Times New Roman', Times, serif;
            padding-left: 50px;
            padding-right: 30px;
        }

        table {
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
    </style>
    @vite(['resources/js'])
</head>

<body>
    <div class="rangkasurat">
        <table width="100%">
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
        {{-- {{ $body }} --}}
    </div>
    <script>
        window.print();
    </script>
</body>

</html>
