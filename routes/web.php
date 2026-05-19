<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ShoppingListController;
use App\Http\Controllers\MemberController;

// Dashboard
Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard.alt');

// Auth
Route::get('/login',    [LoginController::class,    'showLoginForm'])->name('login');
Route::post('/login',   [LoginController::class,    'login']);
Route::post('/logout',  [LoginController::class,    'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register',[RegisterController::class, 'register']);

// App (auth requise)
Route::middleware('auth')->group(function () {

    // Famille
    Route::get('/family',         [FamilyController::class, 'index'])->name('family.index');
    Route::post('/family',        [FamilyController::class, 'store'])->name('family.store');
    Route::post('/family/join',   [FamilyController::class, 'join'])->name('family.join');
    Route::delete('/family/{family}', [FamilyController::class, 'destroy'])->name('family.destroy');

    // Notifications
    Route::get('/notifications',                  'App\Http\Controllers\NotificationController@index')->name('notifications.index');
    Route::post('/notifications/{id}/read',      'App\Http\Controllers\NotificationController@markAsRead')->name('notifications.read');
    Route::post('/notifications/read-all',       'App\Http\Controllers\NotificationController@markAllAsRead')->name('notifications.readAll');
    Route::delete('/notifications/{id}',         'App\Http\Controllers\NotificationController@delete')->name('notifications.delete');
    Route::get('/api/notifications/unread-count', 'App\Http\Controllers\NotificationController@getUnreadCount')->name('notifications.unreadCount');

    // Membres
    Route::get('/members',              [MemberController::class, 'index'])->name('members.index');
    Route::delete('/members/{member}',  [MemberController::class, 'destroy'])->name('members.destroy');
    Route::post('/members/{member}/role', [MemberController::class, 'updateRole'])->name('members.updateRole');

    // Événements
    Route::resource('events', EventController::class)->except(['show']);

    // Tâches
    Route::resource('tasks', TaskController::class)->except(['show']);
    Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.status');

    // Listes de courses
    Route::resource('shopping-lists', ShoppingListController::class)->except(['show']);
    Route::post('/shopping-lists/{shoppingList}/items', [ShoppingListController::class, 'addItem'])->name('shopping.items.store');
    Route::patch('/shopping-lists/items/{item}/toggle', [ShoppingListController::class, 'toggleItem'])->name('shopping.items.toggle');
});

