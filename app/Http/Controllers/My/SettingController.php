<?php

namespace App\Http\Controllers\My;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Rules\IdentRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SettingController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('my.setting', compact('user'));
    }

    public function update(Request $request)
    {
        $user = User::find(Auth::user()->id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'login' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id), new IdentRule()],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ]);

        $user->fill($request->all());
        $user->save();

        return to_route('my.setting.edit');
    }
}
