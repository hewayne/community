<?php
/**
 * Created by PhpStorm.
 * User: wayne
 * Date: 2016/12/26
 * Time: 23:13
 */
namespace frontend\models;
use yii\base\Model;
use yii\web\UploadedFile;
/**
 * UploadForm is the model behind the upload form.
 */
class UploadForm extends Model
{
    /**
     * @var UploadedFile|Null file attribute
     */
    public $file;
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['file'], 'file'],
            /*[['file'], 'file', 'extensions' => 'jpg, gif, png, jpeg', 'mimeTypes' => 'image/jpeg, image/png, image/gif',],*/
        ];
    }
}