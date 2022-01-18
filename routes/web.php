<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\DrinkController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Middleware\ValidCart;
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

//home
Route::get('/', [DrinkController::class,'index']);
Route::get('/Search', [DrinkController::class,'searchDrink']);

//auth
Route::get('/Login', [AuthController::class,'loginIndex'])->name('login')->middleware('logged.in');
Route::post('/Login', [AuthController::class,'loginForm'])->name('LoginForm');

Route::get('/Logout', [AuthController::class,'logout'])->middleware('auth');

Route::get('/Register', [AuthController::class,'registerIndex'])->middleware('logged.in');
Route::post('/Register', [AuthController::class,'registerForm'])->name('RegisterForm');

//Profile
Route::get('/Profile', [ProfileController::class,'profileIndex'])->middleware('auth');
Route::put('/Profile/Update', [ProfileController::class,'updateProfileForm'])->name('UpdateProfileForm');

//Drink
Route::get('/Drink/{id}',[DrinkController::class,'drinkDetail'])->middleware('verify.age');
Route::get('/CheckAge',[DrinkController::class,'checkAgeIndex'])->name('CheckAge');
Route::post('/Drink/CheckAge/{id}',[DrinkController::class,'checkAge'])->name('CheckAgeForm');
Route::post('/Drink/AddToCart/{id}',[CartController::class,'addToCart'])->middleware('auth');
//Manage Drink only Admin
Route::get('/ManageDrink',[DrinkController::class,'manageDrinkIndex'])->middleware(['auth','admin']);
Route::get('/ManageDrink/FilterDrink',[DrinkController::class,'filterDrink'])->name('FilterDrink')->middleware(['auth','admin']);
Route::delete('ManageDrink/DeleteDrink/{id}',[DrinkController::class,'deleteDrink'])->name('DeleteDrink')->middleware(['auth','admin']);
Route::delete('DeleteDrink/{id}',[DrinkController::class,'deleteDrink'])->name('DeleteDrink')->middleware(['auth','admin']);
Route::get('/UpdateDrink/{id}',[DrinkController::class,'updateDrinkIndex'])->middleware(['auth','admin']);
Route::put('/UpdateDrink/{id}',[DrinkController::class,'updateDrink'])->name('UpdateDrink')->middleware(['auth','admin']);
Route::get('/CreateDrink',[DrinkController::class,'createDrinkIndex'])->middleware(['auth','admin']);
Route::post('/CreateDrink',[DrinkController::class,'createDrink'])->name('CreateDrink')->middleware(['auth','admin']);

//Cart
//Transaction
Route::get('/TransactionHistory', [TransactionController::class,'transactionHistory'])->middleware(['auth','member']);
Route::get('/Cart', [CartController::class,'index'])->middleware(['auth','member']);
Route::delete('/DeleteCart/{id}', [CartController::class,'deleteItemCart'])->middleware(['auth','member']);
Route::get('/TransactionInformation', [TransactionController::class, 'transactionInformationIndex'])->middleware(['auth','member','valid.cart']);
Route::post('/TransactionInformation/Detail', [TransactionController::class, 'transactionInformation'])->name('TransactionInformation')->middleware(['auth','member']);
Route::get('/TransactionReceipt', [TransactionController::class, 'transactionReceiptIndex'])->middleware(['auth','member']);
