<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MembershipCategoryController;
use App\Http\Controllers\MembershipLevelController;
use App\Models\Member;
use App\Models\MembershipCategory;
use App\Models\MembershipLevel;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', [PageController::class, 'about']);

Route::get('/tasks/{id}', [PageController::class, 'task']);

Route::get('/tasks', [TaskController::class, 'index'])
    ->name('tasks.index');

Route::post('/tasks', [TaskController::class, 'store'])
    ->name('tasks.store');

Route::resource('categories', MembershipCategoryController::class);
Route::resource('levels', MembershipLevelController::class);
Route::resource('members', MemberController::class);
Route::get('/dashboard', function () {
    $members = Member::with(['category', 'level'])->get();
    $categories = MembershipCategory::all();
    $levels = MembershipLevel::all();

    return view('dashboard', compact('members', 'categories', 'levels'));
})->name('dashboard');
