<div class="container main-content">
        <h1 class="text-center">欢迎登录</h1>
        <div class="clearfix">
            <div class="signin card-user">
             <?php
                if(isset($_REQUEST['login'])&&isset($_POST['Account'])&&isset($_POST['Password'])){
                    try{
                        if(PD::Run('Account.Login',$_POST)){
                            header("Location:/account"); exit;
                        }else{
                            echo PD::GetHTML_Alert('登录出错了','可能是用户名或者密码错误了');
                        }
                    }catch (Exception $e) {
                        echo PD::GetHTML_Alert($e->getMessage());
                    }
                }            
            ?>
                <img class="profile-img" src="/public/img/accounts/avatar_2x.png" alt="">
                <p class="profile-name"></p>
                <form method="post" id="mainForm" action="?login">
                    <input id="user_account" name="Account" type="text" placeholder="电子邮件或者手机号" value="" spellcheck="false">
                    <input id="user_password" name="Password" type="password" placeholder="密码">
                    <button type="submit" id="btn_Login" class="btn btn-lg btn-danger" tabindex="0"><i class="glyphicon glyphicon-log-in"></i><span class="ind1">登录</span></button>                    
                </form>          
                <a href="/account/sign">需要帮助?</a>
            </div>            
        </div>
        <div class="clearfix text-center">
            <a href="/account/sign">还没有账号，注册账号</a>
        </div>
    </div>

<script>
$(document).ready(function(e) {
    $('#btnsubmit').click(function(e) {
        var self = $(this);
        var tagID = '#user_name';
        var istest = true;
        if (!$(tagID).val()) {
            $(tagID).focus().parent().addClass('has-error');
            Fanx.Error('姓名不能留空,为方便我们称呼您，请输入!');
            istest = false;
        } else {
            $(tagID).parent().removeClass('has-error');
        }
        tagID = '#user_account'
        if (!$(tagID).val()) {
            $(tagID).focus().parent().addClass('has-error');
            Fanx.Error('账号不能留空!');
            istest = false;
        } else {
            $(tagID).parent().removeClass('has-error');
        }
        tagID = '#user_password'
        if (!$(tagID).val()) {
            $(tagID).focus().parent().addClass('has-error');
            Fanx.Error('密码不能留空!');
            istest = false;
        } else {
            $(tagID).parent().removeClass('has-error');
        }
        if(istest){
            $('#mainForm').submit();
        }
        return false;
    });
});
</script>
