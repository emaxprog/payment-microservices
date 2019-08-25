<?php

use common\helpers\Password;
use yii\db\Migration;

/**
 * Class m190825_144018_fill_user
 */
class m190825_144018_fill_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $time = time();
        for ($i = 0; $i < 20; $i++) {
            $this->insert('{{%user}}', [
                'username' => 'username' . $i,
                'name' => 'User' . $i,
                'email' => 'user' . $i . '@mail.ru',
                'password_hash' => Password::generate(6),
                'created_at' => $time,
                'updated_at' => $time
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->truncateTable('{{%user}}');
    }
}
