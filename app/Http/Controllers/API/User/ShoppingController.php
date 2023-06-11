<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Repositories\User\ShoppingRepositories\ShoppingRepositoryInterface;
use Illuminate\Http\Request;
use Validator;

class ShoppingController extends BaseController
{
    private ShoppingRepositoryInterface $shoppingRepository;

    public function __construct(ShoppingRepositoryInterface $shoppingRepository
    ){
        $this->shoppingRepository = $shoppingRepository;
    }

    public function basketDetail(){
        $login_user = $this->loginUser("user-api");
        $basket = $this->shoppingRepository->basketDetail($login_user->id);
        if ($basket)
            return $this->sendResponse($basket, "success");
        return $this->sendNegativeResponse("empty");
    }

    public function addBasket(Request $request){
        $login_user = $this->loginUser("user-api");
        $basket = $this->shoppingRepository->addBasket($login_user->id, $request->all());
        if ($basket){
            return $this->sendResponse($basket, "added");
        } return $this->sendError("unexpected error");
    }

    public function buyBasket(Request $request, $basket_id){
        $login_user = $this->loginUser("user-api");
        $input =  $request->all();
        if ($input["payment_type"] == "card"){
            $validator = Validator::make($input, [
                'card_no' => 'required',
                'card_name' => 'required',
                'expired_date' => 'required',
                'cvv' => 'required',
            ]);
            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors());
            }
            unset($input["card_no"]);
            unset($input["card_name"]);
            unset($input["expired_date"]);
            unset($input["cvv"]);
        }
        $buy = $this->shoppingRepository->buyBasket($login_user->id, $input, $basket_id);
        if($buy){
            return $this->sendResponse($buy, "ordered");
        } return $this->sendError("unexpected error");
    }

    public function cancelOrder(Request $request, $order_id){
        $data = $request->all();
        $cancel = $this->shoppingRepository->cancelOrder("user", $order_id, $data);
        if ($cancel)
            return $this->sendResponse($cancel, "canceled");
        return $this->sendNegativeResponse("order has already been delivered");
    }

    public function orderDetail($order_id){
        $detail = $this->shoppingRepository->orderDetail($order_id);
        return $this->sendResponse($detail, "order detail");
    }
}
