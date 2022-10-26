<?php

/**
 * @author Edwin Xu <171336747@qq.com>
 * @version 2022-10-26
 */

declare(strict_types=1);

namespace Edwinhuish\ThinkRbac\Models;

use Edwinhuish\ThinkRbac\Contracts\PermissionInterface;
use Edwinhuish\ThinkRbac\Traits\PermissionTrait;
use think\Model;

class Permission extends Model implements PermissionInterface
{
    use PermissionTrait;

    public function __construct()
    {
        $this->table = config('database.prefix') . config('rbac.permissions_table');

        parent::__construct();
    }
}
