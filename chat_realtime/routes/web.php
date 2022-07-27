<?php

use App\Events\ChatEvent;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

Route::middleware('user-login')->group(function () {

Route::get('chat', function () {
    return view('chat');
});

Route::get('logout', function () {
    Auth::logout();

    return view('login');
});

Route::post('send', function(Request $request){
    $request->validate([
        'message' => 'required'
    ]);
    
    $message = [
        'id' => $request->id,
        'name' => $request->name,
        'message' => $request->message
    ];
    
    ChatEvent::dispatch($message);

});
});

//Form đăng nhập
Route::get('login', [LoginController::class, 'index']);

//Đăng nhập Google
Route::get('/auth/google/redirect', [AuthController::class, 'googleredirect']);
Route::get('/auth/google/callback', [AuthController::class, 'googlecallback']);

