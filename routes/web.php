<?php

use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('home');
});

Route::group(['middleware' => 'auth'], function () {
    // Роуты для обычных пользователей
    Route::get('/dashboard', 'UserController@dashboard'); // Вывод баланса
    Route::get('/rewards', 'UserController@rewards'); // История вознаграждений
    Route::get('/withdraw', 'UserController@withdrawForm'); // Форма запроса на выплату
    Route::post('/withdraw', 'UserController@submitWithdrawalRequest'); // Обработка запроса на выплату

    // Роуты для админов (защищены middleware)
    Route::group(['middleware' => 'admin'], function () {
        Route::get('/admin/users', 'AdminController@users'); // Таблица пользователей и балансы
        Route::get('/admin/rewards/create/{user}', 'AdminController@createRewardForm'); // Форма начисления вознаграждения
        Route::post('/admin/rewards/store/{user}', 'AdminController@storeReward'); // Обработка начисления вознаграждения
        Route::get('/admin/withdrawals', 'AdminController@withdrawals'); // Страница запросов на выплату
        Route::post('/admin/withdrawals/approve/{withdrawal}', 'AdminController@approveWithdrawal'); // Подтверждение выплаты
    });
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
