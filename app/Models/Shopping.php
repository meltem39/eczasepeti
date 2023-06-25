<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shopping extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "pharmacy_id",
        "prescription_id",
        "is_medicine",
        "content",
        "nonmedicine_content",
        "status",
        "total",
        "SGK_total",
    ];
}
