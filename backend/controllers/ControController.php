<?php
namespace backend\controllers;
use yii;
use yii\web\Controller;
use frontend\controllers\CommonController;
class  ControController extends CommonController{



    public $enableCsrfValidation = false;
    public $layouts = false;
    public function actionIndex(){
        if(yii::$app->request->isGet){
            return  $this->render('sendAll');
        }
        if(yii::$app->request->isPost){
            $file = $_FILES['img'];
            $name = rand(1,99999);
            $res=move_uploaded_file($file['tmp_name'],'./img/'.$name.'.jpg');    

            $filedata =['file1'=>'@/phpstudy/www/Wchat/backend/web/img/'.$name.'.jpg'];
              $url="https://api.weixin.qq.com/cgi-bin/material/add_material?access_token=".$this->actionToken()."&type=image";
        $da=$this->curl_request($url,$filedata,1);
            var_dump($da);


            echo 1111;
        }     
    }

    /**
     * [actionSendmsg description]
     *  群发 消息
     */
    public function actionSendmsg(){
                if(yii::$app->request->isGet){
                    return $this->render('demo.php');
                }
                if(yii::$app->request->isPost){
                    $data = $_POST;
                   $url = "https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token=".$this->actionToken();

                    $con = "标题是".$data['title']."\n".$data['time']."\n".$data['desc']."\n".$data['content'];
                    $arr =[
                    "filter"=>[
                    'is_to_all'=>true,
                    ],
                    "text"=>[
                    "content"=>$con
                    ],
                    "msgtype"=>"text"
                    ];
                    $json = json_encode($arr,JSON_UNESCAPED_UNICODE);

                            echo  "<pre>";
                            print_r($json);
                    echo "<br>";
                    print_r($con);
                    echo  "<br>";
                    print_r($url);

                     $da=$this->curl_request($url,$json,1);
                     var_dump($da);                
                }
    }
    /**
     *  获取用户列表
     */
    public function actionBase(){
        $redirect_uri=urlencode("http://47.93.251.43/Wchat/backend/web/index.php?r=contro/getcode");
        $url='https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$this->appID.'&redirect_uri='.$redirect_uri.'&response_type=code&scope=snsapi_base#wechat_redirect';
        $da=$this->curl_request($url);
    }

    public function actionGetcode(){
        $code = $_GET['code'];
$url='https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$this->appID.'&secret='.$this->appsecret.'&code='.$code.'&grant_type=authorization_code';
        $da=$this->curl_request($url);
    $arr=json_decode($da,true);
    $access_token=$arr['access_token'];
    $openid=$arr['openid'];
    $url='https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$this->actionToken().'&openid='.$openid.'&lang=zh_CN';
    $da=$this->curl_request($url);
    var_dump($da);
    }

    public function actionNomore(){
        $code = $_GET['code'];
            var_dump($code);die;
    }
    public function actionJss(){

        $url='https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token='.$this->actionToken().'&type=jsapi';
        $da=$this->curl_request($url);
        $arr =json_decode($da,true);
        
        $data['jsapi_ticket']=$arr['ticket'];
        $data['noncestr']="strtotime".rand(0,999).'k'.rand(0,999999);
        $data['timestamp']=time();
        $data['url']='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];;
        $array=[];
        ksort($data);
        foreach($data as $k=>$v){
            $array[] = $k.'='.$v;
        }
        $string=sha1(implode("&",$array));

        return $this->render('jss',['appid'=>$this->appID,'string'=>$string,'data'=>$data]);
    }
}

