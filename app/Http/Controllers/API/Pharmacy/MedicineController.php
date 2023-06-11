<?php

namespace App\Http\Controllers\API\Pharmacy;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Repositories\Pharmacy\NonMedicineRepositories\NonMedicineRepositoryInterface;
use App\Repositories\User\ListRepositories\ListRepositoryInterface;
use Illuminate\Http\Request;
use Validator;
use App\Repositories\Pharmacy\MedicineCategoryRepositories\MedicineCategoryRepositoryInterface;
use App\Repositories\Pharmacy\MedicineRepositories\MedicineRepository;
use App\Repositories\Pharmacy\MedicineRepositories\MedicineRepositoryInterface;

class MedicineController extends BaseController
{
    private ListRepositoryInterface $listRepository;
    private MedicineRepositoryInterface $medicineRepository;
    private NonMedicineRepositoryInterface $nonMedicineRepository;

    public function __construct(NonMedicineRepositoryInterface $nonMedicineRepository,
                                MedicineRepositoryInterface $medicineRepository,
                                ListRepositoryInterface $listRepository
    ){
        $this->nonMedicineRepository = $nonMedicineRepository;
        $this->medicineRepository = $medicineRepository;
        $this->listRepository = $listRepository;
    }


    public function medicineAdd(Request $request){
        $validator = Validator::make($request->all(), [
            'medicine_category_id' => 'required',
            'medicine_name' => 'required',
            'prescription' => 'required',
            'medicine_form_id' => 'required',
            'fee' => 'required',
            'SGK_fee' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user = $this->loginUser("pharmacy-api");
        $pharmacy = $this->pharmacyInfo($user->organization_name);
        $medicine_detail = $request->all();
        $medicine_detail["pharmacology_name"] = isset($medicine_detail["pharmacology_name"]) ? $medicine_detail["pharmacology_name"] : $medicine_detail["medicine_name"];
        $add = $this->medicineRepository->addMedicine($pharmacy, $medicine_detail);
        if ($add)
            return $this->sendResponse($add, "medicine added");
        return $this->sendError('Error.', ['error'=>'unexpected error']);
    }

    public function medicineCategoryList(){
        $login_user = $this->loginUser("pharmacy-api");
        $list = $this->listRepository->medicineCategory($login_user->organization_name);
        return $this->sendResponse($list, "success");
    }

    public function medicineSubCategoryList($category_id){
        $list = $this->listRepository->medicineSubCategory($category_id);
        if (count($list))
            return $this->sendResponse($list, "success");
        return $this->sendNegativeResponse("not defined");
    }

    public function medicineList($sub_category_id){
        $login_user = $this->loginUser("pharmacy-api");
        $list = $this->listRepository->medicine($sub_category_id, $login_user->organization_name);
        if (count($list))
            return $this->sendResponse($list, "success");
    }

    public function nonMedicalCategoryList(){
        $login_user = $this->loginUser("pharmacy-api");
        $list = $this->listRepository->nonMedicineCategory($login_user->organization_name);
        return $this->sendResponse($list, "success");
    }

    public function nonMedicalSubCategoryList($category_id){
        $list = $this->listRepository->nonMedicineSubCategory($category_id);
        if (count($list))
            return $this->sendResponse($list, "success");
        return $this->sendNegativeResponse("not defined");
    }

    public function nonMedicalList($sub_medical_id){
        $login_user = $this->loginUser("pharmacy-api");
        $list = $this->listRepository->nonMedicine($sub_medical_id, $login_user->organization_name);
        if (count($list)){
            foreach ($list as $non_medicine){
                $non_medicine["data"] = env("APP_URL") . "/files/pharmacy/".$login_user->organization_name."/non_medical_image/". $non_medicine["data"];
                unset($non_medicine["name"]);
                unset($non_medicine["type"]);
            }
            return $this->sendResponse($list, "success");

        }
    }

    public function nonMedicalAdd(Request $request){
        $validator = Validator::make($request->all(), [
            'non_medical_category_id' => 'required',
            'non_medical_sub_category_id' => 'required',
            'medicine_name' => 'required',
            'fee' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user = $this->loginUser("pharmacy-api");
        $medicine_detail = $request->all();
        $add = $this->nonMedicineRepository->add($user->organization_name, $medicine_detail);
        $add["data"] = env("APP_URL") . "/files/pharmacy/".$user->organization_name."/non_medical_image/". $add["data"];
        unset($add["type"]);
        unset($add["name"]);
        if ($add)
            return $this->sendResponse($add, "medicine added");
        return $this->sendError('Error.', ['error'=>'unexpected error']);
    }


}
