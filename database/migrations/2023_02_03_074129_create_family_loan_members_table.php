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
        Schema::create('family_loan_members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("loan_type_id"); // foreign key of loan type id
            $table->unsignedBigInteger("house_member_id"); // foreign key of member in the house member table
            $table->integer("loan_amount");
            $table->integer("loan_period"); // period in months
            $table->integer("loan_interest_amount"); // interest * loan period
            $table->integer("amount_received");
            $table->integer("amount_tobepaid");
            $table->string("status"); // unpaid, paid , proccess to be paid
            $table->unsignedBigInteger("user_id");
            $table->timestamps();

            $table->foreign('loan_type_id')->references('id')->on('family_loan_types')
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
        Schema::dropIfExists('family_loan_members');
    }
};
