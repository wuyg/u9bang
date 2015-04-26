<?php
class Help_Page_Item_BP  extends Sys_BP{	
	public function Run(){
		$pd=$this->PD;
		if(!$pd){
			throw new Exception("无上下文环境!");
		}
		$objPram=$this->Param;		
		$id=$objPram->ID;

		$sql_select="";$sql_from="";$sql_where="";$sql_order="";$sql_page="";

		$sql_select="select l.id as ID,l.createdon as CreatedOn,l.createdby as CreatedBy,l.version as Version,l.status as Status";
		$sql_select .=",l.page_parent as Parent,l.page_title as Title,l.page_navcode as NavCode,l.page_sequence as Sequence";
		$sql_select .=",l.page_path as Path,length(l.page_path)-length(replace(l.page_path,'.','')) as Level";
		$sql_select .=",l.page_isedit as IsEdit,l.page_iscomment as IsComment,l.page_isassess as IsAssess,l.page_isprivate as IsPrivate";
		$sql_select .=",l.page_total_child as Total_Child,l.page_total_length as Total_Length,l.page_total_counter as Total_Counter";
		$sql_select .=",l.page_total_edit as Total_Edit,l.page_total_comment as Total_Comment,l.page_total_assess as Total_Assess";
		$sql_select .=",l.page_content as Content";

		$sql_from =" from hp_page as l";
		if($id&&$id>0){
			$sql_where=" where l.ID=".$id."  ";	
		}	
		$sql_page =" limit 1";
		$ds=DB::getLine( $sql_select.$sql_from.$sql_where.$sql_order.$sql_page);
		if($ds){
			$ds=json_encode($ds);
			$ds=json_decode($ds);
		}
		return $ds;
	}
}

?>