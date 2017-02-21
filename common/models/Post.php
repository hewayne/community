<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "post".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $imgs
 * @property string $avatar
 * @property string $username
 * @property integer $create-time
 * @property integer $browser
 * @property integer $reply-num
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'content', 'user_id', 'create_time'], 'required'],
            [['create_time', 'user_id'], 'integer'],
            [['title'], 'string', 'max' => 32],
            [['imgs'], 'string', 'max' => 255],
            [['content'], 'string', 'max' => 1000],
            ['status', 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'content' => 'Content',
            'imgs' => 'Imgs',
            'user_id' => 'User Id',
            'create_time' => 'Create Time',
            'browser' => 'Browser',
            'reply_num' => 'Reply Num',
            'status' => 'Status'
        ];
    }


    //获取关联的‘回复’数据
    public function getReply(){
        return $this->hasMany(Reply::className(), ['post_id' => 'id'])->where(['status' => 1])->orderBy(['id' => SORT_DESC])->asArray();
    }

    //获取【帖子】相关联的用户数据
    public function getNameAndAvatar(){
        return $this->hasOne(User::className(), ['id' => 'user_id'])->asArray();
    }
}







