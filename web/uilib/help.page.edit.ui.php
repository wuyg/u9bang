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
<input type="hidden" value="0" id="edit_MainData" data-id="0" data-parent="0" />
<div class="container-fluid bodybg">
  <div class="col-md-3">
    <div class="row">
    <!--项目信息以及子页面节点-->
    <div class="panel panel-default"  id="tree_page_list">
      <div class="panel-heading">
      点击【<span class="glyphicon glyphicon-console"></span>】增加下级页面节点     
      </div>
      <div class="panel-body">
      </div>
      </div>
    </div>
  </div>
  <div class="col-md-9" role="main">
  <div class="row">
    <ol class="breadcrumb" id="edit_breadcrumb">
        <li><a href="/help/">帮助</a></li>
        <?php
          echo '<li><a href="/help/page.edit/">页面</a></li>';
        ?>        
        <li class="active"><i class="glyphicon glyphicon-plus text-orange">增加</i> </li>       
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
            <input type="text" class="form-control" id="txt_edit_title" />
          </div>
          <div class="form-group">
            <label for="inputPassword" class="control-label">内容</label>
            <textarea class="form-control" rows="20" id="txt_edit_content"></textarea>
          </div>

           <div class="form-group">
            <label class="control-label">导航码<span class="small placeholder ind2 normal">用于快速定位到当前页面,eg:如定义<code>CBO.Wh.List</code>可以快速导航到<strong>存储地点</strong>帮助页面</span></label>  
             <input type="text" class="form-control" id="txt_edit_navcode" />   
          </div>


          <div class="form-group">
            <div class="col-md-3">
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ck_edit_comment" value="1">
                    <strong>可评论</strong>
                    <br/>
                    <small>允许用户评论当前内容.</small>                    
                  </label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="checkbox">
                  <label>
                   <input type="checkbox" id="ck_edit_edit" value="1">              
                    <strong> 可编辑</strong>
                    <br/>
                    <small>允许其它用户参与内容编辑</small>   
                  </label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="checkbox">
                  <label>
                   <input type="checkbox" id="ck_edit_assess" value="1">                
                    <strong> 可评价</strong>
                    <br/>
                    <small>允许用户对内容进行评价</small>   
                  </label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="checkbox">
                  <label>
                   <input type="checkbox" id="ck_edit_private" value="1">                
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
    </div>
</div>
<script src="/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
  CKEDITOR.replace( 'txt_edit_content',{toolbar:"My",height:300});
 var editIns= CKEDITOR.instances.txt_edit_content;
</script>
<?php
$html='<script>';
  $html .='$(document).ready(function(e) { ';
  $html .='Load_PageList('.$param_id.');';
  if($param_id<=0){
     $html .='$("#box_edit_command").hide();';
}
 $html .='});</script>'; 

 echo $html;
?>

<script>
$(document).ready(function(e) { 
  $('#btn_Confirm').click(postEditorData);
  $('#btn_deleteItem').click(deleteItemData);  
  var did=$('#edit_MainData').data('id');
  if(did>0){
    Page_EditorView($('#edit_MainData').data('id'));
  }
});

