<?php

/**
 * @author Edwin Xu <171336747@qq.com>
 * @version 2022-10-26
 */

declare(strict_types=1);

namespace Edwinhuish\ThinkRbac\Contracts;

use think\model\relation\BelongsToMany;

interface RoleInterface
{
    /**
     * Attach permission to current role.
     *
     * @param object|array $permission
     *
     * @return static
     */
    public function attachPermission($permission);

    public function permissions(): BelongsToMany;

    public function removePermission(int $permissionId): static;

    public function users():BelongsToMany;
}
