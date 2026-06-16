<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username', 32)->nullable()->unique()->after('name');
        });

        DB::table('users')
            ->orderBy('id')
            ->get(['id', 'name', 'email'])
            ->each(function ($user): void {
                $base = Str::of($user->name ?: Str::before($user->email, '@'))
                    ->ascii()
                    ->lower()
                    ->replaceMatches('/[^a-z0-9_]+/', '_')
                    ->trim('_')
                    ->limit(20, '')
                    ->value();

                $base = $base !== '' ? $base : 'user';
                $username = $base;
                $suffix = 1;

                while (DB::table('users')
                    ->where('username', $username)
                    ->where('id', '!=', $user->id)
                    ->exists()) {
                    $username = $base.'_'.$suffix;
                    $suffix++;
                }

                DB::table('users')
                    ->where('id', $user->id)
                    ->update(['username' => $username]);
            });

        // New registrations require username at validation level. Existing rows are filled above.
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['username']);
            $table->dropColumn('username');
        });
    }
};
