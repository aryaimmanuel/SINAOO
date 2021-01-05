<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Modules\Lesson\Entities\Lesson;
use Modules\User\Entities\UserPremium;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $lessons = Lesson::paginate(6);
        $title = "Pelajaran yang tersedia";

        return view('home', compact('lessons', 'title'));
    }

    public function premium()
    {
        $kode = "SIN-" . Auth::id() . "-" . time();
        UserPremium::updateOrCreate(
            ['user_id' => Auth::id(), 'payment_code' => null],
            ['price' => config('app.price'), 'payment_code' => $kode]
        );

        Http::post(config('app.ezpay').'transaksi', [
            'payment_code' => $kode,
            'price' => config('app.price'),
            'email' => Auth::user()->email,
            'catatan' => "Pembayaran untuk Sinaoo Premium Account, akun: " . Auth::user()->email
        ]);

        return redirect()->route('profile')->with('success', 'Berhasil!' . config('app.ezpay '));
    }

    public function premium_data()
    {
        return view('premium');
    }
}
