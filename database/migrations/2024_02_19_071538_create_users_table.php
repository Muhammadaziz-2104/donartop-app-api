<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('city_id')->nullable()->constrained();
            $table->foreignId('location_id')->nullable()->constrained();
            $table->string('phone')->nullable();
            $table->string('password');
            $table->date('birth_date')->nullable();
            $table->string('email')->unique();
            $table->string('profession')->nullable();
            $table->string('image')->nullable();
            $table->enum('status', [1,0])->default(0)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
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
