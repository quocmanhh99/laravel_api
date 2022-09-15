<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Demo\Admin\DemoAdminController;
use App\Http\Controllers\Demo\Blog\DemoBlogController;
use App\Http\Controllers\Demo\Cart\DemoCartController;
use App\Http\Controllers\Demo\DemoCalculateController;
use App\Http\Controllers\Demo\Multi\DemoMultiImageController;
use App\Http\Controllers\Demo\Package\DemoPackageController;
use App\Http\Controllers\Demo\Post\DemoPostController;
use App\Http\Controllers\Demo\Prodcut\DemoProductController;
use App\Http\Controllers\Demo\Projectv1\DemoAdminUserController;
use App\Http\Controllers\Demo\Relationship\DemoRelationshipController;
use App\Http\Controllers\Demo\DemoCoursesController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/', [DemoProductController::class, 'show'])->name('demo.product.show');

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

// DEMO DEMO DEMO
Route::prefix('demo/package/')->group(function () {

    Route::get('index', [DemoPackageController::class, 'index'])->name('demo.package.index');
    Route::get('list', [DemoPackageController::class, 'list'])->name('demo.package.list');
    Route::get('sendmail', [DemoPackageController::class, 'sendmail'])->name('demo.package.sendmail');
    Route::get('add', [DemoPackageController::class, 'add'])->name('demo.package.add');
    Route::get('store', [DemoPackageController::class, 'store'])->name('demo.package.store');
    Route::post('store', [DemoPackageController::class, 'store'])->name('demo.package.store');
    Route::get('delete/{id}', [DemoPackageController::class, 'delete'])->name('demo.package.delete');
    Route::get('edit/{id}', [DemoPackageController::class, 'edit'])->name('demo.package.edit');
    Route::get('detail/{id}', [DemoPackageController::class, 'detail'])->name('demo.package.detail');

});

Route::prefix('demo/cart/')->group(function () {

    Route::get('show', [DemoCartController::class, 'show'])->name('demo.cart.show');
    Route::get('add/{id}', [DemoCartController::class, 'add'])->name('demo.cart.add');
    Route::get('remove/{rowId}', [DemoCartController::class, 'remove'])->name('demo.cart.remove');
    Route::get('destroy', [DemoCartController::class, 'destroy'])->name('demo.cart.destroy');
    Route::post('update', [DemoCartController::class, 'update'])->name('demo.cart.update');
    Route::get('update', [DemoCartController::class, 'update'])->name('demo.cart.update');
    Route::get('getCart', [DemoCartController::class, 'getCart'])->name('demo.cart.getCart');
    // Route::get('decrement/{rowId}', [DemoCartController::class, 'decrement'])->name('demo.cart.decrement');
    // Route::get('increment/{rowId}', [DemoCartController::class, 'increment'])->name('demo.cart.increment');

});

Route::prefix('demo/product/')->group(function () {

    Route::get('show', [DemoProductController::class, 'show'])->name('demo.product.show');

});

// Mulit Image Route
Route::prefix('demo/multi/images')->group(function () {

    Route::get('add', [DemoMultiImageController::class, 'add'])->name('demo.multi.add');
    Route::get('action', [DemoMultiImageController::class, 'action'])->name('demo.multi.action');
    Route::post('action', [DemoMultiImageController::class, 'action'])->name('demo.multi.action');
    Route::get('edit/{id}', [DemoMultiImageController::class, 'edit'])->name('demo.multi.edit');
    Route::get('update/{id}', [DemoMultiImageController::class, 'update'])->name('demo.multi.update');
    Route::post('update/{id}', [DemoMultiImageController::class, 'update'])->name('demo.multi.update');
    Route::get('delete/{id}', [DemoMultiImageController::class, 'delete'])->name('demo.multi.delete');
    Route::get('list', [DemoMultiImageController::class, 'list'])->name('demo.multi.list');
    Route::get('listv2', [DemoMultiImageController::class, 'listv2'])->name('demo.multi.listv2');
    Route::get('store', [DemoMultiImageController::class, 'store'])->name('demo.multi.store');
    Route::post('store', [DemoMultiImageController::class, 'store'])->name('demo.multi.store');
    Route::get('deleteAll', [DemoMultiImageController::class, 'deleteAll'])->name('demo.multi.deleteAll');


});

Route::prefix('demo/relationship/')->group(function () {

    Route::get('index', [DemoRelationshipController::class, 'index'])->name('demo.relationship.index');

});

