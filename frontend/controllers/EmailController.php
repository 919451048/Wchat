<?php 
namespace frontend\controllers;

use yii;
use  yii\web\Controller;
class EmailController extends Controller{

	public  $enableCsrfValidation=false;
	public function actionIndex(){
		if(yii::$app->request->isPost){
			
			$redis= yii::$app->redis;
			//print_r($redis);die;
			foreach($_POST['email'] as $k=>$v){
				if(empty($v)){
					continue;
				}
			 $res=yii::$app->db->createCommand()->insert('email',['email'=>$v])->execute();
				if($res){
						$redis->lpush('email',$v);
				}
			}
			$length=$redis->llen('email');
			echo $length."个"."邮件等待发送";
		}else{

		 	return $this->render('index');
		
		}

	}

	public function actionGo(){
		$mail= Yii::$app->mailer->compose();
		$redis= yii::$app->redis;
		$lala=$redis->rpop('email');
		echo "$lala","<br>";
		yii::$app->db->createCommand()->update('email',['status'=>1],['email'=>$lala])->execute();
		$mail->setTo("$lala");  
		$mail->setSubject("邮件测试");  
		$mail->setTextBody('你好啊');   //发布纯文字文本
		$length=$redis->llen('email');
		if($mail->send()){
			echo "success",$length,"个","邮件等待发送";
		}else{
			echo "error",$length,"个","邮件等待发送";
		}
	}

}



 ?>