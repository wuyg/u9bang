<div class="container-fluid">
<?php
$param_id=0; 
if(isset($_REQUEST["id"])){ 
    $param_id=$_REQUEST["id"];    
}
?>
    <br/>
    <br/>
    <div class="col-md-3">
        <div class="row">
            <div class="col-md-11">
                <div class="row">
                    <!--项目信息以及子页面节点-->
                    <div id="tree_page_list">
                    <?php
						$MainData=PD::Run('Help_Page_Parents_BP',array("ID"=>$param_id));
			            if($MainData){
			            	$html='';
			            	$item_count=count($MainData);
			            	foreach ($MainData as $key => $value) {
			            		$html .='<div class="ind'.$value->Level.' node-toc ';
			            		if($value->ID==$param_id){
			            			$html .= ' active';
			            		}
			            		$html .= '" data-level="'.$value->Level.'" data-id="'.$value->ID.'" data-path="'.$value->Path.'">';
				               	if ($value->Total_Child> 0) {
				               		if(($key+1)<$item_count&&strpos($MainData[$key+1]->Path,$value->Path)!==false){
				               			$html .= '<a class="node-toc-icon node-toc-expanded" onclick="NodeItemClick(this)"></a>';
				               		}else{
				               			$html .= '<a class="node-toc-icon node-toc-collapsed" onclick="NodeItemClick(this)"></a>';
				               		}
							        
							    } else {
							        $html .= '<a class="node-toc-icon"></a>';
							    }
							    $html .= '<a class="node-toc-item" href="/help/'.$value->ID.'.html">'.$value->Title.'</a>';
							    $html .= '</div>';
			            	}
			                echo $html;
			            }
                    ?>
                    </div>
                </div>
            </div>
            <div class="col-md-1 resizable-bar">
            </div>
        </div>
    </div>
    <div class="col-md-9" role="main">
    <article>
        <?php           
            $MainData=PD::Run('Help_Page_Item_BP',array("ID"=>$param_id));
            if($MainData){
                $html='<h1 id="page_content_title">'.$MainData->Title.'</h1>';
                $html .='<section id="page_content_content">'.$MainData->Content.'</section>';
                echo $html;
            }
        ?>
    </article>
        <nav>
            <ul class="pager">
                <li class="previous"><a href="#" class="glyphicon glyphicon-chevron-left"></a></li>
                <li class="next"><a href="#" class="glyphicon glyphicon-chevron-right"></a></li>
            </ul>
        </nav>
        <div class="rating well text-center">
            <div id="ratingSection1">
                <h3>
                    此页面有用吗？
                </h3>
                <div class="description">
                    <p>您对此内容的反馈非常重要。</p>
                    <p>请告诉我们您的想法。</p>
                </div>
                <div class="buttons">
                    <button class="btn btn-info glyphicon glyphicon-thumbs-up" id="ratingYes"> 是</button>
                    <button class="btn btn-info glyphicon glyphicon-thumbs-down" id="ratingNo"> 否</button>
                </div>
            </div>
            <div id="ratingSection3" style="display:none">
                <h3>
                    谢谢！
                </h3>
                <div class="description">
                    我们非常感谢您的反馈。
                </div>
            </div>
            <div id="contentFeedbackQAContainer" style="display: none;"></div>
        </div>
    </div>
</div>
<script>
$(document).ready(function(e) {    
     
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
function createPageItemNode(data, i) {
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
    html += '<a class="node-toc-item" href="/help/' + data.ID + '.html">' + data.Title + '</a>';
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
                        createPageItemNode(result.data[i], i);
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
</script>
