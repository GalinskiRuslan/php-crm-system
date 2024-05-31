<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Phones;
use App\Services\MobizonService;
use Illuminate\Http\Request;

class AuthApiController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function getSmsCode(Request $request)
    {
        try {
            $validatePhone = $request->validate(["phone" => 'required|string|max:10|min:10']);
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage()]);
        }
        if (!Phones::where("phone", $validatePhone['phone'])->first()) {
            $code = rand(1000, 9999);
            $newPhone = Phones::create(['phone' => $validatePhone['phone'], "code" => $code]);
            $mobizoneService = new MobizonService();
            $message = "Your verification code is: $code. RUSLANDEV";
            $smsResponse = $mobizoneService->sendSms($validatePhone['phone'], $message);

            return response()->json($smsResponse);
        }
        $currentPhone = Phones::where("phone", $validatePhone['phone'])->first();
        if ($currentPhone->updated_at->addMinutes(10) < now()) {
            $code = rand(1000, 9999);
            $currentPhone->update(["code" => $code]);
            $mobizoneService = new MobizonService();
            $message = "Your verification code is: $code. RUSLANDEV";
            $smsResponse = $mobizoneService->sendSms($validatePhone['phone'], $message);
            return response()->json($smsResponse);
        } else {
            return response()->json(["error" => "Код можно отправлять не чаще 5 минут"], 400, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8']);
        }
    }
    public function registration()
    {
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
