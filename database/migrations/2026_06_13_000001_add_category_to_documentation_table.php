<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('documentation', 'category')) {
            Schema::table('documentation', function (Blueprint $table) {
                $table->string('category')->default('main')->after('title');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('documentation', 'category')) {
            Schema::table('documentation', function (Blueprint $table) {
                $table->dropColumn('category');
            });
        }
    }
};
