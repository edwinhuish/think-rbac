<?php

/**
 * @author Edwin Xu <171336747@qq.com>
 * @version 2022-10-26
 */

declare(strict_types=1);

namespace Edwinhuish\ThinkRbac\Traits;

use think\facade\Cache;
use think\model\relation\BelongsToMany;

trait RoleTrait
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = config('database.prefix') . config('rbac.roles_table');

    /**
     * Attach permission to current role.
     *
     * @param object|array $permission
     *
     * @return void
     */
    public function attachPermission($permission)
    {
        if (is_object($permission)) {
            $permission = $permission->getKey();
        }

        if (is_array($permission)) {
            $permission = $permission['id'];
        }

        $this->perms()->attach($permission);
    }

    /**
     * Attach multiple permissions to current role.
     *
     * @param mixed $permissions
     *
     * @return void
     */
    public function attachPermissions($permissions)
    {
        foreach ($permissions as $permission) {
            $this->attachPermission($permission);
        }
    }

    public function cachedPermissions()
    {
        $cacheKey = 'rbac_permissions_for_role_' . $this[$this->pk];

        return Cache::remember($cacheKey, function () {
            return $this->perms;
        });
    }

    /**
     * Detach permission from current role.
     *
     * @param object|array $permission
     *
     * @return void
     */
    public function detachPermission($permission)
    {
        if (is_object($permission)) {
            $permission = $permission->getKey();
        }

        if (is_array($permission)) {
            $permission = $permission['id'];
        }

        $this->perms()->detach($permission);
    }

    /**
     * Detach multiple permissions from current role.
     *
     * @param mixed $permissions
     *
     * @return void
     */
    public function detachPermissions($permissions)
    {
        foreach ($permissions as $permission) {
            $this->detachPermission($permission);
        }
    }

    public function perms(): BelongsToMany
    {
        return $this->belongsToMany(config('rbac.permission'), config('rbac.permission_role_table'), config('rbac.permission_foreign_key'), config('rbac.role_foreign_key'));
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(config('rbac.user'), config('rbac.role_user_table'), config('rbac.user_foreign_key'), config('rbac.role_foreign_key'));
    }
}
