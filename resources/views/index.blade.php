@extends('master')

@section('title', '注册')

@section('content')
    {{--<form action="{{ url('/service/validate_phone/send') }}" method="post">--}}
        {{--{{ csrf_field() }}--}}

        {{--手机注册--}}
        <div class="weui_cells weui_cells_form">
            <div class="weui_cell">
                <div class="weui_cell_hd"><label class="weui_label">手机号</label></div>
                <div class="weui_cell_bd weui_cell_primary">
                    <input class="weui_input" type="number" placeholder="" name="phone"/>
                </div>
            </div>

            <div class="weui_cell">
                <div class="weui_cell_hd"><label class="weui_label">手机验证码</label></div>
                <div class="weui_cell_bd weui_cell_primary">
                    <input class="weui_input" type="number" placeholder="" name='phone_code'/>
                </div>
                <p class="bk_important bk_phone_code_send" >发送验证码</p>
                <div class="weui_cell_ft">
                </div>
            </div>
            <div class="weui_cell">
                <div class="weui_cell_hd"><label class="weui_label">密码</label></div>
                <div class="weui_cell_bd weui_cell_primary">
                    <input class="weui_input" type="password" placeholder="不少于6位" name='password'/>
                </div>
            </div>
            <div class="weui_cell">
                <div class="weui_cell_hd"><label class="weui_label">确认密码</label></div>
                <div class="weui_cell_bd weui_cell_primary">
                    <input class="weui_input" type="password" placeholder="不少于6位" name='confirm'/>
                </div>
            </div>
        </div>




        <div class="weui_cells_tips"></div>
        <div class="weui_btn_area">
            {{--<a class="weui_btn weui_btn_primary" href="/service/register" >注册</a>--}}
            <input type="submit" class="weui_btn weui_btn_primary" value="注册">
        </div>
        <a href="/login" class="bk_bottom_tips bk_important">已有帐号? 去登录</a>
    {{--</form>--}}
@endsection

@section('my-js')

    <script>
        $('.bk_phone_code_send').click(function()
                {
                    $('.bk_toptips').show();
                    $('.bk_toptips span').html($('input[name=phone]').val());
                    setTimeout(function() {$('.bk_toptips').hide();}, 2000);
                    $.ajax({
                        type:'post',

                        url:'ajaxsvr',
                        data: { _token: "{{csrf_token()}}" ,phone:$('input[name=phone]').val()},
                        success:function(msg){
                            $('.bk_toptips').show();
                            $('.bk_toptips span').html(msg);

                        },
                        error:function(msg) {
                            $('.bk_toptips').show();
                            $('.bk_toptips span').html(msg);

                        }

                    });
                }
        );
    </script>

<script>
    $('1_actioncode').click(function ()
    {
        $.ajax({
            url: 'codesend',
            type: 'POST',
            dataType: 'json',
            cache: false,
            data: {
                phone: phone,
                _token: "{{csrf_token()}}"},
            success: function(data) {
                if(data == null) {
                    $('.bk_toptips').show();
                    $('.bk_toptips span').html('服务端错误');
                    setTimeout(function() {$('.bk_toptips').hide();}, 2000);
                    return;
                }
                if(data.status != 0) {
                    $('.bk_toptips').show();
                    $('.bk_toptips span').html(data.message);
                    setTimeout(function() {$('.bk_toptips').hide();}, 2000);
                    return;
                }

                $('.bk_toptips').show();
                $('.bk_toptips span').html('发送成功');
                setTimeout(function() {$('.bk_toptips').hide();}, 2000);
            },
            error: function(xhr, status, error) {
                console.log(xhr);
                console.log(status);
                console.log(error);
            }
        });
    });
</script>

@endsection
