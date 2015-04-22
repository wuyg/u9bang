<?php
class Sys_Favor_Edit_BP  extends Sys_BP{
	public  function Run(){		
		$pd=$this->PD;
		if(!$pd){
			throw new Exception("无上下文环境!");
		}
		$objPram=$this->Param;

		$msg="";

		$rtn=new stdClass;
		
		$data=$objPram->Data;

		if(!$data){
			throw new Exception("没有数据data!");
		}
		$sql="update sys_favor set Hits=Hits+1,ModifiedOn=now() where DataID='".$data->DataID."' and Type='".$data->Type."'";
		if(DB::runSql($sql)){
			$sql="insert into sys_favor ";
			$sql .="(CreatedOn,Type,DataID,DataCode,DataName,DataDisplayName";
			$sql .=") ";
			$sql .="values (now()";
			$sql .=",'".DB::ToString($data->Type)."'";
			$sql .=",'".DB::ToString($data->DataID)."'";
			$sql .=",'".DB::ToString($data->DataCode)."'";
			$sql .=",'".DB::ToString($data->DataName)."'";
			$sql .=",'".DB::ToString($data->DataDisplayName)."'";			
			$sql .=")";
			DB::runSql($sql);
			$this->Msg="保存成功";
		}	
		return $rtn;	
	}
}

?>