<?php

/**
 * @author Edwin Xu <171336747@qq.com>
 * @version 2022-10-26
 */

declare(strict_types=1);

namespace Edwinhuish\ThinkRbac\Models;

use Edwinhuish\ThinkRbac\Contracts\UserInterface;
use Edwinhuish\ThinkRbac\Traits\UserTrait;
use think\Model;

class User extends Model implements UserInterface
{
    use UserTrait;
}
