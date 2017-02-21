<?php
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = Html::encode($chapter['title']);
$this->params['breadcrumbs'][] = ['label' => '书籍', 'url' => ['book/index']];
$this->params['breadcrumbs'][] = ['label' => '目录', 'url' => ['book/catalog', 'id'=> $chapter['book_id']]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row margin-10">
    <div class="col-lg-9">
        <!--book-content-->
        <div class="book-view font-read">
            <?php
            $cssFile = 'css/book'.$chapter['book_id'].'.css';
            if (file_exists($cssFile)){
                $this->registerCssFile($cssFile);
            }
            echo $chapter['content'];
            ?>
        </div>

        <div class="page-btn">
            <?php
            $prevPage = intval($chapter['catalog_id']) - 1;
            $nextPage = intval($chapter['catalog_id']) + 1;
            ?>
            <a class="btn btn-info btn-sm f-right" href="<?= Url::to(['book/chapter', 'book_id' => $chapter['book_id'], 'catalog_id' => $nextPage,])?>">下一节</a>
            <a class="btn btn-info btn-sm f-right" href="<?= Url::to(['book/chapter', 'book_id' => $chapter['book_id'], 'catalog_id' => $prevPage,])?>">上一节</a>
        </div>
    </div>

    <div class="col-lg-3">
    </div>

</div>


