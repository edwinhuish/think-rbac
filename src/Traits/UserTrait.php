<?php

/**
 * @author Edwin Xu <171336747@qq.com>
 * @version 2022-10-26
 */

declare(strict_types=1);

namespace Edwinhuish\ThinkRbac\Traits;

use think\facade\Cache;

trait UserTrait
{
    /**
     * Alias to eloquent many-to-many relation's attach() method.
     *
     * @param mixed $role
     */
    public function attachRole($role)
    {
        if (is_object($role)) {
            $role = $role->getKey();
        }

        if (is_array($role)) {
            $role = $role['id'];
        }

        $this->roles()->attach($role);
    }

    /**
     * Attach multiple roles to a user.
     *
     * @param mixed $roles
     */
    public function attachRoles($roles)
    {
        foreach ($roles as $role) {
            $this->attachRole($role);
        }
    }

    public function cachedRoles()
    {
        $cacheKey = 'rbac_roles_for_user_' . $this[$this->pk];

        return Cache::remember($cacheKey, function () {
            return $this->roles;
        });
    }

    /**
     * Check if user has a permission by its name.
     *
     * @param string|array $permission permission string or array of permissions
     *
     * @return bool
     */
    public function can($permission)
    {
        foreach ($this->cachedRoles() as $role) {
            foreach ($role->cachedPermissions() as $perm) {
                if ($permission == $perm['name']) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Alias to eloquent many-to-many relation's detach() method.
     *
     * @param mixed $role
     */
    public function detachRole($role)
    {
        if (is_object($role)) {
            $role = $role->getKey();
        }

        if (is_array($role)) {
            $role = $role['id'];
        }

        $this->roles()->detach($role);
    }

    /**
     * Detach multiple roles from a user.
     *
     * @param mixed $roles
     */
    public function detachRoles($roles = null)
    {
        if (! $roles) {
            $roles = $this->roles()->get();
        }

        foreach ($roles as $role) {
            $this->detachRole($role);
        }
    }

    /**
     * Many-to-Many relations with Role.
     *
     * @return mixed
     */
    public function roles()
    {
        return $this->belongsToMany(config('database.prefix') . config('rbac.role'), config('database.prefix') . config('rbac.role_user_table'), config('rbac.role_foreign_key'), config('rbac.user_foreign_key'));
    }
}
