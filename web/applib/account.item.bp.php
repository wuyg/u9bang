<?php
class Account_Item_BP  extends Sys_BP{
	public  function Run(){	
		$pd=$this->PD;
		if(!$pd){
			throw new Exception("无上下文环境!");
		}
		$objPram=$this->Param;		
		if(!isset($objPram->Account)&&!isset($objPram->ID)){
			throw new Exception("查询参数Account或者ID不能为空!");
		}
		if(isset($objPram->Account)&&!$objPram->Account){
			throw new Exception("查询参数Account格式不正确!");
		}
		if(isset($objPram->ID)&&!$objPram->ID){
			throw new Exception("查询参数ID格式不正确!");
		}

		$sql_select="";$sql_from="";$sql_where="";$sql_order="";$sql_page="";

		$sql_select="select l.id as ID,l.createdon as CreatedOn,l.version as Version,l.status as Status";
		$sql_select .=",l.u_account as Account,l.u_secretkey as SecretKey,l.u_vkey as VKey";
		$sql_select .=",l.u_name as Name,l.u_nickname as NickName,l.u_email as Email,l.u_phone as Phone";
		$sql_select .=",l.total_vkeys as Total_VKeys";
		$sql_from =" from sso_user as l";
		if(isset($objPram->Account)&&$objPram->Account){
			$sql_where=" where l.u_account='".$objPram->Account."' ";	
		}	
		if(isset($objPram->ID)&&$objPram->ID){
			$sql_where=" where l.ID='".$objPram->ID."' ";	
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