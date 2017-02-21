<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "re_reply".
 *
 * @property integer $id
 * @property integer $reply_id
 * @property string $content
 * @property string $username
 * @property string $avatar
 * @property integer $time
 * @property integer $static
 */
class ReReply extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 're_reply';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['reply_id', 'content', 'user_id', 'time'], 'required'],
            [['reply_id', 'user_id', 'time', 'status'], 'integer'],
            [['content'], 'string', 'min' => 2, 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'reply_id' => 'Reply ID',
            'content' => 'Content',
            'user_id' => 'User Id',
            'time' => 'Time',
            'status' => 'Status',
        ];
    }

    //获取【帖子】相关联的【用户】数据
    public function getNameAndAvatar(){
        return $this->hasOne(User::className(), ['id' => 'user_id'])->asArray();
    }

}
