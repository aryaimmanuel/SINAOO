<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Fortify;
use Modules\User\Entities\UserPremium;

class JogjaController extends Controller
{
    public function masuk(Request $request)
    {

        $cek = User::where('email', $request->email)->first();

        if(is_null($cek)){
            User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'name' => $request->name,
                'last_name' => $request->last_name,
                'role_id' => 2
            ]);
        }

        Fortify::authenticateUsing(function () use($request) {
            $user = User::where('email', $request->email)->first();

            if ($user &&
                Hash::check($request->password, $user->password)) {
                return $user;
            }
        });
    }

    public function konfirmasi(Request $request)
    {
        $cek = UserPremium::where('payment_code', $request->payment_code)->first();

        if(is_null($cek)){
            return response()->json("not oke", 400);
        }else{
            $cek->is_paid = 1;
            $cek->save();

            $user = User::find($cek->user_id);
            $user->is_premium = 1;
            $user->save();
            return response()->json("oke", 200);
        }
    }

    public function update(Request $request)
    {
        $user = User::where('email', $request->input('email'))->first();
        $user->name = $request->input('name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->save();
    }

    public function password(Request $request)
    {
        $user = User::where('email', $request->input('email'))->first();

        if (Hash::check($request->input('current_password'), $user->password)) {
            $user->password = Hash::make($request->input('new_password'));
            $user->save();
        } else {
            return redirect()->back()->withInput();
        }
    }
}
