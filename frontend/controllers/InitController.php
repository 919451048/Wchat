<?php
namespace frontend\controllers;
use yii;
use yii\web\Controller;

class InitController extends CommonController{


        public function actionIndex(){
            if(yii::$app->request->isGet){
                echo $_GET['echostr'];
                exit();
            }
      
        }
        public function  actionSetmenu(){
            $token=$this->actionToken();
            echo $token,"<br>";
            $arr = [
                "button"=>[
                    [
                        'type'=>'click',
                        'name'=>'時訊',
                        'key'=>'shixun'
                    ],
                    [
                        'type'=>'click',
                        'name'=>'熱文',
                        'key'=>'rewen'
                    ],
                    [
                        'name'=>'更多',
                        'sub_button'=>[
                            [
                                'type'=>'view',
                                'name'=>'往期熱文',
                                'url'=>'http://www.jg.com'
                            ],
                            [
                                'type'=>"view",
                                'name'=>'視屏',
                                'url'=>"http://www.baidu.com"
    
                            ],
                        ]
                    ]
                ],
            ];
            $json = json_encode($arr,JSON_UNESCAPED_UNICODE);
            print_r($json);
            echo "<br/>";
            $return=$this->curl_request("https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$token,$json,1);
            var_dump($return);
        }
}