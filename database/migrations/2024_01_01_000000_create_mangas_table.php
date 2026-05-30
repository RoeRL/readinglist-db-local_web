<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mangas', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('cover_url')->nullable();
            $table->json('sources')->nullable();        // [{"label":"...","url":"..."}]
            $table->enum('status', [
                'plan-to-read',
                'reading',
                'on-hold',
                'completed',
                're-reading',
                'dropped',
            ])->default('plan-to-read');
            $table->unsignedSmallInteger('current_chapter')->nullable();
            $table->unsignedSmallInteger('total_chapters')->nullable();
            $table->json('genres')->nullable();         // ["Action","Romance"]
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mangas');
    }
};
