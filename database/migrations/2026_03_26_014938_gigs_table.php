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
        Schema::create('gigs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('title');
        $table->foreignId('category_id')->constrained('gigs_categories')->onDelete('cascade');
        $table->text('description');
        $table->decimal('price', 10, 2);
        $table->enum('price_type', ['per hour', 'per day', 'per project']);
        $table->date('availability')->nullable();
        $table->enum('status', ['active', 'inactive'])->default('active');
        $table->string('image')->nullable();
        $table->float('rating_avg', 2, 1)->default(0);
        $table->unsignedInteger('total_reviews')->default(0);
        $table->unsignedInteger('completion_count')->default(0);
        $table->unsignedInteger('views_count')->default(0);
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gigs');
    }
};
