<?php


namespace App\Http\Controllers\API;


use App\Models\PharmacyList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Facades\DB;


class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];


        return response()->json($response, 200);
    }

    public function sendNegativeResponse($message)
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];


        return response()->json($response, 200);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];


        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }


        return response()->json($response, $code);
    }

    public function loginUser($api_type){
        $user = auth()->guard($api_type)->user();
        return $user;
    }

    public function pharmacyInfo($pharmacy_id){
        $pharmacy = PharmacyList::whereId($pharmacy_id)->first();
        return $pharmacy;
    }
}
