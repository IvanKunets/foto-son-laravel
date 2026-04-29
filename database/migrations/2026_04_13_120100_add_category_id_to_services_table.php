<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable()->after('id');
            $table->foreign('category_id')->references('id')->on('service_categories')->nullOnDelete();
        });

        $defaultCategoryId = DB::table('service_categories')
            ->orderBy('sort_order')
            ->value('id');

        if ($defaultCategoryId !== null) {
            DB::table('services')
                ->whereNull('category_id')
                ->update(['category_id' => $defaultCategoryId]);
        }
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }
};
