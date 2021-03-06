<?php
$this->title = '宠物店';
?>
<div class="row">
    <div class="col-lg-8">

        <div class="health-box">
            <!--显示一条宠物医院-begin-->
            <div class="hosp-box" style="margin: 10px;">
                <h4 class="f-left">您身边的宠物店</h4>
                <button type="button" class="btn btn-default btn-sm f-right create-hosp-btn margin-v-10">添加宠物店信息</button>
                <div class="clearfix"></div>

                <!--搜索宠物店-->
                <div>
                    <div data-toggle="distpicker" class="row addr-picker">
                        <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-3">
                            <label class="sr-only" for="province">Province</label>
                            <select onchange="getCitys()" class="form-control" id="province" name="HospForm[province_id]">
                                <option>---省---</option>
                                <?php foreach ($provinces as $province): ?>
                                    <option value="<?= $province['provinceid']?>"><?= $province['province']?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-3">
                            <label class="sr-only" for="city">City</label>
                            <select onchange="getAreas()" class="form-control" id="city" name="HospForm[city_id]">
                                <option>---市---</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-3">
                            <label class="sr-only" for="district">District</label>
                            <select class="form-control" id="area" name="HospForm[area_id]">
                                <option>---区---</option>
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 col-xs-offset-1">
                            <button id="search-hosp" type="button" class="btn btn-info btn-sm"><i class="fa fa-search"></i>&nbsp;查询</button>
                        </div>
                    </div>
                </div>


                <!--商家hosp-->
                <div id="hosp-items">
                    <?= \frontend\widgets\hosp\HospWidget::widget(['limit' => 2])?>
                </div>

                <div class="more-content">
                    <a href="<?= \yii\helpers\Url::to(['hosp/index'])?>" class="button button-block button-action button-pill button-small">更多本地宠物医院•••</a>
                </div>

            </div>
            <!--显示一条宠物医院-end-->

            <hr class="hr-5">

            <div>
                <!--医护百科文章-->
                <?= \frontend\widgets\baike\BaikeWidget::widget([
                    'pageSize' => 5,
                    'condition' => ['is_valid' => 1, 'cat_id' => 2] //关于医护的分类cat_id = 2
                ])?>
            </div>

        </div>
    </div>
    <div class="col-lg-4">
    </div>
</div>