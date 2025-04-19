<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Reward;
use App\WithdrawalRequest;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        $user = Auth::user();
        return view('user.dashboard', compact('user'));
    }

    public function rewards()
    {
        $user = Auth::user();
        $rewards = Reward::where('user_id', $user->id)->latest()->get();
        return view('user.rewards', compact('rewards'));
    }

    public function withdrawForm()
    {
        $user = Auth::user();
        return view('user.withdraw', compact('user'));
    }

    public function submitWithdrawalRequest(Request $request)
    {
        $user = Auth::user();
        $this->validate($request, [
            'amount' => 'required|numeric|min:1|max:' . $user->balance,
            'paypal_email' => 'required|email',
        ]);

        WithdrawalRequest::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'paypal_email' => $request->paypal_email,
        ]);

        return redirect('/dashboard')->with('success', 'Запрос на выплату успешно отправлен.');
    }
}