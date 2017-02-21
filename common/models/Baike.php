<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "baike".
 *
 * @property integer $id
 * @property string $title
 * @property string $summary
 * @property string $label_img
 * @property string $cat
 * @property integer $user_id
 * @property string $user_name
 * @property integer $is_valid
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $book_chapter
 */
class Baike extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'baike';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'summary', 'is_valid'], 'required'],
            [['user_id', 'created_at', 'updated_at', 'book_chapter'], 'integer'],
            [['title', 'summary', 'label_img'], 'string', 'max' => 255],
            [['cat_id', 'user_name'], 'string', 'max' => 32],
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
            'summary' => 'Summary',
            'label_img' => 'Label Img',
            'cat_id' => 'Cat',
            'user_id' => 'User ID',
            'user_name' => 'User Name',
            'is_valid' => 'Is Valid',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'book_chapter' => 'Book Chapter',
        ];
    }


    //获取文章被查询时的数据详情
    public function getDetail(){
        return $this->hasOne(Detail::className(), ['baike_id' => 'id'])->asArray();
    }
    public function getRelate(){
        return $this->hasMany(RelationBaikeTag::className(), ['baike_id' => 'id'])->asArray();
    }
}
