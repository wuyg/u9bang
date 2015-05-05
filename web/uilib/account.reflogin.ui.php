
     <div class="container main-content">
    	<?php    	
            $request_uri='';
            if(isset($_REQUEST['continue'])&&$_REQUEST['continue']){
                if($request_uri){$request_uri.='&';}
                $request_uri .='continue='.$_REQUEST['continue'];
            }
            if($request_uri){$request_uri='?'.$request_uri;}
			$html='<div class="jumbotron">';
            $html.='<h1>此页面,需要您<a href="/account/login/'.$request_uri.'"><b>登录</b></a>后，才能访问！</h1>';
            $html.='<p></p>';
            $html.=' <p><a class="btn btn-primary btn-lg" role="button" href="/">返回首页</a></p>';
            $html.='</div>';
            echo $html;

            var_dump(PD::GetPD());
    	?>
    </div>
