<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        "basket_id",
        "user_id",
        "pharmacy_id",
        "carrier_id",
        "payment_type",
        "payment_status",
        "order_status",
        "canceled_by",
        "canceled_cause",
        "user_address",
        "total",
        "SGK_total",
    ];
}
