<?php

use app\models\Cart;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Корзина';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile(
    '@web/js/main.js',
    ['depends' => [\yii\web\JqueryAsset::class]]
);
?>
<div class="cart-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="info alert alert-primary"></div>

    <?php Pjax::begin(['id' => 'cart']) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'product.name',
            'count',
            [
                'label' => "Действия",
                'format' => "raw",
                "value" => function($data){
                    return"<button class='btn btn-success' onclick='addCart($data->product_id)'>+</button> <button class='btn btn-success' onclick='removeCart($data->product_id)'>-</button>";
                }
            ],
        ],
    ]); ?>
    <?php Pjax::end() ?>

    <div class="form-group">
        <label for="inputPassword5" class="from-label">Пароль</label>
        <input type="password" id="inputPassword5" class="form-control" aria-describedby="passwordHelpBlock">
        <div id="passwordHelpBlock" class="form-text">
            Для оформления заказа введите свой пароль
        </div>
        <button onclick='byOrder()' class="btn btn-success">Оформить заказ</button>
    </div>

</div>
