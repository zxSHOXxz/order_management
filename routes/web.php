<?php

use App\Http\Controllers\Apps\OrderController;
use App\Http\Controllers\Apps\PermissionManagementController;
use App\Http\Controllers\Apps\RoleManagementController;
use App\Http\Controllers\Apps\UserManagementController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\DashboardController;

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

Route::middleware(['auth', 'checkUserStatus'])->group(function () {

    Route::get('/', [DashboardController::class, 'index']);

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::name('user-management.')->group(function () {
        Route::resource('/user-management/users', UserManagementController::class);
        Route::resource('/user-management/roles', RoleManagementController::class);
        Route::resource('/user-management/permissions', PermissionManagementController::class);
    });
    Route::resource('/order-management/orders', OrderController::class);
    Route::get('/attachments/{attachment}/download', [AttachmentController::class, 'download'])
        ->name('attachments.download');
    Route::get('/orders/{order}/requirements', [OrderController::class, 'getRequirements']);
    Route::post('/requirements/{requirement}/complete', [AttachmentController::class, 'markAsCompleted'])->name('requirements.complete');
    Route::put('/orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::put('/requirements/{requirement}/update-status', [AttachmentController::class, 'updateStatus'])->name('requirements.updateStatus');
});

Route::get('/user-inactive', function () {
    return view('user.inactive'); // عرض صفحة المستخدم غير الفعال
})->name('user.inactive');

Route::get('/error', function () {
    abort(500);
});

Route::get('/google/redirect', [SocialiteController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/google/callback', [SocialiteController::class, 'handleGoogleCallback'])->name('google.callback');



require __DIR__ . '/auth.php';