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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 191);
            $table->string('username', 191)->unique();
            $table->string('email', 191)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('password', 191);
            $table->rememberToken();
            $table->enum('gender', ['male', 'female']);
            $table->string('address', 191)->nullable();
            $table->char('creation_mark', 191)->unique();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo', 191)->nullable();
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
        Schema::dropIfExists('users');
    }
};
