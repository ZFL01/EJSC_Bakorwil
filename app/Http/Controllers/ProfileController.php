<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Mentor;
use App\Models\Talent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Pastikan user punya baris profil sesuai rolenya.
     * Akun hasil pendaftaran via Google dibuat TANPA baris profil
     * (profil dilengkapi belakangan), jadi harus dibuat otomatis
     * sebelum halaman profil / update profil dipakai.
     */
    protected function ensureProfile($user)
    {
        if ($user->isClient()) {
            return $user->client ?: Client::create([
                'id_user'      => $user->id_user,
                'nama_ukm'     => $user->name,
                'nama_pemilik' => $user->name,
                'email'        => $user->email,
                'status'       => 'aktif',
            ]);
        }

        if ($user->isMentor()) {
            return $user->mentor ?: Mentor::create([
                'id_user' => $user->id_user,
                'nama'    => $user->name,
                'email'   => $user->email,
                'status'  => 'aktif',
            ]);
        }

        if ($user->isTalent()) {
            return $user->talent ?: Talent::create([
                'id_user' => $user->id_user,
                'nama'    => $user->name,
                'email'   => $user->email,
                'status'  => 'aktif',
            ]);
        }

        return null;
    }

    /**
     * Display the user's profile.
     */
    public function show()
    {
        $user = auth()->user();

        // Load the appropriate profile based on role
        $profile = $this->ensureProfile($user);
        if ($user->isTalent()) {
            $profile = $user->talent()->with('mentor')->first();
        }

        return view('profile.show', compact('user', 'profile'));
    }

    /**
     * Show the form for editing the user's profile.
     */
    public function edit()
    {
        $user = auth()->user();

        $profile = $this->ensureProfile($user);
        $mentors = null;

        if ($user->isTalent()) {
            $mentors = Mentor::active()->get();
        }

        return view('profile.edit', compact('user', 'profile', 'mentors'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = auth()->user();
        
        // Base validation for user account
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id_user . ',id_user',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Update user account
        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            $validated['profile_photo'] = $request->file('profile_photo')->store('profiles', 'public');
        }

        $user->update($validated);

        // Update role-specific profile (buat profil dulu bila belum ada)
        if ($user->isClient()) {
            $this->updateClientProfile($request, $this->ensureProfile($user));
        } elseif ($user->isMentor()) {
            $this->updateMentorProfile($request, $this->ensureProfile($user));
        } elseif ($user->isTalent()) {
            $this->updateTalentProfile($request, $this->ensureProfile($user));
        }

        return redirect()->route('profile.show')
            ->with('success', 'Profil berhasil diupdate.');
    }

    /**
     * Update client profile.
     */
    protected function updateClientProfile(Request $request, Client $client)
    {
        $this->authorize('update', $client);

        $validated = $request->validate([
            'nama_ukm' => 'required|string|max:255',
            'nama_produk' => 'required|string|max:255',
            'deskripsi_usaha' => 'nullable|string',
            'no_hp' => 'required|string|max:20',
            'alamat_lengkap' => 'required|string',
            'foto_logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto_logo')) {
            if ($client->foto_logo) {
                Storage::disk('public')->delete($client->foto_logo);
            }
            $validated['foto_logo'] = $request->file('foto_logo')->store('client/logo', 'public');
        }

        $validated['updated_by'] = auth()->id();
        $client->update($validated);
    }

    /**
     * Update mentor profile.
     */
    protected function updateMentorProfile(Request $request, Mentor $mentor)
    {
        $this->authorize('update', $mentor);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'no_wa' => 'required|string|max:20',
            'alamat_lengkap' => 'required|string',
            'keahlian' => 'required|string|max:255',
            'pengalaman' => 'nullable|string',
            'expertise_tags' => 'nullable|string',
            'is_available' => 'boolean',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'url_cv' => 'nullable|mimes:pdf,doc,docx|max:5120',
        ]);

        if ($request->hasFile('foto')) {
            if ($mentor->foto) {
                Storage::disk('public')->delete($mentor->foto);
            }
            $validated['foto'] = $request->file('foto')->store('mentor/foto', 'public');
        }

        if ($request->hasFile('url_cv')) {
            if ($mentor->url_cv) {
                Storage::disk('public')->delete($mentor->url_cv);
            }
            $validated['url_cv'] = $request->file('url_cv')->store('cv', 'public');
        }

        if (isset($validated['expertise_tags'])) {
            $validated['expertise_tags'] = array_map('trim', explode(',', $validated['expertise_tags']));
        }

        $validated['updated_by'] = auth()->id();
        $mentor->update($validated);
    }

    /**
     * Update talent profile.
     */
    protected function updateTalentProfile(Request $request, Talent $talent)
    {
        $this->authorize('update', $talent);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'no_wa' => 'required|string|max:20',
            'alamat_lengkap' => 'required|string',
            'keahlian' => 'required|string|max:255',
            'pengalaman' => 'nullable|string',
            'skill_tags' => 'nullable|string',
            'status_pekerjaan' => 'nullable|in:bekerja,belum bekerja,magang',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'url_cv' => 'nullable|mimes:pdf,doc,docx|max:5120',
            'url_butap' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($talent->foto) {
                Storage::disk('public')->delete($talent->foto);
            }
            $validated['foto'] = $request->file('foto')->store('talent/foto', 'public');
        }

        if ($request->hasFile('url_cv')) {
            if ($talent->url_cv) {
                Storage::disk('public')->delete($talent->url_cv);
            }
            $validated['url_cv'] = $request->file('url_cv')->store('cv', 'public');
        }

        if ($request->hasFile('url_butap')) {
            if ($talent->url_butap) {
                Storage::disk('public')->delete($talent->url_butap);
            }
            $validated['url_butap'] = $request->file('url_butap')->store('butap', 'public');
        }

        if (isset($validated['skill_tags'])) {
            $validated['skill_tags'] = array_map('trim', explode(',', $validated['skill_tags']));
        }

        $validated['updated_by'] = auth()->id();
        $talent->update($validated);
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|current_password',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $request->user()->update([
            'password_hash' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Password berhasil diupdate.');
    }
}
