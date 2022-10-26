<?php

/**
 * @author Edwin Xu <171336747@qq.com>
 * @version 2022-10-26
 */

declare(strict_types=1);

namespace Edwinhuish\ThinkRbac\Traits;

use think\model\relation\BelongsToMany;

trait PermissionTrait
{
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(config('rbac.role'), config('rbac.permission_role_table'), config('rbac.role_foreign_key'), config('rbac.permission_foreign_key'));
    }
}
