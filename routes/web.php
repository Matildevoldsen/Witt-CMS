<?php

use App\Http\Controllers\Forum\DiscussionPatchController;
use App\Http\Controllers\Forum\DiscussionShowController;
use App\Http\Controllers\Forum\DiscussionStoreController;
use App\Http\Controllers\Forum\ForumIndexController;
use App\Http\Controllers\Forum\MarkdownPreviewController;
use App\Http\Controllers\Forum\PostDestroyController;
use App\Http\Controllers\Forum\PostPatchController;
use App\Http\Controllers\Forum\PostStoreController;
use Illuminate\Foundation\Application;
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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
Route::post('/forum/markdown-preview', MarkdownPreviewController::class)->name('markdown.preview');

Route::get('/forum', ForumIndexController::class)->name('forum');
Route::get('/forum/{discussion:slug}', DiscussionShowController::class)->name('discussions.show');

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
});
