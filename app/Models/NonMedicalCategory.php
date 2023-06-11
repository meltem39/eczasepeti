<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NonMedicalCategory extends Model
{
    use HasFactory;

    protected $fillable= [
        "pharmacy_id",
        "category_name",
    ];
}
