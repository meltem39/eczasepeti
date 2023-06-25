<?php

namespace App\Repositories\User\ShoppingRepositories;

use App\Models\Medicine;
use App\Models\MedicineCategory;
use App\Models\MedicineForm;
use App\Models\MedicineSubCategory;
use App\Models\NonMedicalCategory;
use App\Models\NonMedicalSubCategory;
use App\Models\NonMedicine;
use App\Models\Order;
use App\Models\Pharmacy;
use App\Models\PharmacyList;
use App\Models\Prescriptions;
use App\Models\Shopping;
use App\Models\User;
use App\Repositories\EloquentBaseRepository;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class ShoppingRepository.
 */
class ShoppingRepository extends EloquentBaseRepository implements ShoppingRepositoryInterface
{
    /**
     * @return string
     *  Return the model
     */
    protected $model;
    protected $orderModel;
    protected $user;
    protected $courrier;

    public function __construct(Shopping $model, Order $orderModel, User $user, Pharmacy $courrier)
    {
        $this->model = $model;
        $this->orderModel = $orderModel;
        $this->user = $user;
        $this->pharmacy = $courrier;

        parent::__construct($this->model);
    }

    public function detail($basket, $medicines, $total = 0, $SGK_total = 0,$isUser){
        $detail  = array();
        switch ($basket->is_medicine){
            case "0":
                foreach ($medicines as $content){
                    $non_medicine = NonMedicine::whereId($content)->first()->makeHidden("created_at", "updated_at", "type", "name", "prescription");
                    $non_medicine["data"] = env("APP_URL") . "/files/pharmacy/".$basket->pharmacy_id."/non_medical_image/". $non_medicine["data"];
                    $non_medicine["pharmacy_id"] = PharmacyList::whereId($non_medicine["pharmacy_id"])->select("id","name")->first();
                    $non_medicine["non_medical_category_id"] = NonMedicalCategory::whereId($non_medicine["non_medical_category_id"])->select("id", "category_name")->first();
                    $non_medicine["non_medical_sub_category_id"] = NonMedicalSubCategory::whereId($non_medicine["non_medical_sub_category_id"])->select("id", "sub_category_name")->first();

                    array_push($detail, $non_medicine);
                    $total = $total + $non_medicine["fee"];
                }
                if($isUser) {
                    $detail["basket_id"] = $basket->id;
                    $detail["total_fee"] = $total;
                }

                return $detail;
            case "1":
                foreach ($medicines as $content){
                    $medicine = Medicine::whereId($content)->first()->makeHidden("created_at", "updated_at", "prescription");

                    $medicine["pharmacy_id"] = PharmacyList::whereId($medicine["pharmacy_id"])->select("id","name")->first();
                    $medicine["medicine_category_id"] = MedicineCategory::whereId($medicine["medicine_category_id"])->select("id", "category_name")->first();
                    $medicine["medicine_sub_category_id"] = MedicineSubCategory::whereId($medicine["medicine_sub_category_id"])->select("id", "sub_category_name")->first();
                    $medicine["medicine_form_id"] = MedicineForm::whereId($medicine["medicine_form_id"])->select("id", "form_name")->first();
                    array_push($detail, $medicine);
                    $total = $total + $medicine["fee"];
                    $SGK_total = $SGK_total + $medicine["SGK_fee"];
                }
                if($isUser) {
                    $detail["basket_id"] = $basket->id;
                    $detail["total_fee"] = $total;
                    $detail["total_SGK_fee"] = $SGK_total;
                }

                return $detail;
        }
    }

    public function stock_update($basket, $operator){
        $content = json_decode($basket->content);
        $medicines = array();
        foreach ((array)$content as $value) {
            $medicines[] = $value;
        }
        switch ($basket->is_medicine){
            case "0":
                foreach ($medicines as $medicine){
                    $non_medicine_stock = NonMedicine::whereId($medicine)->first();
                    $val = $operator == "+" ? $non_medicine_stock->stock+1 : $non_medicine_stock->stock-1;
                    $stock_update = $non_medicine_stock->update(["stock" => $val]);
                }
            case "1":
                foreach ($medicines as $medicine){
                    $medicine_stock = Medicine::whereId($medicine)->first();
                    $value = $operator == "+" ? $medicine_stock->stock+1 : $medicine_stock->stock-1;
                    $stock_update = $medicine_stock->update(["stock" => $value]);
                }
        }
        return $stock_update;
    }

    public function basketDetail($user_id){
        $basket = $this->model->where("user_id", $user_id)->where("status", "adding")->first();
        if ($basket){
            $content = json_decode($basket->content);
            $medicines = array();
            foreach ((array)$content as $value) {
                $medicines[] = $value;
            }
            $detail = $this->detail($basket, $medicines,0,0,true);
            return $detail;
        }
        return false;
    }

