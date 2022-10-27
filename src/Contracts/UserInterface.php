<?php

/**
 * @author Edwin Xu <171336747@qq.com>
 * @version 2022-10-27
 */

declare(strict_types=1);

namespace Edwinhuish\ThinkRbac\Contracts;

use think\Collection;
use think\model\relation\BelongsToMany;
use think\model\relation\HasManyThrough;

interface UserInterface
{
    /**
     * Alias to eloquent many-to-many relation's attach() method.
     *
     * @param int|string|\think\Model $role
     */
    public function attachRole($role): \think\model\Pivot;

    /**
     * Attach multiple roles to a user.
     *
     * @param int[]|string[]|\think\Model[] $roles
     *
     * @return \think\model\Pivot[]|Collection
     */
    public function attachRoles($roles): Collection;

    /**
     * Check if user has a permission by its name.
     *
     * @param string|string[] $permission permission string or array of permissions
     */
    public function can($permission): bool;

    /**
     * Alias to eloquent many-to-many relation's detach() method.
     *
     * @param int|string|\think\Model $role
     */
    public function detachRole($role): bool;

    /**
     * Detach multiple roles from a user.
     *
     * @param int[]|string[]|\think\Model[] $roles
     */
    public function detachRoles($roles = null): int;

    /**
     * Permission.
     */
    public function permissions(): HasManyThrough;

    /**
     *  Many-to-Many relations with Role.
     */
    public function roles(): BelongsToMany;
}
