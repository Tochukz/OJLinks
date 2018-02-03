<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrderMigration2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fullname');
            $table->string('email');
            $table->string('receiver_address');
            $table->integer('cell_number');
            $table->string('item_name');
            $table->double('amount', 7, 2);
            $table->integer('order_id');
            $table->json('order_details');
            $table->enum('paid', ['yes', 'no'])->default('no');
            $table->string('custom_str1');
            $table->enum('delivered',['yes', 'no'])->default('no');
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
