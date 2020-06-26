<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_lines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("order_id")->comment("Identificador del pedido");
            $table->foreign("order_id")->references("id")->on("orders");
            $table->unsignedBigInteger("product_id")->comment("Identificador del producto");
            $table->foreign("product_id")->references("id")->on("products");
            $table->unsignedTinyInteger("quantity")->comment("Número de productos");
            $table->float("price")->comment("Precio de cada unidad del producto");
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
        Schema::dropIfExists('order_lines');
    }
}
