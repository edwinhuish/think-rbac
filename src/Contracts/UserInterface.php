<?php

/**
 * @author Edwin Xu <171336747@qq.com>
 * @version 2022-10-26
 */

declare(strict_types=1);

namespace Edwinhuish\ThinkRbac\Contracts;

use think\model\relation\BelongsToMany;

interface UserInterface
{

    public function addRole(int $roleId): static;

    public function removeRole(int $roleId): static;

    public function roles():BelongsToMany;

    public function can(string $permission_name):bool;
}
