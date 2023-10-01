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
        Schema::create('milk_notes', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date');
            $table->enum('type', ['individual', 'bulk']);
            $table->text('note')->nullable();
            $table->double('produced');
            $table->double('consumption');
            $table->smallInteger('goats_milked');
            $table->foreignId('goat_id')->nullable();
            $table->foreignId('user_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('goat_id')->references('id')->on('goats');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('milk_notes');
    }
};
