@extends('layouts.app')

<style>
        body { font-family: sans-serif; margin: 20px; }
        .container { max-width: 400px; margin: 0 auto; }
        h1 { margin-bottom: 20px; }
        form label { display: block; margin-bottom: 5px; }
        form input[type="text"], form input[type="number"], form input[type="email"] { width: 100%; padding: 8px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        form button { background-color: #007bff; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer; }
        .error { color: red; margin-top: 5px; }
        .back-button { display: inline-block; padding: 10px 15px; background-color: #6c757d; color: white; text-decoration: none; border-radius: 5px; margin-top: 20px; }
    </style>
@section('content')

<div class="container">
    <h1>Запрос на выплату</h1>
    <p>Ваш текущий баланс: ${{ number_format($user->balance, 2) }}</p>
    <form method="POST" action="/withdraw">
        {{ csrf_field() }}

        <div>
            <label for="amount">Сумма для вывода:</label>
            <input type="number" id="amount" name="amount" step="0.01" min="1" max="{{ $user->balance }}" required>
            @if ($errors->has('amount'))
                <span class="error">{{ $errors->first('amount') }}</span>
            @endif
        </div>

        <div>
            <label for="paypal_email">Ваш PayPal email:</label>
            <input type="email" id="paypal_email" name="paypal_email" required>
            @if ($errors->has('paypal_email'))
                <span class="error">{{ $errors->first('paypal_email') }}</span>
            @endif
        </div>

        <button type="submit">Отправить запрос</button>
    </form>
    <a href="/dashboard" class="back-button">Назад</a>
</div>
@endsection