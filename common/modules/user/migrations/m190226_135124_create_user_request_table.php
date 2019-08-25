<?php

use chulakov\components\console\Migration;


/**
 * Handles the creation of table `{{%user_request}}`.
 */
class m190226_135124_create_user_request_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_request}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'type' => $this->string(16)->notNull(),
            'token' => $this->string()->notNull()->unique(),
            'expired_at' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->addForeignKeyNamed(
            '{{%user_request}}', 'user_id',
            '{{%user}}', 'id',
            'CASCADE', 'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_request}}');
    }
}
