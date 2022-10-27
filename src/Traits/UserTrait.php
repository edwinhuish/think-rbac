<?php

/**
 * @author Edwin Xu <171336747@qq.com>
 * @version 2022-10-27
 */

declare(strict_types=1);

namespace Edwinhuish\ThinkRbac\Traits;

use think\Collection;
use think\model\relation\BelongsToMany;
use think\model\relation\HasManyThrough;

trait UserTrait
{
    /**
     * Alias to eloquent many-to-many relation's attach() method.
     *
     * @param int|string|\think\Model $role
     */
    public function attachRole($role): \think\model\Pivot
    {
        return $this->roles()->attach($role);
    }

    /**
     * Attach multiple roles to a user.
     *
     * @param int[]|string[]|\think\Model[] $roles
     *
     * @return \think\model\Pivot[]|Collection
     */
    public function attachRoles($roles): Collection
    {
        $ids = collect($roles)->map(function ($role) {
            if ($role instanceof \think\Model) {
                return $role->getKey();
            }

            return $role;
        })->toArray();

        return collect($this->roles()->attach($ids));
    }

    /**
     * Check if user has a permission by its name.
     *
     * @param string|string[] $permission permission string or array of permissions
     */
    public function can($permission): bool
    {
        if (is_array($permission)) {
            return $this->permissions()->where('name', 'IN', $permission)->count() === count($permission);
        }

        return (bool) $this->permissions()->where('name', $permission)->count();
    }

    /**
     * Alias to eloquent many-to-many relation's detach() method.
     *
     * @param int|string|\think\Model $role
     */
    public function detachRole($role): bool
    {
        return (bool) $this->roles()->detach($role);
    }

    /**
     * Detach multiple roles from a user.
     *
     * @param int[]|string[]|\think\Model[] $roles
     */
    public function detachRoles($roles = null): int
    {
        if (! $roles) {
            $roles = $this->roles()->get();
        }

        $roleIds = collect($roles)->map(function ($role) {
            if ($role instanceof \think\Model) {
                return $role->getKey();
            }

            return $role;
        })->toArray();

        return $this->roles()->detach($roleIds);
    }

    /**
     * Permissions.
     */
    public function permissions(): HasManyThrough
    {
        return $this->hasManyThrough(config('rbac.permission'), config('rbac.role'), config('rbac.user_foreign_key'), config('rbac.role_foreign_key'));
    }

    /**
     * Many-to-Many relations with Role.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(config('database.prefix') . config('rbac.role'), config('database.prefix') . config('rbac.role_user_table'), config('rbac.role_foreign_key'), config('rbac.user_foreign_key'));
    }
}
