<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\FournisseurController;
use App\Http\Controllers\Admin\AchatController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\CommandeUserController;
use App\Http\Controllers\Admin\RapportPerteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/register', fn () => view('auth.register'))->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/login', fn () => view('auth.login'))->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| AUTH USER
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get('/mes-commandes', [CommandeUserController::class, 'index'])
        ->name('user.commandes');
}
    /*
    |--------------------------------------------------------------------------
    | ADMIN DASHBOARD
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | CATEGORIES / PRODUITS
    |--------------------------------------------------------------------------
    */
    Route::resource('categories', \App\Http\Controllers\Admin\CategorieController::class);
    Route::resource('produits', \App\Http\Controllers\Admin\ProduitController::class);

    Route::post('/produits/{produit}/lots', [\App\Http\Controllers\Admin\ProduitController::class, 'addLot'])
        ->name('produits.lots.store');

    Route::delete('/lots/{lot}', [\App\Http\Controllers\Admin\ProduitController::class, 'destroyLot'])
        ->name('produits.lots.destroy');

    /*
    |--------------------------------------------------------------------------
    | CRENEAUX
    |--------------------------------------------------------------------------
    */
    Route::prefix('creneaux')->name('admin.creneaux.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\CreneauController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Admin\CreneauController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Admin\CreneauController::class, 'store'])->name('store');
        Route::get('/{creneau}/edit', [\App\Http\Controllers\Admin\CreneauController::class, 'edit'])->name('edit');
        Route::put('/{creneau}', [\App\Http\Controllers\Admin\CreneauController::class, 'update'])->name('update');
        Route::patch('/{creneau}/toggle', [\App\Http\Controllers\Admin\CreneauController::class, 'toggleStatus'])->name('toggle');
        Route::delete('/{creneau}', [\App\Http\Controllers\Admin\CreneauController::class, 'destroy'])->name('destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | USERS ADMIN
    |--------------------------------------------------------------------------
    */
    Route::prefix('utilisateurs')->name('admin.users.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Admin\UserController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Admin\UserController::class, 'store'])->name('store');
        Route::get('/{user}/edit', [\App\Http\Controllers\Admin\UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | PERTES
    |--------------------------------------------------------------------------
    */
    Route::get('/admin/pertes', [RapportPerteController::class, 'index'])
        ->name('admin.rapports.pertes');

    /*
    |--------------------------------------------------------------------------
    | COMMANDES ADMIN
    |--------------------------------------------------------------------------
    */
    Route::prefix('commandes')->name('commandes.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\CommandeController::class, 'index'])->name('index');
        Route::get('/{commande}', [\App\Http\Controllers\Admin\CommandeController::class, 'show'])->name('show');
        Route::get('/{commande}/edit', [\App\Http\Controllers\Admin\CommandeController::class, 'edit'])->name('edit');
        Route::put('/{commande}', [\App\Http\Controllers\Admin\CommandeController::class, 'update'])->name('update');
        Route::patch('/{commande}/status', [\App\Http\Controllers\Admin\CommandeController::class, 'updateStatus'])->name('updateStatus');
        Route::delete('/{commande}', [\App\Http\Controllers\Admin\CommandeController::class, 'destroy'])->name('destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | CART
    |--------------------------------------------------------------------------
    */
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add/{produit}', [CartController::class, 'add'])->name('add');
        Route::patch('/update/{ligne}', [CartController::class, 'update'])->name('update');
        Route::delete('/remove/{ligne}', [CartController::class, 'remove'])->name('remove');
        Route::post('/clear', [CartController::class, 'clear'])->name('clear');
    });
    Route::middleware(['auth'])->group(function () {
    Route::prefix('admin/achats')->name('achats.')->group(function () {

    // 📄 INDEX = LISTE + FORMULAIRE CREATE + DELETE
    Route::get('/', [AchatController::class, 'index'])
        ->name('index');

    // 💾 CREATE (STORE)
    Route::post('/', [AchatController::class, 'store'])
        ->name('store');

    // ✏️ PAGE EDIT
    Route::get('/{lot}/edit', [AchatController::class, 'edit'])
        ->name('edit');

    // 🔄 UPDATE
    Route::put('/{lot}', [AchatController::class, 'update'])
        ->name('update');

    // 🗑 DELETE
    Route::delete('/{lot}', [AchatController::class, 'destroy'])
        ->name('destroy');
});
    

     Route::prefix('fournisseurs')->name('fournisseurs.')->group(function () {

        Route::get('/', [FournisseurController::class, 'index'])->name('index');
        Route::get('/create', [FournisseurController::class, 'create'])->name('create');
        Route::post('/', [FournisseurController::class, 'store'])->name('store');

        Route::get('/{fournisseur}/edit', [FournisseurController::class, 'edit'])->name('edit');
        Route::put('/{fournisseur}', [FournisseurController::class, 'update'])->name('update');
        Route::delete('/{fournisseur}', [FournisseurController::class, 'destroy'])->name('destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | CHECKOUT
    |--------------------------------------------------------------------------
    */
    Route::get('/checkout', [\App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [\App\Http\Controllers\CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success/{commande}', [\App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');

    /*
    |--------------------------------------------------------------------------
    | NOTIFICATIONS
    |--------------------------------------------------------------------------
    */
    Route::post('/notifications/read-all', function () {
        Auth::user()->unreadNotifications->markAsRead();
        return back();
    })->name('notifications.readAll');
});