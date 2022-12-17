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
        Schema::create('fsic_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fsic_id')->references('id')->on('fsics')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('fsic_no');
            $table->date('valid_for');
            $table->date('valid_until');
            $table->double('amount');
            $table->bigInteger('ops_no');
            $table->bigInteger('or_no');
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('fsic_transactions');
    }
};
