<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->id(); // BIGINT UNSIGNED
            $table->unsignedBigInteger('user_id');

            $table->integer('usia')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->string('domisili', 100)->nullable();
            $table->text('deskripsi_diri')->nullable();
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
