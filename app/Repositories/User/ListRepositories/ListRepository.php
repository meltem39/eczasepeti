<?php

namespace App\Repositories\User\ListRepositories;

use App\Models\Medicine;
use App\Models\MedicineCategory;
use App\Models\MedicineSubCategory;
use App\Models\NonMedicalCategory;
use App\Models\NonMedicalSubCategory;
use App\Models\NonMedicine;
use App\Models\Pharmacy;
use App\Models\PharmacyList;
use App\Models\Prescriptions;
use App\Repositories\EloquentBaseRepository;
use Carbon\Carbon;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class ListRepository.
 */
class ListRepository extends EloquentBaseRepository implements ListRepositoryInterface
{
    protected $pharmacyListModel;
    protected $prescriptionModel;
    protected $medicineModel;
    protected $medicineCategoryModel;
    protected $medicineSubCategoryModel;
    protected $nonMedicineModel;
    protected $nonMedicalCategoryModel;
    protected $nonMedicalSubCategoryModel;

    public function __construct(PharmacyList $pharmacyListModel,
                                Prescriptions $prescriptionModel,
                                Medicine $medicineModel,
                                MedicineCategory $medicineCategoryModel,
                                MedicineSubCategory $medicineSubCategoryModel,
                                NonMedicine $nonMedicineModel,
                                NonMedicalCategory $nonMedicalCategoryModel,
                                NonMedicalSubCategory $nonMedicalSubCategoryModel
    )
    {
        $this->pharmacyListModel = $pharmacyListModel;
        $this->prescriptionModel = $prescriptionModel;
        $this->medicineModel = $medicineModel;
        $this->medicineCategoryModel = $medicineCategoryModel;
        $this->medicineSubCategoryModel = $medicineSubCategoryModel;
        $this->nonMedicineModel = $nonMedicineModel;
        $this->nonMedicalCategoryModel = $nonMedicalCategoryModel;
        $this->nonMedicalSubCategoryModel = $nonMedicalSubCategoryModel;


        parent::__construct($this->pharmacyListModel);
    }

    public function pharmacyList($address)
    {
        $pharmacies = $this->pharmacyListModel::where('address', $address)->where('status','open')->get();
        if($pharmacies) {
            return $pharmacies;
        }
        return false;

    }

    public function prescriptionList($id)
    {
        $prescriptions = $this->prescriptionModel::where('user_id',$id)->where('status','0')->get();
        date_default_timezone_set('Etc/GMT-3');
        $prescArray = array();
        foreach ($prescriptions as $presc) {
            $compare_date = Carbon::parse($presc->expiry_date)->gt(Carbon::now());
            if ($compare_date) {
                $temp = json_decode($presc['medicines']);
                $medicines = array();
                foreach ((array)$temp as $key => $value)
                {
                    $medicines[] = $value;
                }
                $presc['medicines'] =  $medicines;
                $prescArray[] = $presc;
            }
        }
        return $prescArray;

    }

    public function medicineCategory($id){
        $list = $this->medicineCategoryModel::where("pharmacy_id", $id)->orWhere("pharmacy_id", NULL)->select("id", "pharmacy_id", "category_name")->get();
        return $list;
    }

    public function medicineSubCategory($category_id){
        $list = $this->medicineSubCategoryModel::where("category_id", $category_id)->select("id","sub_category_name")->get();
        return $list;
    }

    public function medicine($sub_medical_id, $id){
        $list = $this->medicineModel::where("medicine_sub_category_id", $sub_medical_id)->where("pharmacy_id", $id)->get()->makeHidden(["created_at", "updated_at"]);
        return $list;
    }

    public function nonMedicineCategory($id){
        $list = $this->nonMedicalCategoryModel::where("pharmacy_id", $id)->orWhere("pharmacy_id", NULL)->select("id", "pharmacy_id", "category_name")->get();
        return $list;
    }

    public function nonMedicineSubCategory($category_id){
        $list = $this->nonMedicalSubCategoryModel::where("category_id", $category_id)->select("id","sub_category_name")->get();
        return $list;

    }

    public function nonMedicine($sub_medical_id, $id){
        $list = $this->nonMedicineModel::where("non_medical_sub_category_id", $sub_medical_id)->where("pharmacy_id", $id)->get()->makeHidden(["created_at", "updated_at"]);
        return $list;
    }
}
