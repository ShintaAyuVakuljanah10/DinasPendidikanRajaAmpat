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
        Schema::create('pages', function (Blueprint $table) {
            $table->bigIncrements('id'); // Auto-increment primary key
            $table->string('title');
            $table->string('slug')->nullable();
            $table->longText('content')->nullable();
            $table->enum('type', ['page', 'sub_page'])->nullable();
            $table->unsignedBigInteger('parent')->nullable();
            $table->boolean('with_direct_link')->default(0);
            $table->string('link')->nullable();
            $table->string('meta_title', 125)->nullable();
            $table->text('meta_keywords')->nullable();
            $table->integer('with_content')->nullable();
            $table->unsignedInteger('active')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->integer('order')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
 