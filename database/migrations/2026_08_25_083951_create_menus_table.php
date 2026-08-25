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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();

            // Menu Details
            $table->string('name'); // e.g., "Home", "Services", "About Us"
            $table->string('url')->nullable(); // Target URL or route path
            $table->string('icon')->nullable(); // Optional: FontAwesome or Heroicon string

            // Hierarchy Tracking
            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('menus')
                ->cascadeOnDelete(); // Deleting a parent deletes its submenus

            // Display Sorting
            $table->integer('sort_order')->default(0); // Determines layout order

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
