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

Route::get('{slug?}', [PageController::class, 'index']);

//Admin
Route::prefix(config('core.admin_prefix'))
->middleware('auth:admins')
->as('admin.')
->namespace('Admin')
->group(function() {
    Route::resource('pages', 'PageController');
});