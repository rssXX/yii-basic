<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order_in_product}}`.
 */
class m230519_175135_create_order_in_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order_in_product}}', [
            'id' => $this->primaryKey(),
            "order_id" => $this->integer()->notNull(),
            "product_id" => $this->integer()->notNull(),
            "count" => $this->integer()->notNull(),
            "cost" => $this->decimal(7, 2)->notNull(),
        ]);

        $this->createIndex(
            'idx-order_in_product-order_id',
            'order_in_product',
            'order_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-order_in_product-order_id',
            'order_in_product',
            'order_id',
            'order',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-order_in_product-product_id',
            'order_in_product',
            'product_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-order_in_product-product_id',
            'order_in_product',
            'product_id',
            'product',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%order_in_product}}');
    }
}
