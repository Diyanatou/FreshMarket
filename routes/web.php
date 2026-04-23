<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\CommandeUserController;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');
Route::middleware(['auth'])->group(function () {
    Route::get('/mes-commandes', [CommandeUserController::class, 'index'])->name('user.commandes');
});
Route::post('/register', [AuthController::class, 'register'])
    ->name('register.post');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.post');


Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
        ->name('dashboard');

    Route::resource('categories', \App\Http\Controllers\Admin\CategorieController::class);

    Route::resource('produits', \App\Http\Controllers\Admin\ProduitController::class);

    Route::post('/produits/{produit}/lots', [\App\Http\Controllers\Admin\ProduitController::class, 'addLot'])
        ->name('produits.lots.store');

    Route::delete('/lots/{lot}', [\App\Http\Controllers\Admin\ProduitController::class, 'destroyLot'])
        ->name('produits.lots.destroy');

    // Creneaux (Admin)
    Route::get('/creneaux', [\App\Http\Controllers\Admin\CreneauController::class, 'index'])->name('admin.creneaux.index');
    Route::get('/creneaux/create', [\App\Http\Controllers\Admin\CreneauController::class, 'create'])->name('admin.creneaux.create');
    Route::post('/creneaux', [\App\Http\Controllers\Admin\CreneauController::class, 'store'])->name('admin.creneaux.store');
    Route::get('/creneaux/{creneau}/edit', [\App\Http\Controllers\Admin\CreneauController::class, 'edit'])->name('admin.creneaux.edit');
    Route::put('/creneaux/{creneau}', [\App\Http\Controllers\Admin\CreneauController::class, 'update'])->name('admin.creneaux.update');
    Route::patch('/creneaux/{creneau}/toggle', [\App\Http\Controllers\Admin\CreneauController::class, 'toggleStatus'])->name('admin.creneaux.toggle');
    Route::delete('/creneaux/{creneau}', [\App\Http\Controllers\Admin\CreneauController::class, 'destroy'])->name('admin.creneaux.destroy');

    // Utilisateurs (Admin)
    Route::get('/utilisateurs', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.users.index');
    Route::get('/utilisateurs/create', [\App\Http\Controllers\Admin\UserController::class, 'create'])->name('admin.users.create');
    Route::post('/utilisateurs', [\App\Http\Controllers\Admin\UserController::class, 'store'])->name('admin.users.store');
    Route::get('/utilisateurs/{user}/edit', [\App\Http\Controllers\Admin\UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/utilisateurs/{user}', [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/utilisateurs/{user}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('admin.users.destroy');
    
    // Commandes (Admin)
    Route::get('/commandes', [\App\Http\Controllers\Admin\CommandeController::class, 'index'])->name('commandes.index');
    Route::get('/commandes/{commande}', [\App\Http\Controllers\Admin\CommandeController::class, 'show'])->name('commandes.show');
    Route::get('/commandes/{commande}/edit', [\App\Http\Controllers\Admin\CommandeController::class, 'edit'])->name('commandes.edit');
    Route::put('/commandes/{commande}', [\App\Http\Controllers\Admin\CommandeController::class, 'update'])->name('commandes.update');
    Route::patch('/commandes/{commande}/status', [\App\Http\Controllers\Admin\CommandeController::class, 'updateStatus'])->name('commandes.updateStatus');
    Route::delete('/commandes/{commande}', [\App\Http\Controllers\Admin\CommandeController::class, 'destroy'])->name('commandes.destroy');
    // Panier
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{produit}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update/{ligne}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{ligne}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    // Checkout
    Route::get('/checkout', [\App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [\App\Http\Controllers\CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success/{commande}', [\App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');

    // Notifications
    Route::post('/notifications/read-all', function() {
        Auth::user()->unreadNotifications->markAsRead();
        return back();
    })->name('notifications.readAll');
});


