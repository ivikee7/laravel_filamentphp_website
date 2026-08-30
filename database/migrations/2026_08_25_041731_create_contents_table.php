<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->id();

            // Core Content
            $table->string('title');
            $table->string('slug')->unique();
            $table->json('content')->nullable();
            $table->foreignId('category_id')->nullable()->after('id')->constrained('categories')->nullOnDelete();

            // SEO & Metadata Optimizer Fields
            $table->json('seo')->nullable();

            // Flexibility
            $table->json('meta')->nullable();
            $table->json('styles')->nullable();
            $table->json('setting')->nullable();

            // Ownership & Relations
            $table->foreignId('created_by')->nullable()->index();

            // Lifecycle & Safety
            $table->timestamps();
            $table->softDeletes()->index(); // Sends items to a "Trash bin" instead of wiping the disk
        });

        Schema::create('content_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('content_id')->constrained('contents')->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained('tags')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_tag');
        Schema::dropIfExists('contents');
    }
};
