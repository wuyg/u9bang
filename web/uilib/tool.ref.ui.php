<div class="container-fluid">
 <?php
if(isset($_REQUEST["query"])&&$_REQUEST["query"]){
?>
<!--实体查询-->
 <div  class="row">
  <div class="panel panel-default">
        <?php
			$MainData=PD::Run('Tool_MD_Ref_List_BP',array("Type"=>'REF'));
			if($MainData){
				$html="";
				foreach ($MainData as $key => $value) {
					if($key%3==0){
						$html='<div class="bs-callout bs-callout-warning">';
					}
					else if($key%3==1){
						$html='<div class="bs-callout bs-callout-danger">';
					}else{
						$html='<div class="bs-callout bs-callout-info">';
					}
					$html .='<h4>'.$value->Name.'&nbsp;&nbsp;&nbsp;'.$value->DisplayName.'</h4>';
					$html .='<p>FormID<code>'.$value->ID.'</code></p>';
					$html .='<p>程序集:'.$value->Assembly.'</p>';

					$html .='<p>';
					if($value->RefType){
						$html .='参照类型：<span class="text-value">'.$value->RefType.'</span>';
					}
					if($value->IsMultiSelect){
						$html .='<span class="text-value">多选</span>';
					}
					if($value->IsForMultOrg){
						$html .='<span class="text-value">多组织：</span>';
					}
					if($value->URI){
						$html .='URI<span class="text-value">'.$value->URI.'</span>';
					}
					$html .='</p>';

					if($value->Filter&&strlen($value->Filter)>2){
						$html .='<pre>'.$value->Filter.'</pre>';
					}
					$html.='</div>';
					echo $html;
				}
				
			}
        ?>
    </div>
</div>
<?php
}else{
?>
<!--最近查询-->
<div class="container">
	 <div  class="row ask-box">
		 <div class="col-xs-12 text-center">
			<div>
				<h1>参照查询</h1>
				<div class="ask-bar">
                    <input type="text"  id="body-Submit-key" placeholder="搜索关键词 空格分词" class="placeholder">
                    <a class="pull-right Submit" id="body-Submit-btn"><i class="glyphicon glyphicon-search"></i></a>
                </div>
			</div>
		</div>
	</div>
	<div class="row ask-hislist">
		<div class="col-xs-4">
			<div class="panel panel-success no-radius">		  
			  <div class="panel-heading"><h3 class="panel-title">最近</h3></div>
			  <div class="list-group">
				  <a href="#" class="list-group-item "> Cras justo odio</a>
				  <a href="#" class="list-group-item">Dapibus ac facilisis in</a>
				  <a href="#" class="list-group-item">Morbi leo risus</a>
				  <a href="#" class="list-group-item">Porta ac consectetur ac</a>
				  <a href="#" class="list-group-item">Vestibulum at eros</a>
				  <a href="#" class="list-group-item">Vestibulum at eros</a>
				  <a href="#" class="list-group-item">Vestibulum at eros</a>
			</div>
			</div>		
		</div>

		<div class="col-xs-4">
			<div class="panel panel-info no-radius">		  
			  	<div class="panel-heading"><h3 class="panel-title">足迹</h3></div>
			  	<div class="list-group">
				  <a href="#" class="list-group-item "> Cras justo odio</a>
				  <a href="#" class="list-group-item">Dapibus ac facilisis in</a>
				  <a href="#" class="list-group-item">Morbi leo risus</a>
				  <a href="#" class="list-group-item">Porta ac consectetur ac</a>
				  <a href="#" class="list-group-item">Vestibulum at eros</a>
				  <a href="#" class="list-group-item">Vestibulum at eros</a>
				  <a href="#" class="list-group-item">Vestibulum at eros</a>
				</div>
			</div>
		</div>

		<div class="col-xs-4">
			<div class="panel panel-warning no-radius">		  
			  <div class="panel-heading"><h3 class="panel-title">热搜</h3></div>
			  <div class="list-group">
				  <a href="#" class="list-group-item "> Cras justo odio</a>
				  <a href="#" class="list-group-item">Dapibus ac facilisis in</a>
				  <a href="#" class="list-group-item">Morbi leo risus</a>
				  <a href="#" class="list-group-item">Porta ac consectetur ac</a>
				  <a href="#" class="list-group-item">Vestibulum at eros</a>
				  <a href="#" class="list-group-item">Vestibulum at eros</a>
				  <a href="#" class="list-group-item">Vestibulum at eros</a>
			</div>
			</div>	
		</div>
	</div>
</div>


<?php
}
?>   
</div>
<script type="text/javascript">
    $(document).ready(function(e) {
         $('#body-Submit-key').keypress(function(event) {
            if (event.keyCode == 13) {
                $('#body-Submit-btn').trigger("click");
                return false;
            }
        });
        $('#body-Submit-btn').click(function() {
            if (!$('#body-Submit-key').val()) {
                return false;
            }
            window.location.href = '/tool/ref/?query=' + encodeURI($('#body-Submit-key').val());
            return false;
        });
    });
</script>