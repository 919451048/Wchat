<?php
namespace frontend\controllers;
use yii;
use yii\web\Controller;
class IndexController extends Controller{

    public  $enableCsrfValidation=false;
    public $appID='wx5ae9c35eaa769498';
    protected $secret="de9e005fd6cf46babe4bd4bda21f5c0f";
    public $xml;
    
    public function actionIndex(){
       if($echostr = yii::$app->request->get('echostr')){
           echo $echostr;
           exit();
       }
      // echo $token;die;
       $this->xml = simplexml_load_string($GLOBALS['HTTP_RAW_POST_DATA']);
        switch($this->xml->MsgType){
            case 'text':
                 $this->responeText();
                 break;
            case 'event':
                 $this->responeEvent();
            ;break;
        }
    }
    public function  actionSetmenu(){
        $token=$this->getToken();
       // echo $token;die;
        $url ='https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$token;
        $json = [
            'button'=>[
                [
                    'type'=>'click',
                    'name'=>'今日热文',
                    'key'=>'lla',
                ],
                [
                    'type'=>'click',
                    'name'=>'时讯',
                    'key'=>'lla',
                ]

                // ],
                // [
                //     'name'=>'时讯',
                //     'sub_burron'=>[
                //         ['type'=>'view',
                //         'name'=>'搜索',
                //         'url'=>'www.baidu.com',
                //         ],
                //         [
                //             'type'=>'click',
                //             'name'=>'wxa',
                //             'key'=>'aaaa',
                //         ],
                //     ]
                // ]
            ]
        ];
        $jsson = json_encode($json,JSON_UNESCAPED_UNICODE);
      //  echo $jsson;die;
        $res = $this->send_request($url,$jsson,1);
        var_dump($res);
    }

    public function send_request($url,$data=" ",$post=false){
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        if($post!=false){
            curl_setopt($ch,CURLOPT_POST,1);
            curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
        }
        $return = curl_exec($ch);
        curl_close($ch);
        return $return;          
    }
    public function getToken(){

        $api='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx5ae9c35eaa769498&secret=de9e005fd6cf46babe4bd4bda21f5c0f';
        
        $json = $this->send_request($api);
        $arr=json_decode($json,true);
        return $arr['access_token'];
        //print_r($json);
    }
    /**
     * 文本处理方法
     * 
     */
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

    public function responeEvent(){
        switch($this->xml->EventKey){
            case 'test':
                $con = "点击测试";break;
            case 'click':
                $con = "点赞测试";break;
            default:
                $con = '你的是空虚吗？';break;
        }
        $this->sendResponse($con);
    }

    public function sendResponse($con,$msg_type='news'){
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
             .'<Title><![CDATA[标题]]></Title>'
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
?>

