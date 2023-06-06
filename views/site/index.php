<?php

use app\models\Category;

use yii\grid\GridView;
use yii\widgets\Pjax;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Каталог товаров';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile(
    '@web/js/main.js',
    ['depends' => [\yii\web\JqueryAsset::class]]
);
?>
<div class="cart-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="info alert alert-primary"></div>

    <?php
    $category = ArrayHelper::map(Category::find()->asArray()->all(), 'id', 'name');
    echo Html::dropDownList('list', null, $category, [
        'prompt' => 'выберите категорию',
        'class' => 'form-select',
        'onchange' => 'getProduct(this.options[this.selectedIndex].value)',
    ])
    ?>

    <?php Pjax::begin(['id' => 'cart']) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'data',
            'name',
            'cost',
            'count',
            [
                'label' => 'Фотография',
                'format' => 'html',
                'value' => function($data){
                    return Html::img('@web'.$data->file, ['alt' => 'Избражение отсутсвует', 'width' => 200]);
                }
            ],
            [
                'label' => 'Добавить в корзину',
                'format' => 'raw',
                'value' => function($data){
                    return "<button onclick='addCart($data->id)' class='btn btn-success'>Добавить</button>";
                },
                'visible' => Yii::$app->user->identity,
            ],
        ],
    ]); ?>
    <?php Pjax::end() ?>
</div>
