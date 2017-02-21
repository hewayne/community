<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "book_chapter".
 *
 * @property integer $id
 * @property string $title
 * @property integer $book_id
 * @property integer $chapter_id
 * @property string $content
 * @property string $is_baike
 * @property integer $browser
 */
class BookChapter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'book_chapter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'book_id', 'catalog_id', 'content'], 'required'],
            [['book_id', 'browser'], 'integer'],
            [['content', 'is_baike'], 'string'],
            [['title'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'book_id' => 'Book ID',
            'catalog_id' => 'Catalog ID',
            'content' => 'Content',
            'is_baike' => 'Is Baike',
            'browser' => 'Browser',
        ];
    }
}
