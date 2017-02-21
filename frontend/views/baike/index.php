<?php
use yii\helpers\Url;
use yii\helpers\Html;
$this->title = '狗狗博文';
?>
<div class="row">
    <div class="col-lg-8">

        <div class="baike-box">
            <img class="img-responsive" src="http://oj8hunqbx.bkt.clouddn.com/baike/top/baike-top-img.jpg" alt="baike-top-img">
            <p class="baike-title">狗狗博文</p>

            <div class="baike-nav">
                <!-- 选项卡组件（菜单项nav-tabs）-->
                <ul id="baikeTab" class="nav nav-tabs" role="tablist">
                    <li class="active"><a href="#baike-all" role="tab" data-toggle="tab">全部</a></li>
                    <li><a href="<?= Url::to(['baike/edit'])?>" target="_blank" role="tab" style="cursor: pointer"><i class="fa fa-edit"></i>&nbsp;&nbsp;&nbsp;写写</a></li>
                    <li><a href="#baike-search" role="tab" data-toggle="tab"><i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;搜索</a></li>
                </ul>
                <!-- 选项卡面板 -->
                <div id="baikeTabContent" class="tab-content">
                    <!--baike-all(全部)选项卡-->
                    <div class="tab-pane fade in active" id="baike-all">

                        <?= \frontend\widgets\baike\BaikeWidget::widget([
                            'pageSize' => 5,
                            'condition' => ['is_valid' => 1]
                        ])?>
                    </div>

                    <!--baike-search(搜索)选项卡-->
                    <div class="tab-pane fade in" id="baike-search">
                        <div class="input-group baike-search-box">
                            <input type="text" class="form-control" placeholder="犬种、狗狗医护、美容、训练•••">
                            <span class="input-group-btn"><button class="btn btn-default baike-search-btn" type="button">Go!</button></span>
                        </div>
                        <hr class="hr-10">

                </div>

                </div>
            </div>

        </div>
    </div>
    <div class="col-lg-4">

    </div>
</div>


