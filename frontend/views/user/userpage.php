<a style="position: fixed; bottom: 10%; right: 5%;" class="btn btn-info" href="javascript:history.go(-1)"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;返回上一步</a>
<div style="margin-top: 20px">
    <img src="<?= $user['avatar']?>" alt="avatar" width="70" height="70">&nbsp;&nbsp;&nbsp;&nbsp;
    <span class="username" userid="<?= $user['userId']?>" style="font-size: large"><?= $user['username']?></span>
    <button class="btn btn-default btn-xs" onclick="leaveMessage()" style="float: right;"><i class="glyphicon glyphicon-edit"></i>&nbsp;私信</>
    <div class="clearfix"></div>
</div>
<hr>
<div class="intro-box">
    <?php if ($user['username'] == @Yii::$app->user->identity->username): ?>
        <p><span style="font-size: large">一句话介绍：</span>&nbsp;&nbsp;&nbsp;&nbsp;<button class="btn btn-default btn-xs intro-edit-btn" type="button" style="float: right;"><i class="glyphicon glyphicon-edit"></i>&nbsp;编 辑</button></p>
        <div class="clearfix"></div>
    <?php endif;?>
    <p class="intro"><?= $user['intro']['content']?></p>
</div>
<hr>
<button class="btn btn-default btn-xs" type="button">帖子</button>
<?= \frontend\widgets\post\UserPostWidget::widget(['userId' => $user['userId']])?>
<?php $this->registerJsFile('//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js', ['depends' => 'frontend\assets\SimpleAsset']) ?>
<?php $this->registerJsFile('@web/js/eModal.min.js', ['depends' => 'frontend\assets\SimpleAsset']) ?>
<?php $this->registerJsFile('@web/js/userpage.js', ['depends' => 'frontend\assets\SimpleAsset']) ?>
