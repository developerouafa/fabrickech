<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\category;
use App\Models\profileusers;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        $categories = category::selectcategories()->withcategories()->parent()->get();
        return Inertia::render('Auth/Register', ["categories" => $categories]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|string|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'roles_name' => ["null"],
            'admin' => '1'
        ]);

        $user_id = User::latest()->first()->id;
        profileusers::create([
            'user_id' => $user_id,
            'firstname' => ['en' => 'null', 'ar' => 'فارغ'],
            'lastname' => ['en' => 'null', 'ar' => 'فارغ'],
            'designation' => ['en' => 'null', 'ar' => 'فارغ'],
            'website' => 'null',
            'Address' => 'null',
            'twitter' => 'null',
            'facebook' => 'null',
            'google' => 'null',
            'linkedin' => 'null',
            'github' => 'null',
            'biographicalinfo' => 'null',
            'fullname' => 'null',
            'town' => 'null',
            'city' => 'null',
            'region' => 'null',
            'country' => 'null',
            'streetaddress' => 'null',
            'zipcode' => 'null',
            'phone' => 'null',
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
