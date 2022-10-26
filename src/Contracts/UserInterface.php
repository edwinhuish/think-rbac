<?php

/**
 * @author Edwin Xu <171336747@qq.com>
 * @version 2022-10-26
 */

declare(strict_types=1);

namespace Edwinhuish\ThinkRbac\Contracts;

interface UserInterface
{
    /**
     * Alias to eloquent many-to-many relation's attach() method.
     *
     * @param mixed $role
     */
    public function attachRole($role);

    /**
     * Attach multiple roles to a user.
     *
     * @param mixed $roles
     */
    public function attachRoles($roles);

    /**
     * Alias to eloquent many-to-many relation's detach() method.
     *
     * @param mixed $role
     */
    public function detachRole($role);

    /**
     * Detach multiple roles from a user.
     *
     * @param mixed $roles
     */
    public function detachRoles($roles);

    /**
     *  Many-to-Many relations with Role.
     *
     * @return mixed
     */
    public function roles();
}
