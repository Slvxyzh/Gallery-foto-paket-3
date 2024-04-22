<!-- resources/views/pdf.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Report</title>
    <style>
        /* Tambahkan gaya CSS di sini */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h3>Laporan Aktivitas Pengguna</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Aktivitas</th>
                <th>User ID</th>
                {{-- <th>Waktu</th> --}}
            </tr>
        </thead>
        <tbody>
            @foreach ($activities as $index => $activity)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $activity->aktivitas }}</td>
                    <td>{{ $activity->user_id }}</td>
                    {{-- <td>{{ $activity->created_at }}</td> --}}
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
