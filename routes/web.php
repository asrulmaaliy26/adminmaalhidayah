<?php

use App\Http\Controllers\Back\ArticleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\HomepageController;
use App\Http\Controllers\Back\DashboardController;
use App\Http\Controllers\Back\AuthController;
use App\Http\Controllers\Back\CategoryController;
use App\Http\Controllers\Back\JenisController;
use App\Http\Controllers\Back\TingkatController;
use App\Http\Controllers\Back\PendidikanController;
use App\Http\Controllers\Back\ConfigController;
use App\Http\Controllers\Back\PageController;
use App\Http\Controllers\Back\UserController;
use App\Http\Controllers\Back\ContactController;
use App\Models\Category;
use Monolog\Handler\RotatingFileHandler;

/*
|--------------------------------------------------------------------------
| Back Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    
    Route::middleware('isLogin')->group(function () {
        Route::get('login', [AuthController::class, 'getLogin'])->name('login');
        Route::post('login', [AuthController::class, 'login'])->name('login');
        Route::middleware('role:Admin|Editor|User')->group(function () {
            Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

            //------- Articles Routes -------
            Route::middleware('role:Admin|Editor')->get('articles/{article}/changeStatus', [ArticleController::class, 'changeStatus'])->name('articles.changeStatus');
            Route::get('articles/{article}/trashArticle', [ArticleController::class, 'trashArticle'])->name('articles.trashArticle');
            Route::get('articles/getTrashedArticles', [ArticleController::class, 'getTrashedArticles'])->name('articles.getTrashedArticles');
            Route::get('articles/{article}/recoverArticle', [ArticleController::class, 'recoverArticle'])->name('articles.recoverArticle');
            Route::middleware('permission:hard-delete')->get('articles/{article}/hardDeleteArticle', [ArticleController::class, 'hardDeleteArticle'])->name('articles.hardDeleteArticle');
            Route::get('articles/myArticles', [ArticleController::class, 'myArticles'])->name('articles.myArticles');

            Route::resource('articles', ArticleController::class)->except('index');
            Route::resource('articles', ArticleController::class)->middleware('permission:get-all-articles')->only('index');


            //------- Category Routes -------
            Route::middleware('role:Admin|Editor')->group(function () {
                Route::get('categories', [CategoryController::class, 'index'])->name('category.index');
                Route::get('category/{category}/changeStatus', [CategoryController::class, 'changeStatus'])->name('category.changeStatus');
                Route::post('category/createCategory', [CategoryController::class, 'createCategory'])->name('category.createCategory');
                Route::get('category/getData', [CategoryController::class, 'getData'])->name('category.getData');
                Route::post('category/updateCategory', [CategoryController::class, 'updateCategory'])->name('category.updateCategory');
                Route::post('category/deleteCategory', [CategoryController::class, 'deleteCategory'])->name('category.deleteCategory');
            });

            //------- Jenis Routes -------
            Route::middleware('role:Admin|Editor')->group(function () {
                Route::get('jenises', [JenisController::class, 'index'])->name('jenis.index');
                Route::get('jenis/{jenis}/changeStatus', [JenisController::class, 'changeStatus'])->name('jenis.changeStatus');
                Route::post('jenis/createJenis', [JenisController::class, 'createJenis'])->name('jenis.createJenis');
                Route::get('jenis/getData', [JenisController::class, 'getData'])->name('jenis.getData');
                Route::post('jenis/updateJenis', [JenisController::class, 'updateJenis'])->name('jenis.updateJenis');
                Route::post('jenis/deleteJenis', [JenisController::class, 'deleteJenis'])->name('jenis.deleteJenis');
            });

            //------- Pendidikan Routes -------
            Route::middleware('role:Admin|Editor')->group(function () {
                Route::get('pendidikans', [PendidikanController::class, 'index'])->name('pendidikan.index');
                Route::get('pendidikan/{pendidikan}/changeStatus', [PendidikanController::class, 'changeStatus'])->name('pendidikan.changeStatus');
                Route::post('pendidikan/createPendidikan', [PendidikanController::class, 'createPendidikan'])->name('pendidikan.createPendidikan');
                Route::get('pendidikan/getData', [PendidikanController::class, 'getData'])->name('pendidikan.getData');
                Route::post('pendidikan/updatePendidikan', [PendidikanController::class, 'updatePendidikan'])->name('pendidikan.updatePendidikan');
                Route::post('pendidikan/deletePendidikan', [PendidikanController::class, 'deletePendidikan'])->name('pendidikan.deletePendidikan');
            });

            //------- Tingkat Routes -------
            Route::middleware('role:Admin|Editor')->group(function () {
                Route::get('tingkats', [TingkatController::class, 'index'])->name('tingkat.index');
                Route::get('tingkat/{tingkat}/changeStatus', [TingkatController::class, 'changeStatus'])->name('tingkat.changeStatus');
                Route::post('tingkat/createTingkat', [TingkatController::class, 'createTingkat'])->name('tingkat.createTingkat');
                Route::get('tingkat/getData', [TingkatController::class, 'getData'])->name('tingkat.getData');
                Route::post('tingkat/updateTingkat', [TingkatController::class, 'updateTingkat'])->name('tingkat.updateTingkat');
                Route::post('tingkat/deleteTingkat', [TingkatController::class, 'deleteTingkat'])->name('tingkat.deleteTingkat');
            });

            //------- Page Routes -------
            Route::middleware('role:Admin|Editor')->group(function () {
                Route::resource('pages', PageController::class);
                Route::middleware('permission:Edit Articles')->get('pages/{page}/changeStatus', [PageController::class, 'changeStatus'])->name('pages.changeStatus');
                Route::post('pages/deletePage', [PageController::class, 'deletePage'])->name('pages.deletePage');
            });

            //------- Config Routes -------
            Route::middleware('role:Admin')->group(function () {
                Route::get('/config', [ConfigController::class, 'index'])->name('config.index');
                Route::post('config', [ConfigController::class, 'configPost'])->name('config.configPost');
            });

            Route::middleware('role:Admin')->group(function () {
                Route::get('/contacts', [ContactController::class, 'index'])->name('contact.index');
            });

            //------- User Routes -------
            Route::middleware('role:Admin')->group(function () {
                Route::get('users/{user}/changeStatus', [UserController::class, 'changeStatus'])->name('users.changeStatus');
                Route::get('user/getData', [UserController::class, 'getData'])->name('users.getData');
                Route::get('users/{user}/trashArticle', [UserController::class, 'trashUser'])->name('users.trashUser');

                Route::get('users/getTrashedUsers', [UserController::class, 'getTrashedUsers'])->name('users.getTrashedUsers');
                Route::get('users/{user}/recoveUser', [UserController::class, 'recoverUser'])->name('users.recoverUser');
                Route::get('users/{user}/hardDeleteUser', [UserController::class, 'hardDeleteUser'])->name('users.hardDeleteUser');
                Route::post('users/updateUser', [UserController::class, 'updateUser'])->name('users.updateUser');
                Route::resource('users', UserController::class);
            });
        });
    });
});

Route::get('logout', [AuthController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| Front Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomepageController::class,'index']);
Route::get('/category/{category}', [HomepageController::class,'category'])->name('category');
Route::get('/{category}/{slug}', [HomepageController::class,'getOneArticle'])->name('get.article');

Route::get('/jenis/{jenis}', [HomepageController::class,'jenis'])->name('jenis');
Route::get('/{jenis}/{slug}', [HomepageController::class,'getOneArticle'])->name('get.article');

Route::get('/tingkat/{tingkat}', [HomepageController::class,'tingkat'])->name('tingkat');
Route::get('/{tingkat}/{slug}', [HomepageController::class,'getOneArticle'])->name('get.article');

Route::get('/pendidikan/{pendidikan}', [HomepageController::class,'pendidikan'])->name('pendidikan');
Route::get('/{pendidikan}/{slug}', [HomepageController::class,'getOneArticle'])->name('get.article');
//Sabit URL'ler altta olduğu gibi değişken olanlardan önce tanımlanmalıdır. Sıra önemli.
Route::get('/contact',[HomepageController::class,'getContact'])->name('contact');
Route::post('/contact',[HomepageController::class,'postContact'])->name('contact.post');
Route::get('/{page}',[HomepageController::class,'page'])->name('page');