<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        $roles = [
            [
                'lib_role' => 'administrateur',
                'description_role' => 'Gestion complète du système (utilisateurs, paramètres, etc.)',
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'lib_role' => 'responsable',
                'description_role' => 'Valide les rapports et supervise les experts',
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'lib_role' => 'expert',
                'description_role' => 'Réalise les expertises et envoie les rapports',
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'lib_role' => 'gestionnaire',
                'description_role' => 'Gestion administrative des sinistres',
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // Utilise updateOrInsert pour éviter les doublons si tu relances le seeder
        foreach ($roles as $r) {
            DB::table('roles')->updateOrInsert(
                ['lib_role' => $r['lib_role']], // clé unique sur laquelle on compare
                $r // valeurs à insérer / mettre à jour
            );
        }
    }
}
