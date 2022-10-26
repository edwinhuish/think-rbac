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

trait UserTrait
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = config('database.prefix') . config('rbac.user_table');

    /**
     * Alias to eloquent many-to-many relation's attach() method.
     *
     * @param mixed $role
     *
     * @return $this
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

        $this->forgetRoles();

        return $this;
    }

    /**
     * Attach multiple roles to a user.
     *
     * @param mixed $roles
     *
     * @return $this
     */
    public function attachRoles($roles)
    {
        foreach ($roles as $role) {
            $this->attachRole($role);
        }

        return $this;
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
        foreach ($this->rememberRoles() as $role) {
            foreach ($role->rememberPermissions() as $perm) {
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
     *
     * @return $this
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

        return $this;
    }

    /**
     * Detach multiple roles from a user.
     *
     * @param mixed $roles
     *
     * @return $this
     */
    public function detachRoles($roles = null)
    {
        if (! $roles) {
            $roles = $this->roles()->get();
        }

        foreach ($roles as $role) {
            $this->detachRole($role);
        }

        return $this;
    }

    /**
     * Delete cache roles.
     *
     * @return $this
     */
    public function forgetRoles()
    {
        Cache::delete($this->getCacheKey());

        return $this;
    }

    /**
     * Cache roles.
     */
    public function rememberRoles(): Collection
    {
        return Cache::remember($this->getCacheKey(), function () {
            return $this->roles;
        });
    }

    /**
     * Many-to-Many relations with Role.
     *
     * @return mixed
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(config('database.prefix') . config('rbac.role'), config('database.prefix') . config('rbac.role_user_table'), config('rbac.role_foreign_key'), config('rbac.user_foreign_key'));
    }

    private function getCacheKey(): string
    {
        return 'rbac_roles_for_user_' . $this->getKey();
    }
}
