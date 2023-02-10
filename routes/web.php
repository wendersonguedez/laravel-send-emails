<?php

use App\Mail\ExampleMail;
use App\Mail\UserWelcome;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-email-markdown', function () {
    return (new UserWelcome())->render();

    Mail::to("wenderson@gmail.com")
        ->send(new UserWelcome());

    return 'email markdown enviado';
});

Route::get('/test-email', function () {
    // return (new ExampleMail())->render();
    $user = User::factory()->create();
    Mail::to('wendersonguedez4@gmail.com')->send(new ExampleMail($user));

    return 'email enviado';
});
