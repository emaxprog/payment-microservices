<?php

use chulakov\components\console\Migration;
use common\modules\user\rbac\RbacMigrationTrait;

/**
 * Class m190304_084227_init_rbac_roles
 */
class m190304_084227_init_rbac_roles extends Migration
{
    use RbacMigrationTrait;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->authManager = Yii::$app->authManager;
    }

    /**
     * @throws Exception
     */
    public function safeUp()
    {
        // System roles
        $admin = $this->makeRole('admin', 'System admin role');
        $user  = $this->makeRole('user',  'System user role');

        // $authorRule = $this->makeRule('authorEdit', new \common\modules\user\rbac\AuthorRule());
        // $authorPermission = $this->makePermission('authorEditPost', 'Can edit own created post', $authorRule);

        // User management permission
        $userViewPermission   = $this->makePermission('userView',   'Can view users');
        $userCreatePermission = $this->makePermission('userCreate', 'Can create new users');
        $userUpdatePermission = $this->makePermission('userUpdate', 'Can update users');
        $userDeletePermission = $this->makePermission('userDelete', 'Can delete users');

        // User profile management
        $profileUpdatePermission = $this->makePermission('profileUpdate', 'Can update own profile');

        // Dashboard
        $dashboardPermission = $this->makePermission('dashboard', 'Can view dashboard information');

        // Assign roles and permissions
        $this->assignPermission($admin, $user);

        $this->assignPermission($user, $profileUpdatePermission);

        $this->assignPermission($admin, $userViewPermission);
        $this->assignPermission($admin, $userCreatePermission);
        $this->assignPermission($admin, $userUpdatePermission);
        $this->assignPermission($admin, $userDeletePermission);

        $this->assignPermission($admin, $dashboardPermission);
        // $this->assignPermission($user, $authorPermission);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->authManager->removeAll();
    }
}
