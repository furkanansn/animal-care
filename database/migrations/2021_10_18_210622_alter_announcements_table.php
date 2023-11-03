<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAnnouncementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->foreignId('district_id')
                ->nullable()
                ->constrained()
                ->references('mahalle_key')
                ->on('mahalle')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('ilce_key')
                ->nullable()
                ->constrained()
                ->references('ilce_key')
                ->on('ilce')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('sehir_key')
                ->nullable()
                ->constrained()
                ->references('sehir_key')
                ->on('sehir')
                ->onUpdate('cascade')
                ->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->dropColumn('district_id');
            $table->dropColumn('sehir_key');
            $table->dropColumn('ilce_key');
        });
    }
}
