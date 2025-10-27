<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ApiTokenController extends Controller
{
    /**
     * Display the API tokens page.
     */
    public function index(Request $request): Response
    {
        return Inertia::render('settings/ApiTokens', [
            'tokens' => $request->user()->tokens()->orderBy('created_at', 'desc')->get()->map(function ($token) {
                return [
                    'id' => $token->id,
                    'name' => $token->name,
                    'last_used_at' => $token->last_used_at?->diffForHumans(),
                    'created_at' => $token->created_at->diffForHumans(),
                ];
            }),
        ]);
    }

    /**
     * Create a new API token.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $token = $request->user()->createToken($request->name);

        return redirect()->route('api-tokens.index')->with([
            'plainTextToken' => $token->plainTextToken,
        ]);
    }

    /**
     * Delete an API token.
     */
    public function destroy(Request $request, string $tokenId)
    {
        $request->user()->tokens()->where('id', $tokenId)->delete();

        return back();
    }
}
