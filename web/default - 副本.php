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
$MyPage_Name='blank';
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
<header id="masthead-header" role="banner">
  <div id="header-main" class="container-fluid">
    <div id="section-branding">
    <div id="section-name" class="hidden-xs">
    <a href="#">
    Sports
    </a>
    </div>
    <div id="section-logo">
    <a href="#" target="_top"><img src="/public/css/images/logo-sm.png" alt="The Charlotte Observer | CharlotteObserver.com" class="img-responsive"></a>
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
            <li data-id="case"><a href="/case">案例</a></li>
            <li data-id="community"><a href="/community">社区</a></li>
            <li data-id="code"><a href="/code">示例代码</a></li>
            <li data-id="tool"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">工具</a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="/tool/entity" class="glyphicon glyphicon-equalizer"><span class="ind1">实体查询<span></a></li>
                <li><a href="/tool/bpsv" class="glyphicon glyphicon-pawn"><span class="ind1">BP&SV<span></a></li>
                <li><a href="/tool/ref" class="glyphicon glyphicon-search"><span class="ind1">参照查询<span></a></li>
              </ul>
            </li>
          </ul> 
          <div class="navbar-form navbar-right" role="search" id="site-search">
            <div class="nav-search navbar-form navbar-right">
              <input type="text" id="search-txtKey" placeholder="搜索关键词 空格分词" class="form-control input-sm" />
              <a id="search-btnSubmit" title="查询" class="nav-search-submit"><i class="glyphicon glyphicon-search"></i></a>
             </div>
          </div>   
        </div>
  </nav>
  </div>
