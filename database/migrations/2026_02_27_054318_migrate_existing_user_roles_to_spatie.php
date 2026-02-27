<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('users', 'role')) {
            return;
        }

        $now = now();

        $superadminRoleId = DB::table('roles')->where('name', 'superadmin')->where('guard_name', 'web')->value('id');
        if (! $superadminRoleId) {
            $superadminRoleId = DB::table('roles')->insertGetId([
                'name' => 'superadmin',
                'guard_name' => 'web',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $userRoleId = DB::table('roles')->where('name', 'user')->where('guard_name', 'web')->value('id');
        if (! $userRoleId) {
            $userRoleId = DB::table('roles')->insertGetId([
                'name' => 'user',
                'guard_name' => 'web',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        DB::table('users')->select('id', 'role')->orderBy('id')->chunk(200, function ($users) use ($superadminRoleId, $userRoleId): void {
            $rows = [];

            foreach ($users as $user) {
                $roleId = $user->role === 'superadmin' ? $superadminRoleId : $userRoleId;

                $rows[] = [
                    'role_id' => $roleId,
                    'model_type' => 'App\\Models\\User',
                    'model_id' => $user->id,
                ];
            }

            DB::table('model_has_roles')->upsert(
                $rows,
                ['role_id', 'model_id', 'model_type'],
                []
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasColumn('users', 'role')) {
            return;
        }

        $superadminRoleId = DB::table('roles')->where('name', 'superadmin')->where('guard_name', 'web')->value('id');

        DB::table('users')->select('id')->orderBy('id')->chunk(200, function ($users) use ($superadminRoleId): void {
            foreach ($users as $user) {
                $hasSuperadmin = DB::table('model_has_roles')
                    ->where('model_type', 'App\\Models\\User')
                    ->where('model_id', $user->id)
                    ->where('role_id', $superadminRoleId)
                    ->exists();

                DB::table('users')
                    ->where('id', $user->id)
                    ->update(['role' => $hasSuperadmin ? 'superadmin' : 'user']);
            }
        });
    }
};
