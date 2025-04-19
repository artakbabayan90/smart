<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Reward;
use App\WithdrawalRequest;
use Illuminate\Support\Facades\Config;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function createRewardForm(User $user)
    {
        return view('admin.rewards.create', compact('user'));
    }

    public function storeReward(Request $request, User $user)
    {
        $this->validate($request, [
            'amount' => 'required|numeric|min:0.01',
            'reason' => 'required|string|max:255',
        ]);

        Reward::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'reason' => $request->reason,
        ]);

        $user->increment('balance', $request->amount);

        return redirect('/admin/users')->with('success', 'Вознаграждение успешно начислено пользователю ' . $user->name);
    }

    public function withdrawals()
    {
        $withdrawals = WithdrawalRequest::where('status', 'pending')->latest()->get();
        return view('admin.withdrawals', compact('withdrawals'));
    }

    public function approveWithdrawal(WithdrawalRequest $withdrawal)
    {
        $clientId = env('PAYPAL_CLIENT_ID');
        $clientSecret = env('PAYPAL_SECRET');
        $paypalApiUrl = env('PAYPAL_API_URL');
        $currency = 'USD'; // Можешь сделать настраиваемым

        $accessToken = $this->getPaypalAccessToken($clientId, $clientSecret, $paypalApiUrl);

        if ($accessToken) {
            $payoutData = [
                'sender_batch_header' => [
                    'sender_batch_id' => uniqid(),
                    'email_subject' => 'Выплата от нашего сервиса',
                ],
                'items' => [
                    [
                        'recipient_type' => 'EMAIL',
                        'receiver' => $withdrawal->paypal_email,
                        'amount' => [
                            'value' => number_format($withdrawal->amount, 2, '.', ''),
                            'currency' => $currency,
                        ],
                        'note' => 'Выплата по запросу #' . $withdrawal->id,
                        'sender_item_id' => $withdrawal->id,
                    ],
                ],
            ];

            $payoutUrl = $paypalApiUrl . '/v1/payments/payouts';
            $response = $this->sendPaypalRequest($payoutUrl, 'POST', $accessToken, json_encode($payoutData));

            if ($response && isset($response['batch_header']['batch_status']) && in_array($response['batch_header']['batch_status'], ['PROCESSING', 'COMPLETED'])) {
                $withdrawal->update(['status' => 'approved']);
                $user = User::find($withdrawal->user_id);
                if ($user) {
                    $user->decrement('balance', $withdrawal->amount);
                }
                return redirect('/admin/withdrawals')->with('success', 'Выплата пользователю ' . ($user ? $user->name : 'ID ' . $withdrawal->user_id) . ' инициирована.');
            } else {
                $error = isset($response['debug_id']) ? 'Ошибка PayPal (ID): ' . $response['debug_id'] : 'Ошибка при отправке выплаты через PayPal.';
                \Log::error('PayPal Payout Error: ' . json_encode($response));
                return redirect('/admin/withdrawals')->with('error', $error);
            }
        } else {
            return redirect('/admin/withdrawals')->with('error', 'Не удалось получить токен доступа PayPal.');
        }
    }

    private function getPaypalAccessToken($clientId, $clientSecret, $paypalApiUrl)
    {
        $url = $paypalApiUrl . '/v1/oauth2/token';
        $auth = base64_encode($clientId . ':' . $clientSecret);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Basic ' . $auth,
            'Content-Type: application/x-www-form-urlencoded',
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($httpCode == 200 && $response) {
            $responseArray = json_decode($response, true);
            return isset($responseArray['access_token']) ? $responseArray['access_token'] : null;
        } else {
            \Log::error('PayPal Get Access Token Error: ' . $response . ' (HTTP Code: ' . $httpCode . ')');
            return null;
        }

        curl_close($ch);
    }

    private function sendPaypalRequest($url, $method, $accessToken, $postData = null)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $accessToken,
            'Content-Type: application/json',
        ]);

        if ($postData) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($httpCode >= 200 && $httpCode < 300 && $response) {
            return json_decode($response, true);
        } else {
            \Log::error('PayPal API Request Error (HTTP Code: ' . $httpCode . '): ' . $response);
            return null;
        }

        curl_close($ch);
    }
}