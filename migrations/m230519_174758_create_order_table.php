<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order}}`.
 */
class m230519_174758_create_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order}}', [
            'id' => $this->primaryKey(),
            "data" => $this->timestamp()->null(),
            "status_id" => $this->integer()->notNull(),
            "user_id" => $this->integer()->notNull(),
            "text" => $this->text()->null(),
        ]);

        $this->createIndex(
            'idx-order-status_id',
            'order',
            'status_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-order-status_id',
            'order',
            'status_id',
            'status',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-order-user_id',
            'order',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-order-user_id',
            'order',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%order}}');
    }
}
