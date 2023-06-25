<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Medicine;
use App\Repositories\Pharmacy\MedicineRepositories\MedicineRepositoryInterface;
use App\Repositories\User\PrescriptionRepositories\PrescriptionRepositoryInterface;
use Illuminate\Http\Request;

class MedicineController extends BaseController
{
    private MedicineRepositoryInterface $medicineRepository;

    public function __construct(MedicineRepositoryInterface $medicineRepository,
                                PrescriptionRepositoryInterface $prescriptionRepository
    ){
        $this->medicineRepository = $medicineRepository;
        $this->prescriptionRepository = $prescriptionRepository;
    }

    public function searchMedicine(Request $request, $pharmacy_id){
        $search = $request->search;
        $medicine_name = $this->medicineRepository->searchMedicine($search, $pharmacy_id, "1");
        if ($medicine_name)
            return $this->sendResponse($medicine_name["data"], $medicine_name["where"]);
        else
            return $this->sendError("hata", "cannot find medicine or alternative");
    }

//    public function searchNonMedicine(){
//
//    }

    public function prescriptionDetail($pharmacy_id ,$name){
        $login_user = $this->loginUser("user-api");
        $find = $this->prescriptionRepository->detail($name, $login_user->id);
        if($find){
            $same_same = 0;
            $same_diff = 0;
            $diff_same = 0;
            $diff_diff = 0;
            $total = 0;
            $sgk_total = 0;
            $find["medicines"] = json_decode($find["medicines"]);
            $i=0;
            foreach ($find["medicines"] as $medicine){
                $control[$i] = $this->medicineRepository->searchMedicine($medicine->name, $pharmacy_id, $medicine->prescription);
                if ($control[$i]){
                    if ($control[$i]["where"] == "1.1"){
                        $same_same = $same_same +1;
                        $arr["same_same"][] = $control[$i]["data"];
                    }
                    if ($control[$i]["where"] == "1.2"){
                        $same_diff = $same_diff +1;
                        $control[$i]["data"][] = ["original_name" => $medicine->name];
                        $arr["same_diff"][] = $control[$i]["data"];
                    }
                    if ($control[$i]["where"] == "2.1"){
                        $diff_same = $diff_same +1;
                        $arr["diff_same"][] = $control[$i]["data"];
                    }
                    if ($control[$i]["where"] == "2.2"){
                        $diff_diff = $diff_diff +1;
                        $control[$i]["data"][] = ["original_name" => $medicine->name];
                        $arr["diff_diff"][] = $control[$i]["data"];
                    }
                    $i = $i+1;
                } else {
                    $error[$i] = $medicine;
                }
            }
            if ($same_same>0 && $i == $same_same){
                foreach ($arr["same_same"] as $medicine){
                    $total = $total+$medicine["fee"];
                    $sgk_total = $sgk_total + $medicine["SGK_fee"];
                }
                return $this->sendResponse(["medicine_list" => $arr["same_same"], "total" => $total, "sgk_total" => $sgk_total], "success");
            } else {
                $big_Arr = array();
                if ($same_same>0)
                    $big_Arr["ok"] = $arr["same_same"];
                if ($same_diff>0)
                    $big_Arr["medicine_alternative"] = $arr["same_diff"];
                if ($diff_same>0)
                    $big_Arr["pharmacy_alternative"] = $arr["diff_same"];
                if ($diff_diff>0)
                    $big_Arr["full_alternative"] = $arr["diff_diff"];
                return $this->sendResponse($big_Arr, "control");
            }
        } else
            return $this->sendError("hata", "expired");
    }
}
