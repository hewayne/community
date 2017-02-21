<?php
/**
 * Created by PhpStorm.
 * User: wayne
 * Date: 2016/11/17
 * Time: 22:35
 */
namespace frontend\controllers;

use common\models\Post;
use common\models\ReReply;
use frontend\models\PostForm;
use frontend\models\ReplyForm;
use frontend\models\ReReplyForm;
use frontend\models\UploadForm;
use frontend\models\UserForm;
use Yii;
use yii\web\UploadedFile;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

class ClubController extends BaseController {

    public function actionIndex(){
        $userInfo = UserForm::getUserInfo();
        $posts = Post::find()->where(['status' => 1])->with('nameAndAvatar')->limit(10)
            ->orderBy(['id' => SORT_DESC])->asArray()->all();
        foreach ($posts as $k => $post) {
            $posts[$k]['username'] = $post['nameAndAvatar']['username'];
            $posts[$k]['avatar'] = $post['nameAndAvatar']['avatar'];
            unset($posts[$k]['nameAndAvatar']);
            unset($posts[$k]['status']);
        }
        return $this->render('index', ['user' => $userInfo, 'posts' => $posts]);
    }


    //获取帖子详情页
    public function actionDetail(){
        $postId = (int)Yii::$app->request->get('id');
        $postData = Post::find()->where(['id' => $postId])->with('nameAndAvatar', 'reply.nameAndAvatar')->asArray()->one();
        $postData['username'] = $postData['nameAndAvatar']['username'];
        $postData['avatar'] = $postData['nameAndAvatar']['avatar'];
        foreach ($postData['reply'] as $k => $item) {
            $postData['reply'][$k]['username'] = $item['nameAndAvatar']['username'];
            $postData['reply'][$k]['avatar'] = $item['nameAndAvatar']['avatar'];
            unset($postData['reply'][$k]['nameAndAvatar']);
            unset($postData['reply'][$k]['status']);
            unset($postData['reply'][$k]['post_id']);
        }
        unset($postData['nameAndAvatar']);
        unset($postData['status']);
        //从编辑（edit）直接加载简洁的layout(simple_layout)，以便在模态框中，使页面不显示顶部和按钮导航。
        if (Yii::$app->request->get('comefrom')){  //在编辑后跳转的链接中有：&comefrom=edit.
            $this->layout = 'simple_layout';
            return $this->render('simple_detail', ['post' => $postData]);
        }
        //浏览次数自增1
        $postObj = Post::findOne($postId);
        $postObj->updateCounters(['browser' => 2]);
        return $this->render('detail', ['post' => $postData]);
    }


    //获取更多帖子(通过点击‘显示更多’，使用ajax加载帖子数据)
    public function actionGetPost(){
        $page = Yii::$app->request->get('page');
        $posts = Post::find()->with('nameAndAvatar')->offset($page)->limit(10)->orderBy(['id' => SORT_DESC])->asArray()->all();
        foreach ($posts as $k => $post){
            $posts[$k]['time'] = date('m-d h:i', $post['create_time']);
            if ($post['imgs']){
                $imgs = explode(';', $post['imgs']);
                $posts[$k]['pictures'] = $imgs;
                unset($posts[$k]['imgs']);
            }
            $posts[$k]['username'] = $post['nameAndAvatar']['username'];
            $posts[$k]['avatar'] = $post['nameAndAvatar']['avatar'];
            unset($posts[$k]['create_time']);
            unset($posts[$k]['nameAndAvatar']);
        }
        return json_encode(['posts' => $posts]);
    }


    //处理帖子并保存
    public function actionEdit(){
        $this->layout = 'club_edit';
        if (Yii::$app->request->isPost){
            //保存title、content、urls
            $postData = Yii::$app->request->post();
            $model = new PostForm();
            $model->title = htmlspecialchars(strip_tags($postData['title']), ENT_QUOTES);
            $model->content = htmlspecialchars(strip_tags($postData['content']), ENT_QUOTES);
            $model->imgs = strip_tags($postData['imgs']);
            if ($model->validate()){
                if ($model->savePost()){
                    return json_encode(['static' => 1, 'id' => $model->id]);
                }else{
                    return json_encode(['static' => '-1']);
                }
            }else{
                return json_encode(['static' => '0']);
            }
        }
        return $this->render('edit');
    }


