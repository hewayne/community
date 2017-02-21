<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "hosp_detail".
 *
 * @property integer $id
 * @property integer $hosp_id
 * @property string $detail
 */
class HospDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hosp_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hosp_id', 'detail'], 'required'],
            [['hosp_id'], 'integer'],
            [['detail'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hosp_id' => 'Hosp ID',
            'detail' => 'Detail',
        ];
    }
}
