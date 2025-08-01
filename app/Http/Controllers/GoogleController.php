<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Login;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use Str;

class GoogleController extends Controller
{
    //
    public function redirectGoogle()
    {

        return Socialite::driver('google')
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }

    // public function handleGoogleCallback()
    // {

    //     $googleUser = Socialite::driver('google')->stateless()->user();
    //     $user=User::updateOrCreate(
    //         ['email'=>$googleUser->getEmail()],
    //         ['name'=>$googleUser->getName()]
    //     );
    //     return redirect('/dashboard');
     
    // }

      public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        // Check if user exists
        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            // Create new user without static role
            $user = User::create([
                'email' => $googleUser->getEmail(),
                'name' => $googleUser->getName(),
                'password' => bcrypt(Str::random(16)), 
               
            ]);
        } else {
          
            $user->update([
                'name' => $googleUser->getName(),
            ]);
        }

        
        Auth::login($user);

       
        session([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role, 
        ]);

       
        return redirect($user->role === 'admin' ? '/dashboard' : '/customerdashboard');
    }
}
