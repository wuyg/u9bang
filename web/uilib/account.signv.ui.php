<?php
//验证码验证
if(isset($_REQUEST['vkvalidate'])&&isset($_POST['Account'])&&isset($_POST['VKey'])){
    try{
        if(PD::Run('Account.KeyValidate',$_POST)){
            header("Location:/account/"); exit;
        }else{
            echo PD::GetHTML_Alert('提示','验证码错误!');
        }
    }catch (Exception $e) {
        echo PD::GetHTML_Alert($e->getMessage());
    }
}

if(!isset($_REQUEST['Account'])&&!isset($_POST['Account'])){
    die('火人星入侵！！！!');
}

$account="";
if(isset($_REQUEST['Account'])){
    $account=$_REQUEST['Account'];
}
if(isset($_POST['Account'])){
    $account=$_POST['Account'];
}
$MainData=PD::Run('Account.Item',array("Account"=> $account));
if(!$MainData){
    die('用户数据不合法!');
} 
?>

    <div class="container main-content">
        <h1>验证您的帐户</h1>
        <p class="text-center">就要大功告成了！在我们验证您的帐户后，您就可以开始使用了。</p>
        <div class="signin card-user">
            <img class="profile-img" src="/public/img/accounts/avatar_2x.png" alt="">
            <p class="profile-name"></p>
            <form class="form-horizontal" action="?vkvalidate" method="post">
                <div class="form-group form-group-lg">
                    <label class="col-sm-3 control-label">账号</label>
                    <div class="col-sm-6">
                        <?php
                            echo '<input class="form-control" id="usre_account" value="'.$MainData->Account.'" disabled="disabled" type="text">';
                            echo '<input type="hidden" name="Account" value="'.$MainData->Account.'">';
                        ?>
                    </div>
                    <div class="col-sm-3">
                    <?php
                        if($MainData->Total_VKeys<10){
                            echo '<a  class="btn btn-primary" id="btnsendvkey" data-id="'.$MainData->Account.'" >重发验证码</a>';   
                        }
                    ?>
                    </div>
                </div>
                <div class="form-group form-group-lg">
                    <label class="col-sm-3 control-label">验证码</label>
                    <div class="col-sm-9">
                        <input class="form-control" type="text" id="user_vkey" name="VKey">
                    </div>
                </div>
                <button type="submit" id="btnsubmit" class="btn btn-lg btn-danger" tabindex="0">验证</button>
            </form>
        </div>
    </div>


<script>
$(document).ready(function(e) {
    $('#btnsubmit').click(function(e) {
        var self = $(this);
        var istest = true;
        var data={};
        if (!$('#user_vkey').val()) {
            $('#user_vkey').focus().parent().addClass('has-error');
            Fanx.Error('验证码不能为留空，请输入!');
            istest = false;
        } else {
            $('#user_vkey').parent().removeClass('has-error');
            data.VKey=$('#user_vkey').val();
        }
        return istest;
    });
    $('#btnsendvkey').click(function(e) {
        var self=$(this);
        self.addClass('disabled');
        Fanx.Run('Account.KeySend',{Account:11},function(result,error,e){  
            if(error){                
                Fanx.Error(error);
            }else{
              if(result.su){                   
               
              }
            }
            self.delay(5000).queue(function(){$(this).removeClass('disabled').dequeue();});             
        },{type:"POST"});
        return false;
    });
});
</script>
