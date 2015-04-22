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


<?php
include($_SERVER["DOCUMENT_ROOT"]."/lotusphp/Lotus.php");

$MyPage_Name='help';
if(isset($_REQUEST["lnk"])){
  $MyPage_Name=$_REQUEST["lnk"];
}
$MyPage=HP_Assembly::GetItem($MyPage_Name);
if(!$MyPage){
  die( '当前页面不存在！');
}
if($MyPage->Description){  
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
<div class="container-fluid">
  <header class="navbar navbar-fixed-top navbar-inverse" role="banner">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#"><span class="glyphicon glyphicon-magnet"></span></a>
      </div>
        <div class="collapse navbar-collapse">
          <div class="navbar-form navbar-left" role="search">
            <div class="nav-search">
              <input type="text" id="txtKey" placeholder="输入关键词" class="form-control" />
              <a id="btnSubmit" title="查询" class="nav-search-submit"><i class="glyphicon glyphicon-search"></i></a>
             </div>
          </div>
          <ul class="nav navbar-nav">
            <li><a href="/">主页</a></li>
            <li><a href="/help">帮助 <span class="sr-only">(current)</span></a></li>
            <li   class="active"><a href="/case">案例</a></li>
            <li><a href="/community">社区</a></li>
            <li><a href="/code">示例代码</a></li>
          </ul>
         
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
              <span class="glyphicon glyphicon-plus"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="/help/project.edit" class="glyphicon glyphicon-book"><span class="ind1">增加项目<span></a></li>
                <li><a href="/help/project.page.edit" class="glyphicon glyphicon-list-alt"><span class="ind1">增加页面<span></a></li>
              </ul>
            </li>
            <li><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
              <span  class="glyphicon glyphicon-user"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="#" class="glyphicon glyphicon-asterisk"><span class="ind1">用户中心<span></a></li>
                <li class="divider"></li>
                <li><a href="#"  class="glyphicon glyphicon-log-out"><span class="ind1">退出<span></a></li>
              </ul>
            </li>         
          </ul>           
        </div><!-- /.navbar-collapse -->
  </header>
</div>
<?php   
  try{
      if(is_file(ROOTDIR.$MyPage->Path)){
         include_once(ROOTDIR.$MyPage->Path);
       }
       else{
        echo ROOTDIR.$MyPage->Path;
        echo '未能加载正确的页面 URI:'.$MyPage->Path;
       }

  }
  catch (Exception $e) {
      echo '您加载的页面可能出错了:';
      echo $e;
  }
?>
</body>
</html>