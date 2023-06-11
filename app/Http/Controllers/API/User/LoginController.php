<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Medicine;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;


class LoginController extends BaseController
{



    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required|email|unique:users',
            'mobile' => 'required',
            'TC_no' => 'required',
            'password' => 'required',

        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
//        $success['token'] =  $user->createToken('MyApp', ['user'])-> accessToken;
        $success['name_surname'] =  $user->name. " ". $user->surname;
        $success['mobile'] =  $user->mobile;
        $success['TC_no'] =  $user->TC_no;

        return $this->sendResponse($success, 'User register successfully.');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        if(auth()->guard('user')->attempt(['email' => request('email'), 'password' => request('password')])) {
            config(['auth.guards.api.provider' => 'user']);

            $user = User::select('users.*')->find(auth()->guard('user')->user()->id);
            $success['token'] =  $user->createToken('MyApp',['user'])->accessToken;
            $success['name_surname'] =  $user->name. " ". $user->surname;
            $success['mobile'] = $user->mobile;
            return $this->sendResponse($success, 'Login successfully.');
        }
        else{
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
    }
}
