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
        Schema::create('family_loan_members_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("loan_member_id"); // foreign key for family_loan_members id in table
            $table->integer("loan_amount");
            $table->integer("amount_paid"); // loan amount paid 
            $table->integer("total_paid"); // total amount paid
            $table->integer("remaining_amount"); // remaining amount to be paid
            $table->string("last_date_tobepaid"); // last date to be paid
            $table->unsignedBigInteger("user_id");
            $table->timestamps();

            $table->foreign('loan_member_id')->references('id')->on('family_loan_members')
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
        Schema::dropIfExists('family_loan_members_payments');
    }
};
