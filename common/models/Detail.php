<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "detail".
 *
 * @property integer $id
 * @property integer $baike_id
 * @property string $content
 */
class Detail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['baike_id', 'content'], 'required'],
            [['baike_id'], 'integer'],
            [['content'], 'string'],
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
            'content' => 'Content',
        ];
    }
}
