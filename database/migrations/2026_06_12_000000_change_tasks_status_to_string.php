<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('tasks')) {
            return;
        }

        $driver = DB::connection()->getDriverName();

        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE tasks MODIFY status VARCHAR(50) NOT NULL DEFAULT 'todo'");
        }

        if ($driver === 'pgsql') {
            DB::statement("ALTER TABLE tasks ALTER COLUMN status TYPE VARCHAR(50)");
            DB::statement("ALTER TABLE tasks ALTER COLUMN status SET DEFAULT 'todo'");
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('tasks')) {
            return;
        }

        $driver = DB::connection()->getDriverName();

        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE tasks MODIFY status ENUM('todo', 'in_progress', 'done') NOT NULL DEFAULT 'todo'");
        }
    }
};