    public function addBasket($user_id, $data){
        $total = 0;
        $SGK_total = 0;
        switch ($data["is_medicine"]){
            case "0":
                if($data["non_medicine_content"]){
                    foreach ($data["non_medicine_content"] as $non_medicine){
                        $fee = NonMedicine::whereId($non_medicine)->select("fee")->first()->fee;
                        $total = $total+$fee;
                    }
                }
                if($data["medicine_content"]){
                    foreach ($data["medicine_content"] as $non_medicine){
                        $fee = Medicine::whereId($non_medicine)->select("fee")->first()->fee;
                        $total = $total+$fee;
                    }
                }
                $data["total"] = $total;
                $data["user_id"] = $user_id;
                $data["status"] = "adding";
                $data["content"] = json_encode($data["content"]);
                $control = $this->model->where("user_id", $user_id)->where("status", "adding")->first();
                if ($control)
                    $this->model->whereId($control->id)->update(["status" => "cancelled"]);
                $create = $this->model->create($data);
                return $create;
            case "1":
                $content = array();
                $prescription = Prescriptions::whereId($data["prescription_id"])->select("medicines")->first()->medicines;
                $prescription = json_decode($prescription);
                $medicines = array();
                foreach ((array)$prescription as $value) {
                    $medicines[] = $value;
                }
                $i = 1;
                foreach ($medicines as $medicine){
                    $detail = Medicine::query()
                        ->where("pharmacy_id", $data["pharmacy_id"])
                        ->where("medicine_name", $medicine->name)
                        ->where("stock", "!=", 0)->select("id","SGK_fee", "fee")->first();
                    $total = $total + $detail["fee"];
                    $SGK_total = $SGK_total + $detail["SGK_fee"];
                    $content[$i] = $detail["id"];
                    $i++;
                }
                $data["total"] = $total;
                $data["SGK_total"] = $SGK_total;
                $data["user_id"] = $user_id;
                $data["status"] = "adding";
                $data["content"] = json_encode($content);
                $control = $this->model->where("user_id", $user_id)->where("status", "adding")->first();
                if ($control)
                    $this->model->whereId($control->id)->update(["status" => "cancelled"]);
                $create = $this->model->create($data);
                return $create;
        }
    }

    //public function addBasket($user_id, $data){
    //    $total = 0;
    //    $SGK_total = 0;
    //    switch ($data["is_medicine"]){
    //        case "0":
    //            if($data["content"]){
    //                foreach ($data["content"] as $non_medicine){
    //                    $fee = NonMedicine::whereId($non_medicine)->select("fee")->first()->fee;
    //                    $total = $total+$fee;
    //                }
    //            }
    //            $data["total"] = $total;
    //            $data["user_id"] = $user_id;
    //            $data["status"] = "adding";
    //            $data["content"] = json_encode($data["content"]);
    //            $control = $this->model->where("user_id", $user_id)->where("status", "adding")->first();
    //            if ($control)
    //                $this->model->whereId($control->id)->update(["status" => "cancelled"]);
    //            $create = $this->model->create($data);
    //            return $create;
    //        case "1":
    //            $content = array();
    //            $prescription = Prescriptions::whereId($data["prescription_id"])->select("medicines")->first()->medicines;
    //            $prescription = json_decode($prescription);
    //            $medicines = array();
    //            foreach ((array)$prescription as $value) {
    //                $medicines[] = $value;
    //            }
    //            $i = 1;
    //            foreach ($medicines as $medicine){
    //                $detail = Medicine::query()
    //                    ->where("pharmacy_id", $data["pharmacy_id"])
    //                    ->where("medicine_name", $medicine->name)
    //                    ->where("stock", "!=", 0)->select("id","SGK_fee", "fee")->first();
    //                $total = $total + $detail["fee"];
    //                $SGK_total = $SGK_total + $detail["SGK_fee"];
    //                $content[$i] = $detail["id"];
    //                $i++;
    //            }
    //            $data["total"] = $total;
    //            $data["SGK_total"] = $SGK_total;
    //            $data["user_id"] = $user_id;
    //            $data["status"] = "adding";
    //            $data["content"] = json_encode($content);
    //            $control = $this->model->where("user_id", $user_id)->where("status", "adding")->first();
    //            if ($control)
    //                $this->model->whereId($control->id)->update(["status" => "cancelled"]);
    //            $create = $this->model->create($data);
    //            return $create;
    //    }
    //}

    public function buyBasket($user_id, $data, $basket_id){
        $data["basket_id"] = $basket_id;
        $data["user_id"] = $user_id;
        $basket = Shopping::whereId($basket_id)->first();
        $data["pharmacy_id"] = $basket->pharmacy_id;
        $data["payment_status"] = $data["payment_type"] == "card" ? "1" : "0";
        $data["order_status"] = "taken";
        $data["total"] = $basket->total;
        $data["SGK_total"] = $basket->SGK_total;
        $order = $this->orderModel->create($data);
        if($order){
            $this->stock_update($basket,"-");
            $basket->update(["status" => "ordered"]);
            if ($basket->prescription_id)
                Prescriptions::whereId($basket->prescription_id)->first()->update(["status" => "1"]);
            return $order;
        }
        return false;
    }

