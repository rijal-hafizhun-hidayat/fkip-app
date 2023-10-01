<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bimbingan</title>
</head>
<style>
    table, th, td {
        border:1px solid black;
    }
    </style>
<body>
    <p>Nama: {{ $mahasiswa->nama }}</p>
    <p>Nim: {{ $mahasiswa->nim }}</p>
    <table style="width:100%">
        <tr>
            <td>Waktu Bimbingan</td>
            <td>Keterangan Bimbingan</td>
            <td>Catatan Bimbingan</td>
            <td>Tahapan Bimbingan</td>
            <td>Acc Bimbingan</td>
        </tr>
        @foreach ($datas as $data)
        <tr>
            <td>{{ $data->created_at }}</td>
            <td>{{ $data->keterangan_bimbingan }}</td>
            <td>{{ $data->catatan_pembimbing ?? '-' }}</td>
            <td>{{ $data->tahap_bimbingan }}</td>
            <td>{{ setStatuAccBimbingan($data->confirmed) }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>