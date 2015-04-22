<div class="container-fluid">
<?php

if(isset($_REQUEST["id"])&&$_REQUEST["id"]){
 ?>
<!--实体属性-->
 <div  class="row">
    <div class="panel panel-default blue">
        <div class="panel-heading"><span class="ribbon">大家在搜索</span></div>
        <div class="list-group">
        <?php
			$MainData=PD::Run('Tool_MD_Attribute_List_BP',array("Entity"=>$_REQUEST["id"]));
			if($MainData){
				$html="";
				foreach ($MainData as $key => $value) {
					
				}
				echo $html;
			}
        ?>   
        </div>
    </div>
</div>
 <?php
}else if(isset($_REQUEST["query"])&&$_REQUEST["query"]){
?>
<!--实体查询-->
 <div  class="row">
    <div class="panel panel-default blue">
        <div class="panel-heading"><span class="ribbon">大家在搜索</span></div>
        <div class="list-group">
        <?php
			$MainData=PD::Run('Tool_MD_Entity_List_BP',array("Key"=>$_REQUEST["query"]));
			if($MainData){
				$html="";
				foreach ($MainData as $key => $value) {
					
				}
				echo $html;
			}
        ?>   
        </div>
    </div>
</div>
<?php
}else{
?>
<!--最近查询-->
 <div  class="row">
    <div class="panel panel-default blue">
        <div class="panel-heading"><span class="ribbon">大家在搜索</span></div>
        <div class="list-group">
        <?php
			$MainData=PD::Run('Sys_Favor_List_BP',array("Type"=>'Entity'));
			if($MainData){
				$html="";
				foreach ($MainData as $key => $value) {
					$html .='<a href="/tool/entity/'.$value->DataID.'.html" class="list-group-item">'.$value->DataDisplayName.'<small>&nbsp;&nbsp;&nbsp;'.$value->DataCode.'</small><span class="badge">'.$value->Hits.'</span></a>';
				}
				echo $html;
			}
        ?>   
        </div>
    </div>
</div>
<?php
}
?>   
</div>
