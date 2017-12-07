<?php
namespace frontend\controllers;
use yii;
use yii\web\Controller;
class IndexController extends Controller{

    public  $enableCsrfValidation=false;
    public $appID='wx5ae9c35eaa769498';
    public $appsecret ='=de9e005fd6cf46babe4bd4bda21f5c0f';
    public $xml;
    
    public function actionIndex(){
       if($echostr = yii::$app->request->get('echostr')){
           echo $echostr;
           exit();
       }
       $token=$this->getToken();
      // echo $token;die;
       $url ='https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$token;
       $arr=[
           'button'=>['type'=>'click',
               'name'=>'你点我啊哈哈哈',
               'key'=>'dian'],
            'button'=> ['type'=>'news',
               'name'=>'时讯',
               'key'=>'lla'
               ]
           ];
           $json = json_encode($arr,JSON_UNESCAPED_UNICODE );
        echo  $this->send_request($url,$json,1);
    //    $this->xml = simplexml_load_string($GLOBALS['HTTP_RAW_POST_DATA']);
    //    file_put_contents("1.txt","123123132");
    //     switch($this->xml->MsgType){
    //         case 'text':
    //              $this->responeText();
    //              break;
    //         case 'event':
    //              $this->responeEvent();
    //         ;break;

    //     }
    }

    public function send_request($url,$data=" ",$post=false){
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        if($post){
            curl_setopt($ch,CURLOPT_POST,1);
            curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
        }
        $return = curl_exec($ch);
        curl_close($ch);
        return $return;          
    }

    public function getToken(){

         $api = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='
             .$this->appID.'&secret ='.$this->appsecret;
         $json = $this->send_request($api);
         return $json;
    }
    public function home(){

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

