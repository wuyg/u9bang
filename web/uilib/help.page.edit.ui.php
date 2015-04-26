<?php
  $html="";
  $param_id=0; 
  if(isset($_REQUEST["id"])){ 
    $param_id=$_REQUEST["id"];    
  }
  $param_parent=0; 
  if(isset($_REQUEST["parent"])){ 
    $param_parent=$_REQUEST["parent"];    
  }
  $MainData=null;
  if($param_id>0){
      $MainData=PD::Run('Help_Page_Item_BP',array("ID"=> $param_id));
      if(!$MainData){
        die('没有数据，可能是参数错误或者数据已被删除!');
      }
  }
  if($param_parent>0&&$MainData&&$MainData->Parent!=$param_parent){
    die('非法数据...外星人入侵...');
  }
  if($MainData){
    $param_parent=$MainData->Parent;
  }
?>
<div class="container-fluid bodybg">
  <div class="col-md-3">
    <div class="row">
    <!--项目信息以及子页面节点-->
    <div class="panel panel-default">
      <div class="panel-heading">
      点击【<span class="glyphicon glyphicon-console"></span>】增加下级页面节点     
      </div>
      <div class="panel-body" id="tree_page_list">
         <?php
            if($param_id>0){
               $pageNodes=PD::Run('Help_Page_Parents_BP',array("ID"=>$param_id));
             }else if($param_parent>0){
               $pageNodes=PD::Run('Help_Page_Parents_BP',array("ID"=>$param_parent));
             }else{
              $pageNodes=PD::Run('Help_Page_Parents_BP',array("ID"=>0));
             }           
            if($pageNodes){
              $html='';
              $item_count=count($pageNodes);
              foreach ($pageNodes as $key => $value) {
                $html .='<div class="ind'.$value->Level.' node-toc ';
                if(($param_id>0&&$value->ID==$param_id)||($param_id==0&&$value->ID==$param_parent)){
                  $html .= ' active';
                }
                $html .= '" data-level="'.$value->Level.'" data-id="'.$value->ID.'" data-path="'.$value->Path.'">';
                  if ($value->Total_Child> 0) {
                    if(($key+1)<$item_count&&strpos($pageNodes[$key+1]->Path,$value->Path)!==false){
                      $html .= '<a class="node-toc-icon node-toc-expanded" onclick="NodeItemClick(this)"></a>';
                    }else{
                      $html .= '<a class="node-toc-icon node-toc-collapsed" onclick="NodeItemClick(this)"></a>';
                    }                
                  } else {
                      $html .= '<a class="node-toc-icon"></a>';
                  }
                  $html .='<a class="node-toc-item" href="/help/page.edit/'.$value->ID.'.html">'.$value->Title.'</a>';
                  $html .='<a class="node-toc-op glyphicon glyphicon-console" href="/help/page.edit/parent-'.$value->ID.'/"></a>';
                  $html .= '</div>';
              }
             echo $html;
            }
           ?>
      </div>
      </div>
    </div>
  </div>
  <div class="col-md-9" role="main">
  <div class="row">
    <ol class="breadcrumb" id="edit_breadcrumb">
        <li><a href="/help/">帮助</a></li>
        <li><a href="/help/page.edit/">页面</a></li>
        <?php
          if($param_id>0){
            $html='<li class="active"><i class="glyphicon glyphicon-edit text-orange">编辑</i> </li> ';
          }else{
            $html='<li class="active"><i class="glyphicon glyphicon-plus text-orange">增加</i> </li> ';
          }
          echo $html;
        ?>    
    </ol>
    </div>
    <!--提示   
      <div class="alert alert-warning alert-dismissible fade in" role="alert" id="edit_warning_box">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <p>
    
        </p>
      </div>
    -->  
      <!--编辑区-->
        <section class="clearfix">         
          <div class="form-group">
            <label for="inputPassword" class="control-label">标题 <span class="small placeholder ind2 normal">将显示在页面节点以及导航栏中,尽量用简短且容易理解词语</span></label>
            <?php
              if($MainData&&$param_id>0){
                $html='<input type="text" class="form-control" id="txt_edit_title" value="'.$MainData->Title.'" />';
              }else{
                $html='<input type="text" class="form-control" id="txt_edit_title"  />';
              }
              echo $html;
            ?>            
          </div>
          <div class="form-group">
            <label for="inputPassword" class="control-label">内容</label>
            <textarea class="form-control" rows="20" id="txt_edit_content">
              <?php
              if($MainData&&$param_id>0){
                echo $MainData->Content;
              }
            ?>  
            </textarea>
          </div>

           <div class="form-group">
            <label class="control-label">导航码<span class="small placeholder ind2 normal">用于快速定位到当前页面,eg:如定义<code>CBO.Wh.List</code>可以快速导航到<strong>存储地点</strong>帮助页面</span></label>  
            <?php
              if($MainData&&$param_id>0){
                $html='<input type="text" class="form-control" id="txt_edit_navcode" value="'.$MainData->NavCode.'" />';
              }else{
                $html='<input type="text" class="form-control" id="txt_edit_navcode"  />';
              }
              echo $html;
            ?>    
          </div>

          <div class="form-group">
            <div class="col-md-3">
                <div class="checkbox">
                  <label>
                  <?php
                  if($MainData&&$param_id>0&&$MainData->IsComment){
                    $html='<input type="checkbox" id="ck_edit_comment" value="1" checked>';
                  }else{
                    $html='<input type="checkbox" id="ck_edit_comment" value="1">';
                  }
                  echo $html;
                  ?>
                    <strong>可评论</strong>
                    <br/>
                    <small>允许用户评论当前内容.</small>                    
                  </label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="checkbox">
                  <label>
                  <?php
                  if($MainData&&$param_id>0&&$MainData->IsEdit){
                    $html='<input type="checkbox" id="ck_edit_edit" value="1" checked>';
                  }else{
                    $html='<input type="checkbox" id="ck_edit_edit" value="1">';
                  }
                  echo $html;
                  ?>             
                    <strong> 可编辑</strong>
                    <br/>
                    <small>允许其它用户参与内容编辑</small>   
                  </label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="checkbox">
                  <label>
                  <?php
                  if($MainData&&$param_id>0&&$MainData->IsAssess){
                    $html='<input type="checkbox" id="ck_edit_assess" value="1" checked>';
                  }else{
                    $html='<input type="checkbox" id="ck_edit_assess" value="1">';
                  }
                  echo $html;
                  ?>               
                    <strong> 可评价</strong>
                    <br/>
                    <small>允许用户对内容进行评价</small>   
                  </label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="checkbox">
                  <label>
                  <?php
                  if($MainData&&$param_id>0&&$MainData->IsPrivate){
                    $html='<input type="checkbox" id="ck_edit_private" value="1" checked>';
                  }else{
                    $html='<input type="checkbox" id="ck_edit_private" value="1">';
                  }
                  echo $html;
                  ?>               
                    <strong> 私有的 </strong>
                    <br/>
                    <small>只有授权用户，登录系统后，才能看到此项目.</small>   
                  </label>
                </div>
            </div>
          </div>
        </section>
    <section class="row">
        <div class="form-actions">
            <button class="btn btn-info" type="button" id="btn_Confirm"><i class="glyphicon glyphicon-ok-sign"></i> 保存</button>
        </div>
    </section>
    <?php
      if($MainData&&$param_id>0){
    ?>
        <section class="panel panel-danger" id="box_edit_command">
          <div class="panel-heading strong">危险区</div>
           <div class="list-group">
            <div class="list-group-item">
              <h4 class="list-group-item-heading strong">删除当前项目</h4>
              <button type="button" class="list-group-item-operator btn btn-danger" id="btn_deleteItem">删除项目</button>
              <p class="list-group-item-text placeholder small"><span>删除后数据不可恢复，且该项目的所有页面以及节点都将删除，需要谨慎操作!<span></p>
            </div>
          </div>
        </section>
        <?php
          }
        ?>
    </div>
