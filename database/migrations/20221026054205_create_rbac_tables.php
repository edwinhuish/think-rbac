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
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        // $table = $this->table('admins');
        // $table->addColumn('name', 'string', ['limit' => 20])
        //     ->addColumn('password', 'string', ['limit' => 40])
        //     ->addColumn('last_login_time', 'datetime')
        //     ->addColumn('created_at', 'datetime')
        //     ->addColumn('updated_at', 'datetime', ['null' => true])
        //     ->addIndex(['name'], ['unique' => true])
        //     ->create();

        $this->createRoleTable();

        $this->createRoleUserTable();

        $this->createPermissionTable();

        $this->createPermissionRoleTable();
    }

    private function createPermissionRoleTable()
    {
        // $table = $this->table('permission_role', ['comment' => '权限角色表']);

        // $table->addColumn('permission_id', 'integer', ['signed' => true])
        //     ->addColumn('role_id', 'integer', ['signed' => true])
        //     ->addForeignKey('permission_id', 'permissions', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
        //     ->addForeignKey('role_id', 'roles', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
        //     ->addIndex(['permission_id', 'role_id'])
        //     ->create();

        $table = $this->table(config('rbac.permission_role_table', 'permission_role'), ['comment' => '权限角色表']);

        $table->addColumn(Column::integer('permission_id')->setUnsigned()->setComment('权限表的ID'));
        $table->addColumn(Column::integer('role_id')->setUnsigned()->setComment('角色表的ID'));

        $table->addForeignKey('permission_id', config('rbac.permissions_table', 'permissions'), 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE']);
        $table->addForeignKey('role_id', config('rbac.roles_table', 'roles'), 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE']);

        $table->addIndex(['permission_id', 'role_id']);

        $table->create();
    }

    private function createPermissionTable()
    {
        // $table = $this->table('permissions', ['comment' => '权限表']);
        // $table->addColumn('name', 'string', ['default' => ''])
        //     ->addColumn('description', 'string', ['null' => true])
        // //    ->addColumn('level_name', 'string', ['default' => '', 'comment' => '级别递归名称'])
        // //    ->addColumn('level_id', 'string', ['default' => '', 'comment' => '级别递归id'])
        // //    ->addColumn('level', 'integer', ['default' => 0, 'comment' => '级别'])
        //     ->addColumn('sort_order', 'integer', ['default' => 0, 'comment' => '排序'])
        //     ->addColumn('display_menu', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'default' => 0])
        //     ->addColumn('parent_id', 'integer', ['default' => 0])
        //     ->addColumn('icon', 'string', ['null' => true, 'comment' => '图标'])
        //     ->addColumn('created_at', 'datetime')
        //     ->addColumn('updated_at', 'datetime')
        //     ->addIndex(['name'], ['unique' => true])
        //     ->addIndex(['parent_id'])
        //     ->create();

        $table = $this->table(config('rbac.permissions_table', 'permissions'), ['comment' => '权限表']);

        $table->addColumn(Column::string('name')->setComment('权限唯一标识'));
        $table->addColumn(Column::string('title')->setDefault('')->setComment('权限中文名称'));
        $table->addColumn(Column::string('description')->setDefault('')->setComment('权限描述'));

        $table->addColumn(Column::integer('sorts')->setDefault(0)->setComment('排序'));

        $table->addTimestamps('created_at', 'updated_at');

        $table->addIndex(['name'], ['unique' => true]);

        $table->create();
    }

    private function createRoleTable()
    {
        $table = $this->table(config('rbac.roles_table', 'roles'), ['comment' => '角色表']);

        $table->addColumn(Column::string('name', 20)->setComment('角色唯一标识'));
        $table->addColumn(Column::string('title')->setDefault('')->setComment('角色中文名称'));
        $table->addColumn(Column::string('description')->setDefault('')->setComment('角色描述'));

        // $table->addColumn(Column::text('abilities')->setNullable()->setComment('角色能力，用 | 分割'));

        $table->addTimestamps('created_at', 'updated_at');

        $table->addIndex(['name'], ['unique' => true]);

        $table->create();
    }

    private function createRoleUserTable()
    {
        $table = $this->table(config('rbac.role_user_table', 'role_user'), ['comment' => '用户角色表']);

        $table->addColumn(Column::bigInteger('user_id')->setUnsigned()->setComment('用户表的ID'));
        $table->addColumn(Column::integer('role_id')->setUnsigned()->setComment('角色表的ID'));

        $table->addForeignKey('user_id', config('rbac.user_table', 'users'), 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE']);
        $table->addForeignKey('role_id', config('rbac.roles_table', 'roles'), 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE']);

        $table->addIndex(['user_id', 'role_id']);

        $table->create();
    }
}
