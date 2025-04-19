@extends('layouts.app')
<style>
        body { font-family: sans-serif; margin: 20px; }
        .container { max-width: 600px; margin: 0 auto; }
        h1 { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f0f0f0; }
        .back-button { display: inline-block; padding: 10px 15px; background-color: #6c757d; color: white; text-decoration: none; border-radius: 5px; margin-top: 20px; }
    </style>
    @section('content')

<div class="container">
    <h1>История вознаграждений</h1>
    @if ($rewards->isEmpty())
        <p>У вас пока нет вознаграждений.</p>
    @else
        <table>
            <thead>
            <tr>
                <th>Дата</th>
                <th>Сумма</th>
                <th>Причина</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($rewards as $reward)
                <tr>
                    <td>{{ $reward->created_at }}</td>
                    <td>${{ number_format($reward->amount, 2) }}</td>
                    <td>{{ $reward->reason }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
    <a href="/dashboard" class="back-button">Назад</a>
</div>
@endsection