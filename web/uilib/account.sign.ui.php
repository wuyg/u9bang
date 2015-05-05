<?php
//注册用户
if(isset($_REQUEST['sign'])&&isset($_POST['Account'])){
     try{
        $uid=PD::Run('Account.Sign',$_POST);
        if($uid&&$uid>0){
            header("Location:/account/signv?Account=".$_POST['Account']); exit;
        }else{
            echo PD::GetHTML_Alert('提示','注册失败了!');
        }
    }catch (Exception $e) {
        echo PD::GetHTML_Alert($e->getMessage());
    }
}
?>

    <div class="container main-content">
        <h1 class="text-center">创建您的 U9 帐户</h1>

        <div class="clearfix">
            <div class="sign-box pull-right col-md-6">
                <form method="post" id="mainForm" action="?sign">
                    <div class="form-group need">
                        <label for="user_name">姓名</label>
                        <input type="text" class="form-control" name="Name" id="user_name" placeholder="输入您的真实姓名">
                    </div>
                    <div class="form-group need">
                        <label for="user_account">账号</label>
                        <input type="text" class="form-control" name="Account" id="user_account" placeholder="电子邮箱">
                        <p class="help-block">我们会向此地址发送一封电子邮件，验证您是否佣有该邮件地址。
                        </p>
                    </div>
                    <div class="form-group need">
                        <label for="user_password">密码</label>
                        <input type="password" class="form-control" name="Password" id="user_password">
                        <p class="help-block">请至少使用 6 个字符。请勿使用您用于登录其他网站的密码或容易被猜到的密码</p>
                    </div>
                    <div class="form-group">
                        <label for="user_phone">手机号码</label>
                        <input type="text" class="form-control" name="Phone" id="user_phone" placeholder="手机号">
                        <p class="help-block">我们会向您发送一条短信，验证手机号是否正确，同时，此内容也是我们帮助您找回密码的重要信息
                        </p>
                    </div>
                    <div class="form-group need">
                        <div class="radio">
                            <label>
                                <input type="radio" name="Gender" value="1">男
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="Gender"  value="2">女
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <a href="/account/login" class="pull-left">我有帐号，直接登录</a>
                        <button type="button" id="btnsubmit" class="btn btn-success pull-right">立即注册</button>
                    </div>
                </form>
            </div>
            <div class="side-content pull-left col-md-6">
                <h2>您只需注册一个帐户即可</h2>
                <p>只需一组用户名和密码，即可畅享 U9 所有产品和服务。</p>
                <img src="/public/img/accounts/logo_strip_sign_up_2x.png" height="24px" width="311px">
                <h2>随时随地使用</h2>
                <p>从一台设备换到另一台设备时，会紧接着上次中断处继续。</p>
                <img src="/public/img/accounts/devices_2x.png" height="172px" width="300px">
            </div>
        </div>
    </div>
<script>
$(document).ready(function(e) {
    $('#btnsubmit').click(function(e) {
        var self = $(this);
        var tagID = '#user_name';        
        var istest = true;
        var data={};
        if (!$(tagID).val()) {
            $(tagID).focus().parent().addClass('has-error');
            Fanx.Error('姓名不能留空,为方便我们称呼您，请输入!');
            istest = false;
        } else {
            $(tagID).parent().removeClass('has-error');
            data.Name=$(tagID).val();
        }
        tagID = '#user_account'
        if (!$(tagID).val()) {
            $(tagID).focus().parent().addClass('has-error');
            Fanx.Error('账号不能留空!');
            istest = false;
        } else {
            $(tagID).parent().removeClass('has-error');
            data.Account=$(tagID).val();
        }
        tagID = '#user_password'
        if (!$(tagID).val()) {
            $(tagID).focus().parent().addClass('has-error');
            Fanx.Error('密码不能留空!');
            istest = false;
        } else {
            $(tagID).parent().removeClass('has-error');
        }
        if(!Fanx.IsEmail(data.Account)){
            Fanx.Error('您输入的账号格式不正确，请输入您当前有效的电子邮箱!');
            istest = false;
        }
         if(istest){
            self.addClass('disabled');
            Fanx.Run('Account.SignCheck',{Account:data.Account},function(result,error,e){  
                if(error){
                  Fanx.Error(error);
                }else{
                  if(result.su){                   
                   $('#mainForm').submit();
                  }
                }
                self.removeClass('disabled');                
              },{type:"POST"});
        }
        return false;
    });
});
</script>
