<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    /**
     * Pastikan hanya Admin yang dapat mengakses halaman ini.
     */
    private function ensureAdmin(): void
    {
        abort_unless(
            auth()->check() &&
            auth()->user()->role === 'admin',
            403
        );
    }

    /**
     * Daftar seluruh rating & komentar.
     */
    public function index(Request $request)
    {
        $this->ensureAdmin();

        $query = Rating::with([
            'client',
            'rateable',
        ])->latest();

        // Filter berdasarkan target
        if ($request->filled('type')) {
            $type = $request->type;

            if (in_array($type, ['mentor', 'talenta'], true)) {
                $query->where('rateable_type', $type);
            }
        }

        // Filter berdasarkan rating
        if ($request->filled('rating')) {
            $query->where(
                'rating',
                $request->rating
            );
        }

        $ratings = $query
            ->paginate(15)
            ->withQueryString();

        return view(
            'admin.ratings.index',
            compact('ratings')
        );
    }

    /**
     * Hapus rating & komentar.
     */
    public function destroy(Rating $rating)
    {
        $this->ensureAdmin();

        $rating->delete();

        return redirect()
            ->route('admin.ratings.index')
            ->with(
                'success',
                'Rating dan komentar berhasil dihapus.'
            );
    }
}