@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>

                    <div class="panel-body">
                        @if (Auth::check())
                            <p>Вы успешно вошли в систему!</p>

                            @if (Auth::user()->role == 'admin')
                                <h3>Панель администратора</h3>
                                <ul>
                                    <li><a href="/admin/users">Управление пользователями</a></li>
                                    <li><a href="/admin/withdrawals">Запросы на выплату</a></li>
                                </ul>
                            @else
                                <h3>Личный кабинет пользователя</h3>
                                <ul>
                                    <li><a href="/dashboard">Мой баланс</a></li>
                                    <li><a href="/rewards">История вознаграждений</a></li>
                                    <li><a href="/withdraw">Запросить выплату</a></li>
                                </ul>
                            @endif
                        @else
                            <p>Пожалуйста, войдите или зарегистрируйтесь.</p>
                            <a href="{{ url('/login') }}">Войти</a>
                            <a href="{{ url('/register') }}">Зарегистрироваться</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
