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
.view{
    float: left;
    width: 300px;
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 10px 20px;
    background: #fff;
    margin-top: 20px;
}

.view .title p{
    margin-top: 5px;
}

.view .title .time{
    font-size: 14px;
    color: #666;
}

.view img{
    width: 300px;
    height: 260px;
    margin-top: 15px;
}

.view .desc{
    font-size: 14px;
    color: #999;
    margin-top: 15px;
    border-bottom: 1px solid #ddd;
    padding-bottom: 10px;
}

.view .handler{
    font-size: 14px;
    margin-top: 10px;
}

.view .handler .handler_text{
    float: left;
}

.view .handler_symbol{
    float: right;
    color: #999;
}

.edit{
    width: 500px;
    float: right;
    border: 1px solid #ddd;
    border-radius: 5px;
    margin-top: 20px;
    padding-left: 10px;
}

.edit .title{
    width: 400px;
    height: 40px;
    font-size: 16px;
    margin-top: 10px;
}

.edit .desc{
    width: 490px;
    height: 100px;
    padding-top: 5px;
    font-size: 16px;
    margin-top: 10px;
}

.edit .content{
    width: 490px;
    height: 300px;
    padding-top: 5px;
    font-size: 16px;
    margin-top: 10px;
}
</style>

<div class="top">
    <h2>微信消息群发</h2>
</div>

<div class="main">

    <div class="view">
        <div class="title">
            <p>图文消息标题</p>
            <p class="time">12月11日</p>
        </div>
        <div class="img">
            <img src="./82764.jpg" alt="" width=300 height=500>
        </div>
        <div class="desc">
            这里是文字描述这里是文字描述这里是文字描述这里是文字描述这里是文字描述
        </div>
        <div class="handler">
            <span class="handler_text">阅读全文</span>
            <span class="handler_symbol">></span>
        </div>
    </div>
    <div class="edit">
        <form action="" method="post" >
            <input class="title input" type="text"  name="title" id="title" placeholder="请输入标题">

            <input type="file" value="AjaxUpload" name="time" style="margin-top: 10px;">

            <textarea class="desc input" name="desc" id="desc" cols="30" rows="10" placeholder="请输入描述"></textarea>

            <textarea class="content input" name="content"  cols="30" rows="10" placeholder="请输入内容"></textarea>

            <input type="submit" class="a_button" style="margin: 10px auto;" value="保存并发送">
        </form>
    </div>
</div>
<script src="./jquery.min.js"></script>
<script>
$("#title").blur(function(){
    var val=$(this).val();
    $(".title p:first").html(val);
    $(".title p:last").html("<?php echo date('m 月 d 日') ?>");
})

$("#desc").blur(function(){
    var val=$(this).val();
    console.log(val);
    $(".desc").html(val);
})


</script>
