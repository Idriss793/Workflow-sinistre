<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        // Récupérer les ids des rôles existants
        $adminRoleId = DB::table('roles')->where('lib_role', 'administrateur')->value('id');
        $responsableRoleId = DB::table('roles')->where('lib_role', 'responsable')->value('id');
        $expertRoleId = DB::table('roles')->where('lib_role', 'expert')->value('id');
        $gestionnaireRoleId = DB::table('roles')->where('lib_role', 'gestionnaire')->value('id');

        // Compte admin
        DB::table('users')->updateOrInsert(
            ['email' => 'admin@example.test'],
            [
                'name' => 'Admin System',
                'role_id' => $adminRoleId,
                'email_verified_at' => $now,
                'password' => Hash::make('Admin!234'),
                'remember_token' => Str::random(10),
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );

        // Compte responsable
        DB::table('users')->updateOrInsert(
            ['email' => 'responsable@example.test'],
            [
                'name' => 'Responsable',
                'role_id' => $responsableRoleId,
                'email_verified_at' => $now,
                'password' => Hash::make('Resp!234'),
                'remember_token' => Str::random(10),
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );

        // 10 experts
        for ($i = 1; $i <= 10; $i++) {
            DB::table('users')->updateOrInsert(
                ['email' => "expert{$i}@example.test"],
                [
                    'name' => "Expert Auto {$i}",
                    'role_id' => $expertRoleId,
                    'email_verified_at' => $now,
                    'password' => Hash::make('Expert!234'),
                    'remember_token' => Str::random(10),
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }

        // 5 gestionnaires
        for ($i = 1; $i <= 5; $i++) {
            DB::table('users')->updateOrInsert(
                ['email' => "gestionnaire{$i}@example.test"],
                [
                    'name' => "Gestionnaire {$i}",
                    'role_id' => $gestionnaireRoleId,
                    'email_verified_at' => $now,
                    'password' => Hash::make('Gestion!234'),
                    'remember_token' => Str::random(10),
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }
    }
}
