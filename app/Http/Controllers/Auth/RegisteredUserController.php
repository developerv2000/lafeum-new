<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Folder;
use App\Models\Role;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $validationRules = [
            'name' => ['required', 'string', 'max:255', 'unique:' . User::class],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', 'min:5'],
        ];

        $validationMessages = [
            'name.unique' => 'Пользователь с таким именем уже существует',
            'email.unique' => 'Пользователь с такой почтой уже существует',
            'password.confirmed' => 'Пароли не совпадают'
        ];

        Validator::make($request->all(), $validationRules, $validationMessages)->validate();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => Role::where('name', Role::USER_ROLE)->first()->id,
        ]);

        Folder::createDefaultsForNewUser($user);

        event(new Registered($user));

        Auth::login($user);

        return [
            'success' => true
        ];
    }
}
