<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="shortcut icon" href="dog.ico">
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <div class="container">

        <!--nav-->
        <div class="row">
            <div class="col-lg-12">
                <div class="top-menu">
                    <div><a id="club" href="<?= Url::to(['club/index'])?>" class="button button-glow button-circle button-action">部落</a></div>
                    <div><a id="book" href="<?= Url::to(['book/index'])?>" class="button button-glow button-circle button-highlight">书籍</a></div>
                    <div><a id="baike" href="<?= Url::to(['baike/index'])?>" class="button button-glow button-circle button-royal">博文</a></div>
                    <div><a id="health" href="<?= Url::to(['baike/health'])?>" class="button button-glow button-circle button-caution">附近</a></div>
                    <div><a id="goods" class="button button-glow button-circle button-primary">商品</a></div>
                    <!--<div><a id="beauty" class="button button-glow button-circle button-royal">商品</a></div>-->
                    <?php if (Yii::$app->user->isGuest): ?>
                        <div><a id="login" href="<?= Url::to(['site/login'])?>" class="button button-glow button-circle button-action">登录</a></div>
                    <?php endif;?>
                    <?php if (!Yii::$app->user->isGuest): ?>
                        <!--<div><a id="user" href="<?/*= Url::to(['user/user-info'])*/?>" class="button button-glow button-circle button-action"><?/*=Yii::$app->user->identity->username*/?></a></div>-->
                        <div><a class="user button button-glow button-circle"><img class="img-circle user-icon" src="<?=Html::encode(Yii::$app->user->identity->avatar)?>" alt="<?=Html::encode(Yii::$app->user->identity->username)?>"></a></div>
                    <?php endif;?>
                </div>
                <div class="clearfix" style="margin-bottom: 20px"></div>

                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>

            </div>
        </div>

        <?= Alert::widget() ?>
        <button id="menu-all" style="position: fixed; right: 3%; bottom: 40px; z-index:30;" class="button button-glow button-circle button-caution">
            <i class="fa fa-navicon"></i>
        </button>
        <div class="menu-list">
            <a id="menu-user" style="position: fixed; right: 3%; bottom: 40px; z-index:20;" class="user button button-glow button-circle button-action">
                <i class="fa fa-user-o"></i>
            </a>

            <a href="<?= Url::to(['baike/index'])?>" id="menu-baike" style="position: fixed; right: 3%; bottom: 40px; z-index:19;" class="button button-glow button-circle button-primary">
                <i class="fa fa-book"></i>
            </a>

<!--            <p id="menu-baike-dis" href="" class="button button-action button-pill" style="position: fixed; right: -150px; bottom: 90px; z-index: 18;">百科</p>
-->
            <a href="<?= Url::to(['club/index'])?>" id="menu-club" style="position: fixed; right: 3%; bottom: 40px; z-index:17;" class="button button-glow button-circle button-action">
                <i class="fa fa-comment-o"></i>
            </a>

<!--            <p id="menu-club-dis" href="" class="button button-action button-pill" style="position: fixed; right: -200px; bottom: 140px; z-index: 16;">聊吧</p>
-->
            <!--<a href="<?/*= Url::to(['hosp/index'])*/?>" id="menu-hosp" style="position: fixed; right: 3%; bottom: 40px; z-index:15;" class="button button-glow button-circle button-caution">
                <i class="fa fa-heart-o"></i>
            </a>-->

<!--            <p id="menu-hosp-dis" href="" class="button button-action button-pill" style="position: fixed; right: -250px; bottom: 190px; z-index: 14;">医院</p>
-->
            <a id="menu-shop" style="position: fixed; right: 3%; bottom: 40px; z-index:13;" class="button button-glow button-circle button-highlight">
                <i class="fa fa-shopping-cart"></i>
            </a>

<!--            <p id="menu-shop-dis" href="" class="button button-action button-pill" style="position: fixed; right: -300px; bottom: 240px; z-index: 12;">商城</p>
-->
            <a href="<?= Url::to(['club/index'])?>" id="menu-home" style="position: fixed; right: 3%; bottom: 40px; z-index:11;" class="button button-glow button-circle button-royal">
                <i class="fa fa-home"></i>
            </a>

<!--            <p id="menu-home-dis" href="" class="button button-action button-pill" style="position: fixed; right: -350px; bottom: 290px; z-index: 10;">首页</p>
-->
        </div>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
