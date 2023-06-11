<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NonMedicine extends Model
{
    use HasFactory;

    protected $fillable =[
      "pharmacy_id",
      "non_medical_category_id",
      "non_medical_sub_category_id",
      "medicine_name",
      "definition",
      "prescription",
      "stock",
      "fee",
      "name",
      "type",
      "data"
    ];
}
