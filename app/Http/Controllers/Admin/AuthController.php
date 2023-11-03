<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    /**
     * @return Application|Factory|View
     */
    public function login(): Application|Factory|View
    {

        return view('admin.auth.login');

    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function loginOperation(Request $request): RedirectResponse
    {

        $data = $request->validate([
            'email'     => 'required|email',
            'password'  => 'required'
        ]);

        if (\Auth::attempt($data)) {

            auth()->user()?->update([
                'last_login_time' => time()
            ]);

            session()->regenerate();

            return redirect()->route('web.user.index');

        }

        return redirect()->route('web.login')->withErrors('Kullanıcı adı veya parola yanlış!');



    }

    /**
     * @return RedirectResponse
     */
    public function logout(): RedirectResponse
    {
        \Auth::logout();
        return redirect()->route('web.user.index');
    }

}
