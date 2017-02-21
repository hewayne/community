<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "relation_baike_tag".
 *
 * @property integer $id
 * @property integer $baike_id
 * @property integer $tag_id
 */
class RelationBaikeTag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'relation_baike_tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['baike_id', 'tag_id'], 'required'],
            [['baike_id', 'tag_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'baike_id' => 'Baike ID',
            'tag_id' => 'Tag ID',
        ];
    }

    //获取查询单条文章时关联的标签
    public function getTag(){
        return $this->hasOne(Tags::className(), ['id' => 'tag_id'])->asArray();
    }

    //通过标签查询数据时获取对应标签的数据（with查询）
    public function getBaike(){
        return $this->hasMany(Baike::className(), ['id' => 'baike_id'])
            ->select(['id', 'title', 'summary', 'label_img'])
            ->where(['is_valid' => 1])
            ->limit(10)
            ->asArray();
    }
}
