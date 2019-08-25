<?php

use chulakov\components\console\Migration;

/**
 * Handles the creation of table `{{%payment}}`.
 */
class m190825_104618_create_payment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%payment}}', [
            'id' => $this->primaryKey(),
            'sum' => $this->bigInteger()->notNull(),
            'commission' => $this->float()->notNull(),
            'order_number' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->addForeignKeyNamed('{{%payment}}', 'order_number', '{{%user}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%payment}}');
    }
}
