<?php
namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'level'=>['nullable'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $level = $request->input('level', '');

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'level' => $level,
        ]);
        $datauser=User::where('level','Admin')->get();

            foreach ($datauser as $item) {
                Notifikasi::create([
                'judul'=>'new acount',
                'isi'=>'ada user baru melakukan register',
                'user_id'=>$item->id,
            ]);
        }


        Auth::login($user);

        return redirect()->route('login');
    }
}
