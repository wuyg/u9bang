<?php
class Tool_MD_Attribute_List_BP  extends Sys_BP{	
	public function Run(){
		$pd=$this->PD;
		if(!$pd){
			throw new Exception("无上下文环境!");
		}
		$objPram=$this->Param;		
		$Entity=$objPram->Entity;
		$res=DB::getData("CALL  p_getEntityAttr('".$Entity."')");
		
		if($res){
			$res=json_encode($res);
			$res=json_decode($res);
		}
		return $res;
	}
}

?>