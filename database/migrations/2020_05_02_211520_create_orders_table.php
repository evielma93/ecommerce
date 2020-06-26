<?php
use App\Order;
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
            $table->bigIncrements('id');
            $table->unsignedBigInteger("user_id")->comment("Cliente que ha solicitado el pedido");
            $table->foreign("user_id")->references("id")->on("users");
            $table->string("invoice_id")->nullable()->comment("Factura generada por Stripe");
            $table->float("total_amount")->comment("Coste total del pedido");
            $table->enum("status", [Order::SUCCESS, Order::PENDING])->default(Order::PENDING);
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
