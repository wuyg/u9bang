<?php
class Account_SignCheck_BP  extends Sys_BP{
	public  function Run(){	
		$pd=$this->PD;
		if(!$pd){
			throw new Exception("无上下文环境!");
		}
		$objPram=$this->Param;
		if(!isset($objPram->Account)){
			throw new Exception("账号不能为空!");
		}
		if(!PD::IsEmail($objPram->Account)){
			throw new Exception('您输入的账号格式不正确，请输入您当前有效的电子邮箱!');
		}
		$sql="select id from  sso_user  where u_account='".$objPram->Account."' limit 1 ";
		if(DB::getVar($sql)){
			throw new Exception("该账号[".$objPram->Account."]已经被占用了，建议换个账号试试!");
		}	
		$sql="select id from  sso_user  where u_email='".$objPram->Account."' limit 1 ";
		if(DB::getVar($sql)){
			throw new Exception("该邮箱[".$objPram->Account."]已经注册过了，建议直接用当前邮箱登录!");
		}
		return true;

	}
}

?>