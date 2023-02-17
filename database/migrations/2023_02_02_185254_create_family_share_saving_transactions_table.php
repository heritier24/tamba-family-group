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
            $table->string("monthly_transaction"); // (January-2023, February-2023, March-2023, April-2023, ...)
            $table->integer("amount_tobe_paid");  // this is total share amount from family share savings
            $table->integer("amount_paid");
            $table->integer("remaining_amount");
            $table->string("status");  // unpaid, process , paid
            $table->unsignedBigInteger("user_id"); // id of the user
            $table->timestamps();

            $table->foreign('family_share_saving_id')->references('id')->on('family_share_savings')
                ->onDelete('restrict')
                ->onUpdate('cascade');

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
        Schema::dropIfExists('family_share_saving_transactions');
    }
};
