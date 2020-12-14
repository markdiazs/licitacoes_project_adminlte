<?php

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

use App\Http\Controllers\ControladorCategoria;
use App\Http\Controllers\LicitacaoController;
use Illuminate\Support\Facades\Route;

Route::get('/','LicitacaoController@dashboard');
Route::get('/novalicitacao','LicitacaoController@create');
Route::post('/novalicitacao/store','LicitacaoController@store');
Route::get('/busca','LicitacaoController@busca');
Route::get('/licitacao/{id}','LicitacaoController@consulta');
Route::get('/download/{id}','LicitacaoController@baixarArquivo');
Route::get('/graficoanual','GraficoController@index');
Route::post('/graficoanual','GraficoController@getLicitacoes');
Route::get('/graficoanualapi','GraficoController@getJson');

Route::get('/licitacao/editar/{id}','LicitacaoController@edit');
Route::get('/cadastro/categoria','LicitacaoController@cadCategoria');
Route::post('/cadastro/categoria/store','LicitacaoController@storeCategoria');
Route::post('/licitacao/delete/{id}','LicitacaoController@delete');


// Route::get('/','LicitacaoController@index');

Auth::routes();

Route::get('/home', 'LicitacaoController@dashboard')->name('home');
