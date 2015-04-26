<?php
class Help_Page_List_BP  extends Sys_BP{	
	public function Run(){
		$pd=$this->PD;
		if(!$pd){
			throw new Exception("无上下文环境!");
		}
		$objPram=$this->Param;		
		
		$page=1;$pageSize=20;
		if(isset($objPram->Page)&&$objPram->Page>0){$page=$objPram->Page;}
		if(isset($objPram->PageSize)&&$objPram->PageSize>0){$pageSize=$objPram->PageSize;}

		$sql_select="";$sql_from="";$sql_where="";$sql_order="";$sql_page="";
		$sql_select="select l.id as ID,l.createdon as CreatedOn,l.createdby as CreatedBy,l.version as Version,l.status as Status";
		$sql_select .=",l.page_parent as Parent,l.page_title as Title,l.page_navcode as NavCode,l.page_sequence as Sequence";
		$sql_select .=",l.page_path as Path,length(l.page_path)-length(replace(l.page_path,'.','')) as Level";
		$sql_select .=",l.page_isedit as IsEdit,l.page_iscomment as IsComment,l.page_isassess as IsAssess,l.page_isprivate as IsPrivate";
		$sql_select .=",l.page_total_child as Total_Child,l.page_total_length as Total_Length,l.page_total_counter as Total_Counter";
		$sql_select .=",l.page_total_edit as Total_Edit,l.page_total_comment as Total_Comment,l.page_total_assess as Total_Assess";
		
		$sql_from =" from hp_page as l";

		
		if(isset($objPram->CreatedBy)&&$objPram->CreatedBy){$sql_where .=" and l.createdby='".$objPram->CreatedBy."'";}
		if(isset($objPram->Status)){$sql_where .=" and l.status='".$objPram->Status."'";}

		if(isset($objPram->Project)){$sql_where .=" and l.page_project='".$objPram->Project."'";}
		if(isset($objPram->Parent)){$sql_where .=" and l.page_parent='".$objPram->Parent."'";}

		if(isset($objPram->Title)&&$objPram->Title){$sql_where .=" and l.page_title='".DB::ToString($objPram->Title)."' ";	}
		
		

		if($sql_where){
			$sql_where=substr($sql_where, 4);
			$sql_where=" where ".$sql_where;
		}
		$sql_order=" order by l.page_parent desc,l.page_sequence";
		$sql_page =" limit ".(($page-1)*$pageSize).",".$pageSize." ";

		$ds=DB::getData( $sql_select.$sql_from.$sql_where.$sql_order.$sql_page);
		if($ds){
			$ds=json_encode($ds);
			$ds=json_decode($ds);
		}
		return $ds;
	}
}

?>