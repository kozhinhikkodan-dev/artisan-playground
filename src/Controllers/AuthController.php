<?php

namespace KozhinhikkodanDev\ArtisanPlayground\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('artisan-playground.dashboard');
        }

        return view('artisan-playground::auth.login');
    }

    /**
     * Handle the login request.
     */
    public function login(Request $request)
    {
        $config = config('artisan-playground.auth');

        if ($config['custom_credentials']['enabled']) {
            return $this->handleCustomLogin($request, $config);
        }

        return $this->handleStandardLogin($request);
    }

    /**
     * Handle custom credentials login.
     */
    protected function handleCustomLogin(Request $request, array $config)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $username = $config['custom_credentials']['username'];
        $password = $config['custom_credentials']['password'];

        if ($request->username === $username && $request->password === $password) {
            // Create a temporary session for custom login
            session(['artisan_playground_authenticated' => true]);
            session([
                'artisan_playground_user' => [
                    'id' => 'custom',
                    'name' => $username,
                    'email' => $username . '@artisan-playground.local',
                ]
            ]);

            return redirect()->intended(route('artisan-playground.dashboard'));
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('username'));
    }

    /**
     * Handle standard Laravel authentication.
     */
    protected function handleStandardLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended(route('artisan-playground.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email'));
    }

    /**
     * Handle the logout request.
     */
    public function logout(Request $request)
    {
        // Clear custom session if exists
        if (session('artisan_playground_authenticated')) {
            session()->forget(['artisan_playground_authenticated', 'artisan_playground_user']);
        }

        // Logout from standard auth if logged in
        if (Auth::check()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return redirect()->route('artisan-playground.login');
    }
}