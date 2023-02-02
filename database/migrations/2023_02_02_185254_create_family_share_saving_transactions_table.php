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
        Schema::create('family_share_saving_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("family_share_saving_id"); // id of the family share saving foreign key
            $table->string("monthly_transaction");
            $table->integer("amount_tobe_paid");
            $table->integer("amount_paid");
            $table->integer("remaining_amount");
            $table->string("status");  // unpaid, process , paid
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
        Schema::dropIfExists('family_share_saving_transactions');
    }
};
