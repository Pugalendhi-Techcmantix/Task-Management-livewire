<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('login');
    }

    /**
     * Handle an incoming authentication request.
     */
    // public function store(LoginRequest $request): RedirectResponse
    // {
    //     $request->authenticate();

    //     $request->session()->regenerate();

    //     return redirect()->intended(route('dashboard', absolute: false));
    // }
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $user = Auth::user();

        // if ($user instanceof User) { // Ensure $user is an instance of the User model
        //     $user->status = 1;
        //     $user->save();
        // }
        $user = Auth::user();
        $updatLog = User::where('id', $user->id)->update(['status' => 1]);
        // Session()->put('admin_name', Auth::user()->name);
        $request->session()->regenerate();
        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    // public function destroy(Request $request): RedirectResponse
    // {
    //     Auth::guard('web')->logout();

    //     $request->session()->invalidate();

    //     $request->session()->regenerateToken();

    //     return redirect('/');
    // }


    public function destroy(Request $request): RedirectResponse
    {
        // if ($user instanceof User) { // Ensure $user is an instance of the User model
        //     $user->status = 2;
        //     $user->save();
        // }

        $user = Auth::user();
        $updatLog = User::where('id', $user->id)->update(['status' => 2]);
        // Auth::guard('web')->logout();
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
