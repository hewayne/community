<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "book".
 *
 * @property integer $id
 * @property integer $book_id
 * @property string $book_name
 * @property string $cover_img
 * @property string $discription
 */
class Book extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'book';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['book_id', 'book_name', 'cover_img', 'discription'], 'required'],
            [['book_id'], 'integer'],
            [['book_name'], 'string', 'max' => 32],
            [['cover_img', 'discription'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'book_id' => 'Book ID',
            'book_name' => 'Book Name',
            'cover_img' => 'Cover Img',
            'discription' => 'Discription',
        ];
    }
}
