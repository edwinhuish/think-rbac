<?php

/**
 * @author Edwin Xu <171336747@qq.com>
 * @version 2022-10-26
 */

declare(strict_types=1);

use think\migration\db\Column;
use think\migration\Migrator;

class CreateRbacTables extends Migrator
{
    public function down()
    {
        $this->table(config('rbac.roles_table', 'roles'))->drop();
        $this->table(config('rbac.role_user_table', 'role_user'))->drop();
        $this->table(config('rbac.permissions_table', 'permissions'))->drop();
        $this->table(config('rbac.permission_role_table', 'permission_role'))->drop();
    }

    public function up()
    {
        $this->createRoleTable();

        $this->createRoleUserTable();

        $this->createPermissionTable();

        $this->createPermissionRoleTable();
    }

    private function createPermissionRoleTable()
    {
        $table = $this->table(config('rbac.permission_role_table', 'permission_role'), ['comment' => '权限角色表']);

        $table->addColumn(Column::integer('permission_id')->setUnsigned()->setComment('权限表的ID'));
        $table->addColumn(Column::integer('role_id')->setUnsigned()->setComment('角色表的ID'));

        $table->addIndex(['permission_id', 'role_id']);

        $table->create();
    }

    private function createPermissionTable()
    {
        $table = $this->table(config('rbac.permissions_table', 'permissions'), ['comment' => '权限表']);

        $table->addColumn(Column::string('name')->setComment('权限唯一标识'));
        $table->addColumn(Column::string('title')->setDefault('')->setComment('权限中文名称'));
        $table->addColumn(Column::string('description')->setDefault('')->setComment('权限描述'));

        $table->addColumn(Column::integer('sorts')->setDefault(0)->setComment('排序'));

        $table->addTimestamps();

        $table->addIndex(['name'], ['unique' => true]);

        $table->create();
    }

    private function createRoleTable()
    {
        $table = $this->table(config('rbac.roles_table', 'roles'), ['comment' => '角色表']);

        $table->addColumn(Column::string('name', 20)->setComment('角色唯一标识'));
        $table->addColumn(Column::string('title')->setDefault('')->setComment('角色中文名称'));
        $table->addColumn(Column::string('description')->setDefault('')->setComment('角色描述'));

        $table->addTimestamps();

        $table->addIndex(['name'], ['unique' => true]);

        $table->create();
    }

    private function createRoleUserTable()
    {
        $table = $this->table(config('rbac.role_user_table', 'role_user'), ['comment' => '用户角色表']);

        $table->addColumn(Column::bigInteger('user_id')->setUnsigned()->setComment('用户表的ID'));
        $table->addColumn(Column::integer('role_id')->setUnsigned()->setComment('角色表的ID'));

        $table->addIndex(['user_id', 'role_id']);

        $table->create();
    }
}
