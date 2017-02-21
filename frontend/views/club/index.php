<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>
<img src="http://oj8hunqbx.bkt.clouddn.com/slider/nav-img03.jpg" class="img-responsive margin-v-10">
<div class="row">
    <div class="col-lg-9">
        <div class="club">
            <div class="media club-top">
                <?php if (Yii::$app->user->isGuest): ?>
                    <a class="button button-action button-pill  button-small f-right margin-10 font-larger" href="<?= Url::to(['site/signup'])?>"><i class="fa fa-edit"></i>&nbsp;&nbsp;注册</a>
                    <a class="button button-action button-pill  button-small f-right margin-10 font-larger" href="<?= Url::to(['site/login'])?>"><i class="fa fa-sign-in"></i>&nbsp;&nbsp;登录</a>
                <?php endif;?>
                <?php if (!Yii::$app->user->isGuest): ?>
                    <!--用户信息-begin-->
                    <a class="media-left">
                        <img class="img-circle" src="<?= $user['avatar']?>" alt="avatar">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?= Html::encode($user['username'])?></h4>
                        <div class="user-info">
                            <button class="btn btn-info btn-xs message-btn">消息&nbsp;<span class="badge"><?= $user['message_num']?></span></button>&nbsp;&nbsp;&nbsp;&nbsp;
                            <button class="btn btn-default btn-xs">积分: <?= $user['point']?></button>
                        </div>
                    </div>
                    <!--用户信息-end-->
                <?php endif;?>
                <!--输入帖子内容-begin-->
                <div class="editer-template">
                    <textarea class="form-control margin-v-10" rows="2" placeholder="&nbsp;无聊？聊吧！（点击这里...）"></textarea>
                    <button class="btn btn-default btn-sm f-right" type="submit"><i class="fa fa-paper-plane-o"></i>&nbsp;发贴</button>
                    <div class="clearfix"></div>
                </div>
                <!--输入帖子内容-end-->
            </div>
            <!--帖子展示-begin-->
            <div class="club-content">
                <?php foreach ($posts as $post): ?>
                    <div class="item-content">
                        <a href="<?= Url::to(['club/detail', 'id' => $post['id']])?>" target="_blank">
                            <img class="img-circle user-img" src="<?= $post['avatar']?>" alt="avatar">
                            <span><i class="fa fa-user"></i>&nbsp;&nbsp;<?= Html::encode($post['username'])?>&nbsp;&nbsp;&nbsp;&nbsp;<?= date('m-d h:i', $post['create_time'])?></span>
                            <h4><?= Html::encode($post['title'])?></h4>
                            <p class="summary-cont"><span class="ellipsis">&nbsp;• • •</span><?= Html::encode($post['content'])?></p>
                            <?php if ($post['imgs']): ?>
                                <?php
                                $imgs = explode(';', $post['imgs']);
                                ?>
                                <div class="row content-imgs">
                                    <?php foreach ($imgs as $img): ?>
                                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-4">
                                            <img class="img-responsive" src="<?= $img?>" alt="post-img">
                                        </div>
                                    <?php endforeach;?>
                                </div>
                            <?php endif;?>
                            <div class="content-footer">
                                <span><i class="fa fa-edit"></i>&nbsp;&nbsp;回复</span>
                                <?php if ($post['reply_num']): ?>
                                    <span><i class="fa fa-commenting-o"></i>&nbsp;&nbsp;<?= $post['reply_num']?></span>
                                <?php endif;?>
                                <?php if ($post['browser']): ?>
                                    <span><i class="fa fa-eye"></i>&nbsp;&nbsp;<?= $post['browser']?></span>
                                <?php endif;?>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                <?php endforeach;?>
                <!--一条宠物店hosp的信息-->
                <div id="hosp-items">
                    <?= \frontend\widgets\hosp\HospWidget::widget(['limit' => 1])?>
                </div>
            </div>
            <!--帖子展示-end-->
            <div class="more-content">
                <button class="btn btn-info btn-sm btn-block add-more-post"><span class="border">显 示 更 多</span></button>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div>
        </div>
    </div>
</div>
