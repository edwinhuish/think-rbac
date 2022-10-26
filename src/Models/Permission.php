<?php

/**
 * @author Edwin Xu <171336747@qq.com>
 * @version 2022-10-26
 */

declare(strict_types=1);

namespace Edwinhuish\ThinkRbac\Models;

use Edwinhuish\ThinkRbac\Contracts\RbacPermissionInterface;
use Edwinhuish\ThinkRbac\Traits\RbacPermission as RbacPermissionTraits;
use think\Model;

class Permission extends Model implements RbacPermissionInterface
{
    use RbacPermissionTraits;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table;

    /**
     * Creates a new instance of the model.
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('database.prefix') . config('rbac.permissions_table');
    }
}
