<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnnouncementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->integer('age');
            $table->string('image')->nullable();


            $table->foreignId('type_id')
                ->constrained()
                ->on('announcement_types')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreignId('animal_id')
                ->nullable()
                ->constrained()
                ->on('animals')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('animal_type')
                ->nullable()
                ->constrained()
                ->on('animal_types')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreignId('animal_kind')
                ->nullable()
                ->constrained()
                ->on('animal_kinds')
                ->onDelete('cascade')
                ->onUpdate('cascade');

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
        Schema::dropIfExists('announcements');
    }
}
