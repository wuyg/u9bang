<?php session_start();
	$BPName="";	
	if(isset($_REQUEST["BPName"])){
		$BPName=strip_tags($_REQUEST["BPName"]);
	}
	$svrtn=array("su"=>0,"msg"=>"此方法没有被实现!");	
	if(!$BPName||$BPName==""){
		throw new Exception("服务名称不能为空!");
	}
	include_once("../lotusphp/Lotus.php");
	
	if(class_exists($BPName)){	
		try{
			$param=$_REQUEST["Param"];
			$obj=new $BPName;
			$obj->PD=PD::GetPD();
			if($param){
				$param=json_encode($param);
				$param=json_decode($param);
				$obj->Param=$param;
			}
			$rtn=$obj->Run();
			$svrtn=array("su"=>1,"msg"=>$obj->Msg,"data"=>$rtn);
			unset($obj);
		}
		catch (Exception $e) {
			$svrtn=array("su"=>0,"msg"=> $e->getMessage());
		}
		echo json_encode($svrtn);
	}else{
		throw new Exception("不存在此服务：".$BPName);
	}
	
?>