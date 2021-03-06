<?php
namespace frontend\controllers;
use yii;
use yii\web\Controller;

class InitController extends CommonController{

    public  $enableCsrfValidation=false;
    public $xml;
        public function actionIndex(){
            if(yii::$app->request->isGet){
                echo $_GET['echostr'];
                exit();
            }
            $this->xml = simplexml_load_string($GLOBALS['HTTP_RAW_POST_DATA']);
           // echo $tis->xml;die;
           // file_put_contents('/phpstudy/www/1.txt',$this->xml,0);
            switch($this->xml->MsgType){
                case 'text':
                     $this->responeText();
                     break;
                case 'event':
                     $this->responeEvent();
                ;break;
            }
      
        }

        public function responeText(){
            $con ="";
            switch($this->xml->Content){
                case'你好':
                    $con = "好";
                    break;
                case "你好啊":
                    $con = "没毛病";
                    break;
                default:
                    $con = "啦啦啦[鄙视]";
                    break;
            }
            $this->sendResponse($con);
        }

        public function responseEvent(){
            switch($this->xml->EventKey){
                case 'rewen':
                    $con = "熱文";break;
                case 'news':
                    $con = "實時新聞";break;
                default:
                    $con = '你的是空虚吗？';break;
            }
            $this->sendResponse($con);
        }

        public function  actionSetmenu(){
            $token=$this->actionToken();
            echo $token,"<br>";
            $arr = [
                "button"=>[
                    [
                        'type'=>'click',
                        'name'=>'時訊',
                        'key'=>'news'
                    ],
                    [
                        'name'=>'JS-SDK',
                        'sub_button'=>[
                          [
                            'type'=>'view',
                            'name'=>'JS-SDK',
                            'url'=>'http://47.93.251.43/Wchat/backend/web/index.php?r=contro/jss'
                          ],
                          [
                            'type'=>'click',
                            'name'=>'抽奖',
                            'key'=>'choujiang',
                          ]
                        ]
                    ],
                    [
                        'name'=>'网页授权',
                        'sub_button'=>[
                            [
                                'type'=>'view',
                                'name'=>'静默授权',
                                'url'=>'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx5ae9c35eaa769498&redirect_uri=http%3A%2F%2F47.93.251.43%2FWchat%2Ffrontend%2Fweb%2Findex.php%3Fr%3Dlogin%2Fshouquan&response_type=code&scope=snsapi_base&state=123#wechat_redirect'
                            ],
                            [
                                'type'=>"view",
                                'name'=>'非静默授权',
                                'url'=>"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx5ae9c35eaa769498&redirect_uri=http%3A%2F%2F47.93.251.43%2FWchat%2Fbackend%2Fweb%2Findex.php%3Fr%3Dcontro%2Fnomore&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect"
    
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

        public function sendResponse($con,$msg_type='text'){
            $xml='<xml>'
              .'<ToUserName><![CDATA['.$this->xml->FromUserName.']]></ToUserName>'
              .'<FromUserName><![CDATA['.$this->xml->ToUserName.']]></FromUserName>'
              .'<CreateTime>'.time().'</CreateTime>'
              .'<MsgType><![CDATA['.$msg_type.']]></MsgType>';
              switch($msg_type){
                  case 'text';
                  $xml.='<Content><![CDATA['.$con.']]></Content>';break;
                  case 'news':
                  $xml .='<ArticleCount>1</ArticleCount>'
                  .'<Articles>'
                  .'<item>'
                  .'<Title><![CDATA['.$con.']]></Title>'
                  .'<Description><![CDATA[介绍]]></Description>'
                  .'<PicUrl><![CDATA[www.baidu.com]]></PicUrl>'
                  .'<Url><![CDATA[www.baidu.com]]></Url>'
                  .'</item>'
                  .'</Articles>'; 
                  ;break;
              }
              $xml.='</xml>';
             echo $xml;
         }
}