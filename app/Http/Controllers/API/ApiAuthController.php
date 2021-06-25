<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiAuthController extends Controller
{
    public function register(Request $request){

        $validator = Validator::make($request->all(), User::roles());
        if(!$validator->fails()){
            $user = User::create($request->all());
            if($user){
                return $this->generateToken($user, 'REGISTERED_SUCCESSFULLY');
            }else{
                //
                return response()->json(['status'=>false, 'message'=>'Faled to register']);
            }
        }else{
            return response()->json(['status' => false, 'message' => $validator->getMessageBag()->first()]);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), User::roleslogin());
        if(!$validator->fails()){
            $user = User::where('email', $request->get('email'))->first();

            if(Hash::check($request->get('password'), $user->password)){

                // $this->revokePreviousToken($user->id);
                // dd(123);
                // return $this->generateToken($user, 'LOGGED_IN_SUCCESSFULLY');

                if($this->checkActiveToken($user->id)){
                    return response()->json([
                        'status' => false,
                        'message' => 'Login denied, thire is an active access!'

                    ]);
                }else{
                return $this->generateToken($user, 'LOGGED_IN_SUCCESSFULLY');
                }

            }else{
                return response()->json(['status' => false, 'message' => 'Error credentials']);
            }

        }else{
            return response()->json(['status' => false, 'message' => $validator->getMessageBag()->first()]);
        }
    }

    public function logout(Request $request){
        $request->user('user')->token()->revoke();
        return response()->json([
            'status' => true,
            'message' => 'Logged out successfully',
        ]);

    }

    private function revokePreviousToken($userId){
        DB::table('oauth_access_tokens')
        ->where('user_id',$userId)
        ->update([
            'revoked' => true
        ]);
    }

    private function checkActiveToken($userId){
       return DB::table('oauth_access_tokens')
        ->where('user_id',$userId)
        ->where('revoked',false)
        ->count() >= 1 ;
    }

    public function generateToken($user, $message){
        $tokenResult = $user->createToken('Doccure-User');
        $token = $tokenResult->accessToken;
        $user->setAttribute('token', $token);
        return response()->json([
            'status' => true,
            'message' => '',
            'object' => $user,

        ]);
    }

}
