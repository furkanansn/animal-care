<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->on('users');
            $table->decimal('money_count', 11)->nullable();
            $table->tinyInteger('is_donated')->default(0);

            $table->foreignId('sehir_key')
                ->constrained()
                ->on('sehir')
                ->references('sehir_key')
                ->restrictOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('ilce_key')
                ->constrained()
                ->on('ilce')
                ->references('ilce_key')
                ->restrictOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('district_id')
                ->constrained()
                ->on('mahalle')
                ->references('mahalle_key')
                ->restrictOnUpdate()
                ->restrictOnDelete();


            $table->foreignId('animal_type_id')
                ->constrained()
                ->on('animal_kinds')
                ->restrictOnDelete()
                ->restrictOnUpdate();

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
        Schema::dropIfExists('donations');
    }
}
