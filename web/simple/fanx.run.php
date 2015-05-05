<?php session_start();
	$BPName="";	
	if(isset($_REQUEST["BPName"])){
		$BPName=strip_tags($_REQUEST["BPName"]);
	}
	$svrtn=array("su"=>0,"msg"=>"此方法没有被实现!");	
	if(!$BPName||$BPName==""){
		throw new Exception("服务名称不能为空!");
	}

	$BPName=str_replace('.','_',$BPName);
	$From="";
	if(isset($_REQUEST["From"])){
		$From=strip_tags($_REQUEST["From"]);
	}
	include_once("../lotusphp/Lotus.php");
	if(!class_exists($BPName)){
		if(class_exists($BPName.'_BP')){
			$BPName=$BPName.'_BP';
		}
	}
	if(class_exists($BPName)){	
		try{
			$param=array();
			if(isset($_REQUEST["Param"])){
				$param=$_REQUEST["Param"];
			}
			if(!$param){
				$param=array();
			}
			if(isset($_POST)){
				foreach ($_POST as $key => $value) {
					$param[$key]=$value;
				}				
			}
			if(isset($_REQUEST)){
				foreach ($_REQUEST as $key => $value) {
					$param[$key]=$value;
				}				
			}
			$obj=new $BPName;
			$obj->PD=PD::GetPD();
			if($param){
				$param=json_encode($param);
				$param=json_decode($param);
				$obj->Param=$param;
			}
			$obj->From=$From;
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