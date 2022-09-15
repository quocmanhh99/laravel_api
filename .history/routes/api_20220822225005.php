<?php

use App\Http\Controllers\Demo\API\RestFulApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('demo/restfulapi/')->group(function () {

    Route::get('product', [RestFulApiController::class, 'show'])->name('demo.restfulapi.product');
    Route::get('product/show', [RestFulApiController::class, 'showProduct'])->name('demo.restfulapi.show.product');
    // http://localhost/Laravel-8/api/demo/restfulapi/product
    Route::get('product/{id}', [RestFulApiController::class, 'detail'])->name('demo.restfulapi.product.detail');
    Route::get('addProduct', [RestFulApiController::class, 'addProduct'])->name('demo.restfulapi.addProduct');
    Route::post('addProduct', [RestFulApiController::class, 'addProduct'])->name('demo.restfulapi.addProduct');
    Route::get('productAjax', [RestFulApiController::class, 'productAjax'])->name('demo.restfulapi.productAjax');
    Route::post('deleteProduct/{id}', [RestFulApiController::class, 'deleteProduct'])->name('demo.restfulapi.deleteProduct');
    Route::get('deleteProduct/{id}', [RestFulApiController::class, 'deleteProduct'])->name('demo.restfulapi.deleteProduct');
    Route::get('editProduct/{id}', [RestFulApiController::class, 'editProduct'])->name('demo.restfulapi.editProduct');
    Route::get('updateProduct', [RestFulApiController::class, 'updateProduct'])->name('demo.restfulapi.updateProduct');
    Route::post('updateProduct', [RestFulApiController::class, 'updateProduct'])->name('demo.restfulapi.updateProduct');
    Route::get('sortProduct', [RestFulApiController::class, 'sortProduct'])->name('demo.restfulapi.sortProduct');
    Route::post('sortProduct', [RestFulApiController::class, 'sortProduct'])->name('demo.restfulapi.sortProduct');
    Route::get('searchProduct', [RestFulApiController::class, 'searchProduct'])->name('demo.restfulapi.searcvProduct');

});
