<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNonMedicalCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('non_medical_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("pharmacy_id")->nullable();  // eczane id
            $table->string("category_name");                        // kategori adı
            $table->foreign("pharmacy_id")->references("id")->on("pharmacy_lists")->onDelete("restrict");
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
        Schema::dropIfExists('non_medical_categories');
    }
}
