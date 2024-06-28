<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Phones;
use App\Models\User;
use App\Services\MobizonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Throwable;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthApiController extends Controller
{

    /**
     * @OA\Get(
     *   path="/api/auth/getSms",
     *   summary = "Получение смс кода",
     *   tags={"Auth"},
     *   @OA\Parameter(
     *   name="phone",
     *   in="query",
     *   required=true,
     *   description="Номер телефона",
     *   example="7999999999",
     *   ),
     *
     *
     *   @OA\Response(
     *     response=200,
     *     description="successful operation",
     *   ),
     * )
     *
     *
     */


    public function getSmsCode(Request $request)
    {
        try {
            $validatePhone = $request->validate(["phone" => 'required|string|max:10|min:10']);
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage()], 400);
        }
        if (!Phones::where("phone", $validatePhone['phone'])->first()) {
            $code = /* rand(1000, 9999) */ 9999;
            $code_id = Str::uuid();
            $newPhone = Phones::create(['phone' => $validatePhone['phone'], "code" => $code, "code_id" => $code_id]);
            // $mobizoneService = new MobizonService();
            $message = "Your verification code is: $code. RUSLANDEV";
            // $smsResponse = $mobizoneService->sendSms($validatePhone['phone'], $message);
            return response()->json($code_id);
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
    /**
     * @OA\Post(
     *    path="/api/auth/registration",
     *    summary = "Регистрация",
     *    tags={"Auth"},
     *      @OA\RequestBody(
     *        @OA\JsonContent(
     *         allOf={
     *           @OA\Schema(
     *             @OA\Property( property="code_id", type="string", example="20cccf8f-db3d-4c52-95cb-3c11c490c05e"),
     *             @OA\Property( property="code", type="string", example="9999"),
     *             @OA\Property( property="name", type="string", example="Ruslan"),
     *             @OA\Property( property="email", type="string", example="qK5pI@example.com"),
     *             @OA\Property( property="password", type="string", example="123456789"),
     *           )
     *         }
     *        )
     *      ),
     *
     *     @OA\Response(
     *     response=200,
     *     description="successful operation",
     *     ),
     * )
     */
    public function registration(Request $request)
    {
        try {
            $validate = $request->validate([
                "code_id" => 'required|string', "code" => "required|string|max:4|min:4", "name" => "string|max:255",
                "email" => "string|email|max:255|unique:users", "password" => "required|string|min:8"
            ]);
            $email = isset($validate["email"]) ? $validate["email"] : null;
            $name = isset($validate["name"]) ? $validate["name"] : null;
        } catch (Throwable $error) {
            return response()->json($error->getMessage());
        }
        $phone = Phones::where("code_id", $validate["code_id"])->first();
        if (!$phone) {
            return response()->json("Код не найден", 400, [], JSON_UNESCAPED_UNICODE);
        }
        if ($phone->code !== $validate['code']) {
            return response()->json('Неверный код', 400, [], JSON_UNESCAPED_UNICODE);
        }
        if (User::where("phone", $phone->phone)->first()) {
            return response()->json("Такой пользователь уже зарегистрирован", 400, [], JSON_UNESCAPED_UNICODE);
        }
        $user = User::create([
            "name" => $name,
            "email" =>  $email,
            "password" => $validate["password"],
            "phone" => $phone->phone,
        ]);
        $token = JWTAuth::fromUser($user);
        return response()->json($token);
    }
    /**
     *  @OA\Post(
     *    path="/api/auth/checkCode",
     *    summary = "Проверка кода",
     *    tags={"Auth"},
     *      @OA\RequestBody(
     *        @OA\JsonContent(
     *         allOf={
     *           @OA\Schema(
     *             @OA\Property( property="code_id", type="string", example="20cccf8f-db3d-4c52-95cb-3c11c490c05e"),
     *             @OA\Property( property="code", type="string", example="9999"),
     *           )
     *         }
     *        )
     *      ),
     *     @OA\Response(
     *       response=200,
     *       description="successful operation",
     *     )
     *   )
     *
     */
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
        if (Phones::where('code_id', $validate["code_id"])->first()->updated_at < now()->subMinutes(15)) {
            Phones::where('code_id', $validate["code_id"])->delete();
            return response()->json('Срок действия кода истек', 400, [], JSON_UNESCAPED_UNICODE);
        }
        if (Phones::where('code_id', $validate["code_id"])->first()->code !== $validate['code']) {
            return response()->json('Неверный код', 400, [], JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json(true);
        }
    }
    /**
     * @OA\Get(
     *   path="/api/user",
     *   summary = "Получение информации о пользователе",
     *   tags={"User"},
     *   security={{"bearerAuth":{}}},
     *   @OA\Response(
     *     response=200,
     *     description="successful operation",
     * ),
     *
     * )
     */
    public function userInfo()
    {
        dd(Auth::user());
        $user = Auth::user();
        if ($user) {
            return response()->json(['user' => $user]);
        } else {
            return response()->json('Unauthorized', 401);
        }
    }

    /**
     *  @OA\Post(
     *    path="/api/auth/login",
     *    summary = "Авторизация",
     *    tags={"Auth"},
     *      @OA\RequestBody(
     *        @OA\JsonContent(
     *         allOf={
     *           @OA\Schema(
     *             @OA\Property( property="phone", type="string", example="7999999999"),
     *             @OA\Property( property="password", type="string", example="12345678"),
     *           )
     *         }
     *        )
     *      ),
     *      @OA\Response(
     *       response=200,
     *       description="successful operation",
     *      )
     *  )
     */

    public function login(Request $request)
    {
        try {
            $request->validate([
                'phone' => 'required|string|max:10|min:10',
                'password' => 'required|string',
            ]);
        } catch (Throwable $error) {
            return response()->json($error->getMessage(), 400, [], JSON_UNESCAPED_UNICODE);
        }
        if (!Auth::attempt(['phone' => $request->phone, 'password' => $request->password])) {
            return response()->json('Неверный  телефон или пароль', 400, [], JSON_UNESCAPED_UNICODE);
        }
        $user = Auth::user();
        $token = JWTAuth::fromUser($user);
        return response()->json($token);
    }

    /**
     *  @OA\Post(
     *    path="/api/auth/resetPassword",
     *    summary = "Сброс пароля",
     *    tags={"Auth"},
     *      @OA\RequestBody(
     *        @OA\JsonContent(
     *         allOf={
     *           @OA\Schema(
     *             @OA\Property( property="code_id", type="string", example="20cccf8f-db3d-4c52-95cb-3c11c490c05e"),
     *             @OA\Property( property="code", type="string", example="9999"),
     *             @OA\Property( property="password", type="string", example="12345678"),
     *           )
     *         }
     *        )
     *      ),
     *      @OA\Response(
     *       response=200,
     *       description="successful operation",
     *      )
     *  )
     */
    public function resetPassword(Request $request)
    {
        try {
            $request->validate([
                'code_id' => 'required|string',
                'code' => 'required|string|max:4|min:4',
                'password' => 'required|string|min:8|max:16',
            ]);
        } catch (Throwable $error) {
            return response()->json($error->getMessage(), 400, [], JSON_UNESCAPED_UNICODE);
        }
        if (!Phones::where('code_id', $request->code_id)->first()) {
            return response()->json("Код не найден", 400, [], JSON_UNESCAPED_UNICODE);
        }
        if (Phones::where('code_id', $request->code_id)->first()->updated_at < now()->subMinutes(15)) {
            Phones::where('code_id', $request->code_id)->delete();
            return response()->json('Срок действия кода истек', 400, [], JSON_UNESCAPED_UNICODE);
        }
        if (Phones::where('code_id', $request->code_id)->first()->code !== $request->code) {
            return response()->json('Неверный код', 400, [], JSON_UNESCAPED_UNICODE);
        }
        if (!User::where("phone", Phones::where('code_id', $request->code_id)->first()->phone)) {
            return response()->json("Пользователь не найден", 400, [], JSON_UNESCAPED_UNICODE);
        } else {
            $user = User::where('phone', Phones::where('code_id', $request->code_id)->first()->phone)->first();
            $user->password = bcrypt($request->password);
            $user->save();
            Phones::where('code_id', $request->code_id)->delete();
            return response()->json("Пароь успешно изменен", 200, [], JSON_UNESCAPED_UNICODE);
        }
    }
    public function hello()
    {
        return response()->json("Hello", 200, [], JSON_UNESCAPED_UNICODE);
    }
}
