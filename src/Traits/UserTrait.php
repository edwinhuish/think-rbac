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
     * Cache roles.
     */
    public function cachedRoles(): array
    {
        return Cache::remember($this->getCacheKey(), function () {
            return $this->roles()->with('permissions')->select()->toArray();
        });
    }

    /**
     * Check if user has a permission by its name.
     *
     * @param string|array $permission permission string or array of permissions
     */
    public function can($permission): bool
    {
        foreach ($this->cachedRoles() as $role) {
            foreach ($role->permissions as $perm) {
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
     * refresh cache roles.
     *
     * @return $this
     */
    public function refreshRoles()
    {
        Cache::delete($this->getCacheKey());

        return $this;
    }

    /**
     * Many-to-Many relations with Role.
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
