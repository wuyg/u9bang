<?php
class Help_Page_Edit_BP  extends Sys_BP{	
	public function Run(){
		$pd=$this->PD;
		if(!$pd){
			throw new Exception("无上下文环境!");
		}
		$data=$this->Param;

		$msg="";
		$id=0;
		if(isset($data->ID)){
			$id=$data->ID;
		}		
		$rtn=new stdClass;
		$isNew=true;
		if($id&&$id!=""){
			$isNew=false;			
		}else{
			$id=DB::CreateID();
		}

		if(!$data){
			throw new Exception("没有数据data!");
		}
		$parent_id=0;
		$data_sequence=0;
		$data_path='P';

		if($isNew){	
			if(isset($data->Parent)){
				$parent_id=$data->Parent;
			}

			$sql="select max(page_sequence) from  hp_page  where page_parent=".$parent_id." ";
			$data_sequence=DB::getVar($sql);
			$data_sequence=$data_sequence+1;

			if($parent_id>0){
				$sql="select page_path from  hp_page  where id=".$parent_id." limit 1 ";
				$data_path=DB::getVar($sql);
			}
			$data_path=$data_path.'.'.str_pad($data_sequence,3,'0',STR_PAD_LEFT);

			if($parent_id>0){
				$sql="update hp_page set page_total_child=page_total_child+1  where ID=".$parent_id." ";
				DB::runSql($sql);
			}
			$sql="insert into hp_page ";
			$sql .="(createdon,createdby,id,version";
			$sql .=",page_parent,page_title,page_content";
			$sql .=",page_sequence,page_path,page_isedit,page_iscomment,page_isassess";
			$sql .=",page_total_length";
			$sql .=") ";
			$sql .="values (now()";
			$sql .=",'".$pd->User."'";
			$sql .=",'".$id."'";
			$sql .=",0";
			$sql .=",'".$parent_id."'";
			$sql .=",'".DB::ToString($data->Title)."'";
			$sql .=",'".DB::ToString($data->Content)."'";
			
			$sql .=",'".$data_sequence."'";
			$sql .=",'".$data_path."'";

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