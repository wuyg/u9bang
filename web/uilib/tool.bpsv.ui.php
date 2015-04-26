<div class="container-fluid">
<?php

if(isset($_REQUEST["id"])&&$_REQUEST["id"]){
 ?>
<!--实体属性-->
<?php
	$MainData=PD::Run('Tool_MD_Entity_Attribute_List_BP',array("Entity"=>$_REQUEST["id"]));
?>
<div class="row">
	<div class="panel panel-default">
		<div class="panel-heading">
		<?php
		$html='<span class="ribbon">'.$MainData->AssemblyType.'</span>';

		$html.='<span class="ribbon-text">';
		$html='<span class="ind1">'.$MainData->FullName.'</span>';
		$html='<span class="ind1">'.$MainData->DisplayName;
		if($MainData->Description&&$MainData->DisplayName!=$MainData->Description){
			$html='<span class="small ind1">'.$MainData->Description.'</span>';
		}
		$html.='</span>';
		$html.='</span>';

		?>			
		</div>
	</div>
</div>
<div class="row" id="OP_Info_Param" style="margin:0px">
<h4>
	<span class="label label-default">参数描述</span>
</h4>
<<table>
	<thead>
		<tr>
			<th class="col-xs-4">名称</th>
			<th class="col-xs-4">类型</th>
			<th class="col-xs-1">默认值</th>
			<th class="col-xs-3">描述</th>
		</tr>
	</thead>
	<tbody>
		<?php
		if($MainData){				
				foreach ($MainData->Attr as $key => $value) {
					$html='<tr datarow="'.$key.'" datalevel="1",datatpye="'. $value->DataTypeID.'">';
					$html.='<td class="ind1">'.$value->DisplayName;
					if(($value->DataTypeClassType=="1"||$value->DataTypeClassType=="2")&&$value->IsEntityKey!="1"){
						$html.='<br/><small>'.$value->Description.'</small>';
					}
					$html.='</td>';
					$html.='<td>'.$value->DisplayName;
					if($value->Description&&$value->DisplayName!=$value->Description){
						$html.='<br/><small>'.$value->Description.'</small>';
					}
					$html.='</td>';
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
     
          each item,i in pd.data.attr
            tr(datarow=i,datalevel=1,datatpye= item.DataTypeID)
              td.ind1
                if ((item.DataTypeClassType == 1 || item.DataTypeClassType == 2) &&item.IsEntityKey!=1)
                  i(class=['glyphicon','glyphicon-plus','node-op'],onclick='_getAttr(this)')
                != '&nbsp;'+item.Name
              td
                =item.DataTypeFullName
                if item.IsEntityKey=='1'&&item.DataTypeClassType == 1
                  != '<span class="text-danger strong"><strong>.Key</strong></span>'
                if item.IsCollection=='1'
                  != '<span class="ind1 text-primary" title="集合"><strong>［］</strong></span>'
              td
                =item.DefaultValue
              td
                =item.DisplayName
                  if item.DisplayName!=item.Description&&item.Description
                    != '<br/>'
                    small.ind2= item.Description


  .row#OP_Info_Result(style='margin:15px 0px')
    h4
      span(class=['label','label-default']) 返回结果
    table(class=['table','table-hover','table-bordered','table-relative'])
      thead
        tr
          th(class='col-xs-4') 名称
          th(class='col-xs-4') 类型
          th(class='col-xs-1') 默认值
          th(class='col-xs-3') 描述
      if pd.data && pd.data
        tbody
          tr(datarow=1,datalevel=1,datatpye=pd.data.ReturnDataTypeID)
            td.ind1  
              if ((pd.data.ReturnDataTypeClassType == 1 || pd.data.ReturnDataTypeClassType == 2) &&pd.data.ReturnIsEntityKey!=1)
                i(class=['glyphicon','glyphicon-plus','node-op'],onclick='_getAttr(this)')
              != '&nbsp;返回值'
            td= pd.data.ReturnDataTypeFullName
              if pd.data.ReturnIsEntityKey=='1'&&pd.data.ReturnDataTypeClassType == 1 
                != '<span class="text-danger strong"><strong>.Key</strong></span>'
              if pd.data.ReturnIsCollection=='1'
                != '<span class="ind1 text-primary" title="集合"><strong>［］</strong></span>'
            td
            td= pd.data.ReturnDataTypeDisplayName

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
			$MainData=PD::Run('Tool_MD_Entity_List_BP',array("ClassType"=>"7","Key"=>$_REQUEST["query"]));
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
                <h1>BP or SV 查询</h1>
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
            window.location.href = '/tool/bpsv/?query=' + encodeURI($('#body-Submit-key').val());
            return false;
        });
    });
</script>

<script type="text/javascript">
	    function _CreateParamRow(table, data, level, parentRowID) {
        if (data != null && data != undefined && data.length > 0) {
            var html = "";
            var parRow = null;
            if (parentRowID !=undefined) {
                parRow = $("tbody",table).find("tr[datarow='" + parentRowID + "']").next();
            }
            for (var i = 0; i < data.length; i++) {
                var row = data[i];
                html = '<tr datarow="' + parentRowID + "-" + i + '" datalevel="'+level+'" datatpye="'+row.DataTypeID+'">';
                html += '<td class="ind'+level+'">';
                if ((row.DataTypeClassType == 1 || row.DataTypeClassType == 2) &&row.IsEntityKey!=1) {
                    html += '<i class="node-op glyphicon glyphicon-plus" onclick="_getAttr(this)"></i>';
                }
                html += '&nbsp;' + row.Name;
                html += '</td>';
                html += '<td>';
                html += row.DataTypeFullName;
                if (row.DataTypeClassType == 1&&ToBoolean(row.IsEntityKey)) html += '<span class="text-danger strong"><strong>.Key</strong></span>';                
                if (ToBoolean(row.IsCollection)) html += '<span class="text-primary ind1" title="集合"><strong>［］</strong></span>';
                html += '</td>';
                html += '<td>' + (row.DefaultValue!=undefined?row.DefaultValue:"") + '</td>';
                html += '<td>';
                html += row.DisplayName
                if(row.DisplayName != row.Description&&row.Description){
                  html+= '<br/><small class="ind2">' + row.Description + '</small>';
                }
                html += '</td>';
                html += '</tr>';
                if (parRow != null && parRow.length > 0) {
                    $(html).insertBefore(parRow);
                } else {
                    $("tbody",table).append(html);
                }
            }
        }
    };
    function _getAttr(obj) {
        var jobj=$(obj);
        if (!jobj||jobj.length==0) return;
        var level =parseInt(jobj.closest('tr').attr('datalevel'));
        var table = jobj.closest('table');
        var datatpye = jobj.closest('tr').attr('datatpye');
        var rowid = jobj.closest('tr').attr('datarow');
        if ($(obj).hasClass('glyphicon-plus')) {
            var input = '/api/entity/'+datatpye;
            jobj.removeClass('glyphicon-plus');
            $.get(input,function(result){
              if (result != null && result != undefined&&result.length>0) {
                    _CreateParamRow(table, result, (level+1), rowid);
                }
                jobj.removeClass('glyphicon-plus').addClass('glyphicon-minus');
            });
        } else {
            table.find("tr[datarow^='" + rowid + "'][datarow!='" + rowid + "']").remove();
            jobj.removeClass('glyphicon-minus').addClass('glyphicon-plus');
        }
    }
</script>
