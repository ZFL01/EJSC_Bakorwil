<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Mentor;
use App\Models\Rating;
use App\Models\Talent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    /**
     * Menyimpan rating dan komentar dari Client.
     */
    public function store(Request $request)
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect()
                ->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        /*
        |--------------------------------------------------------------------------
        | Cari data Client berdasarkan user yang sedang login
        |--------------------------------------------------------------------------
        */
        $client = Client::where(
            'id_user',
            Auth::user()->id_user
        )->first();

        // Hanya Client yang boleh memberikan rating
        if (!$client) {
            return back()->with(
                'error',
                'Hanya Client yang dapat memberikan rating.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Validasi input
        |--------------------------------------------------------------------------
        */
        $validated = $request->validate(
            [
                'rateable_type' => [
                    'required',
                    'in:talenta,mentor',
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
            ],
            [
                'rateable_type.required' =>
                    'Target rating tidak ditemukan.',

                'rateable_type.in' =>
                    'Target rating tidak valid.',

                'rateable_id.required' =>
                    'ID target tidak ditemukan.',

                'rating.required' =>
                    'Silakan pilih rating terlebih dahulu.',

                'rating.min' =>
                    'Rating minimal 1 bintang.',

                'rating.max' =>
                    'Rating maksimal 5 bintang.',

                'comment.max' =>
                    'Komentar maksimal 1000 karakter.',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Pastikan Talent / Mentor benar-benar ada
        |--------------------------------------------------------------------------
        */
        if ($validated['rateable_type'] === 'talenta') {

            $target = Talent::where(
                'id_talenta',
                $validated['rateable_id']
            )->first();

            if (!$target) {
                return back()->with(
                    'error',
                    'Talent tidak ditemukan.'
                );
            }

        } else {

            $target = Mentor::where(
                'id_mentor',
                $validated['rateable_id']
            )->first();

            if (!$target) {
                return back()->with(
                    'error',
                    'Mentor tidak ditemukan.'
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Cek apakah Client sudah pernah memberikan rating
        |--------------------------------------------------------------------------
        */
        $alreadyRated = Rating::where(
            'client_id',
            $client->id_client
        )
        ->where(
            'rateable_type',
            $validated['rateable_type']
        )
        ->where(
            'rateable_id',
            $validated['rateable_id']
        )
        ->exists();

        if ($alreadyRated) {
            return back()->with(
                'error',
                'Anda sudah memberikan rating untuk profil ini.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Simpan rating
        |--------------------------------------------------------------------------
        */
        Rating::create([
            'client_id' => $client->id_client,
            'rateable_type' => $validated['rateable_type'],
            'rateable_id' => $validated['rateable_id'],
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
        ]);

        return back()->with(
            'success',
            'Rating dan komentar berhasil dikirim.'
        );
    }
}