<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('documentation', function (Blueprint $table) {
            $table->dropUnique(['request_token']);
            $table->unique(['project_id', 'request_token']);
        });
    }

    public function down(): void
    {
        Schema::table('documentation', function (Blueprint $table) {
            $table->dropUnique(['project_id', 'request_token']);
            $table->unique('request_token');
        });
    }
};
