$(function(){
    var isAjax=false;
$("#fabu").click(function(){
    var k=$("#qq").val(); 
  
  //^表示不匹配。d表示任意数字，{5,10}表示长度为5到10。   
  var reg=/^\d{5,11}$/;    
  
  //用上面定义的正则表达式测试，如果不匹配则返回false   
  if(!reg.test(k)){   
    alert("请输入你正确的QQ号");   
    return false;   
  }   
    if(isAjax)
    return;
isAjax=true;
setTimeout(function(){
isAjax=false;
},5000);

//$("div").css(("background","red");// display: block;
    var a=$("#nicheng").val();
    var b=$("#qq").val();
    var c=$("#simi option:selected").val();
    var d=$("#yzm").val();
    var e1=$("#content_liuyan").val();
    var e=AnalyticEmotion(e1);
    $.post("insert.php",{
        name:a,
        QQ:b,
        simi:c,
        yzm:d,
        content:e
    },function(res){
     $("#user_city").html(res.local);
     $("#user_name").html(res.name);
     $("#user_time").html(res.time);
     $("#layer").html("刚刚留言");
     $("#user_content").html(res.content);
     $("#user_qq").attr("src",res.src);
    $("#add").css("display","block");
    $("input").val('');
    $("textarea").val('');
    //
    })
$("html,body").animate({scrollTop:0}, 500);

});
});

