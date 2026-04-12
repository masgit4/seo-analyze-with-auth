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
        Schema::create('analyses', function (Blueprint $table) {
            $table->id();
            $table->ulid('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('url');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->integer('h1')->default(0);
            $table->integer('h2')->default(0);
            $table->integer('img_no_alt')->default(0);
        
            $table->integer('internal_links')->default(0);
            $table->integer('external_links')->default(0);
        
            $table->boolean('https')->default(false);
            $table->boolean('sitemap')->default(false);
            $table->boolean('robots')->default(false);
            $table->boolean('canonical')->default(false);
            $table->boolean('og_tags')->default(false);
        
            $table->float('keyword_density')->default(0);
            $table->integer('score')->default(0);
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analyses');
    }
};
