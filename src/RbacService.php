<?php

/**
 * @author Edwin Xu <171336747@qq.com>
 * @version 2022-10-26
 */

declare(strict_types=1);

namespace Edwinhuish\ThinkRbac;

use Edwinhuish\ThinkRbac\Command\Publish;
use think\Service;

class RbacService extends Service
{
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/rbac.php', 'rbac');

        $this->commands(['rbac:publish' => Publish::class]);
    }

    public function register()
    {
        // 注册数据迁移服务
        $this->app->register(\think\migration\Service::class);

        $this->app->bind('rbac', function () {
        });
    }

    protected function mergeConfigFrom(string $path, string $key)
    {
        $config = $this->app->config->get($key, []);

        $this->app->config->set(array_merge(require $path, $config), $key);
    }
}
