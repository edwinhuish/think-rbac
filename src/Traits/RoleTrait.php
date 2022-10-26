<?php

/**
 * @author Edwin Xu <171336747@qq.com>
 * @version 2022-10-26
 */

declare(strict_types=1);

namespace Edwinhuish\ThinkRbac\Traits;

use think\Collection;
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
     * @return $this
     */
    public function attachPermission($permission)
    {
        if (is_object($permission)) {
            $permission = $permission->getKey();
        }

        if (is_array($permission)) {
            $permission = $permission['id'];
        }

        $this->permissions()->attach($permission);

        $this->forgetPermissions();

        return $this;
    }

    /**
     * Attach multiple permissions to current role.
     *
     * @param mixed $permissions
     *
     * @return $this
     */
    public function attachPermissions($permissions)
    {
        foreach ($permissions as $permission) {
            $this->attachPermission($permission);
        }

        return $this;
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

        $this->permissions()->detach($permission);
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

    /**
     * Delete cache.
     *
     * @return $this
     */
    public function forgetPermissions()
    {
        Cache::delete($this->getCacheKey());

        return $this;
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(config('rbac.permission'), config('rbac.permission_role_table'), config('rbac.permission_foreign_key'), config('rbac.role_foreign_key'));
    }

    /**
     * Return cached permissions.
     */
    public function rememberPermissions(): Collection
    {
        return Cache::remember($this->getCacheKey(), function () {
            return $this->permissions;
        });
    }

    /**
     * Save the inputted permissions.
     *
     * @param mixed $inputPermissions
     *
     * @return void
     */
    public function savePermissions($inputPermissions)
    {
        if (! empty($inputPermissions)) {
            $this->permissions()->sync($inputPermissions);
        } else {
            $this->permissions()->detach();
        }
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(config('rbac.user'), config('rbac.role_user_table'), config('rbac.user_foreign_key'), config('rbac.role_foreign_key'));
    }

    private function getCacheKey()
    {
        return 'rbac_permissions_for_role_' . $this->getKey();
    }
}
