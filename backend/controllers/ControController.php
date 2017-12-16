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
            move_uploaded_file($file['tmp_name'],'./img/'.$name.'.jpg');
            //print_r($file);
            $file_info =[
                'filename'=>'phpstudy/www/Wchat/backend/web/img/'.$name.'.jpg',
                'content-typ'=>$file['type'],
                'filelength'=>$file['size']
            ];
            $data = ['mediz'=>$file_info['filename'],"form-data"=>$file_info];
              $url="https://api.weixin.qq.com/cgi-bin/material/add_material?access_token=".$this->actionToken();
        // //    $data=[
        // //     "articles"=> [
        // //         "title"=>"标题",
        // //         "thumb_media_id"=>"longlong",
        // //         "author"=>"冯彪",
        // //         "digest"=>"图片测试",
        // //         "show_cover_pic"=>0,
        // //         "content"=>'<img src="./img/beautgirl.jpg">',
        // //         "content_source_url"=>"http://47.93.251.43/Wchat/backend/web/img/beatgirl.jpg",
        // //         ]
        // //     ];       
        $json = json_encode($data,JSON_UNESCAPED_UNICODE);
        $da=$this->curl_request($url,$json,1);
            var_dump($da);
        }     
    }
}

