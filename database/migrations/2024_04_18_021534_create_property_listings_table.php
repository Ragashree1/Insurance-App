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
            $table->string("title");
            $table->string('image')->nullable();
            $table->integer('num_bedroom');
            $table->integer('num_bathroom');
            $table->integer('area');
            $table->integer('sale_price');
            $table->string("location")->unique();
            $table->text("description");
            $table->foreignId('create_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['new', 'sold', 'reserve'])->default('new');
            $table->unsignedInteger('num_views')->default(0);
            $table->unsignedInteger('num_shortlist')->default(0);
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
