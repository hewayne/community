<?php
/**
 * Created by PhpStorm.
 * User: wayne
 * Date: 2016/12/23
 * Time: 16:53
 */
namespace frontend\controllers;

use common\models\Intro;
use common\models\User;
use frontend\fun\ReadFiles;
use frontend\models\MessageForm;
use frontend\models\UserForm;
use yii\base\Controller;
use Yii;

class UserController extends Controller {

    public $layout = 'simple_layout';

    public function actionUserInfo(){
        $userInfo = UserForm::getUserInfo();
        $messages = '';
        if ($userInfo['message_num'] > 0){
            $messages = (new MessageForm())->getMessage();
        }
        return $this->render('user_info', ['user' => $userInfo, 'messages' => $messages]);
    }

    //获取消息
    public function actionMessage(){
        $model = new MessageForm();
        $messages = $model->getMessage();
        return $this->render('message', ['messages' => $messages]);
    }

    //获取用户主页
    public function actionUserpage(){
        $userId = Yii::$app->request->get('userid');
        $intro = Intro::find()->where(['user_id' => $userId])->asArray()->one();

        $userInfo = (new UserForm())->getNameAndAvatar($userId);
        $userInfo['intro'] = $intro;
        $userInfo['userId'] = $userId;

        return $this->render('userpage', ['user' => $userInfo]);
    }

    //处理【私信】
    public function actionLetter(){
        $post = Yii::$app->request->post();

        $model = new MessageForm();
        if (!$model->addLetter($post)){
            return json_encode(['static' => 0]);
        }

        return json_encode(['static' => 1]);
    }

    //处理【一句话介绍】
    public function actionEditIntro(){
        $intro = Yii::$app->request->post('intro');

        $userId = Yii::$app->user->id;

        $model = Intro::find()->where(['user_id' => $userId])->one();
        if ($model){
            $model->content = htmlspecialchars(strip_tags($intro));
            $model->create_time = time();

            if (!$model->save()){
                return json_encode(['static' => 0]);
            }
            return json_encode(['static' => 1]);
        }

        $newModel = new Intro();
        $newModel->user_id = $userId;
        $newModel->content = htmlspecialchars(strip_tags($intro));
        $newModel->create_time = time();

        if (!$newModel->save()){
            return json_encode(['static' => 0]);
        }
        return json_encode(['static' => 1]);
    }


    //更改用户图像
    public function actionSelectAvatar(){
        if (Yii::$app->request->isPost){
            $avatar = Yii::$app->request->post('avatar');
            $model = User::findOne(Yii::$app->user->id);
            $model->avatar = str_replace('images', 'http://xxxxx.bkt.clouddn.com', strip_tags($avatar));
            if (!$model->save()){
                return json_encode(['status' => 0]);
            }
            return json_encode(['status' => 1]);
        }

        $File =new ReadFiles();
        $avatarUrls = $File->getFiles('images/avatar/',true);
        return $this->render('select_avatar', ['avatarUrls' => $avatarUrls]);
    }

}



















