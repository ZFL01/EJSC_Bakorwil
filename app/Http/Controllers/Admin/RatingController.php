<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mentor;
use App\Models\Rating;
use App\Models\Talent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    private function ensureAdmin(): void
    {
        abort_unless(
            Auth::check() &&
            Auth::user()->role === 'admin',
            403
        );
    }

    public function index(Request $request)
    {
        $this->ensureAdmin();

        $query = Rating::with([
            'client',
            'admin',
            'rateable',
        ])->latest();

        if ($request->filled('type')) {

            $type = $request->type;

            if (in_array($type, ['mentor', 'talenta'], true)) {

                $query->where(
                    'rateable_type',
                    $type
                );
            }
        }

        if ($request->filled('rating')) {

            $query->where(
                'rating',
                $request->rating
            );
        }

        $ratings = $query
            ->paginate(15)
            ->withQueryString();

        $mentors = Mentor::query()
            ->orderBy('nama')
            ->get([
                'id_mentor',
                'nama',
            ]);

        $talents = Talent::query()
            ->orderBy('nama')
            ->get([
                'id_talenta',
                'nama',
            ]);

        return view(
            'admin.ratings.index',
            compact(
                'ratings',
                'mentors',
                'talents'
            )
        );
    }

    public function store(Request $request)
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'rater_name' => [
                'required',
                'string',
                'max:150',
            ],

            'rateable_type' => [
                'required',
                'in:mentor,talenta',
            ],

            'rateable_id' => [
                'required',
                'integer',
            ],

            'rating' => [
                'required',
                'integer',
                'min:1',
                'max:5',
            ],

            'comment' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        if (
            $validated['rateable_type'] === 'mentor'
        ) {

            $targetExists = Mentor::where(
                'id_mentor',
                $validated['rateable_id']
            )->exists();

        } else {

            $targetExists = Talent::where(
                'id_talenta',
                $validated['rateable_id']
            )->exists();
        }

        abort_unless(
            $targetExists,
            404,
            'Mentor atau Talent tidak ditemukan.'
        );

        Rating::create([
            'client_id' => null,

            'admin_id' =>
                Auth::user()->id_user,

            'rater_name' =>
                $validated['rater_name'],

            'rateable_type' =>
                $validated['rateable_type'],

            'rateable_id' =>
                $validated['rateable_id'],

            'rating' =>
                $validated['rating'],

            'comment' =>
                $validated['comment'] ?? null,
        ]);

        return redirect()
            ->route('admin.ratings.index')
            ->with(
                'success',
                'Rating berhasil ditambahkan.'
            );
    }

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