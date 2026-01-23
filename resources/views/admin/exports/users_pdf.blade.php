<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Users</title>
</head>

<body>
    <h2>Users</h2>
    <p>Tanggal Export: {{ date('d-m-Y H:i:s') }}</p>
    <br><br>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Tanggal Dibuat</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td>{{ $user->created_at->format('d-m-Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
