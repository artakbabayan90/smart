@extends('layouts.app')
    <style>
        body { font-family: sans-serif; margin: 20px; }
        .container { max-width: 800px; margin: 0 auto; }
        h1 { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f0f0f0; }
        .button { display: inline-block; padding: 8px 12px; background-color: #28a745; color: white; text-decoration: none; border-radius: 5px; margin-right: 5px; }
        .success { color: green; margin-top: 10px; }
    </style>
@section('content')
<div class="container">
    <h1>Запросы на выплату</h1>
    @if (session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif
    @if ($withdrawals->isEmpty())
        <p>Нет ожидающих запросов на выплату.</p>
    @else
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Пользователь</th>
                <th>Сумма</th>
                <th>PayPal Email</th>
                <th>Дата запроса</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($withdrawals as $withdrawal)
                <tr>
                    <td>{{ $withdrawal->id }}</td>
                    <td>{{ $withdrawal->user->name }}</td>
                    <td>${{ number_format($withdrawal->amount, 2) }}</td>
                    <td>{{ $withdrawal->paypal_email }}</td>
                    <td>{{ $withdrawal->created_at }}</td>
                    <td>
                        <form method="POST" action="/admin/withdrawals/approve/{{ $withdrawal->id }}">
                            {{ csrf_field() }}
                            <button type="submit" class="button">Подтвердить</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
