<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Kreait\Firebase\Contract\Auth as FirebaseAuth;
use Kreait\Firebase\Contract\Database;
use Session;

class AuthenticatedSessionController extends Controller
{
    public function __construct(FirebaseAuth $auth, Database $database)
    {
        $this->auth = $auth;
        $this->database = $database;
        $this->table_name = 'doctors';
    }
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return Inertia::render("Auth/Login");
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        if ($this->auth->signInWithEmailAndPassword($request->email, $request->password)) {
            $user = $this->auth->getUserByEmail($request->email);
            if ($request->email == 'admin@admin.com') {
                $type = 'admin';
                session(['uid' => $user->uid, 'email' => $user->email, 'display_name' => 'Admin', 'type' => $type]);
            } else {
                $doctor = $this->database->getReference($this->table_name . '/' . $user->uid)->getValue();
                session([
                    "department" => $doctor['department'],
                    "email" => $doctor['email'],
                    "first_name" => $doctor['first_name'],
                    "uid" => $doctor['key'],
                    "last_name" => $doctor['last_name'],
                    "middle_initial" => $doctor['middle_initial'],
                    'type' => 'normal'
                ]);
            }



            return redirect()->intended(RouteServiceProvider::HOME);
        };


        // $request->authenticate();



        $request->session()->regenerate();
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {



        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
