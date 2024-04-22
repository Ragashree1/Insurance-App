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
        Schema::create('property_listings', function (Blueprint $table) {
            $table->id();
            $table->string("type");
            $table->string('image')->nullable();
            $table->integer('num_bedroom');
            $table->integer('num_bathroom');
            $table->decimal('area', 8, 2); 
            $table->decimal('sale_price', 10, 2); 
            $table->string("location");
            $table->string("description");
            $table->foreignId('create_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('create_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_listings');
    }
};