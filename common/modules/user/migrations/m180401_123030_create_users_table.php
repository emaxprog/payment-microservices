<?php

use chulakov\components\console\Migration;

/**
 * Миграция токенов авторизации.
 * Требуется только при наличии требования к авторизации на нескольких устройствах.
 *
 * ./yii migrate/up --migrationPath='@common/modules/user/migrations'
 */
class m180401_123030_create_users_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'name' => $this->string()->notNull(),
            'auth_key' => $this->string(32), // drop if use user_token table
            'password_hash' => $this->string(),
            'email' => $this->string()->unique(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]); // Set default table options utf-8 InnoDb

        /*
        // Uncomment if use many auth keys
        $this->createTable('{{%user_token}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'token' => $this->string(64)->notNull(),
            'ip_address' => $this->string(16),
            'user_agent' => $this->string(),
            'expired_at' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]); // Set default table options utf-8 InnoDb

        $this->createIndexNamed('{{%user_token}}', 'token', true);

        $this->addForeignKeyNamed(
            '{{%user_token}}', 'user_id',
            '{{%user}}', 'id',
            'CASCADE', 'CASCADE'
        );
        */
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        // $this->dropForeignKeyNamed('{{%user_token}}', 'user_id', '{{%user}}', 'id');
        // $this->dropTable('{{%user_token}}');
        $this->dropTable('{{%user}}');
    }
}
