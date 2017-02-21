<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>
<?php if (count($hosps) == 0): ?>
    <div class="hosp-item">
        <hr class="hr-10">
        <h4>没有此地区的宠物店信息</h4>
        <p>是宠物店主？&nbsp;&nbsp;&nbsp;<a href="<?= Url::to(['hosp/edit'])?>">添加宠物店信息</a></p>
    </div>
<?php endif;?>
<?php foreach ($hosps as $hosp): ?>
    <div class="hosp-item">
        <hr class="hr-10">
        <a href="<?= Url::to(['hosp/view', 'id' => $hosp['id']])?>"><h4 style="font-size: 1.2em"><i class="fa fa-plus-square" style="color: red;"></i>&nbsp;&nbsp;<?= Html::encode($hosp['hosp_name'])?></h4></a>
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-5">
                <a href="<?= Url::to(['hosp/view', 'id' => $hosp['id']])?>"><img class="img-responsive" src="<?= Html::encode($hosp['label_img'])?>" alt="hosp-img"></a>
            </div>
            <div class="col-lg-6 col-md-5 col-sm-5">
                <p style="margin-top: 10px">
                    <span>地址：</span>&nbsp;&nbsp;<?= Html::encode($hosp['addr'])?>&nbsp;&nbsp;
                </p>
                <hr class="hr-10">
                <p><span>电话：</span>&nbsp;&nbsp;<?= Html::encode($hosp['tel'])?></p>
                <hr class="hr-10">
                <span class="f-left" style="width: 4em;">服务：</span>
                <p class="f-left" style="width: 80%;">
                    <?= Html::encode($hosp['server'])?>
                    ...&nbsp;&nbsp;<a href="<?= Url::to(['hosp/view', 'id' => $hosp['id']])?>" class="btn btn-default btn-xs">了解详情</a>
                </p>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
<?php endforeach;?>
