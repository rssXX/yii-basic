<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product}}`.
 */
class m230519_173406_create_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
            "name" => $this->string()->notNull(),
            "count" => $this->integer()->notNull(),
            "cost" => $this->decimal(7, 2)->notNull(),
            "data" => $this->timestamp()->notNull(),
            "release" => $this->date()->null(),
            "country" => $this->string()->null(),
            "model" => $this->string()->null(),
            'file' => $this->string()->null(),
            "category_id" => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-product-category_id',
            'product',
            'category_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-product-category_id',
            'product',
            'category_id',
            'category',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product}}');
    }
}
