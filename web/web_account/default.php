<?php session_start();?>
<!DOCTYPE html>
<html lang="zh-cn">

<head>
    <meta charset="utf-8" />
    <meta name="author" content="u9" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="U9,ERP,帮助,企业管理系统,信息化">
    <meta name="description" content="U9,ERP,帮助,企业管理系统,信息化">
    <?php include($_SERVER[ "DOCUMENT_ROOT"]. "/lotusphp/Lotus.php"); 
    $MyPage_Name='blank' ; 
    if(isset($_REQUEST[ "lnk"])){ 
        $MyPage_Name=$_REQUEST[ "lnk"]; 
    } 
    $MyPage=HP_Assembly::GetItem($MyPage_Name);    
    ?>
    <title>U9用户中心</title>
    <link rel="stylesheet" href="/public/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/css/gritter.css">
    <link rel="stylesheet" href="/public/css/Avenir.css">
    <link rel="stylesheet" href="/public/css/account.css">
    <!--[if lt IE 9]>
<script src="/public/js/html5shiv.min.js"></script>
<script src="/public/js/respond.min.js"></script>
<![endif]-->
    <script src="/public/js/jquery.min.js"></script>
    <script src="/public/js/bootstrap.min.js"></script>
    <script src="/public/js/jquery.gritter.min.js"></script>
    <script src="/public/js/fanx.js"></script>
</head>

<body>
<div class="wrapper">
    <header id="masthead-header" role="banner">
        <div class="container-fluid">
            <div id="section-branding">
                <a class="section-logo" href="/"><i  class="glyphicon glyphicon-magnet"></i><i>9</i></a>
                <span class="section-name">
                    <a href="/account"><i class="glyphicon glyphicon-user"></i> 用户中心</a>
                </span>
                
                <div class="pull-right">
                    <ul class="nav navbar-nav">
                        <?php
                            $html='';
                            if(PD::OauthCheck(false)){
                                $html='<li><a class="glyphicon glyphicon-bell" title="消息"></a></li>';
                                $html.='<li><a class="glyphicon glyphicon-cog" title="设置"></a></li>';
                                $html.='<li><a class="glyphicon glyphicon-share" title="分享"></a></li>';
                                $html.='<li><a> <img class="img-responsive img-circle" src="/public/img/accounts/avatar_2x.png" alt="更换头像"></a></li>';
                            }else{
                                 $html='<li><a class="glyphicon glyphicon-bell" title="消息"></a></li>';
                            }
                            echo $html;
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </header>
    <div id="main-body">
    <?php 
    $html='<input type="hidden" value="" id="Page_Main_DataID" ' ; 
    foreach ($_REQUEST as $key=> $value){ 
        $html .=' data-'.$key.'="'.$value.'"'; 
    } 
    $html .=' />'; 
    echo $html; 

    if(!$MyPage){ 
       echo  '<div class="well text-center" style="min-height:500px;"><h1>当前页面不存在！</h1><p>页面正在建设中，请等待!</p></div>'; 
    }
    try{ 
        if($MyPage){
            if(is_file(ROOTDIR.$MyPage->Path)){ 
                include_once(ROOTDIR.$MyPage->Path); 
            } else{ 
                echo ROOTDIR.$MyPage->Path; 
                echo '未能加载正确的页面 URI:'.$MyPage->Path; 
            } 
        }
       
    }catch (Exception $e) { 
        echo '您加载的页面可能出错了:'; echo $e; 
    } 
    ?>
     </div>
    <div id="footer">
        <div class="content">
            <ul>
                  <li>U9</li>
                  <li>
                  <a> 隐私权和服务条款</a>
                  </li>
                  <li><a>帮助</a></li>
            </ul>
            <span class="pull-right">用友优普信息技术有限公司 © yonyou up information technology Co., Ltd. 京ICP备1501号</span>            
      </div>        
    </div>
    </div>
    <script type="text/javascript">
    $(document).ready(function(e) {
         mainPageNav();
    });
    function  mainPageNav(){
        $('#page_header_nav>li.active').removeClass('active');
        var curr = $('#Page_Main_DataID').data('lnk') || 'blank';
        if (curr) {
            $('#page_header_nav>li[data-id="' + curr.split('.')[0] + '"]').addClass('active');
        };

        $('#search-txtKey').keypress(function(event) {
            if (event.keyCode == 13) {
                $('#search-btnSubmit').trigger("click");
                return false;
            }
        });
        $('#search-btnSubmit').click(function() {
            if (!$('#search-txtKey').val()) {
                return false;
            }
            if (curr == 'blank') {
                window.location.href = '/?query=' + encodeURI($('#search-txtKey').val());
            } else {
                window.location.href = '/' + curr.replace('.', '/') + '/?query=' + encodeURI($('#search-txtKey').val());
            }
            return false;
        });
        var searchKey = $('#Page_Main_DataID').data('query');
        if (searchKey) {
            $('#search-txtKey').val(searchKey);
        }
    }
    </script>
</body>

</html>
