<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
      "pharmacy_id",
      "medicine_category_id",
      "medicine_sub_category_id",
      "medicine_name",
      "pharmacology_name",
      "prescription",
      "medicine_form_id",
      "stock",
      "fee",
      "SGK_fee"
    ];
}
