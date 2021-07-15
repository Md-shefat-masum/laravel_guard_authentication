<?php

use App\Models\Admin;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('user')->name('user.')->group(function(){

    Route::group( ['middleware'=>['guest:web','PreventBack']],function(){
        Route::view('/login', 'user_auth.login')->name('login');
        Route::view('/register', 'user_auth.resgister')->name('register');

        Route::post('/login_to','Controller@login_to')->name('login_to');
    });

    Route::group( ['middleware'=>['auth:web','PreventBack'] ],function(){
        Route::view('/dashboard', 'dashboard')->name('dashboard');
        Route::get('/profile','Controller@profile')->name('profile');
    });

});

Route::prefix('admin')->name('admin.')->group(function(){
    Route::group( ['middleware'=>['guest:admin','PreventBack']],function(){
        Route::view('/login', 'admin.login')->name('login');
        Route::post('/login_to_admin','Controller@login_to_admin')->name('login_to_admin');
    });

    Route::group( ['middleware'=>['auth:admin','PreventBack']],function(){
        Route::view('/dashboard', 'admin_dashboard')->name('dashboard');

        Route::get('/logout',function(){
            Auth::guard('admin')->logout();
            return redirect()->route('admin.login');
        })->name('logout');
    });
});

Route::prefix('customer')->name('customer.')->group(function(){
    Route::group( ['middleware'=>['guest:customer','PreventBack']],function(){
        Route::view('/login', 'customer.login')->name('login');
        Route::post('/login_to_customer','Controller@login_to_customer')->name('login_to_customer');
    });

    Route::group( ['middleware'=>['auth:customer','PreventBack']],function(){
        Route::view('/dashboard', 'customer_dashboard')->name('dashboard');

        Route::get('/logout',function(){
            Auth::guard('customer')->logout();
            return redirect()->route('customer.login');
        })->name('logout');
    });
});

Route::get('/create-admin',function(){
    Admin::truncate();
    Admin::insert([
        'name' => 'admin guard',
        'email' => 'admin_guard@gmail.com',
        'password' => Hash::make('12345678'),
        'created_at' => Carbon::now()->toDateTimeString(),
    ]);

    Admin::insert([
        'name' => 'admin guard2',
        'email' => 'admin_guard2@gmail.com',
        'password' => Hash::make('12345678'),
        'created_at' => Carbon::now()->toDateTimeString(),
    ]);
});

Route::get('/create-customer',function(){
    Customer::truncate();
    Customer::insert([
        'name' => 'customer guard',
        'email' => 'customer_guard@gmail.com',
        'password' => Hash::make('12345678'),
        'created_at' => Carbon::now()->toDateTimeString(),
    ]);

    Customer::insert([
        'name' => 'customer guard2',
        'email' => 'customer_guard2@gmail.com',
        'password' => Hash::make('12345678'),
        'created_at' => Carbon::now()->toDateTimeString(),
    ]);
});