function Page_BindData(data){
   $('#edit_MainData').data('id',data.ID).val(data.ID);
   $('#edit_MainData').data('parent',data.Parent);
   $('#txt_edit_title').val(data.Title); 
   editIns.setData(data.Content);
   $('#txt_edit_navcode').val(data.NavCode); 
   $('#ck_edit_assess').prop('checked',data.IsAssess);
   $('#ck_edit_comment').prop('checked',data.IsComment);
   $('#ck_edit_edit').prop('checked',data.IsEdit); 
}
function Page_AddView(parent){     
   $('#box_edit_command').hide();
   $('#edit_breadcrumb>li.active>i').removeClass('glyphicon-edit').addClass('glyphicon-plus').html('增加');
   SetNodeFocus(parent);
   Page_BindData({Parent:parent,ID:0});
}
function Page_EditorView(id){
  Fanx.Run('Help_Page_Item_BP',{ID:id},function(result,error,e){
    if(error){
        Fanx.Error(error);
      }else{
        if(result.su){
          Page_BindData(result.data);                         
        }
      }
  },{type:"GET"});

  $('#box_edit_command').show();
  $('#edit_breadcrumb>li.active>i').removeClass('glyphicon-plus').addClass('glyphicon-edit').html('编辑');
  SetNodeFocus(id);
};
function Load_PageList(id){
  Fanx.Run('Help_Page_Parents_BP',{ID:id},function(result,error,e){
      if(error){
          Fanx.Error(error);
        }else{
          if(result.su){
             for (var i = 0; i < result.data.length; i++) {
              createPageItemNode(result.data[i],i);
            }
          }
        }
    },{type:"GET"});
}
function SetNodeFocus(id){
  $('#tree_page_list>.panel-body>.active').removeClass('active');
  $('#tree_page_list>.panel-body>[data-id="'+id+'"]').addClass('active');
  var ct=$('#tree_page_list>.panel-body>[data-id="'+id+'"]');
  if(ct){
    $('#edit_MainData').data('id',ct.data('id')).val(ct.data('id'));
    $('#edit_MainData').data('parent',ct.data('parent'));
  }
}
function NodeItemClick(sender){
  if(!sender){
    return false;
  }
  if(!$(sender).data('isrun')||$(sender).data('isrun')=="0"){  
    $(sender).data('isrun',"1");
    var c_div=$(sender.parentElement);
    var param={ID:c_div.data('id'),Path:c_div.data('path')};
    if($(sender).hasClass('node-toc-collapsed')){
      expendTree(param.ID);    
    }else{
       $('#tree_page_list>.panel-body').find("div[data-path^='" + param.Path + "'][data-path!='" + param.Path + "']").remove();
       $(sender).removeClass('node-toc-expanded').addClass('node-toc-collapsed');  

       $(sender).data('isrun',"0");   
    }
  }
}
function createPageItemNode(data,i){
    var html='',param={Path:"0",Level:0};
    var parRow=null;
    var box=$('#tree_page_list>.panel-body');
    if(data.Parent&&data.Parent>0){
      var c_div=box.find('div[data-id="'+data.Parent+'"]');
      param.Level=c_div.data('level')+1;
      param.Path=c_div.data('path');

      parRow=c_div.next();
    }
    html='<div class="ind'+(param.Level)+' node-toc" data-level="'+(param.Level)+'" data-id="'+data.ID+'" data-path="'+param.Path+'-'+i+'">';
    if(data.Total_Child>0){
      html +='<a class="node-toc-icon node-toc-collapsed" onclick="NodeItemClick(this)"></a>';
    }else{
      html +='<a class="node-toc-icon"></a>';
    }
    html +='<a class="node-toc-item" onclick="Page_EditorView('+data.ID+')">'+data.Title+'</a>';
    html +='<a class="node-toc-op glyphicon glyphicon-console" onclick="Page_AddView('+data.ID+');"></a>';
    html +='</div>';

    if (parRow != null && parRow.length > 0) {
        $(html).insertBefore(parRow);
    } else {
        box.append(html);
    }

    if(data.Parent&&data.Parent>0){
      $('#tree_page_list>.panel-body>div[data-id="'+data.Parent+'"]>.node-toc-icon').removeClass('node-toc-collapsed').addClass('node-toc-expanded').data('isrun',"0");
    }
}
function expendTree(parent,currID){
  var param={ID:0,Path:"0",Level:0};
  if(parent&&parent>0){
    var c_div=$('#tree_page_list>.panel-body>div[data-id="'+parent+'"]');
    if(c_div&&c_div.length>0){
      param.ID=c_div.data('id');
      param.Level=c_div.data('level')+1;
      param.Path=c_div.data('path');

      $('#tree_page_list>.panel-body').find("div[data-path^='" + param.Path + "'][data-path!='" + param.Path + "']").remove();
    }
  }else{
    $('#tree_page_list>.panel-body').find("div[data-path]").remove();
  }
  Fanx.Run('Help_Page_List_BP',{Parent:param.ID},function(result,error,e){  
    if(error){
      Fanx.Error(error);
    }else{
      if(result.su){
        if(result.data&&result.data.length>0){
          for (var i = 0; i < result.data.length; i++) {
            createPageItemNode(result.data[i],i);
          }
          if(currID&&currID>0){
            SetNodeFocus(currID);
          }          
        }
      }            
    }
  },{type:"POST"});
};
function deleteItemData(e){
  var cbtn=$(this);
  var param={ID:$('#edit_MainData').val(),Parent:$('#edit_MainData').data('parent')};
  if(param.ID>0){
    if(cbtn.hasClass('disabled')){return false;}
    
    Fanx.Run('Help_Page_Delete_BP',{ID:param.ID},function(result,error,e){  
        if(error){
          Fanx.Error(error);
        }else{
          if(result.su){
            expendTree(param.Parent);
            Page_AddView(param.Parent);
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
    var did=$('#edit_MainData').data('id');
    var param={};
    param.Title=$('#txt_edit_title').val(); 
    param.Content=editIns.getData();
    param.NavCode=$('#txt_edit_navcode').val();
    param.IsAssess=$('#ck_edit_assess').prop('checked');
    param.IsComment=$('#ck_edit_comment').prop('checked');
    param.IsEdit=$('#ck_edit_edit').prop('checked');

    param.Parent=$('#edit_MainData').data('parent');
    param.Sequence=0;
    param.Length=param.Content.length;

    if(!param.Title ||param.Title.length<=0){$('#txt_edit_title').focus(); Fanx.Error("标题不能为空！");return false;};
    
    cbtn.addClass('disabled');
    
    Fanx.Run('Help_Page_Edit_BP',{ID:did,Data:param},function(result,error,e){  
      if(error){
        Fanx.Error(error);
      }else{
        if(result.su){
          Page_EditorView(result.data.ID);
          expendTree(param.Parent,result.data.ID);
        }
      }
      cbtn.removeClass('disabled');
    },{type:"POST"});
    return false;
};

</script>