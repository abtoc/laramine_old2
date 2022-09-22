<?php

namespace App\Http\Controllers\My;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ResetPasswordController extends Controller
{
    public function edit()
    {
        return view('my.reset');
    }

    public function update(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'new_password' => ['required', 'confirmed', 'different:password', Rules\Password::defaults()],
        ]);

        $user = Auth::user();
        if(Hash::check($request->password, $user->password)){
            $user->password = Hash::make($request->new_password);
            $user->save();
            return redirect(RouteServiceProvider::HOME);
        }

        throw ValidationException::withMessages([
            'password' => [trans('auth.failed')],
        ]);
    }
}
