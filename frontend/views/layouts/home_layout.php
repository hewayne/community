<?php/* @var $this \yii\web\View *//* @var $content string */use yii\helpers\Html;use yii\widgets\Breadcrumbs;use frontend\assets\HomeAsset;use common\widgets\Alert;use yii\helpers\Url;HomeAsset::register($this);?><?php $this->beginPage() ?><!DOCTYPE html><html lang="zh-CN"><head>    <meta charset="<?= Yii::$app->charset ?>">    <meta name="viewport" content="width=device-width, initial-scale=1">    <?= Html::csrfMetaTags() ?>    <title><?= Html::encode($this->title) ?></title>    <?php $this->head() ?>    <style type="text/css">        body{margin:0;}        svg:not(:root){overflow:hidden;}        .container {            overflow: hidden;            width: 100vw;            height: 100vh        }    </style>    <!--[if IE]>    <script src="http://libs.useso.com/js/html5shiv/3.7/html5shiv.min.js"></script>    <![endif]--></head><body><?php $this->beginBody() ?><div class="demo-husky">    <div class="snow"></div>    <div class="container">        <?= $content ?>        <div class="content content--husky">            <div class="mountain"></div>            <div class="mountain"></div>            <div class="husky">                <div class="husky-mane">                    <div class="husky-coat"></div>                </div>                <div class="husky-body">                    <div class="husky-head">                        <div class="husky-ear"></div>                        <div class="husky-ear"></div>                        <div class="husky-face">                            <div class="husky-eye"></div>                            <div class="husky-eye"></div>                            <div class="husky-nose"></div>                            <div class="husky-mouth">                                <div class="husky-lips"></div>                                <div class="husky-tongue"></div>                            </div>                        </div>                    </div>                    <div class="husky-torso"></div>                </div>                <div class="husky-legs">                    <div class="husky-front-legs">                        <div class="husky-leg"></div>                        <div class="husky-leg"></div>                    </div>                    <div class="husky-hind-leg">                    </div>                </div>                <div class="husky-tail">                    <div class="husky-tail">                        <div class="husky-tail">                            <div class="husky-tail">                                <div class="husky-tail">                                    <div class="husky-tail">                                        <div class="husky-tail"></div>                                    </div>                                </div>                            </div>                        </div>                    </div>                </div>            </div>            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" style="display:none">                <defs>                    <filter id="squiggly-0">                        <feTurbulence id="turbulence" baseFrequency="0.02" numOctaves="3" result="noise" seed="0" />                        <feDisplacementMap id="displacement" in="SourceGraphic" in2="noise" scale="2" />                    </filter>                    <filter id="squiggly-1">                        <feTurbulence id="turbulence" baseFrequency="0.02" numOctaves="3" result="noise" seed="1" />                        <feDisplacementMap in="SourceGraphic" in2="noise" scale="3" />                    </filter>                    <filter id="squiggly-2">                        <feTurbulence id="turbulence" baseFrequency="0.02" numOctaves="3" result="noise" seed="2" />                        <feDisplacementMap in="SourceGraphic" in2="noise" scale="2" />                    </filter>                    <filter id="squiggly-3">                        <feTurbulence id="turbulence" baseFrequency="0.02" numOctaves="3" result="noise" seed="3" />                        <feDisplacementMap in="SourceGraphic" in2="noise" scale="3" />                    </filter>                    <filter id="squiggly-4">                        <feTurbulence id="turbulence" baseFrequency="0.02" numOctaves="3" result="noise" seed="4" />                        <feDisplacementMap in="SourceGraphic" in2="noise" scale="1" />                    </filter>                </defs>            </svg>        </div><!-- /content -->    </div><!-- /container --></div><?php $this->endBody() ?></body></html><?php $this->endPage() ?>