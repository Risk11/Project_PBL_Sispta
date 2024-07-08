<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index()
    {
        return view('pengguna.login');
    }
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        $user->password = Hash::make($request->new_password);
        /* $user->save(); */

        return redirect()->route('pengguna.login')->with('success', 'Password successfully updated');
    }
    public function post_login(Request $request)
    {

        $request->validate([
            'email' => 'required',
            'password' =>'required',
        ]);
        $data = [
        'email' => $request->email,
        'password' => $request->password
        ];
        if(Auth::attempt($data)){
            $request->session()->flash('welcome', 'Selamat datang, ' . Auth::user()->level);
            return redirect('layout');
        }



        else{
            return redirect()->route('login')->with('error','silahkan coba lagi');
        }
    }


    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Auth::logout();
        return redirect()->route('landingpage3')->with('success','kamu berhasil logout');
    }
}
