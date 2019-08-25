<?php

use yii\db\Migration;

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
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%payment_order}}');
    }
}
