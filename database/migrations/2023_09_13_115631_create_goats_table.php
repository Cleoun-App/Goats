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
        Schema::create('goats', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('tag', 100)->unique();
            $table->string('picture');
            $table->enum('gender', ['female', 'male']);
            $table->integer('weight')->comment('Weight in gram');
            $table->string('origin');
            $table->foreignId('group_id')->nullable();
            $table->foreignId('user_id');
            $table->foreignId('mother_id')->nullable();
            $table->foreignId('father_id')->nullable();
            $table->string('breed');
            $table->enum('status', ['alive', 'death', 'sold']);
            $table->string('obtained_by');
            $table->timestamp('birth_date');
            $table->string('note', 450);
            $table->timestamps();

            $table->foreign('user_id')->on('users')->references('id')->restrictOnDelete();
            $table->foreign('group_id')->on('groups')->references('id')->restrictOnDelete();
            $table->foreign('mother_id')->on('goats')->references('id')->restrictOnDelete();
            $table->foreign('father_id')->on('goats')->references('id')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goats');
    }
};
