<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "areas".
 *
 * @property integer $id
 * @property string $areaid
 * @property string $area
 * @property string $cityid
 */
class Areas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'areas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['areaid', 'area', 'cityid'], 'required'],
            [['areaid', 'cityid'], 'string', 'max' => 20],
            [['area'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'areaid' => 'Areaid',
            'area' => 'Area',
            'cityid' => 'Cityid',
        ];
    }
}
