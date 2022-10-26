<?php

/**
 * @author Edwin Xu <171336747@qq.com>
 * @version 2022-10-26
 */

declare(strict_types=1);

namespace Edwinhuish\ThinkRbac\Traits;

use think\Collection;
use think\model\relation\BelongsToMany;

trait RoleTrait
{
    /**
     * Attach permission to current role.
     *
     * @param int|string|\think\Model $permission
     */
    public function attachPermission($permission): \think\model\Pivot
    {
        return $this->permissions()->attach($permission);
    }

    /**
     * Attach multiple permissions to current role.
     *
     * @param int[]|string[]|\think\Model[] $permissions
     *
     * @return \think\model\Pivot[]|Collection
     */
    public function attachPermissions($permissions): Collection
    {
        $permIds = collect($permissions)->map(function ($perm) {
            if ($perm instanceof \think\Model) {
                return $perm->getKey();
            }

            return $perm;
        })->toArray();

        return collect($this->permissions()->attach($permIds));
    }

    /**
     * Detach permission from current role.
     *
     * @param int|string|\think\Model $permission
     *
     * @return bool result
     */
    public function detachPermission($permission): bool
    {
        $deleted = $this->permissions()->detach($permission);

        return (bool) $deleted;
    }

    /**
     * Detach multiple permissions from current role.
     *
     * @param int[]|string[]|\think\Models $permissions
     *
     * @return int detach count
     */
    public function detachPermissions($permissions): int
    {
        $permIds = collect($permissions)->map(function ($perm) {
            if ($perm instanceof \think\Model) {
                return $perm->getKey();
            }

            return $perm;
        })->toArray();

        return $this->permissions()->detach($permIds);
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(config('rbac.permission'), config('rbac.permission_role_table'), config('rbac.permission_foreign_key'), config('rbac.role_foreign_key'));
    }

    /**
     * Save the inputted permissions.
     *
     * @param int[]|string[]|\think\Model[] $inputPermissions
     *
     * @return $this
     */
    public function syncPermissions($inputPermissions)
    {
        if (! empty($inputPermissions)) {
            $permIds = collect($inputPermissions)->map(function ($perm) {
                if ($perm instanceof \think\Model) {
                    return $perm->getKey();
                }

                return $perm;
            })->toArray();
            $this->permissions()->sync($permIds);
        } else {
            $this->permissions()->detach();
        }

        return $this;
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(config('rbac.user'), config('rbac.role_user_table'), config('rbac.user_foreign_key'), config('rbac.role_foreign_key'));
    }
}
