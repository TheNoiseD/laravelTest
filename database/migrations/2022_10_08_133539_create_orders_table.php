<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->unsignedBigInteger('user_id')
                  ->comment("Es el id del usuario que reliza el pedido.");
            $table->string('url_process', 255)
                  ->nullable()
                  ->comment("Url de proceso de pago.");
            $table->unsignedBigInteger('cart_id')
                  ->comment("Id del carrito de compras.");
            $table->decimal('total', 15, 2)
                  ->comment("Total de la compra.");
            $table->enum('status', ['CREATED','PAYED','REJECTED'])
                  ->default('CREATED')
                  ->comment("Los estados posibles son CREATED, PAYED, REJECTED.");
            $table->enum('status_pay', ['APPROVED','REJECTED','PENDING'])
                  ->default('PENDING');
            $table->unsignedBigInteger('request_id')
                  ->nullable()
                  ->comment("Id de la transaccion en el sistema de pagos.");
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('cart_id')->references('id')->on('carts');
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
};
