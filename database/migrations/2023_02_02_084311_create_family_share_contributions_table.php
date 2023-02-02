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
        Schema::create('family_share_contributions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("share_type_id"); // family share type id * contribution or savings
            $table->unsignedBigInteger("house_member_id"); // id of member from family house member table
            $table->string('share_amount'); // share amount to be paid
            $table->string("amount_paid"); // amount of member paid
            $table->string('status'); // unpaid, paid , process ()
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
        Schema::dropIfExists('family_share_contributions');
    }
};
