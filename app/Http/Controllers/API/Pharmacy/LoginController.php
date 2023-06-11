<?php

namespace App\Http\Controllers\API\Pharmacy;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Pharmacy;
use App\Models\PharmacyList;
use Illuminate\Http\Request;
use Validator;


class LoginController extends BaseController
{

    public function addCarrier(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'surname' => 'required',
            'mobile' => 'required',
            'job' => 'required',
            'title' => 'required',
            'email' => 'required|email|unique:pharmacies',
            'password' => 'required',
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $login_user = $this->loginUser("pharmacy-api");
        $input = $request->all();
        $input["organization_name"] = $login_user->organization_name;
        $input['password'] = bcrypt($input['password']);
        $user = Pharmacy::create($input);
        $success['name_surname'] =  $user->name. " ". $user->surname;
        return $this->sendResponse($success, 'User register successfully.');

    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'surname' => 'required',
            'mobile' => 'required',
            'organization_name' => 'required',
            'job' => 'required',
            'title' => 'required',
            'city' => 'required',
            'district' => 'required',
            'address' => 'required',
            'email' => 'required|email|unique:pharmacies',
            'password' => 'required',
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $data = [
            "name" => $input["organization_name"],
            'city' => $input["city"],
            'district' => $input["district"],
            'address' => $input["address"],
        ];
        $list = PharmacyList::create($data);
        $input["organization_name"] = $list["id"];
        $user = Pharmacy::create($input);
        $success['token'] =  $user->createToken('MyApp', ['pharmacy'])-> accessToken;
        $success['name_surname'] =  $user->name. " ". $user->surname;

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



        if(auth()->guard('pharmacy')->attempt(['email' => request('email'), 'password' => request('password')])) {
            config(['auth.guards.api.provider' => 'pharmacy']);

            $user = Pharmacy::select('pharmacies.*')->find(auth()->guard('pharmacy')->user()->id);
            $success['token'] =  $user->createToken('MyApp', ['pharmacy'])-> accessToken;
            $success['name_surname'] =  $user->name. " ". $user->surname;
            $success['mobile'] = $user->mobile;
            return $this->sendResponse($success, 'Login successfully.');
        }
        else{
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
    }
}
