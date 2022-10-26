<?php

/**
 * @author Edwin Xu <171336747@qq.com>
 * @version 2022-10-26
 */

declare(strict_types=1);

namespace Edwinhuish\ThinkRbac\Contracts;

use think\model\relation\BelongsToMany;

interface PermissionInterface
{
    /*
     * 和角色表的一个多对多关系
     * */
    public function roles(): BelongsToMany;
}
