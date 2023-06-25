<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Pharmacy;
use App\Models\PharmacyList;
use Illuminate\Http\Request;

class ManagementController extends BaseController
{
    public function pharmacyList(){
        $pharmacy_list = PharmacyList::get();
        foreach ($pharmacy_list as $pharmacy){
            $pharmacy["user"] = Pharmacy::where("organization_name", $pharmacy["id"])->get()->makeHidden("password");
        }
        return $this->sendResponse($pharmacy_list, "success");
    }

    public function pharmacyAccept($user_id){
        $update = Pharmacy::whereId($user_id)->first()->update(["status" => "accept"]);
        return $this->sendResponse($update, "success");
    }
    public function pharmacyDelete($user_id){
        $update = Pharmacy::whereId($user_id)->first()->update(["status" => "delete"]);
        return $this->sendResponse($update, "success");
    }
}
