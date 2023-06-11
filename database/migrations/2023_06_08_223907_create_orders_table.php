<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("basket_id");
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("pharmacy_id");
            $table->unsignedBigInteger("carrier_id")->nullable();
            $table->enum("payment_type", ["card", "cash"]);
            $table->enum("payment_status", ["1","0"]);
            $table->enum("order_status", ["taken", "preparing","on_the_way", "delivered", "canceled"]);
            $table->enum("canceled_by", ["pharmacy", "carries", "user"])->nullable();
            $table->text("canceled_cause")->nullable();
            $table->longText("user_address");
            $table->float("total");
            $table->float("SGK_total")->nullable();
            $table->foreign("basket_id")->references("id")->on("shoppings")->onDelete("restrict");
            $table->foreign("user_id")->references("id")->on("users")->onDelete("restrict");
            $table->foreign("pharmacy_id")->references("id")->on("pharmacy_lists")->onDelete("restrict");
            $table->foreign("carrier_id")->references("id")->on("pharmacies")->onDelete("restrict");

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
        Schema::dropIfExists('orders');
    }
}
