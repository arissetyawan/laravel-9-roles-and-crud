<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PriorityController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\DocumentController;
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

// Route::get('/', function () {
//     return redirect('/home');
// });

Route::middleware('auth')->controller(UserController::class)->prefix('user')->group(function ()
{
    Route::get('/','index')->name('user');
    
    Route::get('/create','create')->name('user/create');

    Route::post('/store', 'store')->name('user/store');

    Route::get('/edit/{id}', 'edit')->name('user/edit')->where('id','[0-9]+');

    Route::post('/update', 'update')->name('user/update')->where('id','[0-9]+');

    Route::get('/destroy/{id}', 'destroy')->name('user/destroy')->where('id','[0-9]+');


});

Route::middleware('auth')->controller(ProfileController::class)->prefix("profile")->group(function (){
   
    Route::get('/edit','edit')->name('profile/edit');

    Route::post('/update','update')->name('profile/update');

    Route::post('/updatePassword','updatePassword')->name('profile/updatePassword');

});

Route::middleware('auth')->controller(RoleController::class)->prefix("role")->group(function (){

Route::get('/', 'index')->name('role');

Route::get('/create', 'create')->name('role/create');

Route::post('/store', 'store')->name('role/store');

Route::get('/edit/{id}', 'edit')->name('role/edit')->where('id','[0-9]+');

Route::post('/update', 'update')->name('role/update')->where('id','[0-9]+');

Route::get('/destroy/{id}', 'destroy')->name('role/destroy')->where('id','[0-9]+');

});

Route::middleware('auth')->controller(StatusController::class)->prefix("status")->group(function (){

Route::get('/', 'index')->name('status');

Route::get('/create', 'create')->name('status/create');

Route::post('/store', 'store')->name('status/store');

Route::get('/edit/{id}', 'edit')->name('status/edit')->where('id','[0-9]+');

Route::post('/update', 'update')->name('status/update')->where('id','[0-9]+');

Route::get('/destroy/{id}', 'destroy')->name('status/destroy')->where('id','[0-9]+');

});


Route::middleware('auth')->controller(CategoryController::class)->prefix("category")->group(function (){

    Route::get('/', 'index')->name('category');
    
    Route::get('/create', 'create')->name('category/create');
    
    Route::post('/store', 'store')->name('category/store');
    
    Route::get('/edit/{id}', 'edit')->name('category/edit')->where('id','[0-9]+');
    
    Route::post('/update', 'update')->name('category/update')->where('id','[0-9]+');
    
    Route::get('/destroy/{id}', 'destroy')->name('category/destroy')->where('id','[0-9]+');
    
});


Route::middleware('auth')->controller(PriorityController::class)->prefix("priority")->group(function (){

    Route::get('/', 'index')->name('priority');

    Route::get('/create', 'create')->name('priority/create');

    Route::post('/store', 'store')->name('priority/store');

    Route::get('/edit/{id}', 'edit')->name('priority/edit')->where('id','[0-9]+');

    Route::post('/update', 'update')->name('priority/update')->where('id','[0-9]+');

    Route::get('/destroy/{id}', 'destroy')->name('priority/destroy')->where('id','[0-9]+');

});

Route::middleware('auth')->controller(TicketController::class)->prefix("ticket")->group(function (){

    Route::get('/', 'index')->name('ticket');

    Route::get('/create', 'create')->name('ticket/create');

    Route::post('/store', 'store')->name('ticket/store');

    Route::get('/edit/{id}', 'edit')->name('ticket/edit')->where('id','[0-9]+');

    Route::post('/update', 'update')->name('ticket/update')->where('id','[0-9]+');

    Route::get('/destroy/{id}', 'destroy')->name('ticket/destroy')->where('id','[0-9]+');

});


Route::middleware('auth')->controller(DocumentController::class)->prefix("document")->group(function (){
    Route::get('/', 'index')->name('document');
    Route::get('/create', 'create')->name('document/create');
    Route::post('/store', 'store')->name('document/store');
    Route::get('/edit/{id}', 'edit')->name('document/edit')->where('id','[0-9]+');
    Route::post('/update', 'update')->name('document/update')->where('id','[0-9]+');
    Route::get('/destroy/{id}', 'destroy')->name('document/destroy')->where('id','[0-9]+');
});

Auth::routes([
    'reset' => false, // Disable password reset routes
    'verify'  => false,
    'register' => false
]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\IndexController::class, 'index'])->name('index');
/**
* Document Upload Routes
// */
// Route::get('/documents', 'DocumentsController@index')->name('documents.index');
// Route::get('/documents/add', 'DocumentsController@create')->name('documents.create');
// Route::post('/documents/add', 'DocumentsController@store')->name('documents.store');