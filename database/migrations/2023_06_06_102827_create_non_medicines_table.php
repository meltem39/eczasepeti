<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNonMedicinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('non_medicines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("pharmacy_id")->index();                 // eczane id
            $table->unsignedBigInteger("non_medical_category_id")->index();     // ilaç kategorisi id
            $table->unsignedBigInteger("non_medical_sub_category_id")->index(); // ilaç alt kategorisi id
            $table->string("medicine_name");                                    // ilaç adı
            $table->longText("definition");                                     // ilaç adı
            $table->enum("prescription", ["1","0"])->default("1");        // reçeteli satış 1:reçetesiz satılır 0:reçetesiz satılmaz
            $table->float("stock")->default(0);                           // stok
            $table->float("fee");                                               // ücret
            $table->mediumText('name')->nullable();                             // image name
            $table->mediumText('type')->nullable();                             // image type
            $table->longText('data')->nullable();                               // image data
            $table->foreign("pharmacy_id")->references("id")->on("pharmacy_lists")->onDelete("restrict");
            $table->foreign("non_medical_category_id")->references("id")->on("non_medical_categories")->onDelete("restrict");
            $table->foreign("non_medical_sub_category_id")->references("id")->on("non_medical_sub_categories")->onDelete("restrict");
//            $table->foreign("medicine_component_id")->references("id")->on("medicine_components")->onDelete("restrict");
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('non_medicines');
    }
}
