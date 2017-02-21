<?php
namespace frontend\models;

use frontend\fun\ReadFiles;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $avatar;
    public $verifyCode;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'match', 'pattern' => '/^[a-zA-Z\x{4e00}-\x{9fa5}][a-zA-Z0-9_\x{4e00}-\x{9fa5}]{2,14}$/u', 'message' => '用户名由字母、汉字、数字、下划线组成（字母或汉字开头，最多15个字符）'],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            [['email', 'avatar'], 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            [['verifyCode'], 'captcha'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'username' => '用户名',
            'email' => '邮 箱',
            'password' => '密 码',
            'verifyCode' => '验证码',
        ];
    }


    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->avatar = strip_tags($this->_getAvatar());
        $user->setPassword($this->password);
        $user->generateAuthKey();
        
        return $user->save() ? $user : null;
    }


    private function _getAvatar(){
        $File =new ReadFiles();
        $avatarUrls = $File->getFiles('images/avatar/',true);

        $avatarArr = [];
        foreach ($avatarUrls as $avatarUrl){
            foreach ($avatarUrl as $item){
                $avatarArr[] = $item;
            }
        }

        $avatar = array_rand($avatarArr, 1);
        return $avatarArr[$avatar];

    }
}
