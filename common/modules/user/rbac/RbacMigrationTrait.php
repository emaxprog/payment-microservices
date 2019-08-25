<?php
/**
 * Файл класса RbacMigrationTrait
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\user\rbac;

use yii\db\Migration;
use yii\rbac\BaseManager;
use yii\rbac\Permission;
use yii\rbac\Role;
use yii\rbac\Rule;

/**
 * Трейт конфигурации RBAC для пользователя через миграции.
 *
 * @mixin Migration
 */
trait RbacMigrationTrait
{
    /**
     * @var BaseManager
     */
    protected $authManager;

    /**
     * Получение роли
     *
     * @param string $name
     * @return Role
     */
    protected function getRole($name)
    {
        return $this->authManager->getRole($name);
    }

    /**
     * Создание роли
     *
     * @param string $name
     * @param string $description
     * @param string|Rule $ruleName
     * @param mixed $data
     * @return Role
     * @throws \Exception
     */
    protected function makeRole($name, $description = null, $ruleName = null, $data = null)
    {
        $role = $this->authManager->createRole($name);

        $role->data = $data;
        $role->description = $description;
        if ($ruleName) {
            if ($ruleName instanceof Rule) {
                $ruleName = $ruleName->name;
            }
            $role->ruleName = $ruleName;
        }

        $this->authManager->add($role);
        return $role;
    }

    /**
     * Назначение роли Пользователю
     *
     * @param integer $id
     * @param Role $role
     * @throws \Exception
     */
    protected function assignRole($id, $role)
    {
        $this->authManager->assign($role, $id);
    }

    /**
     * Снятие роли с пользователя
     *
     * @param integer $id
     * @param Role $role
     */
    protected function revokeRole($id, $role)
    {
        $this->authManager->revoke($role, $id);
    }

    /**
     * Получение разрешения
     *
     * @param string $name
     * @return Permission
     */
    protected function getPermission($name)
    {
        return $this->authManager->getPermission($name);
    }

    /**
     * Создание разрешения
     *
     * @param string $name
     * @param string $description
     * @param string|Rule $ruleName
     * @param mixed $data
     * @return Permission
     * @throws \Exception
     */
    protected function makePermission($name, $description = null, $ruleName = null, $data = null)
    {
        $permission = $this->authManager->createPermission($name);

        $permission->data = $data;
        $permission->description = $description;
        if ($ruleName) {
            if ($ruleName instanceof Rule) {
                $ruleName = $ruleName->name;
            }
            $permission->ruleName = $ruleName;
        }

        $this->authManager->add($permission);
        return $permission;
    }

    /**
     * Назначение разрешений к ролям
     *
     * @param Role $role
     * @param Permission|Role $permission
     * @throws \Exception
     */
    protected function assignPermission($role, $permission)
    {
        $this->authManager->addChild($role, $permission);
    }

    /**
     * Снятие разрешения
     *
     * @param Role $role
     * @param Permission $permission
     */
    protected function revokePermission($role, $permission)
    {
        $this->authManager->removeChild($role, $permission);
    }

    /**
     * Добавление правила проверки
     *
     * @param string $name
     * @param Rule $rule
     * @return Rule
     * @throws \Exception
     */
    protected function makeRule($name, Rule $rule)
    {
        $rule->name = $name;
        $this->authManager->add($rule);
        return $rule;
    }
}
