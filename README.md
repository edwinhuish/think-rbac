# Rbac (ThinkPHP 5 Package)

Rbac是向ThinkPHP 5添加基于角色的权限的简洁而灵活的方式。


## Contents
- [安装](#安装)
- [配置](#配置)
    - [用户与角色的关系](#用户与角色的关系)
    - [模型](#模型)
        - [Role](#role)
        - [Permission](#permission)
        - [Admin](#admin)
- [使用](#使用)
    - [概念](#概念)
        - [检查用户是否拥有权限](#检查用户是否拥有权限)
        
- [故障排除](#故障排除)
- [License](#license)
- [Contribution guidelines](#contribution-guidelines)


## 安装

1. 运行 `composer require edwinhuish/think-rbac`

2. 使用 `php think rbac:publish` 在项目内新增 `/config/rbac.php` 以及在 `/database/migrations/` 内新增迁移文件。

3. 配置 `config/rbac.php`，其中 user 表需要自行创建。

4. 运行 `php think migrate:run` 生成数据表。


### 模型

#### Role

使用以下示例在`app\model\Role.php`内创建角色模型：

```php
<?php

namespace app\model;

use Edwinhuish\ThinkRbac\Contracts\RoleInterface;
use Edwinhuish\ThinkRbac\Traits\RoleTrait;
use think\Model;

class Role extends Model implements RoleInterface
{
    use RoleTrait;
}

```

角色模型的主要属性是 `name`
- `name` &mdash; 角色的唯一名称，用于在应用程序层查找角色信息。 例如：“管理员”，“所有者”，“员工”.
- `description` &mdash; 该角色的人类可读名称。 不一定是唯一的和可选的。 例如：“用户管理员”，“项目所有者”，“Widget Co.员工”.

 `description` 字段是可选的; 他的字段在数据库中是可空的。

#### Permission

使用以下示例在`app\model\Permission.php`内创建角色模型：

```php
<?php
namespace app\model;

use Edwinhuish\ThinkRbac\Contracts\PermissionInterface;
use Edwinhuish\ThinkRbac\Traits\PermissionTrait;
use think\Model;

class Permission extends Model implements PermissionInterface
{
    use PermissionTrait;
}

```

“权限”模型与“角色”具有相同的两个属性：
- `name` &mdash; 权限的唯一名称，用于在应用程序层查找权限信息。一般保存的是路由.
- `description` &mdash; 该权限的描述。 例如：“创建文章”，“查看文件”，“文件管理”等权限.

 `description` 字段是可选的; 他的字段在数据库中是可空的。


#### User

接下来，在现有的User模型中使用`UserTrait`特征。 例如：

```php
<?php
namespace app\model;

use Edwinhuish\ThinkRbac\Contracts\UserInterface;
use Edwinhuish\ThinkRbac\Traits\UserTrait;
use think\Model;

class User extends Model implements UserInterface
{
    use UserTrait;
}

```

这将启用与Role的关系，并在User模型中添加以下方法roles（）和 can（$ permission）


不要忘记转储composer的自动加载

```bash
composer dump-autoload
```

**准备好了.**

## 使用

### 概念
让我们从创建以下`角色`和`权限`开始：

```php
$owner = new Role();
$owner->name         = 'owner';
$owner->description  = '网站所有者'; // 可选
$owner->save();

$administrator = new Role();
$administrator->name        = 'administrator';
$administrator->description = '管理员'; // 可选
$administrator->save();
```

接下来，让我们为刚刚创建的两个角色将它们分配给用户。
这很容易：

```php
$hurray = User::where('name', 'hurray')->find();

// 为用户分配角色

$hurray->attachRole($administrator);

//等效于 $admin->roles()->attach($administrator->id);
```

现在我们只需要为这些角色添加权限：

```php
$administrator = Role::where('name', 'administrator')->find();

$owner = Role::where('name', 'owner')->find();

$createPost = new Permission();
$createPost->name         = 'post/create';
// 允许administrator...
$createPost->description  = '创建一篇文章'; // 可选
$createPost->save();

$editPost = new Permission();
$editPost->name         = 'post/edit';
// 允许owner...
$editPost->description  = '编辑一篇文章'; // optional
$editPost->save();

$administrator->attachPermission($createPost);
//等效于  $admin->permissions()->attach($createPost->id);

$owner->attachPermissions([$createPost, $editPost]);
//等效于  $owner->permissions()->attach([$createPost->id, $editPost->id]);
```

#### 检查用户是否拥有权限

现在我们可以通过执行以下操作来检查角色和权限：

```php
$hurray = Admins::where('name', 'hurray')->find();
$hurray->can('post/edit');   // false
$hurray->can('post/create'); // true
```

小提示：本功能在保存用户和角色之间的关系和角色与权限之间的关系，为了避免大量的sql查询是使用了tp的缓存的哦，

如果你更新了他们之间的关系，记得把缓存清理一下。
```php
$hurray->refreshRoles();
```

到目前为止，已经可以很大的满足到后台用户权限管理功能了。

本功能目前比较简单，现在作者正在扩展其他功能.

最后，如果你觉得不错，请start一个吧 你的鼓励是我创作的无限动力.

## 故障排查

如果你迁移和配置中遇到问题，可直接联企鹅号:775893055



## License

Rbac is free software distributed under the terms of the MIT license.

## Contribution guidelines

Support follows PSR-1 and PSR-4 PHP coding standards, and semantic versioning.

Please report any issue you find in the issues page.  
Pull requests are welcome.
