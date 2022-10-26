<?php

/**
 * @author Edwin Xu <171336747@qq.com>
 * @version 2022-10-26
 */

declare(strict_types=1);

namespace Edwinhuish\ThinkRbac\Contracts;

use think\Collection;
use think\model\relation\BelongsToMany;

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
     * Cache roles.
     */
    public function cachedRoles(): array;

    /**
     * Check if user has a permission by its name.
     *
     * @param string|array $permission permission string or array of permissions
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
     * refresh cache roles.
     *
     * @return $this
     */
    public function refreshRoles();

    /**
     *  Many-to-Many relations with Role.
     *
     * @return mixed
     */
    public function roles(): BelongsToMany;
}
