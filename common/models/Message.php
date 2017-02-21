<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "message".
 *
 * @property integer $id
 * @property integer $to_user
 * @property string $content
 * @property integer $create_time
 * @property string $from_user
 * @property integer $static
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['to_user', 'content', 'create_time', 'from_user'], 'required'],
            [['create_time', 'static'], 'integer'],
            [['content'], 'string', 'max' => 255],
            [['to_user', 'from_user'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'to_user' => 'To User',
            'content' => 'Content',
            'create_time' => 'Create Time',
            'from_user' => 'From User',
            'static' => 'Static',
        ];
    }
}
