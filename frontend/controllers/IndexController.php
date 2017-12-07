<?php
namespace frontend\controllers;
use yii;
use yii\web\Controller;
class IndexController extends Controller{

    public  $enableCsrfValidation=false;

    public $xml;
    
    public function actionInit(){
        
    }
    public function actionIndex(){
       if($echostr = yii::$app->request->get('echostr')){
           echo $echostr;
           exit();
       }
       $this->xml = simplexml_load_string($GLOBALS['HTTP_RAW_POST_DATA']);
       file_put_contents("1.txt","123123132");
        switch($this->xml->MsgType){
            case 'text':
                 $this->responeText();
                 break;
            case 'event':
                 $this->responeEvent();
            ;break;

        }
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

