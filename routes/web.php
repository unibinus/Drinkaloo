<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\GameController;
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
Route::get('/', [GameController::class,'index']);
Route::get('/Search', [GameController::class,'searchGame']);

//auth
Route::get('/Login', [AuthController::class,'loginIndex'])->name('login')->middleware('logged.in');
Route::post('/Login', [AuthController::class,'loginForm'])->name('LoginForm');

Route::get('/Logout', [AuthController::class,'logout'])->middleware('auth');

Route::get('/Register', [AuthController::class,'registerIndex'])->middleware('logged.in');
Route::post('/Register', [AuthController::class,'registerForm'])->name('RegisterForm');

//Profile
Route::get('/Profile', [ProfileController::class,'profileIndex'])->middleware('auth');
Route::put('/Profile/Update', [ProfileController::class,'updateProfileForm'])->name('UpdateProfileForm');

//Game
Route::get('/Game/{id}',[GameController::class,'gameDetail'])->middleware('verify.age');
Route::get('/CheckAge',[GameController::class,'checkAgeIndex'])->name('CheckAge');
Route::post('/Game/CheckAge/{id}',[GameController::class,'checkAge'])->name('CheckAgeForm');
Route::post('/Game/AddToCart/{id}',[CartController::class,'addToCart'])->middleware('auth');
//Manage Game only Admin
Route::get('/ManageGame',[GameController::class,'manageGameIndex'])->middleware(['auth','admin']);
Route::get('/ManageGame/FilterGame',[GameController::class,'filterGame'])->name('FilterGame')->middleware(['auth','admin']);
Route::delete('ManageGame/DeleteGame/{id}',[GameController::class,'deleteGame'])->name('DeleteGame')->middleware(['auth','admin']);
Route::get('/UpdateGame/{id}',[GameController::class,'updateGameIndex'])->middleware(['auth','admin']);
Route::put('/UpdateGame/{id}',[GameController::class,'updateGame'])->name('UpdateGame')->middleware(['auth','admin']);
Route::get('/CreateGame',[GameController::class,'createGameIndex'])->middleware(['auth','admin']);
Route::post('/CreateGame',[GameController::class,'createGame'])->name('CreateGame')->middleware(['auth','admin']);

//Cart

//Friend
Route::get('/Friend', [FriendController::class,'friendIndex'])->middleware(['auth','member']);
Route::post('/Friend/AddFriend', [FriendController::class, 'addFriend'])->name('AddFriend')->middleware(['auth','member']);
Route::post('/Friend/Cancel', [FriendController::class, 'cancelRequest'])->name('CancelRequest')->middleware(['auth','member']);
Route::post('/Friend/Incoming', [FriendController::class, 'incomingRequest'])->name('IncomingRequest')->middleware(['auth','member']);

//Transaction
Route::get('/TransactionHistory', [TransactionController::class,'transactionHistory'])->middleware(['auth','member']);
Route::get('/Cart', [CartController::class,'index'])->middleware(['auth','member']);
Route::delete('/DeleteCart/{id}', [CartController::class,'deleteItemCart'])->middleware(['auth','member']);
Route::get('/TransactionInformation', [TransactionController::class, 'transactionInformationIndex'])->middleware(['auth','member','valid.cart']);
Route::post('/TransactionInformation/Detail', [TransactionController::class, 'transactionInformation'])->name('TransactionInformation')->middleware(['auth','member']);
Route::get('/TransactionReceipt', [TransactionController::class, 'transactionReceiptIndex'])->middleware(['auth','member']);
