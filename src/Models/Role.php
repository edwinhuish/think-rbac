<?php

/**
 * @author Edwin Xu <171336747@qq.com>
 * @version 2022-10-26
 */

declare(strict_types=1);

namespace Jackchow\Rbac;

use Edwinhuish\ThinkRbac\Contracts\RoleInterface;
use Edwinhuish\ThinkRbac\Traits\RoleTrait;
use think\Model;

class Role extends Model implements RoleInterface
{
    use RoleTrait;
}
