<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('i_p_user_id')->unsigned()->index();
            $table->bigInteger('product_id')->unsigned()->index();

            $table->bigInteger('quantity')->default(1);
            $table->string('type')->default('buy');
            $table->float('price');

            $table->foreign('i_p_user_id')->references('id')->on('i_p_users');
            $table->foreign('product_id')->references('id')->on('products');

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
        Schema::dropIfExists('carts');
    }
}
