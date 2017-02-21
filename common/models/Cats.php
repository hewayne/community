<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cats".
 *
 * @property integer $id
 * @property string $cat_name
 * @property integer $post_num
 */
class Cats extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cats';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cat_name'], 'required'],
            [['post_num'], 'integer'],
            [['cat_name'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cat_name' => 'Cat Name',
            'post_num' => 'Post Num',
        ];
    }

    public function getCats(){
        $cats[0] = '请选择分类';
        $catsData = self::find()->asArray()->all();
        foreach ($catsData as $item){
            $cats[$item['id']] = $item['cat_name'];
        }
        return $cats;
    }
}
