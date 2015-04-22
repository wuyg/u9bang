<?php
class Help_Page_Edit_BP  extends Sys_BP{	
	public function Run(){
		$pd=$this->PD;
		if(!$pd){
			throw new Exception("无上下文环境!");
		}
		$objPram=$this->Param;

		$msg="";
		$id=$objPram->ID;
		$rtn=new stdClass;
		$isNew=true;
		$data=$objPram->Data;
		if($id&&$id!=""){
			$isNew=false;			
		}else{
			$id=DB::CreateID();
		}

		if(!$data){
			throw new Exception("没有数据data!");
		}
		if($isNew){
			$sql="select id from hp_page where page_parent='".DB::ToString($data->Parent)."' and page_title='".DB::ToString($data->Title)."' limit 1";
			if(DB::getVar( $sql)){
				throw new Exception("标题为【".DB::ToString($data->Title)."】的条目已经存在!");
			}
		}else{
			if(isset($data->Title)) {
				$sql="select id from hp_page where page_parent='".DB::ToString($data->Parent)."' and page_title='".DB::ToString($data->Title)."' and id<>'".DB::ToLong($id)."' limit 1";
				if(DB::getVar( $sql)){
					throw new Exception("标题为【".DB::ToString($data->Title)."】的条目已经存在!");
				}
			}
		}
			
		if($isNew){		
			if($data->Parent>0){
				$sql="update hp_page set page_total_child=page_total_child+1  where ID=".DB::ToLong($data->Parent)." ";
				DB::runSql($sql);
			}

			$sql="insert into hp_page ";
			$sql .="(createdon,createdby,id,version";
			$sql .=",page_parent,page_title,page_content";
			$sql .=",page_sequence,page_isedit,page_iscomment,page_isassess";
			$sql .=",page_total_length";
			$sql .=") ";
			$sql .="values (now()";
			$sql .=",'".$pd->User."'";
			$sql .=",'".$id."'";
			$sql .=",0";
			$sql .=",'".DB::ToLong($data->Parent)."'";
			$sql .=",'".DB::ToString($data->Title)."'";
			$sql .=",'".DB::ToString($data->Content)."'";
			
			$sql .=",'".DB::ToInt($data->Sequence)."'";
			$sql .=",'".DB::ToBool($data->IsEdit)."'";
			$sql .=",'".DB::ToBool($data->IsComment)."'";
			$sql .=",'".DB::ToBool($data->IsAssess)."'";
			$sql .=",'".DB::ToInt($data->Length)."'";
			$sql .=")";
			DB::runSql($sql);
			$this->Msg="保存成功";
		}
		else{
			$sql="update hp_page set ";
			$sql .=" version=version+1";
			if(isset($data->Title)) {$sql .=",page_title='".DB::ToString($data->Title)."'";}
			if(isset($data->Content)) {$sql .=",page_content='".DB::ToString($data->Content)."'";}			
			if(isset($data->Sequence)) {$sql .=",page_sequence='".DB::ToString($data->Sequence)."'";}

			if(isset($data->IsEdit)) {$sql .=",page_isedit='".DB::ToBool($data->IsEdit)."'";}	
			if(isset($data->IsComment)) {$sql .=",page_iscomment='".DB::ToBool($data->IsComment)."'";}	
			if(isset($data->IsAssess)) {$sql .=",page_isassess='".DB::ToBool($data->IsAssess)."'";}		

			if(isset($data->Length)) {$sql .=",page_total_length='".DB::ToString($data->Length)."'";}		
				
			$sql .=" where ID in (".$id.")";
			DB::runSql($sql);
			
			$this->Msg="修改，保存成功";
		}
		$rtn->ID=$id;	
		return $rtn;
	}
}

?>