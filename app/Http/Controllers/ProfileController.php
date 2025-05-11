<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Resenha;
use App\Models\Favorita;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }


    public function index(Request $request): View
    {
        $user = $request->user();
        $resenhas = Resenha::where('id_usuario', $user->id)->paginate(4);
        $favoritas = Favorita::where('id_usuario', $user->id)->get();

        return view('profile.mi-perfil', [
            'user' => $user,
            'resenhas' => $resenhas,
            'favoritas' => $favoritas,
        ]);
    }

    public function ver_perfil_ajeno($username)
    {
        $user = User::where('name', $username)->firstOrFail();

        $resenhas = $user->resenhas()->latest()->paginate(5); // Asumiendo relación hasMany

        return view('pages.perfil_ajeno', compact('user', 'resenhas'));
    }
}
