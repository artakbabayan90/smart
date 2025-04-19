@extends('layouts.app')
<style>
    body { font-family: sans-serif; margin: 20px; }
    .container { max-width: 400px; margin: 0 auto; }
    h1 { margin-bottom: 20px; }
    form label { display: block; margin-bottom: 5px; }
    form input[type="number"], form textarea { width: 100%; padding: 8px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
    form button { background-color: #007bff; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer; }
    .error { color: red; margin-top: 5px; }
    .back-button { display: inline-block; padding: 10px 15px; background-color: #6c757d; color: white; text-decoration: none; border-radius: 5px; margin-top: 20px; }
</style>
@section('content')
    <div class="container">
        <h1>Начислить вознаграждение пользователю {{ $user->name }}</h1>
        <form method="POST" action="/admin/rewards/store/{{ $user->id }}">
            {{ csrf_field() }}

            <div>
                <label for="amount">Сумма вознаграждения:</label>
                <input type="number" id="amount" name="amount" step="0.01" min="0.01" required>
                @if ($errors->has('amount'))
                    <span class="error">{{ $errors->first('amount') }}</span>
                @endif
            </div>

            <div>
                <label for="reason">Причина вознаграждения:</label>
                <textarea id="reason" name="reason" rows="3" required></textarea>
                @if ($errors->has('reason'))
                    <span class="error">{{ $errors->first('reason') }}</span>
                @endif
            </div>

            <button type="submit">Начислить</button>
        </form>
        <a href="/admin/users" class="back-button">Назад</a>
    </div>
@endsection
