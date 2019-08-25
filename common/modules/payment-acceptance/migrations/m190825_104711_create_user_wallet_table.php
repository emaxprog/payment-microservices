<?php

use chulakov\components\console\Migration;

/**
 * Handles the creation of table `{{%user_wallet}}`.
 */
class m190825_104711_create_user_wallet_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_wallet}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'sum' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->addForeignKeyNamed('{{%user_wallet}}', 'user_id', '{{%user}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_wallet}}');
    }
}
