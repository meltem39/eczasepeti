<?php

namespace App\Http\Controllers\API\Pharmacy;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Pharmacy;
use App\Repositories\User\ShoppingRepositories\ShoppingRepositoryInterface;
use Illuminate\Http\Request;

class OrderController extends BaseController
{
    private ShoppingRepositoryInterface $shoppingRepository;

    public function __construct(ShoppingRepositoryInterface $shoppingRepository
    ){
        $this->shoppingRepository = $shoppingRepository;
    }

    public function orderList(){
        $login_user = $this->loginUser("pharmacy-api");
        $order_list = $this->shoppingRepository->listOrder($login_user->organization_name);
        return $this->sendResponse($order_list, "success");
    }
    public function orderUpdate(Request $request, $order_id){
        $update_status = $this->shoppingRepository->updateStatus($order_id, $request->all());
        return $this->sendResponse($update_status, "success");
    }

    public function currierList(){
        $login_user = $this->loginUser("pharmacy-api");
        $currier_list = Pharmacy::where("organization_name",  $login_user->organization_name)->where("job", "kurye")->get();
        return $this->sendResponse($currier_list, "success");
    }
}
