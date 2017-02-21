<?php/** * Created by PhpStorm. * User: wayne * Date: 2016/12/17 * Time: 13:53 */namespace frontend\models;use common\models\Cities;use common\models\Hosp;use common\models\HospDetail;use yii\base\Model;use yii;class HospForm extends Model {    public $id;    public $hosp_name;    public $province_id;    public $city_id;    public $area_id;    public $label_img;    public $addr;    public $tel;    public $server;    public $detail;    public $verifyCode;    public $_lastError;    public function rules()    {        return [            [['hosp_name', 'province_id', 'city_id', 'area_id', 'addr', 'tel', 'server', 'label_img'], 'required'],            [['province_id', 'city_id', 'area_id', 'tel'], 'integer'],            [['detail', 'label_img'], 'string'],            [['hosp_name'], 'string', 'max' => 32],            [['addr', 'server'], 'string', 'max' => 255],            [['verifyCode'], 'captcha'],        ];    }    public function attributeLabels()    {        return [            'id' => 'ID',            'hosp_name' => '宠物店名称',            'label_img' => '店铺形象图',            'province_id' => '所在省',            'city_id' => '所在城市',            'area_id' => '所在区/县',            'file' => '上传图片',            'addr' => '地址',            'tel' => '电话',            'server' => '提供的服务',            'score' => 'Score',            'ip' => 'Ip',            'detail' => '店铺活动、推广等信息（可选）',            'verifyCode' => '验证码',        ];    }    public function create(){        //将数据写入hosp        $model = new Hosp();        $transation = Yii::$app->db->beginTransaction();        try{            $model->setAttributes($this->attributes);            $model->ip = \Yii::$app->request->userIP;            if (!empty(trim($this->detail))){                $model->score = 10;            }            if (!$model->save()){                $this->_lastError = 'hosp->save失败';                return false;            }            $this->id = $model->id;  //获取id            //将detail上传到数据库            if (!empty($this->detail)){                if (!$this->_createDetail()){                    return false;                }            }            $transation->commit();            return true;        }catch (\Exception $exception){            $transation->rollBack();            $this->_lastError = $exception->getMessage();            return false;        }    }    //将detail上传到数据库    private function _createDetail(){        $model = new HospDetail();        $model->hosp_id = $this->id;        $model->detail = $this->detail;        if (!$model->save()){            $this->_lastError = '详细信息detail保存失败';            return false;        }        return true;    }    public function getHospById($id){        $hospData = Hosp::find()            ->where(['id' => $id])            ->with('hospDetail')            ->asArray()->one();        $hospData['detail'] = $hospData['hospDetail']['detail'];        unset($hospData['hospDetail'], $hospData['score'], $hospData['ip']);        return $hospData;    }    //获取本地宠物店hosp信息（根据ip地理位置: 先获取‘市’的hosp,如果‘市’没有数据就获取‘省’的数据，如果没有‘省’就获取积分最高的hosp）    public function getLocalHosp($limit){        $cityId = $this->_getCityId();        if ($cityId){            $hospData = Hosp::find()->select(['id', 'hosp_name', 'label_img', 'addr', 'tel', 'server'])                ->where(['city_id' => $cityId])                ->orderBy(['score' => SORT_DESC])->limit($limit)->asArray()->all();            if (empty($hospData)){                //如果此ip所在的参数没有hosp数据，则获取其省的hosp数据                $province = Cities::find()->select(['provinceid'])->where(['cityid' => $cityId])->asArray()->one();                $hospData = Hosp::find()->select(['id', 'hosp_name', 'label_img', 'addr', 'tel', 'server'])                    ->where(['province_id' => $province['provinceid']])                    ->orderBy(['score' => SORT_DESC])->limit($limit)->asArray()->all();            }        }else{            $hospData = Hosp::find()->select(['id', 'hosp_name', 'label_img', 'addr', 'tel', 'server'])                ->orderBy(['score' => SORT_DESC])->limit($limit)->asArray()->all();        }        return $hospData;    }    private function _getCityId(){        $ip = Yii::$app->request->userIP;        $opts = array(            'http'=>array(                'method'=>"GET",                'timeout'=>2,            )        );        $ipInfo = @file_get_contents('http://ip.taobao.com/service/getIpInfo.php?ip='.$ip, false, stream_context_create($opts));        if ($ipInfo){            $ipInfo = json_decode($ipInfo, true);            if ($ipInfo['code'] != 1) { //code=1为失败                return $ipInfo['data']['city_id'];            }else{                return false;            }        }else{            return false;        }    }    public function searchHosp($ids){        $hospData = [];        $res = Hosp::find()->select(['id', 'area_id', 'hosp_name', 'label_img', 'addr', 'tel', 'server'])            ->where(['province_id' => $ids[0], 'city_id' => $ids[1]])            ->asArray()->all();        foreach ($res as $item){            if ($item['area_id'] == $ids[2]){                $hospData['area'][] = $item;                unset($item);                continue;            }            $hospData['city'][] = $item;        }        return $hospData;    }}