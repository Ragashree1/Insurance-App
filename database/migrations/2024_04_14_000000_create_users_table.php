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
            $table->string('username', 50)->unique();
            $table->string('first_name', 25);
            $table->string('last_name', 25);
            $table->date('dob');
            $table->string('email', 50)->unique();
            $table->string('contact', 50)->unique();
            $table->string('password');
            $table->unsignedBigInteger('user_profile_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->rememberToken();
            $table->enum('status', ['active', 'suspended'])->default('active');
            $table->string('nationality', 50)->nullable();
            $table->string('residence_country', 50)->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreign('user_profile_id')->references('id')->on('user_profile')->nullOnDelete();
            // $table->foreignId('user_profile_id')->constrained();
            $table->timestamp('create_date')->nullable();
            // $table->timestamps();
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
