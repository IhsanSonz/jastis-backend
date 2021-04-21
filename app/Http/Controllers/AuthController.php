<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use JWTAuth;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Validator;

class AuthController extends Controller
{
    public $token = true;

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required',
            ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->registration_id = null;
        $user->save();

        if ($this->token) {
            return $this->login($request);
        }

        return response()->json([
            'success' => true,
            'message' => 'Register Successfully',
            'data' => $user,
        ], Response::HTTP_OK);
    }

    public function login(Request $request)
    {
        $input = $request->only('email', 'password');
        $token = null;
        $user = User::where('email', '=', $request->email)->with('user_kelas')->with('kelas')->first();

        if (!$token = JWTAuth::attempt($input)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Email or Password',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json([
            'success' => true,
            'message' => 'Login Successfully',
            'token' => $token,
            'data' => $user,
        ]);
    }

    public function loginGoogle(Request $request)
    {
        $user = Socialite::driver('google')->userFromToken($request->token);
        $token = null;
        $findUser = User::where('google_id', $user->id)->first();

        if ($findUser) {
            if (!$token = JWTAuth::fromUser($findUser)) {
                return response()->json([
                    'success' => true,
                    'message' => 'invalid Credential',
                    'data' => null,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Login Successfully',
                'token' => $token,
                'data' => $findUser,
            ]);
        }

        $newUser = new User;
        $newUser->name = $user->name;
        $newUser->email = $user->email;
        $newUser->password = null;
        $newUser->avatar = $user->avatar;
        $newUser->google_id = $user->id;
        $newUser->registration_id = null;
        $newUser->save();

        $token = JWTAuth::fromUser($newUser);

        return response()->json([
            'success' => true,
            'message' => 'Login Successfully',
            'token' => $token,
            'data' => $newUser,
        ]);
    }

    public function logout(Request $request)
    {
        $this->validate($request, [
            'token' => 'required',
        ]);

        try {
            JWTAuth::invalidate($request->token);

            return response()->json([
                'success' => true,
                'message' => 'User logged out successfully',
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, the user cannot be logged out',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getUser()
    {
        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException$exception) {

            return response()->json(['token_expired'], $exception->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException$exception) {

            return response()->json(['token_invalid'], $exception->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException$exception) {

            return response()->json(['token_absent'], $exception->getStatusCode());
        }

        return response()->json([
            'success' => true,
            'message' => 'get data success',
            'token' => $token,
            'data' => $user,
        ]);
    }
}
