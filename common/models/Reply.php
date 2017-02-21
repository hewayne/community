<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "reply".
 *
 * @property integer $id
 * @property integer $post_id
 * @property string $content
 * @property string $username
 * @property string $avatar
 * @property integer $time
 * @property integer $re_reply_num
 */
class Reply extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reply';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'content', 'user_id', 'time'], 'required'],
            [['post_id', 'user_id', 'time', 're_reply_num', 'status'], 'integer'],
            [['content'], 'string', 'min' => 3, 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_id' => 'Post ID',
            'content' => 'Content',
            'user_id' => 'User Id',
            'time' => 'Time',
            're_reply_num' => 'Re Reply Num',
            'status' => 'Status'
        ];
    }

    //获取【帖子】相关联的【用户】数据
    public function getNameAndAvatar(){
        return $this->hasOne(User::className(), ['id' => 'user_id'])->asArray();
    }
}
