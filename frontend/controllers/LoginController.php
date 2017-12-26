<?php 
namespace frontend\controllers;

use yii;
use frontend\controllers\CommonController;

class LoginController extends CommonController{

	public  $enableCsrfValidation=false;
	public $layout= false;
	public function actionIndex(){
		$url='https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$this->actionToken();
		$data =[
			'action_name'=>'QR_LIMIT_SCENE',
			'action_info'=>[
				'scene'=>[
				'scene_id'=>123
				]
			]
		];
		$json = json_encode($data,JSON_UNESCAPED_UNICODE);
		$res=$this->curl_request($url,$json,1);
		var_dump($res);
		echo "<br>";
		$arr=json_decode($res,true);
		$ticket=urlencode($arr['ticket']);
		$uri='https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.$ticket;
		$res=$this->curl_request($uri);
		$res=file_put_contents('./img/ticket.png',$res);
	}

	public function actionSaoma(){
		return $this->render('demo');
	}
	public function actionShouquan(){
			$code = yii::$app->request->get('code');
			$url ='https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$this->appID.'&secret='.$this->appsecret.'&code='.$code.'&grant_type=authorization_code';
			$res=$this->curl_request($url);
			$data = json_decode($res,true);
			$openid = $data['openid'];
			$url='https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$this->actionToken().'&openid='.$openid.'&lang=zh_CN';
			$res=$this->curl_request($url);
			$data = json_decode($res,true);
			$arr=[];
			$arr['open_id']=$openid;
			$arr['nick_name']=$data['nickname'];
			$arr['headimg']=$data['headimgurl'];
			$arr['city']=$data['city'];
			$arr['province']=$data['province'];
			$arr['status']=$data['subscribe'];
			$arr['password']='000000';
			$sql = "select id,nick_name from users where `open_id`='".$openid."'";$dd=yii::$app->db->createCommand($sql)->queryOne();
			if(empty($dd)){
			yii::$app->db->createCommand()->insert('users',$arr)->execute();
			}
			return $this->render('redirect.php',['data'=>$data,'openid'=>$openid]);

	}

	public function actionReset(){
		if(yii::$app->request->isGet){
			$openid=yii::$app->request->get('openid');
		$sql = "select * from users where `open_id`='".$openid."'";
		$data=yii::$app->db->createCommand($sql)->queryOne();
		return $this->render('reset',['data'=>$data]);
	}else{

			$openid = yii::$app->request->get('openid');	
			$npwd = yii::$app->request->post('npwd');
			//echo $openid,",,,",$npwd;die();
			$res=yii::$app->db->createCommand()->update('users',['password'=>$npwd],['open_id'=>$openid])->execute();	
			if($res){
				echo "修改成功";
			}
		}
	}

	public function actionLogin(){
		if(yii::$app->request->isGet){
			return $this->render('login');
		}else{
			$data =$_POST;
			$nickname=$data['nickname'];
			$password=$data['password'];
			$sql = 'select id from users where nick_name ="'.$nickname.'" and password ="'.$password.'"';
		$res=yii::$app->db->createCommand($sql)->queryOne();	
		if($res){
			echo "登录成功";
			if($password=='000000'&&strlen($password)==6){
				echo "<br>";
				echo  "您尚未重置密码,请尽快去重置密码";
			}
		}
		}
	}
	public function actionDel(){

		$openid=yii::$app->request->get('openid');
		$sql = "delete from users where open_id = '".$openid."'";
		$res=yii::$app->db->createCommand($sql)->execute();
		if($res){
			echo "解绑成功";die();
		}
	}


}



 ?>