<?php

use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DonationController;
use App\Http\Controllers\Admin\EventController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\NoticeController;
use App\Http\Controllers\Admin\AnimalController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DiseasesController;
use App\Http\Controllers\Admin\MedicineController;
use App\Http\Controllers\Admin\NoticeTypeController;
use App\Http\Controllers\Admin\OperationController;
use App\Http\Controllers\Admin\SectorController;
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

/*Route::get('/', function () {
   $tokens = \App\Models\User::all()->pluck('fcm_token')->toArray();
   dd(sendNotification($tokens, 'İlk başlık', 'İlk deneme içeriği.'));
});*/

Route::get('/show', function () {
    $photo = \Storage::disk('s3')->get(\request()->query('path'));

    return response()->make(
        $photo,
        200, ['Content-type' => 'image/png']
    );
})->name('show.photo');

Route::name('web.')->prefix('/yonetim-paneli')->middleware(['web', 'auth:web', 'log'])->group(static function () {

    Route::get('/', function () {
        if (request()->user('web')) {
            return redirect(\route('web.user.index'));
        }
        return redirect(\route('web.login'));
    });

    //Auth
    Route::get('/giris', [AuthController::class, 'login'])->name('login')->withoutMiddleware('auth:web');
    Route::post('/giris', [AuthController::class, 'loginOperation'])->name('login.operation')->withoutMiddleware('auth:web');
    Route::get('/cikis', [AuthController::class, 'logout'])->name('logout');
    //End Auth

    routeGenerator('user', 'kullanicilar', UserController::class);
    routeGenerator('notice', 'ihbarlar', NoticeController::class);
    routeGenerator('animal', 'hayvanlar', AnimalController::class);
    routeGenerator('disease', 'hayvan-hastaliklari', DiseasesController::class);
    routeGenerator('category', 'blog-kategorileri', CategoryController::class);
    routeGenerator('notice-type', 'ihbar-turleri', NoticeTypeController::class);
    routeGenerator('operation', 'ameliyatlar', OperationController::class);
    routeGenerator('sector', 'sektorler', SectorController::class);
    routeGenerator('medicine', 'ilaclar', MedicineController::class);
    routeGenerator('blog', 'blog-yazilari', BlogController::class);
    routeGenerator('event', 'etkinlikler', EventController::class);
    routeGenerator('donation', 'bagislar', DonationController::class);
    Route::get('notice/forward/update/{data}', [NoticeController::class, 'updateAjax'])->name('update.ajax');

});
