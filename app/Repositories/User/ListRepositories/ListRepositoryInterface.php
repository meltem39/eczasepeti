<?php
namespace App\Repositories\User\ListRepositories;

interface ListRepositoryInterface{

    public function pharmacyList($address);

    public function prescriptionList($id);

    //****************************************
    public function medicineCategory($id);

    public function medicineSubCategory($category_id);

    public function medicine($sub_medical_id, $id);

    //****************************************
    public function nonMedicineCategory($id);

    public function nonMedicineSubCategory($category_id);

    public function nonMedicine($sub_medical_id, $id);

    public function getNonMedicines($id);

}
