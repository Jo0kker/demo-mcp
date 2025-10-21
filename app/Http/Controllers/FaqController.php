<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Faq::query()->published();

        if ($category = $request->get('category')) {
            $query->byCategory($category);
        }

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('question', 'like', "%{$search}%")
                  ->orWhere('answer', 'like', "%{$search}%");
            });
        }

        $faqs = $query->orderBy('created_at', 'desc')->paginate(10);
        $categories = Faq::published()->distinct()->pluck('category')->filter();

        return Inertia::render('Faq/Index', [
            'faqs' => $faqs,
            'categories' => $categories,
            'filters' => [
                'category' => $category,
                'search' => $search,
            ],
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Faq $faq)
    {
        if (!$faq->is_published) {
            abort(404);
        }

        $faq->incrementViewCount();

        return Inertia::render('Faq/Show', [
            'faq' => $faq,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Faq/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'category' => 'nullable|string|max:255',
            'is_published' => 'boolean',
        ]);

        Faq::create($validated);

        return redirect()->route('faqs.index')->with('success', 'FAQ créée avec succès !');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Faq $faq)
    {
        return Inertia::render('Faq/Edit', [
            'faq' => $faq,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Faq $faq)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'category' => 'nullable|string|max:255',
            'is_published' => 'boolean',
        ]);

        $faq->update($validated);

        return redirect()->route('faqs.index')->with('success', 'FAQ mise à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faq $faq)
    {
        $faq->delete();

        return redirect()->route('faqs.index')->with('success', 'FAQ supprimée avec succès !');
    }
}
