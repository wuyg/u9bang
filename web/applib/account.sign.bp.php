<?php
class Account_Sign_BP  extends Sys_BP{
	public  function Run(){	
		$pd=$this->PD;
		if(!$pd){
			throw new Exception("无上下文环境!");
		}
		$objPram=$this->Param;
		if(!isset($objPram->Account)||!$objPram->Account){
			throw new Exception("账号不能为空!");
		}
		if(!isset($objPram->Password)||!$objPram->Password){
			throw new Exception("密码不能为空!");
		}
		//验证用户名
		PD::Run('Account.SignCheck',array("Account"=>$objPram->Account));

		$id=DB::CreateID();
		$secretkey=PD::CreateRand(8);
		$password=DB::ToString($objPram->Password);//md5(DB::ToString($objPram->Password).$secretkey);
		$sql="insert into sso_user ";
		$sql .="(createdon,id,version";
		$sql .=",u_account,u_secretkey,u_password";
		$sql .=",u_name,u_nickname,u_email,u_phone,status,u_vkey";
		$sql .=") ";
		$sql .="values (now()";
		$sql .=",'".$id."'";
		$sql .=",0";
		$sql .=",'".DB::ToString($objPram->Account)."'";
		$sql .=",'".$secretkey."'";
		$sql .=",'".$password."'";
		$sql .=",'".DB::ToString($objPram->Name)."'";
		$sql .=",'".DB::ToString($objPram->NickName)."'";
		$sql .=",'".DB::ToString($objPram->Email)."'";
		$sql .=",'".DB::ToString($objPram->Phone)."'";
		$sql .=",2";
		$sql .=",8888";
		$sql .=")";
		DB::runSql($sql);
		$this->Msg="注册成功";
		return $id;
	}
}
?>