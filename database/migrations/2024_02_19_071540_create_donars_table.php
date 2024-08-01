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
        Schema::create('donars', function (Blueprint $table) {
            $table->id();
            $table->integer('featured')->default(0);
            $table->string('name');
            $table->foreignId('blood_id')->constrained();
            $table->foreignId('city_id')->constrained();
            $table->foreignId('location_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->string('religion');
            $table->string('email');
            $table->string('phone');
            $table->string('profession');
            $table->text('details');
            $table->string('image')->nullable();
            $table->string('address');
            $table->integer('total_donate')->default(0);
            $table->enum('gender',['Male', 'Female']);
            $table->enum('status', [0,1,2])->default(0);
            $table->date('birth_date');
            $table->date('last_donate');
            $table->text('socialMedia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donars');
    }
};
