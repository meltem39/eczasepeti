<?php

namespace App\Repositories\Pharmacy\MedicineRepositories;

interface MedicineRepositoryInterface {

    public function addMedicine($pharmacy, array $medicine_detail);

    public function searchMedicine($search, $pharmacy_id, $prescription);


}
