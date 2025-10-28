<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFieldDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('field_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('field_id')->constrained();
            $table->string('value')->nullable();
            $table->integer('column');
            $table->date('page_date');
            $table->timestamps();

            $table->unique(['field_id', 'column', 'page_date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('field_data');
    }
}
