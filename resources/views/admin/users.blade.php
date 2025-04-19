@extends('layouts.app')
    <style>
        body { font-family: sans-serif; margin: 20px; }
        .container { max-width: 800px; margin: 0 auto; }
        h1 { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f0f0f0; }
        .button { display: inline-block; padding: 8px 12px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; margin-right: 5px; }
        .success { color: green; margin-top: 10px; }
    </style>
@section('content')
<div class="container">
    <h1>Управление пользователями</h1>
    @if (session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Имя</th>
            <th>Email</th>
            <th>Баланс</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>${{ number_format($user->balance, 2) }}</td>
                <td><a href="/admin/rewards/create/{{ $user->id }}" class="button">Начислить</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection