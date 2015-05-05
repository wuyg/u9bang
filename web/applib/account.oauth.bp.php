<?php
/*
get user secretkey for login
*/
class Account_Oauth_BP  extends Sys_BP{
	public  function Run(){		
		$objPram=$this->Param;		
		if(!$objPram||!$objPram->Account||!$objPram->Password||!$objPram->Client){
			throw new Exception("非法登录!");
		}
		$sql="select * from sso_user where u_account='".DB::ToString($objPram->Account)."' and u_password='".DB::ToString($objPram->Password)."' limit 1";		
		$data=DB::getLine( $sql );
		if($data){
			$userLoginInfo=array();	
			$userLoginInfo["ID"]=floatval($data["id"]);
			$userLoginInfo["Account"]=$data["u_account"];
			$userLoginInfo["Name"]=$data["u_nickname"];
			$userLoginInfo["Email"]=$data["u_email"];
			$userLoginInfo["Secretkey"]=$data["u_secretkey"];
			
			$_SESSION['Fanx_Session'] = $userLoginInfo;
			setcookie('Fanx_Session', http_build_query($userLoginInfo),time()+3600,"/");
			return true;
		}
		throw new Exception("登录失败,用户名或者密码错误!");
		return false;		
	}
}

?>