</div>
<script src="/ckeditor/ckeditor.js"></script> 
<script>
 CKEDITOR.replace('txt_edit_content',{toolbar:"My",height:300});
var editIns= CKEDITOR.instances.txt_edit_content;
$(document).ready(function(e) { 
  $('#btn_Confirm').click(postEditorData);
  $('#btn_deleteItem').click(deleteItemData);
});

function NodeItemClick(sender) {
    if (!sender) {
        return false;
    }
    if (!$(sender).data('isrun') || $(sender).data('isrun') == "0") {
        $(sender).data('isrun', "1");
        var c_div = $(sender.parentElement);
        if ($(sender).hasClass('node-toc-collapsed')) {
            expendTree(c_div.data('id'));
        } else {
            $('#tree_page_list').find('div[data-path^="' + c_div.data('path') + '."]').remove();
            $(sender).removeClass('node-toc-expanded').addClass('node-toc-collapsed');
            $(sender).data('isrun', "0");
        }
    }
}
function createPageItemNode(data) {
    var html = '';
    var parRow=null;
    var box = $('#tree_page_list');    
    if (data.Parent && data.Parent > 0) {
        var parent_path=data.Path.substring(0,data.Path.lastIndexOf('.'));
        parRow=box.find('div[data-path^="' + parent_path + '."]:last');
        if(parRow.length<=0){
            parRow=box.find('div[data-path="' + parent_path + '"]');
        }
    }
    html = '<div class="ind' + (data.Level) + ' node-toc" data-level="' + (data.Level) + '" data-id="' + data.ID + '" data-path="' + data.Path+'">';
    if (data.Total_Child > 0) {
        html += '<a class="node-toc-icon node-toc-collapsed" onclick="NodeItemClick(this)"></a>';
    } else {
        html += '<a class="node-toc-icon"></a>';
    }
    html += '<a class="node-toc-item" href="/help/page.edit/' + data.ID + '.html">' + data.Title + '</a>';
    html += '<a class="node-toc-op glyphicon glyphicon-console" href="/help/page.edit/parent-'+data.ID+'/"></a>';
    html += '</div>';

    if (parRow != null && parRow.length > 0) {
        $(html).insertAfter(parRow);
    } else {
        box.append(html);
    }
    if (data.Parent && data.Parent > 0) {
        $('#tree_page_list>div[data-id="' + data.Parent + '"]>.node-toc-icon').removeClass('node-toc-collapsed').addClass('node-toc-expanded').data('isrun', "0");
    }
}

