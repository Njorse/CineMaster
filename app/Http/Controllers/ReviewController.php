<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'tmdb_id' => 'required',
            'content' => 'required|string|max:1000',
        ]);

        Review::create([
            'user_id' => Auth::id(),
            'tmdb_id' => $request->input('tmdb_id'),
            'content' => $request->input('content'),
        ]);

        return back()->with('success', 'Reseña publicada con éxito.');
    }

    public function destroy(Review $review)
    {
        // Verificar que el usuario sea dueño de la reseña
        if ($review->user_id !== Auth::id()) {
            abort(403, 'No autorizado');
        }

        $review->delete();

        return back()->with('success', 'Reseña eliminada.');
    }
}
