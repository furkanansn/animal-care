<?php

use App\Http\Controllers\Api\DiseasesController;
use App\Http\Controllers\Api\DonationController;
use App\Http\Controllers\Api\Homepage\HomeController;
use App\Http\Controllers\Api\MedicineController;
use App\Http\Controllers\Api\OperationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Animal\AnimalController;
use App\Http\Controllers\Api\Cities\CitiesController;
use App\Http\Controllers\Api\Notice\NoticeController;
use App\Http\Controllers\Api\Sector\SectorController;
use App\Http\Controllers\Api\User\UserController;
use App\Http\Controllers\Api\Event\EventController;
use App\Http\Controllers\Api\Databank\DatabankController;
use App\Http\Controllers\Api\Databank\DatabankCategoryController;
use App\Http\Controllers\Api\Announcement\AnnouncementController;
use App\Http\Controllers\Api\Announcement\AnnouncementTypeController;
use App\Http\Controllers\Api\Animal\KindController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::name('api.')->prefix('v1')->middleware('log')->group(static function () {

    /*______________________________AUTH_________________________*/

    Route::name('auth.')->prefix('auth')->group(static function () {

        Route::post('/register', [AuthController::class, 'register'])
            ->name('register')
            ->middleware('isLogged');
        Route::post('/login', [AuthController::class, 'login'])
            ->name('login')
            ->middleware('isLogged');


        Route::post('/approve', [AuthController::class, 'userApprove'])->name('approve')->middleware('isLogged');

        Route::post('/forget-password', [AuthController::class, 'forget'])->name('forget.password');
        Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('reset.password');

        Route::post('/deleteAccount', [AuthController::class, 'deleteAccount'])->name('deleteAccount')->middleware('isLogin');

        Route::delete('/logout', [AuthController::class, 'logout'])->middleware('isLogin')->name('logout');

    });

    /*______________________________END-AUTH_________________________*/

    Route::name('animals.')->middleware('isLogin')->prefix('animals')->group(static function () {

        Route::get('/', [AnimalController::class, 'index'])->name('index');
        Route::get('/get/{id}', [AnimalController::class, 'get'])->name('get');

        Route::post('/create', [AnimalController::class, 'create'])->name('create');
        Route::match(['post', 'put'], '/update/{id}', [AnimalController::class, 'update'])->name('update');

        Route::delete('/delete/{id}', [AnimalController::class, 'delete'])->name('delete');
        Route::get('/show', [AnimalController::class, 'showPhoto'])->withoutMiddleware(['isLogin', 'headerCheck']);

        Route::get('/qr/{id}', [AnimalController::class, 'qr'])->name('qr')->withoutMiddleware(['isLogin', 'headerCheck']);
        Route::get('/getAnimal/{uuid}', [AnimalController::class, 'uuid'])->name('uuid');

    });

    Route::name('animal-kinds.')->middleware('isLogin')->prefix('animal-kinds')->group(static function () {

        Route::get('/', [KindController::class, 'index'])->name('index');
        Route::get('/{id}', [KindController::class, 'get'])->name('get');

    });

    Route::name('cities.')->prefix('cities')->group(static function () {

        Route::get('/', [CitiesController::class, 'getCity'])->name('cities')->withoutMiddleware('headerCheck');
        Route::get('/ilce/{id}', [CitiesController::class, 'getIlce'])->name('ilce')->withoutMiddleware('headerCheck');
        Route::get('/mahalle/{id}', [CitiesController::class, 'getMahalle'])->name('mahalle')->withoutMiddleware('headerCheck');
        Route::get('/sokak/{id}', [CitiesController::class, 'getSokak'])->name('sokak')->withoutMiddleware('headerCheck');

    });

    Route::name('notices.')->prefix('notices')->group(static function () {

        Route::get('/', [NoticeController::class, 'index'])->name('index');
        Route::get('/get/{id}', [NoticeController::class, 'get'])->name('get');
        Route::get('/my-notices', [NoticeController::class, 'getMyNotices'])->name('my-notices');
        Route::post('/agree', [NoticeController::class, 'agreeNotice'])->name('agree');

        Route::post('/create', [NoticeController::class, 'create'])->name('create');
        Route::match(['post', 'put'], '/update/{id}', [NoticeController::class, 'update'])->name('update');

        Route::delete('/delete/{id}', [NoticeController::class, 'delete'])->name('delete');

    });

    Route::name('sectors.')->middleware('isLogin')->prefix('sectors')->group(static function () {

        Route::get('/', [SectorController::class, 'index'])->name('index')->withoutMiddleware('isLogin');
        Route::get('/get/{id}', [SectorController::class, 'get'])->name('get')->withoutMiddleware('isLogin');

        Route::post('/create', [SectorController::class, 'create'])->name('create');
        Route::match(['post', 'put'], '/update/{id}', [SectorController::class, 'update'])->name('update');

        Route::delete('/delete/{id}', [SectorController::class, 'delete'])->name('delete');

    });

    Route::name('users.')->middleware('isLogin')->prefix('users')->group(static function () {

        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/get/{id}', [UserController::class, 'get'])->name('get');

        Route::match(['post', 'put'], '/update/{id}', [UserController::class, 'update'])->name('update');

        Route::delete('/delete/{id}', [UserController::class, 'delete'])->name('delete');

    });

    Route::name('events.')->middleware('isLogin')->prefix('events')->group(static function () {

        Route::get('/', [EventController::class, 'index'])->name('index');
        Route::get('/get/{id}', [EventController::class, 'get'])->name('get');

    });

    Route::name('databank.')->middleware('isLogin')->prefix('databank')->group(static function () {

        Route::get('/', [DatabankController::class, 'index'])->name('index');
        Route::get('/get/{id}', [DatabankController::class, 'get'])->name('get');

    });

    Route::name('databank_categories.')->middleware('isLogin')->prefix('categories')->group(static function ($q) {

        Route::get('/', [DatabankCategoryController::class, 'index'])->name('index');

    });


    Route::name('announcements.')->middleware('isLogin')->prefix('announcements')->group(static function () {

        Route::get('/', [AnnouncementController::class, 'index'])->name('index');
        Route::get('/get/{id}', [AnnouncementController::class, 'get'])->name('get');

        Route::post('/create', [AnnouncementController::class, 'create'])->name('create');
        Route::match(['post', 'put'], '/update/{id}', [AnnouncementController::class, 'update'])->name('update');

        Route::delete('/delete/{id}', [AnnouncementController::class, 'delete'])->name('delete');

    });

    Route::name('announcements_types.')->middleware('isLogin')->prefix('announcements/type')->group(static function () {

        Route::get('/', [AnnouncementTypeController::class, 'index'])->name('index');
        Route::get('/get/{id}', [AnnouncementTypeController::class, 'get'])->name('get');

    });


    Route::name('diseases.')->middleware('isLogin')->prefix('diseases')->group(function () {

        Route::get('/', [DiseasesController::class, 'index'])->name('index');
        Route::get('/get/{id}', [DiseasesController::class, 'get'])->name('get');

    });

    Route::name('operation.')->prefix('operations')->group(function () {

        Route::get('/', [OperationController::class, 'index'])->name('index')->withoutMiddleware('headerCheck');
        Route::get('/get/{id}', [OperationController::class, 'get'])->name('get')->withoutMiddleware('headerCheck');

    });

    Route::name('medicine.')->middleware('isLogin')->prefix('medicines')->group(function () {

        Route::get('/', [MedicineController::class, 'index'])->name('index');
        Route::get('/get/{id}', [MedicineController::class, 'get'])->name('get');

    });

    Route::name('home.')->middleware('isLogin')->prefix('home')->group(function () {
        Route::get('/', [HomeController::class, 'home'])->name('home')->withoutMiddleware('isLogin');
    });

    Route::name('donation.')->middleware('isLogin')->prefix('donations')->group(function () {

        Route::get('/get/{id}', [DonationController::class, 'get'])->name('get');
        Route::post('/create', [DonationController::class, 'create'])->name('create');

    });

});
