<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //ROLES
        $admin = Role::create(["name"=> "Administrador"]);
        $editor = Role::create(["name"=> "Editor"]);
        $create = Role::create(["name"=> "Creador"]);

        //PERMISOS PARA DOCUMENTOS
        Permission::create([
            'name'=> 'documentos.index',
            'description'=>'ver listado de documentos'])->syncRoles([$admin,$editor,$create]);
            
        Permission::create([
            'name'=> 'documentos.cerrado',
            'description'=>'ver listado de documentos cerrados'])->assignRole( $admin);
        
        Permission::create([
            'name'=> 'documentos.store',
            'description'=>'crear documentos'])->syncRoles([$admin,$create]);

        Permission::create([
            'name'=> 'documentos.update',
            'description'=>'modificar documentos existentes'])->syncRoles( [$admin,$editor]);

        Permission::create([
            'name'=> 'documentos.estado',
            'description'=>'cambiar estado de documentos'])->syncRoles( [$admin,$editor]);
        
        //PERMISOS PARA ROLES DE USUARIOS
        Permission::create(['name'=>'users.index',
                                        'description'=> 'Ver usuarios'])->assignRole( $admin);
        
        Permission::create(['name'=>'users.edit',
                                        'description'=> 'Editar usuarios'])->assignRole( $admin);

        /*                                
        Permission::create(['name'=>'users.destroy',
                                        'description'=> 'Eliminar usuarios'])->assignRole( $admin);
        */
    }
}
