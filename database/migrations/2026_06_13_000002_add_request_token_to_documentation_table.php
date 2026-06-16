<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('documentation', 'request_token')) {
            Schema::table('documentation', function (Blueprint $table) {
                $table->uuid('request_token')->nullable()->unique()->after('project_id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('documentation', 'request_token')) {
            Schema::table('documentation', function (Blueprint $table) {
                $table->dropUnique(['request_token']);
                $table->dropColumn('request_token');
            });
        }
    }
};
