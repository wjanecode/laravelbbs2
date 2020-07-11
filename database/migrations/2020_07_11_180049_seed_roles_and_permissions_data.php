<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;


class SeedRolesAndPermissionsData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //需清理缓存,否则会报错
        app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        //插入权限
        Permission::create(['name'=>'manage_contents']);
        Permission::create(['name'=>'manage_users']);

        //插入角色
        $master = Role::create(['name'=>'master']);
        $admin = Role::create(['name'=>'admin']);

        //给站长赋权限
        $master->givePermissionTo('manage_contents','manage_users');

        //给管理员赋权限
        $admin->givePermissionTo('manage_contents');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        //需清理缓存,否则会报错
        app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        //清空数据表
        //

    }
}
