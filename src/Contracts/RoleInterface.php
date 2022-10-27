<?php

/**
 * @author Edwin Xu <171336747@qq.com>
 * @version 2022-10-27
 */

declare(strict_types=1);

namespace Edwinhuish\ThinkRbac\Contracts;

use think\Collection;
use think\model\relation\BelongsToMany;

interface RoleInterface
{
    /**
     * Attach permission to current role.
     *
     * @param int|string|\think\Model $permission
     *
     * @return \think\model\Pivot
     */
    public function attachPermission($permission);

    /**
     * Attach multiple permissions to current role.
     *
     * @param int[]|string[]|\think\Model[] $permissions
     *
     * @return \think\model\Pivot[]|Collection
     */
    public function attachPermissions($permissions): Collection;

    /**
     * Check if user has a permission by its name.
     *
     * @param string|string[] $permission permission string or array of permissions
     */
    public function can($permission): bool;

    /**
     * Detach permission from current role.
     *
     * @param int|string|\think\Model $permission
     *
     * @return bool result
     */
    public function detachPermission($permission): bool;

    /**
     * Detach multiple permissions from current role.
     *
     * @param int[]|string[]|\think\Models $permissions
     *
     * @return int detach count
     */
    public function detachPermissions($permissions): int;

    /**
     * Many-to-Many relations with Permission.
     */
    public function permissions(): BelongsToMany;

    /**
     * Save the inputted permissions.
     *
     * @param int[]|string[]|\think\Model[] $inputPermissions
     *
     * @return $this
     */
    public function syncPermissions($inputPermissions);

    /**
     * Many-to-Many relations with the user model.
     */
    public function users(): BelongsToMany;
}
