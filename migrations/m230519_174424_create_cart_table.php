<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cart}}`.
 */
class m230519_174424_create_cart_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%cart}}', [
            'id' => $this->primaryKey(),
            "product_id" => $this->integer()->notNull(),
            "count" => $this->integer()->notNull(),
            "user_id" => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-cart-product_id',
            'cart',
            'product_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-cart-product_id',
            'cart',
            'product_id',
            'product',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-cart-user_id',
            'cart',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-cart-user_id',
            'cart',
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
        $this->dropTable('{{%cart}}');
    }
}
