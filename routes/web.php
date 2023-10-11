<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\InertiaTestController;

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

Route::get('/inertia-test', function () {
    return Inertia::render('InertiaTest');
    }
);

Route::get('/component-test', function () {
    return Inertia::render('ComponentTest');
    }
);

Route::get('/inertia/index', [InertiaTestController::class, 'index'])
->name('inertia.index');

Route::get('/inertia/create', [InertiaTestController::class, 'create'])
->name('inertia.create');

Route::post('/inertia', [InertiaTestController::class, 'store'])
->name('inertia.store');

Route::get('/inertia/show/{id}', [InertiaTestController::class, 'show'])
->name('inertia.show');

Route::delete('/inertia/{id}', [InertiaTestController::class, 'delete'])
->name('inertia.delete');

Route::get('/', function () {
    return Inertia::render('Welcome', [
        //'login' ルートが存在する場合は true、存在しない場合は false を 'canLogin' プロパティにセット'Welcome' コンポーネント内でログインが可能かどうかを判断
        'canLogin' => Route::has('login'),
        //'Welcome' コンポーネント内で新規登録が可能かどうかを判断
        'canRegister' => Route::has('register'),
        //Laravel アプリケーションのバージョンを 'laravelVersion' プロパティにセット
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {

    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
