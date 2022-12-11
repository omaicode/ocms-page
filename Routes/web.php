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

use Modules\Page\Http\Controllers\PageController;

Route::get('{slug?}', [PageController::class, 'index'])->where('slug', '^(?!api|'.config('core.admin_prefix', 'admin').'|assets|guest).*$');

//Admin
Route::prefix(config('core.admin_prefix'))
->middleware('auth:admins')
->as('admin.')
->namespace('Admin')
->group(function() {
    Route::post('pages/delete', 'PageController@deletes')->name('pages.destroy');
    Route::resource('pages', 'PageController', ['except' => ['destroy', 'show']]);
});