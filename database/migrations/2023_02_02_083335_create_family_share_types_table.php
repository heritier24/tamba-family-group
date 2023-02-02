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
        Schema::create('family_share_types', function (Blueprint $table) {
            $table->id();
            $table->string("share_type"); // share , savings , ..... 
            $table->string("amount"); // amount per share , for example amount per savings = 5000 
            $table->string("status"); // active share type, inactive share type
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
        Schema::dropIfExists('family_share_types');
    }
};
