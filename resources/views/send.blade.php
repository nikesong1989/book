<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>菜鸟教程(runoob.com)</title>
    <script src="http://cdn.static.runoob.com/libs/jquery/1.10.2/jquery.min.js">
    </script>
    <script>
        $(document).ready(function()
        {
            $("button").click(function()
            {

                $.ajax(
                        {
                            url:"ajaxsvr",    //请求地址
                            type:'POST',        //请求方法 POST 类型必须有Token以支持Laravel
                            dataType:'json',  //请求和返回数据类型
                            data:{phone:$('#phone').val(),_token:'{{ csrf_token() }}'}, //发送的数据
                            success:function(result)   //请求成功时执行
                            {
                                if(result.status==1) {

                                    $("#box").html(result.message);
                                }
                            },
                            error: function(xhr, status, error) {   //请求失败时执行
                                $("#box").html(status +'_'+ error);  //输出错误状态和信息

                            }
                        }
                );
            });
        });
    </script>
</head>
<body>

<div><h2> AJAX 可以修改文本内容</h2></div>
<input type="text" id="phone">
<button>修改内容</button>
<p id="box">model</p>
</body>
</html>