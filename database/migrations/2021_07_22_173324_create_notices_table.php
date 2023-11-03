<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoticesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notices', function (Blueprint $table) {
            $table->id();
            $table->integer('animal_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('district_id');
            $table->string('image', 1000);
            $table->tinyInteger('is_noticed')->default(0);
            $table->string('noticed_time', 20)->nullable();
            $table->unsignedBigInteger('forward_who')->nullable();
            $table->string('title');
            $table->text('content');
            $table->unsignedBigInteger('notice_type_id');
            $table->integer('view_count')->default(0);
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
        Schema::dropIfExists('notices');
    }
}
