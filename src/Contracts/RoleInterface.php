<?php

/**
 * @author Edwin Xu <171336747@qq.com>
 * @version 2022-10-26
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
     * @param object|array $permission
     *
     * @return $this
     */
    public function attachPermission($permission);

    /**
     * Attach multiple permissions to current role.
     *
     * @param mixed $permissions
     *
     * @return $this
     */
    public function attachPermissions($permissions);

    /**
     * Detach permission form current role.
     *
     * @param object|array $permission
     *
     * @return $this
     */
    public function detachPermission($permission);

    /**
     * Detach multiple permissions from current role.
     *
     * @param mixed $permissions
     *
     * @return $this
     */
    public function detachPermissions($permissions);

    /**
     * Delete cache.
     *
     * @return $this
     */
    public function forgetPermissions();

    /**
     * Many-to-Many relations with Permission.
     */
    public function permissions(): BelongsToMany;

    /**
     * Return cached permissions.
     */
    public function rememberPermissions(): Collection;

    /**
     * Save the inputted permissions.
     *
     * @param mixed $inputPermissions
     *
     * @return $this
     */
    public function savePermissions($inputPermissions);

    /**
     * Many-to-Many relations with the user model.
     */
    public function users(): BelongsToMany;
}
