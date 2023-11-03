<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone_number')->unique();
            $table->text('questions_json')->nullable();
            $table->integer('district_id');
            $table->string('tax_office')->nullable();
            $table->string('tax_number')->unique()->nullable();
            $table->text('address')->nullable();
            $table->tinyInteger('is_personal')->default(1);
            $table->string('authorized_phone')->nullable();
            $table->string('working_hours')->nullable();
            $table->string('birthday');
            $table->tinyInteger('is_approved')->nullable();
            $table->rememberToken();
            $table->softDeletes();
            $table->unsignedBigInteger('last_activity')->nullable();
            $table->string('register_ip', 20)->nullable();
            $table->string('last_login_ip', 20)->nullable();
            $table->string('user_agent', 1000)->nullable();
            $table->unsignedBigInteger('last_login_time')->nullable()->default(0);
            $table->text('fcm_token')->nullable();
            $table->unsignedBigInteger('sector_id')->nullable();
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
        Schema::dropIfExists('users');
    }
}
