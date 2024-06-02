<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Phones;
use App\Services\MobizonService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Throwable;

class AuthApiController extends Controller
{
    public function getSmsCode(Request $request)
    {
        try {
            $validatePhone = $request->validate(["phone" => 'required|string|max:10|min:10']);
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage()]);
        }
        if (!Phones::where("phone", $validatePhone['phone'])->first()) {
            $code = /* rand(1000, 9999) */ 9999;
            $code_id = Str::uuid();
            $newPhone = Phones::create(['phone' => $validatePhone['phone'], "code" => $code, "code_id" => $code_id]);
            // $mobizoneService = new MobizonService();
            $message = "Your verification code is: $code. RUSLANDEV";
            // $smsResponse = $mobizoneService->sendSms($validatePhone['phone'], $message);
            return response()->json([$code_id]);
        }
        $currentPhone = Phones::where("phone", $validatePhone['phone'])->first();
        if ($currentPhone->updated_at->addMinutes(10) < now()) {
            $code = 9999/* rand(1000, 9999) */;
            $code_id = Str::uuid();
            $currentPhone->update(["code" => $code, "code_id" => $code_id]);
            // $mobizoneService = new MobizonService();
            $message = "Your verification code is: $code. RUSLANDEV";
            // $smsResponse = $mobizoneService->sendSms($validatePhone['phone'], $message);
            return response()->json($code_id);
        } else {
            return response()->json("Код можно отправлять не чаще 1 раз за 5 минут", 400, [], JSON_UNESCAPED_UNICODE);
        }
    }
    public function registration()
    {
    }
    public function checkCode(Request $request)
    {
        try {
            $validate = $request->validate(["code" => "required|string|max:4|min:4", "code_id" => "required|string"]);
        } catch (Throwable $error) {
            return response()->json($error);
        }
        if (!Phones::where('code_id', $validate["code_id"])->first()) {
            return response()->json("Код не найден", 400, [], JSON_UNESCAPED_UNICODE);
        }
        if (Phones::where('code_id', $validate["code_id"])->first()->code !== $validate['code']) {
            return response()->json('Неверный код', 400, [], JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json(true);
        }
    }
    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }
    public function edit(string $id)
    {
        //
    }
    public function update(Request $request, string $id)
    {
        //
    }
    public function destroy(string $id)
    {
        //
    }
}
