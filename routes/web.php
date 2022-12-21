<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductCatController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomTextController;

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

Route::localizedGroup(function () {
    Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

    Route::get('404', function() {
        abort(404);
        return view('errors.404');
    })->name('404');

    Route::fallback(function () {
        return redirect(route('404'));
    });
    
    Route::get('contact', [ContactController::class, 'getForm'])->name('contact');
    Route::post('contact', [ContactController::class, 'postForm'])->name('contact.post');
    
    Route::transGet('routes.qui-sommes-nous', [SupplierController::class, 'index'])->name('who');
    Route::transGet('routes.qui-sommes-nous/{id}', [SupplierController::class, 'getById'])->name('who.getById');
    
    //-----Les catégories----
    Route::transGet('routes.categorie-{id}/{name}', [ProductCatController::class, 'getById'])->name('productCat.index');
    
    //-----Les produits-----
    Route::transGet('routes.produit-{id}/{slugCat}/{slug}', [ProductController::class, 'index'])->name('product.index');
    Route::transPost('routes.recherche', [ProductController::class, 'search'])->name('product.search');

    //-----Les authentifications----
    Auth::routes();

    //-----Les users----
    Route::resource('user', UsersController::class, ['except'=>['index', 'show', 'store', 'edit', 'update']]);
    Route::transGet('routes.mon-compte', [UsersController::class, 'index'])->name('user.index');
    Route::get('user/{id}/edit', [UsersController::class, 'edit'])->name('user.edit');
    Route::put('user/{id}/edit', [UsersController::class, 'update'])->name('user.update');

    //-----Les paniers-----
    Route::post('panier/ajouter', [BasketController::class, 'add'])->name('basket.add');
    Route::post('panier/modifier/{id}', [BasketController::class, 'editQuantity'])->name('basket.edit');

    //-----Les commandes-----
    Route::post('commande/ajouter', [OrderController::class, 'add'])->name('order.add');
    Route::transGet('routes.commande/{id}', [OrderController::class, 'showForUser'])->name('order.user.show');
    Route::transGet('routes.commande/historique', [OrderController::class, 'userHistory'])->name('orders.historical');

    //-----Les protégées----
    Route::group(['middleware' => ['role:1']], function () {
        //-----Les produits-----
        Route::get('mon-compte/ajouter-produit/{id}', [ProductController::class, 'create'])->name('product.createWith');
        Route::transGet('routes.mon-compte/ajouter-produit', [ProductController::class, 'create'])->name('product.create');
        Route::transPost('routes.mon-compte/ajouter-produit', [ProductController::class, 'store'])->name('product.store');

        Route::transGet('routes.mon-compte/modifier-produit/{id}', [ProductController::class, 'edit'])->name('product.edit');
        Route::transPut('routes.mon-compte/modifier-produit/{id}', [ProductController::class, 'update'])->name('product.update');
        Route::get('mon-compte/supprimer-produit/{id}', [ProductController::class, 'destroy'])->name('product.destroy');

        //-----Les Producteurs-----
        Route::transGet('routes.mon-compte/ajout-producteur', [SupplierController::class, 'create'])->name('supplier.create');
        Route::post('mon-compte/ajout-producteur', [SupplierController::class, 'store'])->name('supplier.store');

        Route::transGet('routes.mon-compte/modifier-producteur/{id}', [SupplierController::class, 'edit'])->name('supplier.edit');
        Route::transPut('routes.mon-compte/modifier-producteur/{id}', [SupplierController::class, 'update'])->name('supplier.update');
        
        //-----Les catégories----
        Route::transGet('routes.mon-compte/ajout-categorie', [ProductCatController::class, 'create'])->name('productCat.create');
        Route::post('mon-compte/ajout-categorie', [ProductCatController::class, 'store'])->name('productCat.store');

        Route::transGet('routes.mon-compte/ajout-categorie-{id}/{name}', [ProductCatController::class, 'createChild'])->name('productCat.create.child');
        Route::post('mon-compte/ajout-categorie-{id}/{name}', [ProductCatController::class, 'store'])->name('productCat.store.child');
        
        Route::get('mon-compte/ajout-categorie/destroy/{id}', [ProductCatController::class, 'destroy'])->name('productCat.create.destroy');
        Route::transGet('routes.mon-compte/ajout-categorie/modifier/{id}', [ProductCatController::class, 'edit'])->name('productCat.edit');
        Route::transPut('routes.mon-compte/ajout-categorie/modifier/{id}', [ProductCatController::class, 'update'])->name('productCat.update');

        //-----Les commandes-----
        Route::transGet('routes.commande/marchand/{id}', [OrderController::class, 'showForMerchant'])->name('order.merchant.show');
        Route::post('commande/{id}', [OrderController::class, 'changeStatus'])->name('order.delivered');
        Route::transPost('routes.commande/confirmer-toutes', [OrderController::class, 'changeAllStatus'])->name('orders.delivered');
        Route::transGet('routes.commande/marchand/historique', [OrderController::class, 'merchantHistory'])->name('orders.merchant.historical');
    });

    //-----Les admins----
    Route::group(['middleware' => ['role:2']], function () {
        Route::get('admin', [AdminController::class, 'index'])->name('admin');
        Route::get('admin/user/create', [AdminController::class, 'createUser'])->name('admin.user.create');
        Route::get('admin/user/{id}', [AdminController::class, 'editUser'])->name('admin.user.edit');
        Route::put('admin/user/{id}', [AdminController::class, 'updateUser'])->name('admin.user.update');
        Route::post('admin/user/create', [UsersController::class, 'store'])->name('admin.user.create');
        Route::delete('admin/user/{id}', [AdminController::class, 'destroyUser'])->name('admin.user.destroy');
        Route::get('admin/delivery/{number}', [AdminController::class, 'destroyDelivery'])->name('admin.deleteDelivery');
        Route::post('admin', [AdminController::class, 'addDelivery'])->name('admin.addDelivery');
        Route::get('admin/customTexts/{id}', [CustomTextController::class, 'edit'])->name('admin.customText.edit');
        Route::put('admin/customTexts/{id}', [CustomTextController::class, 'update'])->name('admin.customText.update');
        Route::get('admin/customTexts', [CustomTextController::class, 'index'])->name('admin.customText.index');
    });
});