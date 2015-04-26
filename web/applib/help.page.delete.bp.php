<?php
class Help_Page_Delete_BP  extends Sys_BP{	
	public function Run(){
		$pd=$this->PD;
		if(!$pd){
			throw new Exception("无上下文环境!");
		}
		$objPram=$this->Param;
		$id=$objPram->ID;
		if(isset($id)&&$id>0){
			$sql="select page_parent from  hp_page  where id=".$id." limit 1 ";
			$sid=DB::getVar($sql);
			if($sid&&floatval($sid)>0){
				$sql="update hp_page set page_total_child=page_total_child-1  where ID=".$sid." ";
				DB::runSql($sql);
			}
			$sql="select page_path from  hp_page  where id=".$id." limit 1 ";
			$sid=DB::getVar($sql);

			if($sid){
				$sql="delete from  hp_page  where page_path like '".$sid.".%' ";
				DB::runSql($sql);
			}
			$sql="delete from  hp_page  where id=".$id." ";
			DB::runSql($sql);
			$msg="删除记录成功";
			return true;
		}
		return false;
	}
}

?>