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
        Schema::create('family_loan_types', function (Blueprint $table) {
            $table->id();
            $table->string("loan_types"); // family_loan_types(saving loan types, family_loan_types)
            $table->integer("interest_rate"); // interest_rate %
            $table->string("status"); // loan active , loan inactive
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
        Schema::dropIfExists('family_loan_types');
    }
};
