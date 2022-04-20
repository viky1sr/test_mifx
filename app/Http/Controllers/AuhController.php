<?php

namespace App\Http\Controllers;

use App\Services\UserServices;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use JWTAuth;

class AuhController extends Controller
{
    private $userService;

    public function __construct(
        UserServices $userService
    ){
        $this->userService = $userService;
    }

    public function logout( Request $request ) {
        $token = $request->header( 'Authorization' );
        try {
            JWTAuth::parseToken()->invalidate( $token );

            return response()->json( [
                'status'   => false,
                'message' => trans( 'auth.logged_out' )
            ] );
        } catch ( TokenExpiredException $exception ) {
            return response()->json( [
                'error'   => true,
                'message' => trans( 'auth.token.expired' )

            ], 401 );
        } catch ( TokenInvalidException $exception ) {
            return response()->json( [
                'error'   => true,
                'message' => trans( 'auth.token.invalid' )
            ], 401 );

        } catch ( JWTException $exception ) {
            return response()->json( [
                'error'   => true,
                'message' => trans( 'auth.token.missing' )
            ], 500 );
        }
    }

    public function login(Request $request)
    {
        $credential = $request->only('email','password');
        try {
            if (!$access_token = JWTAuth::attempt($credential)) {
                return response()->json([
                    'status' => false,
                    'messages' => 'Password dan email tidak sama.',
                ],422);
            }
        } catch (JWTException $e) {
            return response()->json([
                'status' => 'false',
                'messages' => 'could_not_create_token'
            ], 500);
        }

        if($access_token) {
            $user = \Auth::user();
            $exp = JWTAuth::setToken($access_token)->getPayload()->get('exp');
        }

        return response()->json(compact('access_token','exp','user'),200);
    }

    public function register(Request $request){
        $validated = userValidation($request->all());
        if($validated->fails()){
            return response()->json([
                'status' => false,
                'messages' => $validated->errors()->first()
            ],422);
        } else {
            if($user = $this->userService->create($request->except('_token','submit'))) {
                $token = JWTAuth::fromUser($user);
                return response()->json(compact('user','token'),201);
            }
        }
    }

    public function update(Request $request, $id) {
        $validated = userValidation($request->all());
        if(\Auth::user()->is_admin){
            if($validated->fails()){
                return response()->json([
                    'status' => false,
                    'messages' => $validated->errors()->first()
                ],422);
            } else {
                if($this->userService->update($request->except('_token','submit'), $id )) {
                    $user = $this->userService->getById($id);
                    $token = JWTAuth::fromUser($user);
                    return response()->json(compact('user','token'),201);
                }
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Your not admin, u cant edit data.'
            ],422);
        }
    }
}
