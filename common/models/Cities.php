<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cities".
 *
 * @property integer $id
 * @property string $cityid
 * @property string $city
 * @property string $provinceid
 */
class Cities extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cities';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cityid', 'city', 'provinceid'], 'required'],
            [['cityid', 'provinceid'], 'string', 'max' => 20],
            [['city'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cityid' => 'Cityid',
            'city' => 'City',
            'provinceid' => 'Provinceid',
        ];
    }
}
