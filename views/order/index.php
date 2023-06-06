<?php

use app\models\Order;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Заказы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'data',
            'status.name',
            [
                'label' => 'Количество товара',
                'value' => function($data){
                    return count($data->orderInProducts);
                }
            ],
            [
                'label' => 'Список товаров',
                'format' => 'html',
                'value' => function($data){
                    $res = [];
                    foreach ($data->orderInProducts as $item){
                        $res[] = $item->product->name;
                    }
                    return join('<br>', $res);
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'visibleButtons' => [
                    'delete' => function($model, $key, $index){
                        return $model->status->code == 'new';
                    }
                ]
            ]
        ],
    ]); ?>


</div>
