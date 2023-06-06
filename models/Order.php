<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property string $data
 * @property int $status_id
 * @property int $user_id
 * @property string|null $text
 *
 * @property OrderInProduct[] $orderInProducts
 * @property Status $status
 * @property User $user
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['data', 'status_id', 'user_id'], 'required'],
            [['data'], 'safe'],
            [['status_id', 'user_id'], 'integer'],
            [['text'], 'string'],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::class, 'targetAttribute' => ['status_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'data' => 'Data',
            'status_id' => 'Status ID',
            'user_id' => 'User ID',
            'text' => 'Text',
        ];
    }

    /**
     * Gets query for [[OrderInProducts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderInProducts()
    {
        return $this->hasMany(OrderInProduct::class, ['order_id' => 'id']);
    }

    /**
     * Gets query for [[Status]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::class, ['id' => 'status_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