function expendTree(parent, currID) {
    Fanx.Run('Help_Page_List_BP', {
        Parent: parent
    }, function(result, error, e) {
        if (error) {
            Fanx.Error(error);
        } else {
            if (result.su) {
                if (result.data && result.data.length > 0) {
                    for (var i = 0; i < result.data.length; i++) {
                        createPageItemNode(result.data[i]);
                    }
                    if (currID && currID > 0) {
                        SetNodeFocus(currID);
                    }
                }
            }
        }
    }, {
        type: "POST"
    });
};
function deleteItemData(e){
  var cbtn=$(this);
  var param={ID:$('#Page_Main_DataID').data('id')};
  if(param.ID>0){
    if(cbtn.hasClass('disabled')){return false;}
    
    Fanx.Run('Help_Page_Delete_BP',{ID:param.ID},function(result,error,e){  
        if(error){
          Fanx.Error(error);
        }else{
          if(result.su){
            window.location.href="/help/page.edit/";
          }
        }
        cbtn.removeClass('disabled');
      },{type:"POST"});
    }
    return false;
};
function postEditorData(e){
    var cbtn=$(this);
    if(cbtn.hasClass('disabled')){return false;}

    var param={};
    param.ID=$('#Page_Main_DataID').data('id')||0;
    param.Title=$('#txt_edit_title').val(); 
    param.Content=editIns.getData();
    param.NavCode=$('#txt_edit_navcode').val();
    param.IsAssess=$('#ck_edit_assess').prop('checked');
    param.IsComment=$('#ck_edit_comment').prop('checked');
    param.IsEdit=$('#ck_edit_edit').prop('checked');

    param.Parent=$('#Page_Main_DataID').data('parent')||0;
    param.Sequence=0;
    param.Length=param.Content.length;

    if(!param.Title ||param.Title.length<=0){$('#txt_edit_title').focus(); Fanx.Error("标题不能为空！");return false;};
    
    cbtn.addClass('disabled');
    
    Fanx.Run('Help_Page_Edit_BP',param,function(result,error,e){  
      if(error){
        Fanx.Error(error);
      }else{
        if(result.su){
          window.location.href="/help/page.edit/"+result.data.ID+".html"; 
        }
      }
      cbtn.removeClass('disabled');
    },{type:"POST"});
    return false;
};

</script>