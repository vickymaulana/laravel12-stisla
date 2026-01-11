<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/change-password', [ProfileController::class, 'changepassword'])->name('profile.change-password');
    Route::put('/profile/password', [ProfileController::class, 'password'])->name('profile.password');
    Route::get('/blank-page', [App\Http\Controllers\HomeController::class, 'blank'])->name('blank');

    Route::get('/hakakses', [App\Http\Controllers\HakaksesController::class, 'index'])->name('hakakses.index')->middleware('superadmin');
    Route::get('/hakakses/edit/{id}', [App\Http\Controllers\HakaksesController::class, 'edit'])->name('hakakses.edit')->middleware('superadmin');
    Route::put('/hakakses/update/{id}', [App\Http\Controllers\HakaksesController::class, 'update'])->name('hakakses.update')->middleware('superadmin');
    Route::delete('/hakakses/delete/{id}', [App\Http\Controllers\HakaksesController::class, 'destroy'])->name('hakakses.delete')->middleware('superadmin');

    Route::get('/table-example', [App\Http\Controllers\ExampleController::class, 'table'])->name('table.example');
    Route::get('/clock-example', [App\Http\Controllers\ExampleController::class, 'clock'])->name('clock.example');
    Route::get('/chart-example', [App\Http\Controllers\ExampleController::class, 'chart'])->name('chart.example');
    Route::get('/form-example', [App\Http\Controllers\ExampleController::class, 'form'])->name('form.example');
    Route::get('/map-example', [App\Http\Controllers\ExampleController::class, 'map'])->name('map.example');
    Route::get('/calendar-example', [App\Http\Controllers\ExampleController::class, 'calendar'])->name('calendar.example');
    Route::get('/gallery-example', [App\Http\Controllers\ExampleController::class, 'gallery'])->name('gallery.example');
    Route::get('/todo-example', [App\Http\Controllers\ExampleController::class, 'todo'])->name('todo.example');
    Route::get('/contact-example', [App\Http\Controllers\ExampleController::class, 'contact'])->name('contact.example');
    Route::get('/faq-example', [App\Http\Controllers\ExampleController::class, 'faq'])->name('faq.example');
    Route::get('/news-example', [App\Http\Controllers\ExampleController::class, 'news'])->name('news.example');
    Route::get('/about-example', [App\Http\Controllers\ExampleController::class, 'about'])->name('about.example');

    // Activity Logs Routes
    Route::get('/activity-logs', [App\Http\Controllers\ActivityLogController::class, 'index'])->name('activity-logs.index')->middleware('superadmin');
    Route::get('/activity-logs/export/excel', [App\Http\Controllers\ActivityLogController::class, 'export'])->name('activity-logs.export')->middleware('superadmin');
    Route::get('/activity-logs/{id}', [App\Http\Controllers\ActivityLogController::class, 'show'])->name('activity-logs.show')->middleware('superadmin');
    Route::delete('/activity-logs/{id}', [App\Http\Controllers\ActivityLogController::class, 'destroy'])->name('activity-logs.destroy')->middleware('superadmin');
    Route::delete('/activity-logs', [App\Http\Controllers\ActivityLogController::class, 'clear'])->name('activity-logs.clear')->middleware('superadmin');

    // Settings Routes
    Route::get('/settings', [App\Http\Controllers\SettingController::class, 'index'])->name('settings.index')->middleware('superadmin');
    Route::put('/settings', [App\Http\Controllers\SettingController::class, 'update'])->name('settings.update')->middleware('superadmin');
    Route::post('/settings', [App\Http\Controllers\SettingController::class, 'store'])->name('settings.store')->middleware('superadmin');
    Route::post('/settings/reset', [App\Http\Controllers\SettingController::class, 'reset'])->name('settings.reset')->middleware('superadmin');

    // Notifications Routes
    Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/mark-as-read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');
    Route::post('/notifications/mark-all-read', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::delete('/notifications/{id}', [App\Http\Controllers\NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::delete('/notifications', [App\Http\Controllers\NotificationController::class, 'destroyAll'])->name('notifications.destroy-all');
    Route::get('/notifications/send-test', [App\Http\Controllers\NotificationController::class, 'sendTest'])->name('notifications.send-test');
    Route::get('/notifications/create', [App\Http\Controllers\NotificationController::class, 'create'])->name('notifications.create')->middleware('superadmin');
    Route::post('/notifications/send', [App\Http\Controllers\NotificationController::class, 'send'])->name('notifications.send')->middleware('superadmin');

    // File Manager Routes
    Route::get('/file-manager', [App\Http\Controllers\FileManagerController::class, 'index'])->name('file-manager.index');
    Route::post('/file-manager/upload', [App\Http\Controllers\FileManagerController::class, 'upload'])->name('file-manager.upload');
    Route::get('/file-manager/{id}/download', [App\Http\Controllers\FileManagerController::class, 'download'])->name('file-manager.download');
    Route::put('/file-manager/{id}', [App\Http\Controllers\FileManagerController::class, 'update'])->name('file-manager.update');
    Route::delete('/file-manager/{id}', [App\Http\Controllers\FileManagerController::class, 'destroy'])->name('file-manager.destroy');
    Route::get('/file-manager/{id}/show', [App\Http\Controllers\FileManagerController::class, 'show'])->name('file-manager.show');
    Route::post('/file-manager/create-folder', [App\Http\Controllers\FileManagerController::class, 'createFolder'])->name('file-manager.create-folder');

    // System Info Route (Superadmin only)
    Route::get('/system-info', [App\Http\Controllers\SystemInfoController::class, 'index'])->name('system-info.index')->middleware('superadmin');
});
