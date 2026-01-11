<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
    $table->engine = 'InnoDB';

    $table->bigIncrements('id');
    $table->unsignedBigInteger('user_id');

    $table->string('name');
    $table->string('photo')->nullable();
    $table->string('phone')->nullable();
    $table->text('bio')->nullable();
    $table->decimal('location_lat', 10, 7)->nullable();
    $table->decimal('location_lng', 10, 7)->nullable();

    $table->timestamps();

    $table->foreign('user_id')
        ->references('id')
        ->on('users')
        ->onDelete('cascade');
});


    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};

