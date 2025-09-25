<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('cron-run',[\App\Http\Controllers\CronController::class, 'handle'])->name('cron.run');
Route::get('queue-work', function () {
    $cron = \App\Models\Cron::where('code', \App\Enums\CronCode::QUEUE_WORK)->first();
    if ($cron){
        $cron->last_run = \Carbon\Carbon::now();
        $cron->save();
    }
    Illuminate\Support\Facades\Artisan::call('queue:work', ['--stop-when-empty' => true]);
})->name('queue.work');


Route::middleware(['security.headers', 'xss'])->group(function () {
    Route::middleware(['web'])->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('home');
        Route::get('/trades', [HomeController::class, 'trade'])->name('trade');
        Route::get('/page/{url}', [HomeController::class, 'page'])->name('dynamic.page');
        Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
        Route::get('/language-change/{languageId}', [HomeController::class, 'languageChange'])->name('language.change');
        Route::get('/blogs/{id}/details', [HomeController::class, 'blogDetail'])->name('blog.detail');
        Route::post('/subscribes', [HomeController::class, 'subscribe'])->name('subscribe');
        Route::get('/default/images/{size}', [HomeController::class, 'defaultImageCreate'])->name('default.image');
        Route::post('/contact/store', [HomeController::class, 'contactStore'])->name('contact.store');
        Route::get('/quick/{slug}/{id}', [HomeController::class, 'policy'])->name('policy');
    });
});

require __DIR__.'/auth.php';
