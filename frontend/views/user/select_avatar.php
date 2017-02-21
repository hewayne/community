<style>
    .avatar-select-box {
        width: 70%;
        margin: 0 auto;
    }
    .avatar-select-box img {
        margin: 10px;
        border-radius: 7px;
        cursor: pointer;
    }
</style>
<a style="position: fixed; bottom: 10%; right: 5%;" class="btn btn-info" href="javascript:history.go(-1)"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;返回上一步</a>
<h3>选择图像</h3>
<hr>
<div class="avatar-select-box">
    <?php foreach ($avatarUrls as $item): ?>
        <?php foreach ($item as $value): ?>
            <img src="<?= $value?>" alt="avatar" width="90px" height="90px">
        <?php endforeach;?>
        <hr>
    <?php endforeach;?>
</div>
<?php $this->registerJsFile('//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js', ['depends' => 'frontend\assets\SimpleAsset']) ?>
<?php $this->registerJsFile('@web/js/eModal.min.js', ['depends' => 'frontend\assets\SimpleAsset']) ?>
<?php $this->registerJsFile('@web/js/userpage.js', ['depends' => 'frontend\assets\SimpleAsset']) ?>
