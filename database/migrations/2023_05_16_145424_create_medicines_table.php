<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("pharmacy_id")->index();                 // eczane id
            $table->unsignedBigInteger("medicine_category_id")->index();        // ilaç kategorisi id
            $table->unsignedBigInteger("medicine_sub_category_id")->index();    // ilaç alt kategorisi id
            $table->string("medicine_name");                                    // ilaç adı
            $table->string("pharmacology_name");                                // famakolojik adı
            $table->enum("prescription", ["1","0"]);                            // reçeteli satış 1:reçetesiz satılır 0:reçetesiz satılmaz
            $table->unsignedBigInteger("medicine_form_id")->index();            // ilaç formu
            $table->float("stock")->default(0);                           // stok
            $table->float("fee");                                               // ücret
            $table->float("SGK_fee");                                           // sgk ücreti
//            $table->string("medicine_component_id")->nullable();            // bileşenler
            $table->foreign("pharmacy_id")->references("id")->on("pharmacy_lists")->onDelete("restrict");
            $table->foreign("medicine_category_id")->references("id")->on("medicine_categories")->onDelete("restrict");
            $table->foreign("medicine_sub_category_id")->references("id")->on("medicine_sub_categories")->onDelete("restrict");
            $table->foreign("medicine_form_id")->references("id")->on("medicine_forms")->onDelete("restrict");
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
        Schema::dropIfExists('medicines');
    }
}
