<?php

use Illuminate\Support\Facades\Route;
use App\Customer;
use App\Transaction;

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
    return redirect('/login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/driver', 'HomeController@driver')->name('driver');
Route::get('/customer', 'HomeController@customer')->name('customer');
Route::post('/export', 'HomeController@export')->name('export');
Route::post('/export_pdf', 'HomeController@export_pdf')->name('export_pdf');
Route::get('/customer/{id}', 'HomeController@show');

Route::get('coba', function () {
    $haha = Customer::find(1)->transaction()->orderBy('date')->get();
    $transaction_terakhir = $haha[$haha->count() - 1];
    $ab = $haha->where('date', '>', date('Y-m-d'));
    dd($ab);
});
