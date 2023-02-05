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
        Schema::create('family_loan_members_interests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("house_member_id");  // house_member_id in table family house members
            $table->string("interest_type")->default("Loan Interest");
            $table->integer("interest_amount");
            $table->string("interest_period"); // month and year of interest
            $table->string("status");  //paid, unpaid
            $table->timestamps();

            $table->foreign('house_member_id')->references('id')->on('family_house_members')
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
        Schema::dropIfExists('family_loan_members_interests');
    }
};
