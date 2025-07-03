<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\User1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class User1Controller extends Controller
{
    public function showUser()
    {
        return view('login');
    }
    public function user(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);
        $user = User1::where('email', $request->email)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            Session::put('id', $user->id);
            Session::put('name', $user->name);
            Session::put('email', $user->email);
            Session::put('role', $user->role);
            if ($user->role === 'admin') {
                return redirect('/dashboard');
            } {
                return redirect('/customerdashboard');
            }
        } else {
        }
        return redirect()->back()->with('error', 'Invalid email or password');
    }
    public function updateProfile(Request $requset)
    {
        $requset->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|digits:10',
            'address' => 'required|string|max:500',
        ]);
        $user=User1::find(session('id'));
        if($user)
        {
            $user->name=$requset->name;
            $user->email=$requset->email;
            $user-> phone=$requset->phone;
            $user->address=$requset->address;
            $user->save();
            
            session([
                'name'=>$user->name,
                'email'=>$user->email,
            ]);
             return redirect()->back()->with('success', 'Profile updated successfully!');
        }
        return redirect()->back()->with('error', 'User not found.');
    }
    public function updatePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|string|min:6|confirmed',
    ]);

    $user = User::find(Session::get('user_id'));

    if (!$user || !Hash::check($request->current_password, $user->password)) {
        return redirect()->back()->with('error', 'Current password is incorrect.');
    }

    $user->password = Hash::make($request->new_password);
    $user->save();

    return redirect()->back()->with('success', 'Password changed successfully.');
}
    public function logout()
    {
        Session::flush();
        return redirect('/login');
    }
}
