<?php

/** @var yii\web\View $this */

use app\models\Category;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$this->title = 'О нас';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="wrapper">
        <div>
            <img src="/web/images/loho.png" alt="Логотип">
        </div>
        <div>
            <h3>Девиз компании</h3>
            <p>fqwgojqwhgqkwngqwojgpqwmgqowngqk qpwhgqiwngq qwghwigh qng qw.</p>
        </div>
    </div>

    <h2>Новинки компании</h2>
    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="false">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <?php
            $product = \app\models\Product::find()->limit(5)->all();
            foreach ($product as $item){
                echo "<div class='carousel-item active'>
                    <img src='/web/images/1.jpg' class='d-block w-100' alt='телефон'>
                <div class='carousel-caption d-none d-md-block'>
                    <h5 class='text-black'>$item->name</h5>
                </div>
            </div>";
            }
            ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>
