<html>

<head>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        table,
        th,
        td {
            border: 1px solid black;
            height: 20px;
        }
    </style>
    <h1>Daftar Kategori</h1>
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $category)
            <tr>
                <td>{{ $category->name }}</td>
                <td>{{ $category->description }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</head>

</html>