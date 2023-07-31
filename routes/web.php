<?php

use App\Http\Controllers\Blog\ArticleIndexController;
use App\Http\Controllers\Blog\ArticlePatchController;
use App\Http\Controllers\Blog\CreateArticleController;
use App\Http\Controllers\Blog\EditArticleController;
use App\Http\Controllers\Blog\PublishArticleController;
use App\Http\Controllers\CSV\CSVImporterController;
use App\Http\Controllers\Dashboard\CreateSiteController;
use App\Http\Controllers\Dashboard\DashboardIndexController;
use App\Http\Controllers\Dashboard\SiteSettingsController;
use App\Http\Controllers\Dashboard\UpdateSiteSettingsController;
use App\Http\Controllers\Dashboard\Users\AssignPermissionsController;
use App\Http\Controllers\Dashboard\Users\CreateRoleController;
use App\Http\Controllers\Dashboard\Users\DeleteRoleController;
use App\Http\Controllers\Dashboard\Users\EditRoleController;
use App\Http\Controllers\Dashboard\Users\RoleIndexController;
use App\Http\Controllers\Dashboard\Users\UpdateRoleController;
use App\Http\Controllers\Forum\DiscussionPatchController;
use App\Http\Controllers\Forum\DiscussionShowController;
use App\Http\Controllers\Forum\DiscussionStoreController;
use App\Http\Controllers\Forum\ForumIndexController;
use App\Http\Controllers\Forum\MarkdownPreviewController;
use App\Http\Controllers\Forum\PostDestroyController;
use App\Http\Controllers\Forum\PostPatchController;
use App\Http\Controllers\Forum\PostStoreController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductShowController;
use App\Http\Controllers\Shop\CustomersIndexController;
use App\Http\Controllers\Shop\InventoryController;
use App\Http\Controllers\Shop\InventoryUpdateController;
use App\Http\Controllers\Shop\OrdersIndexController;
use App\Http\Controllers\Shop\ProductIndexController;
use App\Http\Controllers\Shop\ProductVariantStoreController;
use App\Http\Controllers\Shop\ReportsIndexController;
use App\Http\Controllers\Shop\SaveProductController;
use App\Http\Controllers\Shop\UploadProductImageController;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', HomeController::class)->name('home');

Route::get('/blog/article/{article:slug}', ArticleIndexController::class)->name('article.show');

Route::post('/forum/markdown-preview', MarkdownPreviewController::class)->name('markdown.preview');

Route::get('/forum', ForumIndexController::class)->name('forum');
Route::get('/forum/{discussion:slug}', DiscussionShowController::class)->name('discussions.show');
Route::get('/products/{product:slug}', ProductShowController::class)->name('product.show');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::post('/forum/discussions', DiscussionStoreController::class)->name('discussions.store');
    Route::post('/forum/discussions/{discussion}/posts', PostStoreController::class)->name('posts.store');
    Route::patch('/forum/discussions/{discussion}/solution', DiscussionPatchController::class)->name('discussions.solutions.patch');

    Route::patch('/forum/posts/{post}', PostPatchController::class)->name('posts.patch');
    Route::delete('/forum/posts/{post}', PostDestroyController::class)->name('posts.destroy');

    Route::get('/blog/article/{article:slug}/edit', EditArticleController::class)->name('article.edit');
    Route::post('/blog/article/create', CreateArticleController::class)->name('article.create');
    Route::patch('/blog/article/{article:slug}/edit', ArticlePatchController::class)->name('article.patch');
    Route::patch('/blog/article/{article:slug}/publish', PublishArticleController::class)->name('article.publish');

    Route::get('dashboard', DashboardIndexController::class)->name('dashboard');
    Route::post('create-site', CreateSiteController::class)->name('create-site')->middleware(HandlePrecognitiveRequests::class);
    Route::post('dashboard/roles/{role}/permissions', AssignPermissionsController::class)->name('roles.permissions.assign');
    Route::get('dashboard/users/roles', RoleIndexController::class)->name('roles.show');
    Route::get('dashboard/users/roles/{role}', EditRoleController::class)->name('roles.edit');
    Route::post('dashboard/users/roles', CreateRoleController::class)->name('roles.create');
    Route::put('dashboard/users/roles/{role}', UpdateRoleController::class)->name('roles.update');
    Route::delete('dashboard/users/roles/{role}', DeleteRoleController::class)->name('roles.delete');

    Route::get('dashboard/shop/inventory', InventoryController::class)->name('dashboard.shop.inventory');
    Route::post('dashboard/shop/inventory/import', [CSVImporterController::class, 'uploadFile'])->name('dashboard.shop.inventory.upload');
    Route::post('dashboard/shop/inventory/import/upload', [CSVImporterController::class, 'import'])->name('dashboard.shop.inventory.import');
    Route::post('dashboard/shop/inventory/update/{inventory}', InventoryUpdateController::class)->name('dashboard.shop.inventory.update');
    Route::get('dashboard/shop/inventory/importer/{id}', [InventoryController::class, 'getImporter'])->name('dashboard.shop.inventory.progress');
    Route::get('dashboard/site-settings', SiteSettingsController::class)->name('dashboard.settings.show');
    Route::put('dashboard/site-settings', UpdateSiteSettingsController::class)->name('dashboard.settings.update');
    Route::get('dashboard/shop/products', ProductIndexController::class)->name('dashboard.shop.products');
    Route::post('dashboard/shop/products/variants/store', ProductVariantStoreController::class)->name('dashboard.shop.products.variants.store');
    Route::post('products/{product}/upload', UploadProductImageController::class)->name('dashboard.shop.products.image.store');
    Route::put('/dashboard/shop/products/{product}', SaveProductController::class)->name('dashboard.shop.products.save');
    Route::get('dashboard/shop/orders', OrdersIndexController::class)->name('dashboard.shop.orders');
    Route::get('dashboard/shop/customers', CustomersIndexController::class)->name('dashboard.shop.customers');
    Route::get('dashboard/shop/reports', ReportsIndexController::class)->name('dashboard.shop.reports');
});
