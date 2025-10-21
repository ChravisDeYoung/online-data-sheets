<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDashboardTilesTable extends Migration
{
    public function up(): void
    {
        Schema::create('dashboard_tiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->nullable()->constrained();
            $table->foreignId('parent_dashboard_tile_id')->nullable()->constrained('dashboard_tiles');
            $table->string('title');
            $table->integer('sort_order');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dashboard_tiles');
    }
}
