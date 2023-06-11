<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShoppingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shoppings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("pharmacy_id");
            $table->unsignedBigInteger("prescription_id")->nullable();
            $table->enum("is_medicine", ["1","0"]);
            $table->json("content")->nullable();
            $table->enum("status", ["adding", "ordered", "cancelled"]);
            $table->float("total");
            $table->float("SGK_total")->nullable();
            $table->foreign("user_id")->references("id")->on("users")->onDelete("restrict");
            $table->foreign("pharmacy_id")->references("id")->on("pharmacy_lists")->onDelete("restrict");
            $table->foreign("prescription_id")->references("id")->on("prescriptions")->onDelete("restrict");

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
        Schema::dropIfExists('shoppings');
    }
}
