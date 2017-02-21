<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>
<?php foreach ($baike as $item): ?>
    <div class="baike-item">
        <a href="<?= Url::to(['baike/view', 'id' => $item['id'], 'book_chapter' => $item['book_chapter']])?>">
            <h4><?= Html::encode($item['title'])?></h4>
            <?php if (!empty(Html::encode($item['label_img']))): ?>
                <img class="img-rounded" src="<?= Html::encode($item['label_img'])?>" alt="baike-item-img">
            <?php endif;?>
            <?php if (empty(Html::encode($item['label_img']))): ?>
                <img class="img-rounded" src="images/gougou-baike.jpg" alt="baike-item-img">
            <?php endif;?>
            <div class="baike-summary">
                <p><?= Html::encode($item['summary'])?><span class="show-more">&nbsp;&nbsp;&nbsp;&nbsp;显示全部>>></span></p>
            </div>
            <div class="clearfix"></div>
            <hr>
        </a>
    </div>
<?php endforeach;?>
<?= \yii\widgets\LinkPager::widget([
    'pagination' => $pagination,
    'nextPageLabel' => '下一页',
    'prevPageLabel' => '上一页',
])?>