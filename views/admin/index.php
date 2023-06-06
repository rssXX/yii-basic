<?php

use app\models\Cart;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var $searchModel */

$this->title = 'Заказы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'data',
            [
                'label' => 'Статус',
                'attribute' => 'status_id',
                'filter' => \yii\helpers\ArrayHelper::map(\app\models\Status::find()->asArray()->all(), 'id', 'name'),
                'value' => 'status.name'
            ],
            [
                'label' => 'Количество товаров',
                'value' => function($data){
                    return count($data->orderInProducts);
                }
            ],
            [
                'label' => 'ФИО Заказчика',
                'value' => function($data){
                    return $data->user->name . ' ' . $data->user->surname . ' ' . $data->user->patronymic;
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
                'visibleButtons' => [
                    'update' => function ($model, $key, $index){
                        return $model->status->code == 'new';
                    },
                ]
            ],
        ],
    ]); ?>


</div>