<?php
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Site\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BusinessController;
use App\Http\Controllers\Public\MenuController;


/*
|--------------------------------------------------------------------------
| Área pública
|--------------------------------------------------------------------------
*/
Route::get(
    '/cardapio/{slug}',
    [MenuController::class, 'show']
)
->name('public.menu.show');

Route::get('/', [HomeController::class, 'index'])
    ->name('site.home');

/*
|--------------------------------------------------------------------------
| Área administrativa
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->group(function (): void {

        /*
        |--------------------------------------------------------------------------
        | Rotas para usuários não autenticados
        |--------------------------------------------------------------------------
        */

        Route::middleware('guest')->group(function (): void {
            Route::get('/login', [AuthController::class, 'create'])
                ->name('login');

            Route::post('/login', [AuthController::class, 'store'])
                ->name('login.store');
        });

        /*
        |--------------------------------------------------------------------------
        | Rotas protegidas
        |--------------------------------------------------------------------------
        */

        Route::middleware('auth')->group(function (): void {
            Route::get('/', [DashboardController::class, 'index'])
                ->name('dashboard');

                Route::get(
                '/business',
                [BusinessController::class, 'edit']
            )->name('business.edit');

            Route::put(
                '/business',
                [BusinessController::class, 'update']
            )->name('business.update');

            Route::patch(
                '/categories/{category}/toggle-status',
                [CategoryController::class, 'toggleStatus']
            )->name('categories.toggle-status');

            Route::patch(
                '/products/{product}/toggle-status',
                [ProductController::class, 'toggleStatus']
            )->name('products.toggle-status');

            Route::patch(
                '/products/{product}/toggle-availability',
                [ProductController::class, 'toggleAvailability']
            )->name('products.toggle-availability');

            Route::patch(
                '/products/{product}/toggle-sold-out',
                [ProductController::class, 'toggleSoldOut']
            )->name('products.toggle-sold-out');

            Route::post(
                '/products/{product}/duplicate',
                [ProductController::class, 'duplicate']
            )->name('products.duplicate');

            Route::delete(
                '/products/{product}/images/{image}',
                [ProductController::class, 'destroyImage']
            )->name('products.images.destroy');

            Route::patch(
                '/products/{product}/images/{image}/primary',
                [ProductController::class, 'setPrimaryImage']
            )->name('products.images.primary');

            Route::resource('products', ProductController::class)
                ->except('show');

            Route::resource('categories', CategoryController::class)
                ->except('show');

            Route::post('/logout', [AuthController::class, 'destroy'])
                ->name('logout');

        });
    });