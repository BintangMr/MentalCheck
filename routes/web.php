<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\DarkModeController;
use App\Http\Controllers\Member\DashboardController as MemberDashboardController;
use App\Http\Controllers\Member\TestController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\Soal\QuestionController;
use App\Http\Controllers\Admin\Soal\ResultController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\Soal\CategoryController as QuestionCategoryController;
use App\Http\Controllers\Admin\Soal\AnswerController as QuestionAnswerController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\SendEmailController;

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

Route::get('dark-mode-switcher', [DarkModeController::class, 'switch'])->name('dark-mode-switcher');
Route::get('/', [PageController::class, 'index'])->name("index");
Route::post('/Email/Feedback', [SendEmailController::class, 'feedback'])->name("email.feedback");
Route::get('article/{id}',[PageController::class,'artikel'])->name('article.detail');

Route::middleware('loggedin')->group(function () {
    Route::get('login', [AuthController::class, 'loginView'])->name('login-view');
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::get('register', [AuthController::class, 'registerView'])->name('register-view');
    Route::post('register', [AuthController::class, 'register'])->name('register');
});

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    if(\Illuminate\Support\Facades\Auth::user()->admin)
    return redirect()->route('admin');
    return redirect()->route('member');
})->middleware(['auth', 'signed'])->name('verification.verify');
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', function () {
        return view('auth.verify-email',[
            'layout' => 'login'
        ]);
    })->name('verification.notice');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/email/verification-notification', function (Request $request) {
        \Illuminate\Support\Facades\Auth::user()->sendEmailVerificationNotification();

        return back()->with('message', 'Link Verifikasi Terkirim!');
    })->middleware(['throttle:6,1'])->name('verification.send');
});

