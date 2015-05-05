<?php
class Account_KeyValidate_BP  extends Sys_BP{
	public  function Run(){	
		$pd=$this->PD;
		if(!$pd){
			throw new Exception("无上下文环境!");
		}
		$objPram=$this->Param;
		if(!isset($objPram->Account)){
			throw new Exception("账号不能为空!");
		}
		if(!isset($objPram->VKey)){
			throw new Exception("验证码不能为空!");
		}
		$sql="select id from  sso_user  where u_account='".$objPram->Account."' and u_vkey='".$objPram->VKey."' limit 1 ";
		if(!DB::getVar($sql)){
			throw new Exception("输入的验证码错误!");
		}
		return true;
	}
}

?>