<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    /**
     * Persist the manually chosen light / dark theme as a session backup.
     *
     * localStorage stays the primary store so a page load never needs a request,
     * and each section keeps its own key so a frontend choice never leaks into
     * the admin panel. The session covers the cases storage cannot: blocked or
     * cleared localStorage, and a different browser on the same session cookie.
     */
    public function update(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'scope' => ['required', 'in:frontend,admin'],
            'theme' => ['required', 'in:dark,light'],
        ]);

        session(['theme_'.$validated['scope'] => $validated['theme']]);

        return response()->json(['saved' => true]);
    }
}
