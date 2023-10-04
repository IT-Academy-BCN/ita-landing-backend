<?php

use App\Models\App as ModelsApp;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('apps', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url');
            $table->enum('state', ['COMPLETED', 'IN PROGRESS', 'SOON']);
            $table->timestamps();
        });

        Schema::create('app_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('app_id')->unsigned();
            $table->string('locale')->index();
            $table->string('title');
            $table->text('description');

            $table->unique(['app_id', 'locale']);
            $table->foreign('app_id')->references('id')->on('apps')->onDelete('cascade');
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



