<?php

/**
 * @author Edwin Xu <171336747@qq.com>
 * @version 2022-10-26
 */

declare(strict_types=1);

namespace Edwinhuish\ThinkRbac\Models;

use Edwinhuish\ThinkRbac\Contracts\RoleInterface;
use Edwinhuish\ThinkRbac\Traits\RoleTrait;
use think\Model;

class Role extends Model implements RoleInterface
{
    use RoleTrait;

    public function __construct()
    {
        $this->table = config('database.prefix') . config('rbac.roles_table');

        parent::__construct();
    }
}
