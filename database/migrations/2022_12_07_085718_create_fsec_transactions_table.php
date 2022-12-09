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
        Schema::create('fsec_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fsec_id')->references('id')->on('fsecs')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('fsec_transactions');
    }
};