Route::prefix('demo/post/')->group(function () {

    Route::get('read', [ DemoPostController::class, 'read'])->name('demo.post.read');
    Route::get('add', [ DemoPostController::class, 'add'])->name('demo.post.add');
    Route::get('update/{id}', [ DemoPostController::class, 'update'])->name('demo.post.update');
    Route::get('delete/{id}', [ DemoPostController::class, 'delete'])->name('demo.post.delete');
    Route::get('restore/{id}', [ DemoPostController::class, 'restore'])->name('demo.post.restore');
    Route::get('destroy/{id}', [ DemoPostController::class, 'destroy'])->name('demo.post.destroy');

});

Route::prefix('demo/admin/')->group(function () {

    // Route::get('read/{age}', [  DemoAdminController::class, 'index'])->name('demo.admin.index')->middleware('DemoCheckAge');
    Route::get('read/{age}', [  DemoAdminController::class, 'index'])->name('demo.admin.index');

});

Auth::routes(['verify' => true]);

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('verified');

// Route::get('admin/dashboard', [  AdminController::class, 'dashboard'])->name('admin.dashboard')->middleware('CheckRole');

Route::middleware('auth')->group(function(){

    Route::prefix('demo/admin/blog')->group(function () {

        Route::get('index', [ DemoBlogController::class, 'index'])->name('demo.admin.blog.index');
        Route::get('detail/{id}', [ DemoBlogController::class, 'detail'])->name('demo.admin.blog.detail');
        Route::post('detail/{id}', [ DemoBlogController::class, 'detail'])->name('demo.admin.blog.detail');
        Route::get('comment/{blog_id}', [ DemoBlogController::class, 'comment'])->name('demo.admin.blog.comment');
        Route::post('comment/{blog_id}', [ DemoBlogController::class, 'comment'])->name('demo.admin.blog.comment');

    });

    Route::prefix('admin/category')->group(function () {

        Route::get('add', [  CategoryController::class, 'add'])->name('admin.category.add');

    });


    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('verified');

    Route::get('admin/dashboard', [  AdminController::class, 'dashboard'])->name('admin.dashboard')->middleware('CheckRole');

    Route::prefix('projectv1/admin/user/')->group(function () {

        Route::get('list', [DemoAdminUserController::class, 'list'])->name('projectv1.user.list');
        Route::post('list', [DemoAdminUserController::class, 'list'])->name('projectv1.user.list');
        Route::get('add', [DemoAdminUserController::class, 'add'])->name('projectv1.user.add');
        Route::get('edit/{id}', [DemoAdminUserController::class, 'edit'])->name('projectv1.user.edit');
        Route::get('update/{id}', [DemoAdminUserController::class, 'update'])->name('projectv1.user.update');
        Route::post('update/{id}', [DemoAdminUserController::class, 'update'])->name('projectv1.user.update');
        Route::get('store', [DemoAdminUserController::class, 'store'])->name('projectv1.user.store');
        Route::post('store', [DemoAdminUserController::class, 'store'])->name('projectv1.user.store');
        Route::post('action', [DemoAdminUserController::class, 'action'])->name('projectv1.user.action');
        Route::get('delete/{id}', [DemoAdminUserController::class, 'delete'])->name('projectv1.user.delete');
        Route::get('districts/ajax/{province_id}', [DemoAdminUserController::class, 'GetDistricts']);
        Route::get('wards/ajax/{province_id}', [DemoAdminUserController::class, 'GetWards']);
        Route::post('districts/ajax/{province_id}', [DemoAdminUserController::class, 'GetDistricts']);
        Route::post('wards/ajax/{province_id}', [DemoAdminUserController::class, 'GetWards']);
        Route::get('status', [DemoAdminUserController::class, 'userOnlineStatus']);
        Route::get('load-more', [DemoAdminUserController::class, 'userLoadMore']);
        //



    });

});

Route::prefix('demo/courses/')->group(function () {

    Route::get('index', [ DemoCoursesController::class, 'index'])->name('demo.courses.index');
    Route::get('list', [ DemoCoursesController::class, 'list'])->name('demo.courses.list');
    Route::get('add', [ DemoCoursesController::class, 'add'])->name('demo.courses.add');
    Route::get('get-courses', [DemoCoursesController::class, 'getCourses'])->name('get-courses');

});

Route::prefix('demo/calculate/')->group(function () {

    Route::get('index', [ DemoCalculateController::class, 'index'])->name('demo.calculate.index');
    Route::get('store', [ DemoCalculateController::class, 'store'])->name('demo.calculate.store');
    Route::post('store', [ DemoCalculateController::class, 'store'])->name('demo.calculate.store');

});

Route::resource('demo/courses', DemoCoursesController::class);

// Đồ án chính thức






