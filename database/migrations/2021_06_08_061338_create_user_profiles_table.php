<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->text('address');
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->integer('postcode');
            $table->date('dob');
            $table->string('qualification');
            $table->boolean('experience')->default(false)->comment('User Fresher Or Experience');
            $table->string('experience_detail');
            $table->string('image')->nullable();
            $table->string('docs')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_profiles');
    }
}
