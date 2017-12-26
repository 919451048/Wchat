<div>
<h1>测试</h1>
</div>
<script src='http://res.wx.qq.com/open/js/jweixin-1.2.0.js'></script>
<script>
wx.config({
    debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
    appId: '<?php echo $appid?>', // 必填，公众号的唯一标识
    timestamp: '<?php echo $data['timestamp']?>', // 必填，生成签名的时间戳
    nonceStr: '<?php echo $data['noncestr'] ?>', // 必填，生成签名的随机串
    signature:'<?php echo $string ?>',// 必填，签名，见附录1
    jsApiList: [
    	'onMenuShareTimeline'
    ] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2 	

});
wx.ready(function(){
     wx.onMenuShareTimeline({
        title: '这是我分享的标题', // 分享标题
        link: 'http://47.93.251.43/phpinfo.php', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
        imgUrl: 'http://www.baidu.com/img/bd_logo1.png', // 分享图标
        success: function () {
            
        },
        cancel: function () {
         // 用户取消分享后执行的回调函数
        }
    });
    
})



</script>