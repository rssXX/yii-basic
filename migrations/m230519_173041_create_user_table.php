<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m230519_173041_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            "name" => $this->string()->notNull(),
            "surname" => $this->string()->notNull(),
            "patronymic" => $this->string()->null(),
            "username" => $this->string()->unique()->notNull(),
            "email" => $this->string()->unique()->notNull(),
            "password" => $this->string()->notNull(),
            "role_id" => $this->integer()->notNull()->defaultValue(1),
        ]);

        $this->createIndex(
            'idx-user-role_id',
            'user',
            'role_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-user-role_id',
            'user',
            'role_id',
            'role',
            'id',
            'CASCADE'
        );

        $this->insert('{{%user}}', [
            "name" => "Кирилл",
            "surname" => "Романов",
            "username" => "admin00",
            "email" => "admin@yandex.ru",
            "password" => md5("rootroot"),
            "role_id" => 2,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
