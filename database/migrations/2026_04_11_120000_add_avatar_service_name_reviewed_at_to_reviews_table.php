<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->string('avatar', 255)->nullable()->after('is_visible');
            $table->string('service_name', 255)->nullable()->after('avatar');
            $table->date('reviewed_at')->nullable()->after('service_name');
        });
    }

    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn(['avatar', 'service_name', 'reviewed_at']);
        });
    }
};
