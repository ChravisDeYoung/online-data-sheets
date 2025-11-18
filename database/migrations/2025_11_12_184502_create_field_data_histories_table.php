<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFieldDataHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('field_data_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('field_data_id')->constrained('field_data')->restrictOnDelete();
            $table->string('old_value')->nullable();
            $table->string('new_value')->nullable();
            $table->foreignId('user_id')->constrained()->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('field_data_histories');
    }
}
