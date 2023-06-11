<?php

namespace App\Repositories\Pharmacy\MedicineRepositories;

use App\Models\Medicine;
use App\Models\PharmacyList;
use App\Repositories\EloquentBaseRepository;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class MedicineRepository.
 */
class MedicineRepository extends EloquentBaseRepository implements MedicineRepositoryInterface
{

    protected $model;

    public function __construct(Medicine $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    public function addMedicine($pharmacy, $medicine)
    {
        $medicine["pharmacy_id"] = $pharmacy->id;
        $create = $this->model->create($medicine);
        if ($create)
            return $create;
        return false;
    }

    public function searchMedicine($search, $pharmacy_id, $prescription = "1"){
        $name = Medicine::query()
            ->where("pharmacy_id", $pharmacy_id)
            ->where("prescription", $prescription)
            ->where("medicine_name", "LIKE", "%$search%")
            ->where("stock", "!=", 0);

        if ($name->count())
            return ["data" => $name->where("stock", "!=", 0)->first(), "where" => "1.1"];
        else {
            $name = Medicine::query()
                ->where("pharmacy_id", $pharmacy_id)
                ->where("prescription", $prescription)
                ->where("medicine_name", "LIKE", "%$search%");
            $find = $name->where("stock", "=",0)->first();
            if ($find) {
                $alternative = Medicine::query()
                    ->where("pharmacy_id", $pharmacy_id)
                    ->where("prescription", $prescription)
                    ->where("medicine_sub_category_id", $find["medicine_sub_category_id"])
                    ->where("stock", "!=", 0)
                    ->get();
                return ["data" => $alternative, "where" => "1.2"];
            } else {
                $pharmacy_detail = PharmacyList::whereId($pharmacy_id)->first();
                $other_pharmacy = PharmacyList::where("id", "!=", $pharmacy_id)->where("address", $pharmacy_detail["address"])->where("status", "open")->first();
                $pharmacy_alternative = Medicine::query()
                    ->where("pharmacy_id", $other_pharmacy["id"])
                    ->where("prescription", $prescription)
                    ->where("medicine_name", "LIKE", "%$search%");
                if ($pharmacy_alternative->where("stock", "!=", 0)->count())
                    return ["data" => $pharmacy_alternative->where("stock", "!=", 0)->first(), "where" => "2.1"];
                else {
                    $pharmacy_alternative = Medicine::query()
                        ->where("pharmacy_id", $other_pharmacy["id"])
                        ->where("prescription", $prescription)
                        ->where("medicine_name", "LIKE", "%$search%");
                    $find = $pharmacy_alternative->where("stock", "=", 0)->first();
                    if ($find) {
                        $alternative = Medicine::query()
                            ->where("pharmacy_id", $other_pharmacy["id"])
                            ->where("prescription", $prescription)
                            ->where("medicine_sub_category_id", $find["medicine_sub_category_id"])
                            ->where("stock", "!=", 0)
                            ->get();
                        return ["data" => $alternative, "where" => "2.2"];
                    } else
                        return false;
                }
            }
        }
    }

//    public function findControl($data, $status){
//        switch ($status){
//            case "1.1":
//                return $data;
//            case "1.2":
//                return
//            case "2.1":
//            case "2.2":
//        }
//    }
}

