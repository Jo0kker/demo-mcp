<?php

use App\Http\Controllers\Admin\FaqController as AdminFaqController;
use App\Http\Controllers\FaqController;
use App\Models\Faq;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect()->route('faqs.index');
})->name('home');

// Routes FAQ publiques
Route::get('/faqs', [FaqController::class, 'index'])->name('faqs.index');
Route::get('/faqs/{faq}', [FaqController::class, 'show'])->name('faqs.show');

// Routes Dashboard protégées
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        $totalFaqs = Faq::count();
        $publishedFaqs = Faq::published()->count();
        $totalViews = Faq::sum('view_count');
        $recentFaqs = Faq::orderBy('created_at', 'desc')->limit(5)->get();
        $topFaqs = Faq::published()->orderBy('view_count', 'desc')->limit(5)->get();

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
