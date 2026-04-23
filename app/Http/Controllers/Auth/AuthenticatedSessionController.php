<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
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
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    // داخل AuthenticatedSessionController
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        // فحص الحالة بعد المصادقة مباشرة
        if (Auth::user()->status !== 'مفعل') {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors([
                'email' => 'هذا الحساب غير مفعل، يرجى التواصل مع المدير.',
            ]);
        }

        $request->session()->regenerate();
        return redirect()->intended(route('dashboard', absolute: false));
    }


   

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
