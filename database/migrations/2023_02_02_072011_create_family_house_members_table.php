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
        Schema::create('family_house_members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("house_id"); // foreign key of house id
            $table->unsignedBigInteger("member_id"); // foreign key of member id
            $table->string("status")->default("active"); // active, inactive
            $table->timestamps();

            $table->foreign('house_id')->references('id')->on('family_houses')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('member_id')->references('id')->on('family_members')
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
        Schema::dropIfExists('family_house_members');
    }
};
