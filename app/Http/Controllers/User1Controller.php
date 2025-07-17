<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\User1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
              echo json_encode(["status" => "success", "role" => "admin"]);
              
        //  return redirect('/dashboard');
        } else {
              echo json_encode(["status" => "success", "role" => "user"]);
        //  return redirect('/customerdashboard');
        }
    }

    // return redirect()->back()->with('error', 'Invalid email or password');
}

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|digits:10',
            'address' => 'required|string|max:500',
        ]);

        $user = User1::find(session('id'));

        if ($user) {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->save();

            Session::put('name', $user->name);
            Session::put('email', $user->email);

            return redirect()->back()->with('success', 'Profile updated successfully!');
        }

        return redirect()->back()->with('error', 'User not found.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'oldpassword' => 'required',
            'newpassword' => 'required|string|min:6|confirmed',
        ]);

        $user = User1::where('email', session('email'))->first();

        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        if (!Hash::check($request->oldpassword, $user->password)) {
            return redirect()->back()->with('error', 'Old password is incorrect.');
        }

        $user->password = Hash::make($request->newpassword);
        $user->save();

        return redirect()->back()->with('success', 'Password changed successfully.');
    }
   
     public function create()
    {
        return view('users.create'); 
    }
     public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email',
            'password' => 'required|min:6',
            'phone'    => 'required|string|max:20',
            'address'  => 'required|string|max:500',
            'role'     => 'required|in:admin,user',
        ]);

        User1::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone'    => $validated['phone'],
            'address'  => $validated['address'],
            'role'     => $validated['role'],
        ]);
        return response()->json([
        'success' => true,
        'message' => 'User created successfully.'
    ]);

        
    }

public function index()
{
    $users=User1::all();
    return view('users.index',compact('users'));
}
public function destroy($id)
{
    $user = User1::findOrFail($id);
    $user->delete();

     return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    //  return response()->json(['message' => 'User Deleted successfully.'], 200);
    
}
public function edit($id)
{
    $user = User1::findOrFail($id);
    return view('users.edit', compact('user'));
}
public function update(Request $request, $id)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'phone' => 'required|string|max:20',
        'address' => 'required|string|max:500',
        'role' => 'required|in:admin,customer',
    ]);
    
    $user = User1::findOrFail($id);
    $user->update($validated);  

    // return redirect()->route('users.index')->with('success', 'User updated successfully!');
    return response()->json(['message' => 'User updated successfully.'], 200);
    
}





    public function logout()
    {
        Session::flush();
        return redirect('/login');
    }
}
