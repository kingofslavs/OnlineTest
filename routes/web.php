<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [TestController::class, 'index'])->name('home');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/createTest', [TestController::class, 'create'])->name('tests.create')->middleware('auth');

Route::post('/createTest', [TestController::class, 'store'])->name('tests.store')->middleware('auth');

Route::get('/test/{id}', [TestController::class, 'show'])->name('tests.show');
Route::post('/test/{id}/check', [TestController::class, 'checkAnswers'])->name('tests.check');

Route::get('/my-tests', [TestController::class, 'myTests'])->name('tests.my')->middleware('auth');
Route::get('/my-tests/{id}/edit', [TestController::class, 'edit'])->name('tests.editMyTest')->middleware(['auth', 'test.owner']);
Route::put('/my-tests/{id}', [TestController::class, 'update'])->name('tests.update')->middleware(['auth', 'test.owner']);
Route::get('/my-tests/{id}/questions', [TestController::class, 'showQuestions'])->name('tests.questions')->middleware(['auth', 'test.owner']);
Route::get('/my-tests/{test}/questions/{question}/edit', [TestController::class, 'editQuestion'])->name('tests.edit_question')->middleware(['auth', 'test.owner']);
Route::put('/my-tests/{test}/questions/{question}', [TestController::class, 'updateQuestion'])->name('tests.questions.update')->middleware(['auth', 'test.owner']);
Route::get('/my-tests/{id}/questions/add', [TestController::class, 'addQuestion'])->name('tests.questions.add')->middleware(['auth', 'test.owner']);
Route::post('/my-tests/{id}/questions', [TestController::class, 'storeQuestion'])->name('tests.questions.store')->middleware(['auth', 'test.owner']);
Route::delete('/my-tests/{test}/questions/{question}', [TestController::class, 'destroyQuestion'])->name('tests.questions.destroy')->middleware(['auth', 'test.owner']);
Route::delete('/my-tests/{id}', [TestController::class, 'destroy'])->name('tests.destroy')->middleware(['auth', 'test.owner']);

Route::get('/profile', [AuthController::class, 'profile'])->name('profile')->middleware('auth');
Route::put('/profile/password', [AuthController::class, 'passwordChange'])->name('profile.change-password')->middleware('auth');
Route::put('/profile/name', [AuthController::class, 'nameChange'])->name('profile.change-name')->middleware('auth');

Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/tests/{id}/edit', [AdminController::class, 'editTest'])->name('admin.tests.edit');
    Route::put('/admin/tests/{id}', [AdminController::class, 'updateTest'])->name('admin.tests.update');
    Route::delete('/admin/tests/{id}', [AdminController::class, 'destroyTest'])->name('admin.tests.destroy');
    Route::get('/admin/tests/{test}/questions', [AdminController::class, 'editQuestions'])->name('admin.tests.questions');
    Route::get('/admin/questions/{question}/edit', [AdminController::class, 'editQuestion'])->name('admin.questions.edit');
    Route::put('/admin/questions/{question}', [AdminController::class, 'updateQuestion'])->name('admin.questions.update');
    Route::delete('/admin/questions/{question}', [AdminController::class, 'destroyQuestion'])->name('admin.questions.destroy');
    Route::get('/admin/tests/{id}/questions/add', [AdminController::class, 'addQuestion'])->name('admin.questions.add');
    Route::post('/admin/tests/{id}/questions', [AdminController::class, 'storeQuestion'])->name('admin.questions.store');
});
