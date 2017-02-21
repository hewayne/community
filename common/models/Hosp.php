<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "hosp".
 *
 * @property integer $id
 * @property string $hosp_name
 * @property string $label_img
 * @property string $city
 * @property string $district
 * @property string $addr
 * @property integer $tel
 * @property string $server
 * @property integer $score
 * @property string $ip
 */
class Hosp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hosp';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hosp_name', 'label_img', 'province_id', 'city_id', 'area_id', 'addr', 'tel', 'server'], 'required'],
            [['province_id', 'city_id', 'area_id', 'score'], 'integer'],
            [['hosp_name', 'ip', 'tel'], 'string', 'max' => 32],
            [['label_img', 'addr', 'server'], 'string', 'max' => 255],

        ];
        //[['province_id', 'city_id', 'area_id',], 'integer', 'max' => 6],
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hosp_name' => 'Hosp Name',
            'label_img' => 'Label Img',
            'province_id' => 'Province Id',
            'city_id' => 'City Id',
            'area_id' => 'Area Id',
            'addr' => 'Addr',
            'tel' => 'Tel',
            'server' => 'Server',
            'score' => 'Score',
            'ip' => 'Ip',
        ];
    }

    public function getHospDetail(){
        return $this->hasOne(HospDetail::className(), ['hosp_id' => 'id'])->asArray();
    }
}
