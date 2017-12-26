<?php 
namespace frontend\controllers;

use yii;
use  yii\web\Controller;

class EmailController extends Controller{
	public  $enableCsrfValidation=false;
	public function actionIndex(){
		if(yii::$app->request->isPost){
			
			// foreach($_POST['email'] as $k=>$v){
			//  $res=yii::$app->db->createCommand()->insert('email',['email'=>$v])->execute();
			// $res || die($k.'添加失败了');
			// }

			$redis= yii::$app->redis;
			print_r($redis);

		}else{

		 	return $this->render('index');
		
		}
	}

}



 ?>