    //处理图片上传
    public function actionUpload(){
        if (Yii::$app->request->isPost) {
            $model = new UploadForm();
            $files = UploadedFile::getInstances($model, 'file');
            if ($files){
                $savePaths = [];
                foreach ($files as $file) {
                    $_model = new UploadForm();
                    $_model->file = $file;
                    if ($_model->validate()) {
                        //保存到七牛
                        $domain = Yii::$app->params['clubDomain'];  //七牛中xxxx的域名
                        $savePath = 'club/' . date("Ymdhis", time()) . substr(md5(microtime()), 0, 3) . '.' . $_model->file->extension; //保存后的文件名
                        if ($this->_uploadToQiniu($_model->file->tempName, $savePath)){
                            $savePaths[] = $domain.$savePath;  //为添加到数据库做准备
                        }else{
                            return false;
                        }
                    } else {
                        foreach ($_model->getErrors('file') as $error) {
                            $model->addError('file', $error);
                        }
                    }
                }
                if ($model->hasErrors('file')){
                    $errFile = count($model->getErrors('file')) . ' of ' . count($files) . ' files not uploaded';
                    $model->addError(
                        'file', $errFile
                    );
                    return json_encode(['error' => $errFile]);
                }
                $imgUrls = implode(';', $savePaths);
                return json_encode(['response' => $imgUrls]);
            }
            return json_encode(['error' => 'file not exist']);
        }
    }


    //处理并保存‘回复’
    public function actionReply(){
        if (Yii::$app->user->isGuest){
            return json_encode(['static' => -5]);
        }
        $post = Yii::$app->request->post();
        $model = new ReplyForm();
        if (!$model->saveReply($post)){
            return json_encode(['static' => 0]);
        }
        return json_encode(['static' => 1]);
    }


    //处理并保存二级回复
    public function actionReReply(){
        if (Yii::$app->user->isGuest){
            return json_encode(['static' => -5]);
        }
        $post = Yii::$app->request->post();
        $reReplyFormModel = new ReReplyForm();
        if (!$reReplyFormModel->saveReReply($post)){
            return json_encode(['static' => 0]);
        }
        return json_encode(['static' => 1]);
    }


    //获取二级、三级回复
    public function actionGetReReply(){
        $replyId = (int)Yii::$app->request->get('replyId');
        $reReplyData = ReReply::find()->where(['reply_id' => $replyId])
            ->with('nameAndAvatar')->asArray()->all();
        foreach ($reReplyData as $k => $item){
            $reReplyData[$k]['ftime'] = date('m-d h:i', $item['time']);
            $reReplyData[$k]['username'] = $item['nameAndAvatar']['username'];
            $reReplyData[$k]['avatar'] = $item['nameAndAvatar']['avatar'];
            unset($reReplyData[$k]['time']);
            unset($reReplyData[$k]['nameAndAvatar']);
        }
        return json_encode(['reReply' => $reReplyData]);
    }


    //将图片上传到七牛
    public function _uploadToQiniu($file, $savePath){
        $accessKey = Yii::$app->params['accessKey'];
        $secretKey = Yii::$app->params['secretKey'];
        $auth = new Auth($accessKey, $secretKey);
        $bucket = Yii::$app->params['clubBucket'];
        // 生成上传Token
        $token = $auth->uploadToken($bucket);
        // 要上传文件的本地路径
        $filePath = $file;
        // 上传到七牛后保存的文件名
        $key = $savePath;
        // 初始化 UploadManager 对象并进行文件的上传
        $uploadMgr = new UploadManager();
        // 调用 UploadManager 的 putFile 方法进行文件的上传
        list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
        if ($err !== null) {
            return false;
        } else {
            return true;
        }
    }


    //前端获取七牛token
    public function actionGettoken(){
        $this->layout = false;
        $accessKey = Yii::$app->params['accessKey'];
        $secretKey = Yii::$app->params['secretKey'];
        $auth = new Auth($accessKey, $secretKey);
        $bucket = Yii::$app->request->get('bucket');
        // 生成上传Token
        $token = $auth->uploadToken($bucket);
        return json_encode(['uptoken' => $token]);
    }
}