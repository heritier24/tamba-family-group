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
        Schema::create('family_share_savings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("share_type_id"); // family share type id for savings
            $table->unsignedBigInteger("house_member_id"); // id of member from family house member table
            $table->integer("saving_amount");
            $table->integer("number_of_shares"); // number of shares
            $table->integer("total_shares_amount"); // total shares amount to be paid every months = (saving amount * number_of_shares)
            $table->string("status"); // active , inactive
            $table->unsignedBigInteger("user_id"); // user identifier
            $table->timestamps();

            $table->foreign('share_type_id')->references('id')->on('family_share_types')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('house_member_id')->references('id')->on('family_house_members')
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
        Schema::dropIfExists('family_share_savings');
    }
};
