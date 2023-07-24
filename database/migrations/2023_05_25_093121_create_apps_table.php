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
        Schema::create('apps', function (Blueprint $table) {
            $table->id();
            $table->string('locale')->index();
            $table->text('url');
            $table->enum('state', ['COMPLETED', 'IN PROGRESS', 'SOON']);
            $table->timestamps();
        });

        Schema::create('app_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('app_id')->constrained('apps')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->string('locale')->index();
        
            $table->unique(['app_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_translations');
        Schema::dropIfExists('apps');
    }
};



