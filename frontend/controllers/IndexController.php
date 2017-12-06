<?php
namespace frontend\controllers;
use yii;
use yii\web\Controller;
class IndexController extends Controller{

    public  $enableCsrfValidation=false;

    public $xml;
    
    public function actionInit(){
        $this->xml = simplexml_load_string($GLOBALS['HTTP_RAW_POST_DATA']);
        file_put_contents("1.txt","123123132");
         switch($this->xml->MsgType){
             case 'text':
                  $this->responeText();
                  break;
         }
    }
    public function actionIndex(){
       if($echostr = yii::$app->request->get('echostr')){
           echo $echostr;
           exit();
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
                $con = "号";
                break;
            case "年后吗":
                $con = "没毛病";
                break;
            default:
                $con = "lalal[鄙视]";
                break;
        }
        $this->sendResponse($con);
    }

    public function sendResponse($con,$msg_type='text'){
       $xml='<xml>'
         .'<ToUserName><![CDATA['.$this->xml->formUser.']]></ToUserName>'
         .'<FromUserName><![CDATA['.$this->xml->toUser.']]></FromUserName>'
         .'<CreateTime>'.time().'</CreateTime>'
         .'<MsgType><![CDATA['.$msg_type.']]></MsgType>'
         .'<Content><![CDATA['.$con.']]></Content></xml>';
        echo $xml;
    }
}
?>

