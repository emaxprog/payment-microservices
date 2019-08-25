<?php

use chulakov\components\console\Migration;

/**
 * Handles the creation of table `{{%payment_order}}`.
 */
class m190825_104648_create_payment_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%payment_order}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'sum' => $this->bigInteger(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->addForeignKeyNamed('{{%payment_order}}', 'user_id', '{{%user}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%payment_order}}');
    }
}