</header>
<?php   
  try{
    $html='<input type="hidden" value="" id="Page_Main_DataID" ';
    foreach ($_REQUEST as $key => $value){
      $html .=' data-'.$key.'="'.$value.'"';  
    }
    $html .=' />';
    echo $html;

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
<div id="footer">
<header id="footer-logo">
<div class="container text-center">
<a href="http://www.charlotteobserver.com/" target="_top"><img src="http://www.charlotteobserver.com/static/images/charlotteobserver/logo-sm.png" alt="The Charlotte Observer | CharlotteObserver.com" class="img-responsive"></a>
</div>
</header>
<div class="container hidden-xs">
<div class="row ">
<div class="col-sm-12 ">
<div id="footer-columns">
<div class="row " id="footer-menu-columns">
<div class="col-sm-3 footer-column border-right border-xs-remove-right">
<h2 class="heading">
<a href="#collapseOne">
Subscriptions
</a>
</h2>
<ul class=" footer-menu">
<li>
<a href="/plus/#navlink=mi_footer">
Digital Subscriptions
</a>
</li>
<li>
<a href="/customer-service/#navlink=mi_footer">
Subscriber Services
</a>
</li>
<li>
<a href="/customer-service/e-edition/#navlink=mi_footer">
E-edition
</a>
</li>
</ul>
</div>
<div class="col-sm-3 footer-column border-lg-right">
<h2 class="heading">
<a href="#collapseTwo">
Site Information
</a>
</h2>
<ul class=" footer-menu">
<li>
<a href="/customer-service/#navlink=mi_footer">
Customer Service
</a>
</li>
<li>
<a href="/customer-service/about-us/#navlink=mi_footer">
About Us
</a>
</li>
<li>
<a href="/customer-service/contact-us/#navlink=mi_footer">
Contact Us
</a>
</li>
<li>
<a href="http://charlotteobserver.mycapture.com/mycapture/index.asp#navlink=mi_footer">
Photo Store
</a>
</li>
<li>
<a href="http://nie.charlotteobserver.com/">
News in Education
</a>
</li>
<li>
<a href="http://www.charlotteobserver.com/customer-service/rss/">
RSS Feeds
</a>
</li>
</ul>
</div>
<div class="col-sm-3 footer-column border-right border-xs-remove-right">
<h2 class="heading">
<a href="#collapseThree">
Social, Mobile &amp; More
</a>
</h2>
<ul class=" footer-menu">
<li>
<a href="/mobile/#navlink=mi_footer">
Mobile Options
</a>
</li>
<li>
<a href="https://www.facebook.com/thecharlotteobserver#navlink=mi_footer">
Facebook
</a>
</li>
<li>
<a href="https://twitter.com/theobserver#navlink=mi_footer">
Twitter
</a>
</li>
<li>
<a href="https://www.youtube.com/user/cltdotcom#navlink=mi_footer">
YouTube
</a>
</li>
<li>
<a href="https://plus.google.com/115021774857705317436/posts#navlink=mi_footer">
Google+
</a>
</li>
<li>
<a href="/customer-service/newsletter-signup/#navlink=mi_footer">
Newsletters
</a>
</li>
</ul>
</div>
<div class="col-sm-3 footer-column">
<h2 class="heading">
<a href="#collapseFour">
Advertising
</a>
</h2>
<ul class=" footer-menu">
<li>
<a href="/advertise/#navlink=mi_footer">
Information
</a>
</li>
<li>
<a href="http://charlotteobserver.adperfect.com/#navlink=mi_footer">
Place a Classified
</a>
</li>
<li>
<a href="http://findnsave.charlotteobserver.com/#navlink=mi_footer">
Find&amp;Save Local Shopping
</a>
</li>
</ul>
</div>
</div>
<div class="row " id="footer-legal">
<ul class=" footer-menu-legal">
<li>
<a href="/customer-service/copyright/#navlinks=footer" target="_top">
Copyright
</a>
</li>
<li>
<a href="/customer-service/privacy-policy/#navlink=mi_footer" target="_top">
Privacy Policy
</a>
</li>
<li>
<a href="/customer-service/terms-of-service/#navlink=mi_footer" target="_top">
Terms of Service
</a>
</li>
</ul>
<script>
jQuery('#footer #footer-columns .heading > a').each(function(){ $(this).attr('href',$(this).attr('href').split('//')[1]);})
</script>
</div>
</div>
</div>
</div>
</div>
<div id="accordion" class="visible-xs panel-group">
<div class="panel">
<div class="panel-heading">
<h2 class="heading">
<a href="#collapseOne" data-toggle="collapse" data-parent="#accordion">
Subscriptions
</a>
</h2>
</div>
<div id="collapseOne" class="panel-collapse collapse">
<div class="panel-body">
<ul class=" footer-menu">
<li>
<a href="/plus/#navlink=mi_footer">
Digital Subscriptions
</a>
</li>
<li>
<a href="/customer-service/#navlink=mi_footer">
Subscriber Services
</a>
</li>
<li>
<a href="/customer-service/e-edition/#navlink=mi_footer">
E-edition
</a>
</li>
</ul>
</div>
</div>
</div>
<div class="panel">
<div class="panel-heading">
<h2 class="heading">
<a href="#collapseTwo" data-toggle="collapse" data-parent="#accordion">
Site Information
</a>
</h2>
</div>
<div id="collapseTwo" class="panel-collapse collapse">
<div class="panel-body">
<ul class=" footer-menu">
<li>
<a href="/customer-service/#navlink=mi_footer">
Customer Service
</a>
</li>
<li>
<a href="/customer-service/about-us/#navlink=mi_footer">
About Us
</a>
</li>
<li>
<a href="/customer-service/contact-us/#navlink=mi_footer">
Contact Us
</a>
</li>
<li>
<a href="http://charlotteobserver.mycapture.com/mycapture/index.asp#navlink=mi_footer">
Photo Store
</a>
</li>
<li>
<a href="http://nie.charlotteobserver.com/">
News in Education
</a>
</li>
<li>
<a href="http://www.charlotteobserver.com/customer-service/rss/">
RSS Feeds
</a>
</li>
</ul>
</div>
</div>
</div>
<div class="panel">
<div class="panel-heading">
<h2 class="heading">
<a href="#collapseThree" data-toggle="collapse" data-parent="#accordion">
Social, Mobile &amp; More
</a>
</h2>
</div>
<div id="collapseThree" class="panel-collapse collapse">
<div class="panel-body">
<ul class=" footer-menu">
<li>
<a href="/mobile/#navlink=mi_footer">
Mobile Options
</a>
</li>
<li>
<a href="https://www.facebook.com/thecharlotteobserver#navlink=mi_footer">
Facebook
</a>
</li>
<li>
<a href="https://twitter.com/theobserver#navlink=mi_footer">
Twitter
</a>
</li>
<li>
<a href="https://www.youtube.com/user/cltdotcom#navlink=mi_footer">
YouTube
</a>
</li>
<li>
<a href="https://plus.google.com/115021774857705317436/posts#navlink=mi_footer">
Google+
</a>
</li>
<li>
<a href="/customer-service/newsletter-signup/#navlink=mi_footer">
Newsletters
</a>
</li>
</ul>
</div>
</div>
</div>
<div class="panel">
<div class="panel-heading">
<h2 class="heading">
<a href="#collapseFour" data-toggle="collapse" data-parent="#accordion">
Advertising
</a>
</h2>
</div>
<div id="collapseFour" class="panel-collapse collapse">
<div class="panel-body">
<ul class=" footer-menu">
<li>
<a href="/advertise/#navlink=mi_footer">
Information
</a>
</li>
<li>
<a href="http://charlotteobserver.adperfect.com/#navlink=mi_footer">
Place a Classified
</a>
</li>
<li>
<a href="http://findnsave.charlotteobserver.com/#navlink=mi_footer">
Find&amp;Save Local Shopping
</a>
</li>
</ul>
</div>
</div>
</div>
<div class="panel">
<div class="panel-heading">
<h2 class="heading">
<a href="#collapseFive" data-toggle="collapse" data-parent="#accordion">
More
</a>
</h2>
</div>
<div id="collapseFive" class="panel-collapse collapse">
<div class="panel-body">
<script>
jQuery('#footer #accordion .heading > a').attr({'data-toggle':'collapse','data-parent':'#accordion'}).each(function(){ $(this).attr('href',$(this).attr('href').split('//')[1]);})
</script>
<ul class=" footer-menu-legal">
<li>
<a href="/customer-service/copyright/#navlinks=footer" target="_top">
Copyright
</a>
</li>
<li>
<a href="/customer-service/privacy-policy/#navlink=mi_footer" target="_top">
Privacy Policy
</a>
</li>
<li>
<a href="/customer-service/terms-of-service/#navlink=mi_footer" target="_top">
Terms of Service
</a>
</li>
</ul>
</div>
</div>
</div>
</div>
</div>
<script type="text/javascript">
  $(document).ready(function(e) {
    $('#page_header_nav>li.active').removeClass('active');
    var curr=$('#Page_Main_DataID').data('lnk')||'blank';
    if(curr){
      $('#page_header_nav>li[data-id="'+curr.split('.')[0]+'"]').addClass('active');
    };

    $('#search-txtKey').keypress(function (event) { if (event.keyCode == 13) { $('#search-btnSubmit').trigger("click"); return false; } });
    $('#search-btnSubmit').click(function () { 
      if (!$('#search-txtKey').val()) { return false; }
      if(curr=='blank'){
        window.location.href = '/?query=' + encodeURI($('#search-txtKey').val());
      } else{
        window.location.href ='/'+curr.replace('.','/')+'/?query=' + encodeURI($('#search-txtKey').val());
      }      
      return false; 
    });
    var searchKey=$('#Page_Main_DataID').data('query');
    if(searchKey){$('#search-txtKey').val(searchKey);}
});
</script>

</body>
</html>