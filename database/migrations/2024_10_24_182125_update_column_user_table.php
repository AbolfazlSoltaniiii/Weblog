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
        Schema::table('users', static function (Blueprint $table) {
            $table->string('username', 200)->comment('نام کاربری')->change();
            $table->string('password', 150)->comment('گذرواژه')->change();

            $table->string('email', 250)->comment('ایمیل')->change();

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
