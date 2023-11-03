<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnimalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->tinyInteger('is_pet')->default(0);
            $table->integer('type')->nullable();
            $table->integer('kind')->nullable();
            $table->string('image')->unique()->nullable();
            $table->string('birthday');
            $table->string('uuid')->unique();
            $table->integer('district_id');
            $table->text('sickness_json')->nullable();
            $table->text('drugs_used_json')->nullable();
            $table->text('surgeries_json')->nullable();
            $table->string('weight');
            $table->tinyInteger('is_shelter')->default(0);
            $table->text('report_sheet_json')->nullable();
            $table->text('passport_sheet_json')->nullable();
            $table->text('other_docs_json')->nullable();
            $table->tinyInteger('takeOwnerShip')->default(0);
            $table->tinyInteger('wetNurse')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('animals');
    }
}