Route::middleware('auth', 'verified')->group(function () {
    Route::get('profile', [ProfileController::class, 'profileView'])->name("profile");
    Route::get('profile/edit', [ProfileController::class, 'profileEditView'])->name("profile.edit");

    Route::prefix('member')->middleware('member')->group(function () {
        Route::get('/', [MemberDashboardController::class, 'index'])->name('member');
        Route::get('/Test', [TestController::class, 'index'])->name('member.test');
        Route::get('/Test/{id}', [TestController::class, 'start'])->name('member.test.start');
        Route::post('/Test/{id}', [TestController::class, 'save'])->name('member.test.store');
        Route::get('/History', [TestController::class, 'history'])->name('member.history');
        Route::get('/History/{id}', [TestController::class, 'historyTest'])->name('member.history.test');

        Route::prefix('profile')->middleware('member')->group(function () {
            Route::get('/', [MemberDashboardController::class, 'profile'])->name('member.profile');
            Route::post('/update/identittas', [MemberDashboardController::class, 'updateIdentitias'])->name('member.update.identitas');
            Route::post('/update/password', [MemberDashboardController::class, 'updatePassword'])->name('member.update.password');

        });
    });

    Route::prefix('admin')->middleware('admin')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name("admin");

        Route::prefix('contact')->group(function () {
            Route::get('/', [ContactController::class, 'index'])->name("admin.contact");
            Route::post('/', [ContactController::class, 'update'])->name("admin.contact.update");
        });

        Route::prefix('teams')->group(function () {
            Route::get('/', [TeamController::class, 'index'])->name("admin.teams");
            Route::get('/create', [TeamController::class, 'create'])->name("admin.teams.create");
            Route::post('/create', [TeamController::class, 'store'])->name("admin.teams.store");
            Route::get('/edit/{id}', [TeamController::class, 'edit'])->name("admin.teams.edit");
            Route::put('/edit/{id}', [TeamController::class, 'update'])->name("admin.teams.update");
            Route::delete('/delete/{id}', [TeamController::class, 'destroy'])->name("admin.teams.delete");
        });

        Route::prefix('article')->group(function () {
            Route::get('/', [ArticleController::class, 'index'])->name("admin.article");
            Route::get('/create', [ArticleController::class, 'create'])->name("admin.article.create");
            Route::post('/create', [ArticleController::class, 'store'])->name("admin.article.store");
            Route::get('/detail/{id}', [ArticleController::class, 'detail'])->name("admin.article.detail");
            Route::get('/edit/{id}', [ArticleController::class, 'edit'])->name("admin.article.edit");
            Route::put('/edit/{id}', [ArticleController::class, 'update'])->name("admin.article.update");
            Route::delete('/delete/{id}', [ArticleController::class, 'destroy'])->name("admin.article.delete");
        });

        Route::prefix('question')->group(function () {
            Route::prefix('category')->group(function () {
                Route::get('/', [QuestionCategoryController::class, 'index'])->name("admin.question.category");
                Route::get('result/{id}', [ResultController::class, 'index'])->name("admin.question.result");
                Route::post('result/{id}', [ResultController::class, 'update'])->name("admin.question.result.update");
                Route::get('create', [QuestionCategoryController::class, 'create'])->name("admin.question.category.create");
                Route::post('create', [QuestionCategoryController::class, 'store'])->name("admin.question.category.store");
                Route::get('edit/{id}', [QuestionCategoryController::class, 'edit'])->name("admin.question.category.edit");
                Route::put('edit/{id}', [QuestionCategoryController::class, 'update'])->name("admin.question.category.update");
                Route::delete('{id}', [QuestionCategoryController::class, 'destroy'])->name("admin.question.category.delete");
            });

            Route::prefix('list')->group(function () {
                Route::get('{question_category_id}', [QuestionController::class, 'index'])->name("admin.question");
                Route::get('{question_category_id}/create', [QuestionController::class, 'create'])->name("admin.question.create");
                Route::post('{question_category_id}/create', [QuestionController::class, 'store'])->name("admin.question.store");
                Route::get('{question_category_id}/edit/{id}', [QuestionController::class, 'edit'])->name("admin.question.edit");
                Route::put('{question_category_id}/edit/{id}', [QuestionController::class, 'update'])->name("admin.question.update");
                Route::delete('{question_category_id}', [QuestionController::class, 'destroy'])->name("admin.question.delete");
            });

            Route::prefix('answer')->group(function () {
                Route::get('{question_category_id}/{question_id}', [QuestionAnswerController::class, 'index'])->name("admin.question.answer");
                Route::get('{question_category_id}/{question_id}/create', [QuestionAnswerController::class, 'create'])->name("admin.question.answer.create");
                Route::post('{question_category_id}/{question_id}/create', [QuestionAnswerController::class, 'store'])->name("admin.question.answer.store");
                Route::get('{question_category_id}/{question_id}/edit/{id}', [QuestionAnswerController::class, 'edit'])->name("admin.question.answer.edit");
                Route::put('{question_category_id}/{question_id}/edit/{id}', [QuestionAnswerController::class, 'update'])->name("admin.question.answer.update");
                Route::delete('{question_category_id}/{question_id}', [QuestionAnswerController ::class, 'destroy'])->name("admin.question.answer.delete");
            });

        });

        Route::prefix('user')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name("admin.user");
            Route::get('/detail/{id}', [UserController::class, 'show'])->name("admin.user.show");
            Route::get('/create', [UserController::class, 'create'])->name("admin.user.create");
            Route::post('/create', [UserController::class, 'store'])->name("admin.user.store");
            Route::put('/edit/identitas/{id}', [UserController::class, 'updateIdentitas'])->name("admin.user.update.identitas");
            Route::get('/edit/{id}', [UserController::class, 'edit'])->name("admin.user.edit");
            Route::put('/edit/password/{id}', [UserController::class, 'updatePassword'])->name("admin.user.update.password");
            Route::delete('{id}', [UserController::class, 'index'])->name("admin.user.delete");
        });
    });
});
