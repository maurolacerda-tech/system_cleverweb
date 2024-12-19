<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $listArray = [
            ['name' => 'manager_system_show_users', 'label' => 'Permissão para Visualizar Colaboradores', 'group_name' => 'system'],
            ['name' => 'manager_system_add_users', 'label' => 'Permissão para Adicionar Colaboradores', 'group_name' => 'system'],
            ['name' => 'manager_system_edit_users', 'label' => 'Permissão para Editar Colaboradores', 'group_name' => 'system'],

            ['name' => 'manager_system_permission', 'label' => 'Gerenciar Permissões', 'group_name' => 'system'],

            ['name' => 'manager_system_show_roles', 'label' => 'Permissão para Visualizar Grupos de Trabalho', 'group_name' => 'system'],
            ['name' => 'manager_system_add_roles', 'label' => 'Permissão para Adicionar Grupos de Trabalho', 'group_name' => 'system'],
            ['name' => 'manager_system_edit_roles', 'label' => 'Permissão para Editar Grupos de Trabalho', 'group_name' => 'system'],

            ['name' => 'manager_system_settings', 'label' => 'Gerenciar Configurações', 'group_name' => 'system'],
            ['name' => 'manager_system_integrations', 'label' => 'Gerenciar Integrações', 'group_name' => 'system'],
            ['name' => 'view_system_logs', 'label' => 'Visualizar Logs', 'group_name' => 'system']
        ];

        Permission::insert($listArray);
    }
}