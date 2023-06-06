<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $name
 * @property int $count
 * @property float $cost
 * @property string $data
 * @property string|null $release
 * @property string|null $country
 * @property string|null $model
 * @property string|null $file
 * @property int $category_id
 *
 * @property Cart[] $carts
 * @property Category $category
 * @property OrderInProduct[] $orderInProducts
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'count', 'cost', 'data', 'category_id'], 'required'],
            [['count', 'category_id'], 'integer'],
            [['cost'], 'number'],
            [['data', 'release'], 'safe'],
            [['name', 'country', 'model', 'file'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'count' => 'Количество',
            'cost' => 'Стоимость',
            'data' => 'Дата добавления',
            'release' => 'Дата релиза',
            'country' => 'Страна-производитель',
            'model' => 'Модель',
            'file' => 'Фото',
            'category_id' => 'Category ID',
        ];
    }

    /**
     * Gets query for [[Carts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarts()
    {
        return $this->hasMany(Cart::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[OrderInProducts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderInProducts()
    {
        return $this->hasMany(OrderInProduct::class, ['product_id' => 'id']);
    }
}
