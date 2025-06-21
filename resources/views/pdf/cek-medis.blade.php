<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Form Pemeriksaan Medis</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .section {
            margin-bottom: 20px;
        }

        .hr {
            border-top: 1px solid #333;
            margin: 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #333;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 10px;
        }
    </style>
</head>

<body>
    <h2>Form Pemeriksaan Medis</h2>

    <div class="section">
        <table>
            <tr>
                <th>Nama</th>
                <td>{{ $cek->nama }}</td>
            </tr>
            <tr>
                <th>Tanggal Lahir</th>
                <td>{{ $cek->tanggal_lahir }}</td>
            </tr>
            <tr>
                <th>Jenis Kelamin</th>
                <td>{{ $cek->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
            </tr>
            <tr>
                <th>Rumah Sakit</th>
                <td>{{ $cek->pilih_klinik }}</td>
            </tr>
        </table>
    </div>

    <div class="hr"></div>

    <div class="section">
        <table>
            <tr>
                <th>Gejala</th>
                <td>{{ $cek->gejala }}</td>
            </tr>
            <tr>
                <th>Tekanan Darah</th>
                <td>{{ $cek->tekanan_darah }}</td>
            </tr>
            <tr>
                <th>Denyut Nadi</th>
                <td>{{ $cek->denyut_nadi }}</td>
            </tr>
            <tr>
                <th>Berat Badan</th>
                <td>{{ $cek->berat_badan }} kg</td>
            </tr>
            <tr>
                <th>Tinggi Badan</th>
                <td>{{ $cek->tinggi_badan }} cm</td>
            </tr>
            <tr>
                <th>IMT</th>
                <td>{{ $cek->imt }}</td>
            </tr>
            <tr>
                <th>Suhu</th>
                <td>{{ $cek->suhu }} °C</td>
            </tr>
        </table>
    </div>

    <div class="hr"></div>

    <div class="section">
        <table>
            <tr>
                <th>Paket</th>
                <td>{{ $cek->paket }}</td>
            </tr>
            <tr>
                <th>Jadwal</th>
                <td>{{ $cek->jadwal_tanggal }} {{ $cek->jadwal_jam }}</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>Dokumen ini dihasilkan secara otomatis dan tidak memerlukan tanda tangan.</p>
    </div>
</body>

</html>
