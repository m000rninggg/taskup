<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('projects', 'created_by')) {
            Schema::table('projects', function (Blueprint $table) {
                $table->foreignId('created_by')
                    ->nullable()
                    ->after('team_id')
                    ->constrained('users')
                    ->nullOnDelete();
            });
        }

        DB::table('projects')
            ->whereNull('created_by')
            ->orderBy('id')
            ->eachById(function ($project): void {
                $ownerId = DB::table('teams')
                    ->where('id', $project->team_id)
                    ->value('owner_id');

                DB::table('projects')
                    ->where('id', $project->id)
                    ->update(['created_by' => $ownerId]);
            });
    }

    public function down(): void
    {
        if (Schema::hasColumn('projects', 'created_by')) {
            Schema::table('projects', function (Blueprint $table) {
                $table->dropConstrainedForeignId('created_by');
            });
        }
    }
};
