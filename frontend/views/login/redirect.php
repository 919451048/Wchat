<meta charset="utf8">

<style>
table{ border-collapse: collapse; border: 1px solid #ddd; width: 800px; margin: 0 auto;margin-top: 50px; background: rgba(121, 217, 221, 0.4); color: #666}
table tr{ height: 40px;}
table td{ border: 1px solid #ddd; text-align: center}

*{margin: 0; padding:0 ; font-family: 微软雅黑}
a{ text-decoration: none; color: #666;}

.top{ width: 100%; text-align: center;}
.top h2{ margin-top: 50px;}

.a_button{
    width: 150px;
    height: 40px;
    line-height: 40px;
    text-align: center;
    background: green;
    color: #fff;
    display: block;
    border: 1px solid green;
    border-radius: 5px;
    margin: 0 auto;
    margin-top: 20px;
}

.input{
    border: 1px solid #ddd;
    border-radius: 5px;
    padding-left: 10px;
}

.main{
    width: 900px;
    margin: 0 auto;
}

.qrcode{
    width: 300px;
    margin: 0 auto;
    margin-top: 20px;
}

img{
    width: 300px;
}

p{
    width: 300px;
    text-align: center;
    margin-top: 10px;
}

.click_here{
    color: red
}
</style>

<?php 
use  yii\helpers\Url;
print_r($data);
 ?>
<div class="top">
    <h2>微信回调页面</h2>
</div>

<div class="main">
    <div class="qrcode">
        <img src="<?php echo $data['headimgurl'] ?>" alt="">
        <p>欢迎：  <?php echo $data['nickname'] ?> </p>
    <?php 
    $sql = "Select * from users where open_id ='".$openid."'";
    $arr=yii::$app->db->createCommand($sql)->queryOne();
    if($arr['password']=="000000"&&strlen($arr['password'])==6){
        ?>
    <p>您尚未重置密码，<a class="click_here" href="<?php echo Url::toRoute(['login/reset','openid'=>$openid]) ?>">点击这里</a>重置</p>
    <?php
    }
    ?>
    <?php 
        if(!empty($arr)){
            //判断 是否与 微信绑定
            ?>
            <a href="<?php echo Url::toRoute(['login/del','openid'=>$openid]) ?>" class="a_button">解绑</a>
            <?php
        }
     ?>
        

        <a href="<?php echo Url::toRoute(['login/login'])?>" class="a_button">退出</a>
    </div>
</div>
