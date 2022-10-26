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
     * @param mixed $role
     *
     * @return $this
     */
    public function attachRole($role);

    /**
     * Attach multiple roles to a user.
     *
     * @param mixed $roles
     *
     * @return $this
     */
    public function attachRoles($roles);

    public function cachedRoles();

    /**
     * Check if user has a permission by its name.
     *
     * @param string|array $permission permission string or array of permissions
     */
    public function can($permission): bool;

    /**
     * Alias to eloquent many-to-many relation's detach() method.
     *
     * @param mixed $role
     *
     * @return $this
     */
    public function detachRole($role);

    /**
     * Detach multiple roles from a user.
     *
     * @param mixed $roles
     *
     * @return $this
     */
    public function detachRoles($roles);

    /**
     * Delete cache roles.
     *
     * @return $this
     */
    public function forgetRoles();

    /**
     * Cache roles.
     */
    public function rememberRoles(): Collection;

    /**
     *  Many-to-Many relations with Role.
     *
     * @return mixed
     */
    public function roles(): BelongsToMany;
}
