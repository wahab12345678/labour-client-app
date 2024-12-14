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
            return redirect()->intended('dashboard')->with('success', $result['message']);
        }
        return back()->withErrors(['email' => $result['message']])->onlyInput('email');
    }
}
