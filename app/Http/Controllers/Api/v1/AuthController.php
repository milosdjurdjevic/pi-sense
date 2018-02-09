<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;

class AuthController extends Controller
{

    use Helpers;

    protected $user;

    public function __construct(User $user)
    {
        $this->middleware('auth:api', ['except' => ['authenticate']]);
        $this->user = $user;
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->errorBadRequest($validator->messages());
        }
        // grab credentials from the request
        $credentials = $request->only('email', 'password');
//                       print_r($credentials); die;
//        // attempt to verify the credentials and create a token for the user
//        if (!$token = JWTAuth::attempt($credentials)) {
//            $this->response->errorForbidden(trans('auth.incorrect'));
//        }

        $user = User::where('email', $credentials['email'])->get();

//        return $user;

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = Auth::attempt($credentials)) {
                return $this->response()->errorNotFound('invalid_credentials');
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return $this->response()->errorInternal('could_not_create_token');
        }

        // all good so return the token
        return $this->response->array(compact('token'));
//        return response()->json(compact('token'));
    }
}
