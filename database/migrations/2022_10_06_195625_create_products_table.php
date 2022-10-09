<?php

use App\Models\Product;
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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('brand',20);
            $table->string('name', 20);
            $table->unsignedFloat('cost', 15, 2);
            $table->unsignedFloat('price', 15, 2);
            $table->unsignedBigInteger('stock');
            $table->string('description', 255);
            $table->string('image')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

//        create test product
        Product::create([
            'brand' => 'Apple',
            'name' => 'Apple watch S5',
            'cost'=> 5,
            'price' => 10,
            'stock' => 10,
            'description' => 'Apple watch S5',
            'image' => 'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/FWW52_AV1?wid=1144&hei=1144&fmt=jpeg&qlt=90&.v=1580326084542',
            'enabled' => true
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
