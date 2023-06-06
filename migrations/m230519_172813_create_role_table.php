<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%role}}`.
 */
class m230519_172813_create_role_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%role}}', [
            'id' => $this->primaryKey(),
            "code" => $this->string()->unique()->notNull(),
            "name" => $this->string()->notNull(),
        ]);

        $this->insert("{{%role}}", [
            "code" => "User",
            "name" => "Пользователь",
        ]);

        $this->insert("{{%role}}", [
            "code" => "Admin",
            "name" => "Администратор",
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%role}}');
    }
}
