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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('slug')->unique()->nullable();
            $table->string('author')->nullable();

            $table->text('intro')->nullable();
            $table->longText('content')->nullable();

            $table->unsignedInteger('category')->nullable();
            $table->unsignedInteger('label')->nullable();

            $table->string('image')->nullable();

            $table->string('meta_title', 125)->nullable();
            $table->text('meta_keywords')->nullable();

            $table->enum('status', ['Published', 'Draft', 'Unpublished'])->default('Draft');

            
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();

            $table->timestamp('published_at')->nullable();

            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
