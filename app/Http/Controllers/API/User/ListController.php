<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Pharmacy;
use App\Repositories\User\ListRepositories\ListRepositoryInterface;
use Illuminate\Http\Request;

class ListController extends BaseController
{
    private ListRepositoryInterface $listRepository;

    public function __construct(ListRepositoryInterface $listRepository
    ){
        $this->listRepository = $listRepository;
    }
    public function pharmacyList($address){
        $pharmacies = $this->listRepository->pharmacyList($address);
        if($pharmacies) {
            return $this->sendResponse($pharmacies,"Pharmacy List");
        }

        return $this->sendNegativeResponse('Pharmacy not found');
    }

    public function prescriptionList(){
        //try {
            $login_user = $this->loginUser("user-api");
            $prescriptions = $this->listRepository->prescriptionList($login_user->id);
            if(count($prescriptions)) {
                return $this->sendResponse($prescriptions,'Prescription List');
            }
            return $this->sendNegativeResponse('No prescriptions');
        //} catch (\Throwable $exception) {
        //    return $this->sendError($exception);
        //}


    }

    public function categoryList($pharmacy_id){
        $category_list = $this->listRepository->nonMedicineCategory($pharmacy_id);
        return $this->sendResponse($category_list, "success");
    }

    public function subCategoryList($category_id){
        $sub_category_list = $this->listRepository->nonMedicineSubCategory($category_id);
        return $this->sendResponse($sub_category_list, "success");
    }

    public function cityList(){
         $list = ["İstanbul"];
         return $this->sendResponse($list, "success");
    }

    public function districtList(){
        $district = [
            "Adalar", "Arnavutköy", "Ataşehir", "Avcılar", "Bağcılar", "Bahçelievler", "Bakırköy", "Başakşehir", "Bayrampaşa", "Beşiktaş", "Beykoz", "Beylikdüzü", "Beyoğlu", "Büyükçekmece", "Çatalca", "Çekmeköy", "Esenler", "Esenyurt", "Eyüp", "Fatih", "Gaziosmanpaşa", "Güngören", "Kadıköy", "Kağıthane", "Kartal", "Küçükçekmece", "Maltepe", "Pendik", "Sancaktepe", "Sarıyer", "Şile", "Silivri", "Şişli", "Sultanbeyli", "Sultangazi", "Tuzla", "Ümraniye", "Üsküdar", "Zeytinburnu"
        ];
        return $this->sendResponse($district, "success");
    }

    public function addressList(){
        $address = [
            "ALTAYÇEŞME",
            "ALTINTEPE",
            "AYDINEVLER",
            "BAĞLARBAŞI",
            "BAŞIBÜYÜK",
            "BÜYÜKBAKKALKÖY",
            "CEVİZLİ",
            "ÇINAR",
            "ESENKENT",
            "FEYZULLAH",
            "FINDIKLI",
            "GİRNE",
            "GÜLENSU",
            "GÜLSUYU",
            "İDEALTEPE",
            "KÜÇÜKYALI MERKEZ",
            "YALI",
            "ZÜMRÜTEVLER",
        ];
        return $this->sendResponse($address, "success");
    }

    public function nonMedicineList($sub_category, $pharmacy_id){
        $login_user = $this->loginUser("pharmacy-api");
        $list = $this->listRepository->nonMedicine($sub_category, $pharmacy_id);
        if (count($list)){
            foreach ($list as $non_medicine){
                $non_medicine["data"] = env("APP_URL") . "/files/pharmacy/".$pharmacy_id."/non_medical_image/". $non_medicine["data"];
                unset($non_medicine["name"]);
                unset($non_medicine["type"]);
            }
            return $this->sendResponse($list, "success");

        }
    }
}
