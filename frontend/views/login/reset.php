<meta charset="utf8">

<style>
table{ border-collapse: collapse; border: 1px solid #ddd; width: 800px; margin: 0 auto;margin-top: 50px; background: rgba(121, 217, 221, 0.4); color: #666}
table tr{ height: 40px;}
table td{ border: 1px solid #ddd; text-align: center}

*{margin: 0; padding:0 ; font-family: 微软雅黑}
a{ text-decoration: none; color: #666;}

.top{ width: 100%; text-align: center;}
.top h2{ margin-top: 50px;}

form{ width: 450px; margin: 0 auto; margin-top: 50px;}
form input{
    width: 300px;
    height: 40px;
    border: 1px solid #ddd;
    border-radius: 5px;
    padding-left: 5px;
    font-size: 14px;
}

form p{
    margin-top: 20px;
    width: 100%;
}

form span{
    width: 120px;
    text-align: right;
    display: inline-block;
}

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
}

form .time{
    width: auto;
    padding: 0 5px;
    font-size: 16px;
    font-weight: bold;
}

.remind{
    text-align: center;
    color: red;
}
</style>

<div class="top">
    <h2>密码重置</h2>
</div>

<div class="main">
    <form action="" method="post">
        <p>
            <span>请输入新密码：</span>
            <input type="text" name='npwd'  id ='npwd' placeholder="请输入新密码："><span id='sp'></span>
        </p>
        <p>
            <span>确认密码：</span>
            <input type="password" id='rpwd' placeholder="请输入确认密码："><span id='span'></span>
        </p>
        <p>
            <input type="submit" value="重置" class="a_button">
        </p>
    </form>
</div>
<script src='./jquery.min.js'></script>
<script>

$('#npwd').blur(function(){
    npwd=$(this).val();
    opwd="<?php echo $data['password'] ?>"
    if(npwd==opwd){
        
        alert('新密码与旧密码不能一致')
    }
    if(npwd==000000&&npwd.length==6){
        
        alert('新密码与旧密码不能一致')
    }
    if(npwd!==opwd){
         $('#sp').css('color','green');
        $('#sp').html('正确')
    }
})
$('#rpwd').blur(function(){
    rpwd =$(this).val();
    npwd=$('#npwd').val();
        if(rpwd!=npwd){
       
        alert('两次输入不一致')
        }else{
         $('#span').html("正确");
         $('#span').css('color','green');
        }
})
</script>