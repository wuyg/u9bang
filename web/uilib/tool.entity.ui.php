<div class="container-fluid">
<?php

if(isset($_REQUEST["id"])&&$_REQUEST["id"]){
 ?>
<!--实体属性-->
<?php
	$MainData=PD::Run('Tool_MD_Entity_Attribute_List_BP',array("Entity"=>$_REQUEST["id"]));
?>   
 <div  class="row">

    <div class="panel panel-default blue">
        <div class="panel-heading">
        <?php
        if($MainData){		
        	if($MainData->ClassType=="1")
				$html='<span class="ribbon">实体</span>';
			else if($MainData->ClassType=="2")
				$html='<span class="ribbon">实体</span>';
			else if($MainData->ClassType=="3")
				$html='<span class="ribbon">枚举</span>';
			else
				$html='<span class="ribbon">其它</span>';
			$html.='<span class="ribbon-text">';
			$html.='<span class="ind1">'.$MainData->DisplayName.'</span>';
			if($MainData->DefaultTable){
				$html.='<span class="ind1">'.$MainData->DefaultTable.'</span>';
			}
			$html.='<span class="ind1">'.$MainData->FullName.'</span>';
			$html.='</span>';
			echo $html;
		}
        ?>
        </div>
        <table class="table table-hover">
        	<thead>
        		<tr>
        			<th>名称</th>
        			<th>显示名称</th>
        			<th>数据类型</th>
        			<th>默认值</th>
        			<th>分组</th>        			
        			<th>IsKey</th>
        			<th>可空</th>
        			<th>系统</th>
        			<th>业务主键</th>
        			<th>集合</th>
        		</tr>
        	</thead>
        	<tbody>
        	<?php			
			if($MainData){				
				foreach ($MainData->Attr as $key => $value) {
					$html="<tr>";
					$html.="<td>".$value->Name."</td>";
					$html.="<td>".$value->DisplayName;
					if($value->Description&&$value->DisplayName!=$value->Description){
						$html.="<br/><small>".$value->Description.'</small>';
					}
					$html.="</td>";
					if($value->DataTypeClassType=="1"||$value->DataTypeClassType=="2"||$value->DataTypeClassType=="3"){
						$html.='<td><a href="'.$value->DataTypeID.'.html" target="_self">'.$value->DataTypeFullName.'</td>';
					}else{
						$html.="<td>".$value->DataTypeFullName."</td>";
					}
					$html.="<td>".$value->DefaultValue."</td>";
					$html.="<td>".$value->GroupName."</td>";
					$html.="<td>".PD::HTML_FIsTrue($value->IsKey)."</td>";
					$html.="<td>".PD::HTML_FIsTrue($value->IsNullable)."</td>";
					$html.="<td>".PD::HTML_FIsTrue($value->IsSystem)."</td>";
					$html.="<td>".PD::HTML_FIsTrue($value->IsBusinessKey)."</td>";
					$html.="<td>".PD::HTML_FIsTrue($value->IsCollection)."</td>";
					$html.="</tr>";

					echo $html;
				}
			}
        	?>
        	</tbody>
        </table>
    </div>
</div>
 <?php
}else if(isset($_REQUEST["query"])&&$_REQUEST["query"]){
?>
<!--实体查询-->
 <div  class="row">
 <table class="table table-hover">
        	<thead>
        		<tr>
        			<th>名称</th>
        			<th>全称</th>
        			<th>显示名称</th>
        			<th>默认表名</th>
        		</tr>
        	</thead>
        	<tbody>
        		
        	<?php
			$MainData=PD::Run('Tool_MD_Entity_List_BP',array("ClassType"=>"1,3","Key"=>$_REQUEST["query"]));
			if($MainData){
				$html="";
				foreach ($MainData as $key => $value) {
					$html="<tr>";
					$html.='<td><a href="'.$value->ID.'.html" target="_self">'.$value->Name.'</td>';
					$html.='<td><a href="'.$value->ID.'.html" target="_self">'.$value->FullName.'</td>';
					$html.='<td>'.$value->DisplayName;
					if($value->Description&&$value->DisplayName!=$value->Description){
						$html.="<br/><small>".$value->Description.'</small>';
					}
					$html.="</td>";
					
					$html.="<td>".$value->DefaultTable."</td>";
					$html.="</tr>";
					echo $html;
				}
				echo $html;
			}
        ?>   
        	</tbody>
        	</table>
</div>
<?php
}else{
?>
<!--最近查询-->
<div class="container">
	 <div  class="row ask-box">
		 <div class="col-xs-12 text-center">
            <div>
                <h1>实体查询</h1>
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
            window.location.href = '/tool/entity/?query=' + encodeURI($('#body-Submit-key').val());
            return false;
        });
    });
</script>