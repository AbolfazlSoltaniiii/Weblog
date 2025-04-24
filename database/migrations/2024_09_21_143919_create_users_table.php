<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', static function (Blueprint $table) {
            $table->id();

            $table->string('username', 200)->comment('نام کاربری');
            $table->string('password', 150)->comment('گذرواژه');
            $table->string('email', 250)->comment('ایمیل')->unique();

            $table->timestamps();
            $table->softDeletes();

            $table->comment('کاربران');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
