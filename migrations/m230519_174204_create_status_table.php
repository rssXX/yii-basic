<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%status}}`.
 */
class m230519_174204_create_status_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%status}}', [
            'id' => $this->primaryKey(),
            "code" => $this->string()->unique()->notNull(),
            "name" => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%status}}');
    }
}
