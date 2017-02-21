<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "provinces".
 *
 * @property integer $id
 * @property string $provinceid
 * @property string $province
 */
class Provinces extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'provinces';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['provinceid', 'province'], 'required'],
            [['provinceid'], 'string', 'max' => 20],
            [['province'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'provinceid' => 'Provinceid',
            'province' => 'Province',
        ];
    }
}