    public function cancelOrder($cancel_by, $order_id, $data){
        $select_order = $this->orderModel->whereId($order_id)->first();
        if($select_order->order_status != "delivered"){
            $basket = $this->model->whereId($select_order->basket_id)->first();
            $this->stock_update($basket, "+");
            $update = $select_order->update(["order_status" => "canceled", "canceled_by" => $cancel_by, "canceled_cause" => $data["canceled_cause"]]);
            $shopping = $this->model->whereId($select_order->basket_id)->first();
            if ($shopping->prescription_id)
                Prescriptions::whereId($shopping->prescription_id)->update(["status" =>"0"]);
            $shopping->update(["status" => "cancelled"]);
            $carrier_id = $data["carrier_id"];
            $this->pharmacy->whereId($carrier_id)->first()->update(["status" => "wait"]);
            return $update;
        }
        return false;
    }

    public function orderDetail($order_id){
        $info = $this->orderModel->whereId($order_id)->first()->makeHidden("created_at", "updated_at");
        $basket = $this->model->whereId($info->basket_id)->select("is_medicine", "prescription_id", "content","id")->first();
        $content = json_decode($basket->content);
        $medicines = array();
        foreach ((array)$content as $value) {
            $medicines[] = $value;
        }
        $detail = $this->detail($basket, $medicines,0,0,false);
        $basketdetail = [];
        foreach ($detail as $value) {
            $basketdetail[] = $value;
        }
        $info["basket"] = $basketdetail;
        return $info;
    }

    public function listOrder($pharmacy_id){
        $taken_list = $this->orderModel->where("pharmacy_id", $pharmacy_id)->where("order_status", "taken")->get();
        $preparing_list = $this->orderModel->where("pharmacy_id", $pharmacy_id)->where("order_status", "preparing")->get();
        $on_the_way_list = $this->orderModel->where("pharmacy_id", $pharmacy_id)->where("order_status", "on_the_way")->get();
        $delivered_list = $this->orderModel->where("pharmacy_id", $pharmacy_id)->where("order_status", "delivered")->get();
        $canceled_list = $this->orderModel->where("pharmacy_id", $pharmacy_id)->where("order_status", "canceled")->get();
        foreach ($taken_list as $taken) {
            $attacheduser = $this->user->where("id",$taken->user_id)->get()->first();
            $taken["user"] = $attacheduser;
        }
        foreach ($preparing_list as $preparing) {
            $attacheduser = $this->user->where("id",$preparing->user_id)->get()->first();
            $preparing["user"] = $attacheduser;
        }
        foreach ($on_the_way_list as $on_the_way) {
            $attacheduser = $this->user->where("id",$on_the_way->user_id)->get()->first();
            $attachedcourrier = $this->pharmacy->where("id",$on_the_way->carrier_id)->get()->first();
            $on_the_way["user"] = $attacheduser;
            $on_the_way["courrier"]  = $attachedcourrier;
        }
        foreach ($delivered_list as $delivered) {
            $attacheduser = $this->user->where("id",$delivered->user_id)->get()->first();
            $attachedcourrier = $this->pharmacy->where("id",$delivered->carrier_id)->get()->first();
            $delivered["user"] = $attacheduser;
            $delivered["courrier"]  = $attachedcourrier;
        }
        foreach ($canceled_list as $canceled) {
            $attacheduser = $this->user->where("id",$canceled->user_id)->get()->first();
            $attachedcourrier = $this->pharmacy->where("id",$canceled->carrier_id)->get()->first();
            $canceled["user"] = $attacheduser;
            if($attachedcourrier) {
                $canceled["courrier"]  = $attachedcourrier;
            }
        }
        $list = [
            "taken" => $taken_list,
            "preparing" => $preparing_list,
            "on_the_way" => $on_the_way_list,
            "delivered" => $delivered_list,
            "canceled" => $canceled_list,
        ];
        return $list;
    }

    public function updateStatus($order_id, $data){
        switch ($data["status"]){
            case "preparing":
                $update = $this->orderModel->whereId($order_id)->first()->update(["order_status" => "preparing"]);
                break;
            case "on_the_way":
                $carrier_id = $data["carrier_id"];
                $this->pharmacy->whereId($carrier_id)->first()->update(["status" => "accept"]);
                $update = $this->orderModel->whereId($order_id)->first()->update(["order_status" => "on_the_way", "carrier_id" => $carrier_id]);
                break;
            case "delivered":
                $update = $this->orderModel->whereId($order_id)->first()->update(["order_status" => "delivered"]);
                $carrier_id = $data["carrier_id"];
                $this->pharmacy->whereId($carrier_id)->first()->update(["status" => "wait"]);
                break;
            case "canceled":
                $canceled_by = "pharmacy";
                $canceled_cause = $data["canceled_cause"];
                $carrier_id = $data["carrier_id"];
                $this->pharmacy->whereId($carrier_id)->first()->update(["status" => "wait"]);
                $update = $this->orderModel->whereId($order_id)->first()->update(["order_status" => "canceled", "canceled_by" => $canceled_by, "canceled_cause" => $canceled_cause]);
                $select_order = $this->orderModel->whereId($order_id)->first();
                $basket = $this->model->whereId($select_order->basket_id)->first();
                $this->stock_update($basket, "+");
                break;
        }
        return $update;
    }
}
