<?php

use App\Models\Field;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fields', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('page_id')->constrained();
            $table->string('name');
            $table->tinyInteger('type')->default(Field::TYPE_TEXT);
            $table->string('subsection');
            $table->integer('subsection_sort_order');
            $table->integer('sort_order');
            $table->decimal('minimum')->nullable();
            $table->decimal('maximum')->nullable();
            $table->string('select_options')->nullable();
            $table->string('required_columns')->default('1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fields');
    }
}
