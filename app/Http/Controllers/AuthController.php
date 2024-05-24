<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;
use App\Models\User;
use App\Services\MobizonService;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required | string | max:255',
            'email' => 'required | string | email | max:255 | unique:users',
            'phone' => 'required | string | unique:users',
            'password' => 'required | string | min:8 | confirmed',
        ]);
        // dd($validated);
        // Создаем пользователя, но не активируем его
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'is_active' => false, // или любой другой способ отметить неактивного пользователя
        ]);

        // Генерация кода подтверждения
        $verificationCode = rand(100000, 999999);
        $user->verification_code = $verificationCode;
        $user->save();
        // Отправка SMS с помощью Twilio
        $this->sendSms($user->phone, "Your verification code is: $verificationCode");
        dd($user);

        return redirect('/verify')->with('status', 'We sent you a verification code. Please check your phone.');
    }

    public function showVerifyForm()
    {
        return view('auth.verify');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:15',
            'verification_code' => 'required|integer',
        ]);

        $user = User::where('phone', $request->phone)->where('verification_code', $request->verification_code)->first();

        if ($user) {
            $user->is_active = true;
            $user->verification_code = null;
            $user->save();

            // Логиним пользователя
            auth()->login($user);

            return redirect('/home')->with('status', 'Your phone number has been verified.');
        } else {
            return back()->withErrors(['verification_code' => 'The provided verification code is incorrect.']);
        }
    }

    private function sendSms($to, $message)
    {
        $client = new \GuzzleHttp\Client();
        $endpoint = "http://api.mobizon.kz/service/message/sendsmsmessage?text=Hello&apiKey=kzed162ea83f13bdf624152ac71a28a07ddc3ac4f1260b8f48b10e999f429b86e3b026&recipient=7707142366&";
        $response = $client->request("GET", $endpoint);
        dd($response->getBody()->getContents(), $response->getStatusCode(), $response);


        // $mobizoneService = new MobizonService();
        // $mobizoneService->sendSms($to, $message);

        // $sid = env('TWILIO_SID');
        // $token = env('TWILIO_AUTH_TOKEN');
        // $twilio = new Client($sid, $token, null, null, null, null, ['verify' => false]);

        // $twilio->messages->create($to, [
        //     'from' => env('TWILIO_PHONE_NUMBER'),
        //     'body' => $message,
        // ]);
    }
}
