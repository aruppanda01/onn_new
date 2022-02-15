<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth','admin']], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /**
     * Profile Management
     * Change Password
     */
    Route::get('change-password', [DashboardController::class, 'changePassword'])->name('changePassword');
    Route::post('update-password', [DashboardController::class, 'updatePassword'])->name('updatePassword');

    /**
     * Category Management
     */
    Route::resource('category',CategoryController::class);
    Route::resource('sub-category',SubCategoryController::class);

    /**
     * Range Management
     */
    Route::resource('range',RangeController::class);

    /**
     * Product Color Management
     */
    Route::resource('available-product-color',ProductColorController::class);

    /**
     * Product Management
     */
    Route::resource('product',ProductController::class);
    Route::resource('available-product-size',ProductSizeController::class);
    Route::post('add-product-variant',[ProductController::class,'addVariant'])->name('addVariant');
    Route::get('product/edit-product-variant/{id}',[ProductController::class,'editVariant'])->name('editVariant');
    Route::put('product/update-product-variant/{id}',[ProductController::class,'updateVariant'])->name('updateVariant');
    Route::delete('product/delete-product-variant/{id}',[ProductController::class,'deleteVariant'])->name('deleteVariant');
    Route::get('product-variant/{id}',[ProductController::class,'getAllProductVariantById'])->name('getAllProductVariantById');
    Route::get('product/show-product-variant/{id}',[ProductController::class,'showProductVariantById'])->name('showProductVariantById');

    /**
     * Image Management
     */
    Route::resource('image',ImageController::class);

    /**
     * Invoice Management
     */

    Route::resource('invoice',InvoiceManagentController::class);
});
