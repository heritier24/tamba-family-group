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
        Schema::create('general_transactions', function (Blueprint $table) {
            $table->id();
            $table->string("transaction_date");
            $table->string("transaction_type"); // savings type, loan transaction type, interest rate type and , .....
            $table->string("transaction_from"); // from bank, from ccash , from family members, ... 
            $table->string("transaction_to");   // to bank, to cash , to members, ... 
            $table->string("transaction_amount");
            $table->unsignedBigInteger("user_id");
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('general_transactions');
    }
};
