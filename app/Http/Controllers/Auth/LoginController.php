<?php

namespace App\Http\Controllers\Auth;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AuthService;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    protected $authService;

    /**
     * LoginController constructor.
     *
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    // Handle login
    public function login(LoginRequest $request)
    {
        $result = $this->authService->authenticate($request->validated());
        if ($result['success']) {
            return redirect()->route('admin.dashboard')->with('success', $result['message']);
        }
        // Add the email to session and return errors
        return back()->withErrors(['invalid' => $result['message']]); // Retains email in input
    }

    // Handle logout
    public function logout()
    {
        Auth::logout();
        return redirect('/admin')->with('success', 'You have been logged out!');
    }
}
