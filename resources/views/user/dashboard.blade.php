@extends('layouts.app')

<head>
    <title>Личный кабинет</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
        }

        .balance {
            font-size: 1.5em;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .button {
            display: inline-block;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }

        .success {
            color: green;
            margin-top: 10px;
        }
    </style>
    @section('content')

        <div class="container">
            <h1>Добро пожаловать, {{ $user->name }}!</h1>
            <p class="balance">Ваш баланс: ${{ number_format($user->balance, 2) }}</p>
            <a href="/rewards" class="button">История вознаграждений</a>
            <a href="/withdraw" class="button">Запросить выплату</a>

            @if (session('success'))
                <div class="success">{{ session('success') }}</div>
            @endif
        </div>
@endsection