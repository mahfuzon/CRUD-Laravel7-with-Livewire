<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date');
            $table->integer('berat_ikan');
            $table->integer('jlh_kantong');
            $table->integer('harga_ikan');
            $table->integer('total_berat');
            $table->integer('total_harga');
            $table->integer('bayar');
            $table->integer('hutang')->nullable();
            $table->text('keterangan')->nullable();
            $table->bigInteger('customer_id')->unsigned()->nullable();
            $table->bigInteger('driver_id')->unsigned()->nullable();

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('SET NULL');
            $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('SET NULL');
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
        Schema::dropIfExists('transactions');
    }
}
