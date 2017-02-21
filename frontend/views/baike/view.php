<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="row">
    <div class="col-lg-8">
        <?php
        $this->title = Html::encode($baike['title']);
        $this->params['breadcrumbs'][] = ['label' => '博文', 'url' => ['baike/index']];
        $this->params['breadcrumbs'][] = $this->title;
        ?>
        <div class="baike-view book-view">
            <?php
                if (isset($baike['is_baike']) && $baike['is_baike'] == 1){
                    $this->registerCssFile('css/book.css');
                }
            ?>
            <h3><?= Html::encode($baike['title'])?></h3>
            <hr>
            <div class="baike-content"><?= $baike['content']?></div>
            <hr>
            <?php if (!empty($baike['tags'])): ?>
                <div class="view-tag">
                    <h4>相关内容：</h4>
                    <?php foreach ($baike['tags'] as $tag): ?>
                        <button class="btn btn-info btn-xs">
                            <span class="tag-id" style="display: none;"><?= Html::encode($tag['id'])?></span>
                            <i class="fa fa-tag"></i>&nbsp;&nbsp;
                            <span><?= Html::encode($tag['tag_name'])?>&nbsp;&nbsp;</span>
                            <span class="badge"><?= Html::encode($tag['baike_num'])?></span>
                        </button>
                    <?php endforeach;?>
                </div>
            <?php endif;?>
        </div>
        <!--点击标签后展示的baike-item-->
        <div id="tag-search-content"></div>
    </div>
</div>