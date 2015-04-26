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
    
    if($MyPage&&$MyPage->Description){ 
        echo '<title>UU帮-让你更了解-'.$MyPage->Description.'</title>'; 
    }else{ 
        echo '<title>UU帮 - 让你更了解!</title>'; 
        } 
    ?>
    <link rel="stylesheet" href="/public/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/css/gritter.css">
    <link rel="stylesheet" href="/public/css/Avenir.css">
    <link rel="stylesheet" href="/public/css/ui.css">
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
    <header id="masthead-header" role="banner">
        <div id="header-main" class="container-fluid">
            <div id="section-branding">
                <div id="section-name" class="hidden-xs">
                    <a><i  class="glyphicon glyphicon-magnet"></i><i >9</i><i class="glyphicon glyphicon-grain text-green"></i></a>
                </div>
                <div id="section-logo">
                    <a>Trifles make perfect,but perfect is not a trifle any more.</a>
                </div>
            </div>
        </div>
        <div id="header-nav">
            <nav class="navbar" role="navigation">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav" id="page_header_nav">
                        <li data-id="blank"><a href="/">主页</a></li>
                        <li data-id="help"><a href="/help">帮助</a></li>
                        <li data-id="document"><a href="/document">组件化</a></li>
                        <li data-id="service"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">服务</a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="http://u9service.ufida.com.cn/u9/web/kmIndex.aspx"><i class="glyphicon glyphicon-book text-red"></i><span class="ind1">U9知识库<span></a></li>
                                <li><a href="http://u9service.ufida.com.cn/"><i class="glyphicon glyphicon-question-sign text-primary"></i><span class="ind1">PMP问题系统<span></a></li>
                            </ul>
                        </li>
                        <li data-id="custdev"><a href="/custdev">客开</a></li>
                        <li data-id="community"><a href="/community">社区</a></li>
                        <li data-id="code"><a href="/code">示例代码</a></li>
                        <li data-id="tool"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">工具</a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="/tool/entity/?hq=1"><i class="glyphicon glyphicon-equalizer text-red"></i><span class="ind1">实体查询<span></a></li>
                                <li><a href="/tool/bpsv/?hq=1"><i class="glyphicon glyphicon-pawn text-primary"></i><span class="ind1">BP&SV<span></a></li>
                                <li><a href="/tool/ref/?hq=1"><i class="glyphicon glyphicon-search text-green"></i><span class="ind1">参照查询<span></a></li>
                            </ul>
                        </li>
                    </ul>
                    <?php 
                        $hq=0;
                        if(isset($_REQUEST["hq"])){ 
                            $hq=$_REQUEST["hq"];    
                        }
                        if($hq==0){
                    ?>
                    <div class="navbar-form navbar-right" role="search" id="site-search">
                        <div class="nav-search navbar-form navbar-right">
                            <input type="text" id="search-txtKey" placeholder="搜索关键词 空格分词" class="form-control input-sm" />
                            <a id="search-btnSubmit" title="查询" class="nav-search-submit"><i class="glyphicon glyphicon-search"></i></a>
                        </div>
                    </div>
                    <?php }?>
                </div>
            </nav>
        </div>
    </header>
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
    <div id="footer">
        <header id="footer-logo">
            <div class="container text-center">
            </div>
        </header>
        <div class="container hidden-xs">
            <div class="row ">
                <div class="col-sm-12 ">
                    <div id="footer-columns">
                        <div class="row " id="footer-menu-columns">
                            <div class="col-sm-3 footer-column border-right border-xs-remove-right">
                                <h2 class="heading"><a href="#collapseOne">订阅</a></h2>
                                <ul class=" footer-menu">
                                   <li>
                                       <a href="#">xxxxxx</a>
                                    </li>
                                    <li>
                                       <a href="#">xxxxxx</a>
                                    </li>
                                    <li>
                                       <a href="#">xxxxxx</a>
                                    </li>
                                    <li>
                                       <a href="#">xxxxxx</a>
                                    </li>
                                    <li>
                                       <a href="#">xxxxxx</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-sm-3 footer-column border-right">
                                <h2 class="heading"><a href="#collapseTwo">网站信息</a></h2>
                                <ul class=" footer-menu">
                                   <li>
                                       <a href="#">xxxxxx</a>
                                    </li>
                                    <li>
                                       <a href="#">xxxxxx</a>
                                    </li>
                                    <li>
                                       <a href="#">xxxxxx</a>
                                    </li>
                                    <li>
                                       <a href="#">xxxxxx</a>
                                    </li>
                                    <li>
                                       <a href="#">xxxxxx</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-sm-3 footer-column border-right border-xs-remove-right">
                                <h2 class="heading"><a href="#collapseThree">社交，移动</a></h2>
                                <ul class=" footer-menu">
                                    <li>
                                       <a href="#">xxxxxx</a>
                                    </li>
                                    <li>
                                       <a href="#">xxxxxx</a>
                                    </li>
                                    <li>
                                       <a href="#">xxxxxx</a>
                                    </li>
                                    <li>
                                       <a href="#">xxxxxx</a>
                                    </li>
                                    <li>
                                       <a href="#">xxxxxx</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-sm-3 footer-column">
                                <h2 class="heading"><a href="#collapseFour">广告</a></h2>
                                <ul class=" footer-menu">
                                    <li>
                                       <a href="#">xxxxxx</a>
                                    </li>
                                    <li>
                                       <a href="#">xxxxxx</a>
                                    </li>
                                    <li>
                                       <a href="#">xxxxxx</a>
                                    </li>
                                    <li>
                                       <a href="#">xxxxxx</a>
                                    </li>
                                    <li>
                                       <a href="#">xxxxxx</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row " id="footer-legal">
                            <ul class=" footer-menu-legal">
                                <li>
                                    <a>用友优普信息技术有限公司 © yonyou up information technology Co., Ltd. 京ICP备1501号</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
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
