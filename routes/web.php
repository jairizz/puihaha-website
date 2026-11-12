<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MembershipCategoryController;
use App\Http\Controllers\MembershipLevelController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route(auth()->check() ? 'dashboard' : 'login');
});

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

Route::middleware('auth')->group(function (): void {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');

    Route::resource('members', MemberController::class);
    Route::resource('categories', MembershipCategoryController::class);
    Route::resource('levels', MembershipLevelController::class);

    Route::resource('transactions', TransactionController::class)->only([
        'index',
        'create',
        'store',
        'show',
    ]);
    Route::post('/transactions/{transaction}/approve', [TransactionController::class, 'approve'])
        ->name('transactions.approve');
    Route::post('/transactions/{transaction}/cancel', [TransactionController::class, 'cancel'])
        ->name('transactions.cancel');
    Route::get('/transactions/{transaction}/receipt', [TransactionController::class, 'receipt'])
        ->name('transactions.receipt');

    Route::get('/transactions/{transaction}/payments/create', [PaymentController::class, 'create'])
        ->name('payments.create');
    Route::post('/transactions/{transaction}/payments', [PaymentController::class, 'store'])
        ->name('payments.store');
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
});

Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/tasks/{id}', [PageController::class, 'task'])->name('tasks.show');
Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
