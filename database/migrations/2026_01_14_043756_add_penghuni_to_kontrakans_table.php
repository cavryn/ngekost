<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('kontrakans', function (Blueprint $table) {
            $table->integer('max_penghuni')->after('harga');
            $table->integer('jumlah_penghuni')->default(0)->after('max_penghuni');
        });
    }

    public function down(): void
    {
        Schema::table('kontrakans', function (Blueprint $table) {
            $table->dropColumn(['max_penghuni', 'jumlah_penghuni']);
        });
    }
};
