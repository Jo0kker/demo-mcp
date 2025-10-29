<?php

use App\Http\Controllers\Admin\FaqController as AdminFaqController;
use App\Http\Controllers\FaqController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return redirect()->route('faqs.index');
})->name('home');

// Routes FAQ publiques
Route::get('/faqs', [FaqController::class, 'index'])->name('faqs.index');
Route::get('/faqs/{faq}', [FaqController::class, 'show'])->name('faqs.show');

// Routes Dashboard protégées
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        $totalFaqs = \App\Models\Faq::count();
        $publishedFaqs = \App\Models\Faq::published()->count();
        $totalViews = \App\Models\Faq::sum('view_count');
        $recentFaqs = \App\Models\Faq::orderBy('created_at', 'desc')->limit(5)->get();
        $topFaqs = \App\Models\Faq::published()->orderBy('view_count', 'desc')->limit(5)->get();

        return Inertia::render('Dashboard', [
            'stats' => [
                'totalFaqs' => $totalFaqs,
                'publishedFaqs' => $publishedFaqs,
                'totalViews' => $totalViews,
            ],
            'recentFaqs' => $recentFaqs,
            'topFaqs' => $topFaqs,
        ]);
    })->name('dashboard');

    // Admin FAQs
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/faqs', [AdminFaqController::class, 'index'])->name('faqs.index');
        Route::get('/faqs/create', [AdminFaqController::class, 'create'])->name('faqs.create');
        Route::post('/faqs', [AdminFaqController::class, 'store'])->name('faqs.store');
        Route::get('/faqs/{faq}/edit', [AdminFaqController::class, 'edit'])->name('faqs.edit');
        Route::put('/faqs/{faq}', [AdminFaqController::class, 'update'])->name('faqs.update');
        Route::delete('/faqs/{faq}', [AdminFaqController::class, 'destroy'])->name('faqs.destroy');
    });
});

require __DIR__.'/settings.php';
