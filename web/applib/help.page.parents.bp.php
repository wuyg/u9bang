<?php
class Help_Page_Parents_BP  extends Sys_BP{	
	public function Run(){
		$pd=$this->PD;
		if(!$pd){
			throw new Exception("无上下文环境!");
		}
		$objPram=$this->Param;	
		$id=$objPram->ID;
		$ds=DB::getData('CALL p_hp_page_getparents('.$id.');');
		if($ds){
			$ds=json_encode($ds);
			$ds=json_decode($ds);
		}
		return $ds;
	}
}

?>