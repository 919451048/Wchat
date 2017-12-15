<?php
namespace frontend\controllers;
use yii;
use yii\web\Controller;
class CommonController extends Controller{


    public $appID="wx5ae9c35eaa769498";
    public $appsecret="de9e005fd6cf46babe4bd4bda21f5c0f";

    public function actionToken(){
        $sql="select value,time from type where id =1";
        $arr=yii::$app->db->createCommand($sql)->queryOne();
        $token=$arr['value'];
        if($arr['time']<time()){
            $url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$this->appID."&secret=".$this->appsecret;
            $json=$this->curl_request($url);
            $data=json_decode($json,true);
            $token=$data['access_token'];
            $time=time()+7000;
            yii::$app->db->createCommand()->update('type',['time'=>$time,'value'=>$token])->execute();
        }
       return $token;
    }

    public function  curl_request($url,$data="",$post=false){
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
        if($post!=false){
            curl_setopt($ch,CURLOPT_POST,1);
            curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
        }
        $return = curl_exec($ch);
        curl_close($ch);
        return $return;
    }
}