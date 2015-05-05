<?php
class Account_Login_BP  extends Sys_BP{
	public  function Run(){		
		$objPram=$this->Param;
		if(!isset($objPram->Account)||!$objPram->Account){
			throw new Exception("账号不能为空!");
		}
		if(!isset($objPram->Password)||!$objPram->Password){
			throw new Exception("密码不能为空!");
		}
		if(!$objPram||!$objPram->Account||!$objPram->Password){
			throw new Exception("非法登录!");
		}
		$sql="select * from sso_user where u_account='".DB::ToString($objPram->Account)."' and u_password='".DB::ToString($objPram->Password)."' limit 1";		
		$data=DB::getLine( $sql );
		if($data){
			$userLoginInfo=array();	
			$userLoginInfo["User_ID"]=floatval($data["id"]);
			$userLoginInfo["User_Account"]=$data["u_account"];
			$userLoginInfo["User_NickName"]=$data["u_nickname"];
			$userLoginInfo["User_Name"]=$data["u_name"];
			$userLoginInfo["User_Image"]=$data["u_image"];
			$userLoginInfo["User_SecretKey"]=$data["u_secretkey"];
			
			$_SESSION['Fanx_Session'] = $userLoginInfo;
			setcookie('Fanx_Session', http_build_query($userLoginInfo),time()+3600,"/");
			return true;
		}else{
			throw new Exception("登录失败,用户名或者密码错误!");
		}		
		return true;		
	}
}

?>