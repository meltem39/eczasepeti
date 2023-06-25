<?php

namespace App\Repositories\User\ShoppingRepositories;

interface ShoppingRepositoryInterface{

    public function detail($basket, $medicines,$prescriptionlessMedicines, $total = 0, $SGK_total = 0,$isUser);

    public function stock_update($basket, $operator);

    public function basketDetail($user_id);

    public function addBasket($user_id, $data);

    public function myOrders($user_id);

    public function buyBasket($user_id, $data, $basket_id);

    public function cancelOrder($cancel_by, $order_id, $data);

    public function orderDetail($order_id);

    public function listOrder($pharmacy_id);

    public function updateStatus($order_id, $data);
}
