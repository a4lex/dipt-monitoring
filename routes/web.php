<?php

use App\Service\CreateMikrotik;
use Illuminate\Support\Facades\Route;

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



/*
 *
 *  TODO:
 *      1.
 *
 */
Auth::routes([
    'register' => false,
    'confirm' => false,
    'reset' => false,
]);

Route::middleware(['auth'])->group(function () {

    Route::get('/', function () {
        return view('app');
    });

    //
    //  Devices Routes
    //
    Route::get('/devices/create',       'DeviceController@create');
    Route::post('/devices',             'DeviceController@store');

    //
    //  RRD DB Routes
    //
    Route::get('/rrd',                  'RRDController@getRRDData');

    //
    //  Column Visibility Routes
    //
    Route::post('/change_visibility',   'ColumnVisibilityController@change_visibility');

    //
    //  Represent Main Routes
    //
    Route::get('/{model}',              'RepresentController@index');
    Route::post('/{model}',             'RepresentController@store')->middleware(['null2string', ]);
    Route::get('/{model}/create',       'RepresentController@create');
    Route::get('/{model}/{id}',         'RepresentController@show');
    Route::put('/{model}/{id}',         'RepresentController@update')->middleware(['null2string', ]);
    Route::delete('/{model}/{id}',      'RepresentController@destroy');
    Route::get('/{model}/{id}/edit',    'RepresentController@edit');
});



