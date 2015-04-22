<?php
class Sys_Favor_List_BP  extends Sys_BP{
	public  function Run(){		
		$pd=$this->PD;
		if(!$pd){
			throw new Exception("无上下文环境!");
		}
		$objPram=$this->Param;		
		
		$page=1;$pageSize=20;
		if(isset($objPram->Page)&&$objPram->Page>0){$page=$objPram->Page;}
		if(isset($objPram->PageSize)&&$objPram->PageSize>0){$pageSize=$objPram->PageSize;}

		$sql_select="";$sql_from="";$sql_where="";$sql_order="";$sql_page="";
		$sql_select="select * from sys_favor as l";

		
		if(isset($objPram->Type)&&$objPram->Type){$sql_where .=" and l.Type='".$objPram->Type."'";}		

		if($sql_where){
			$sql_where=substr($sql_where, 4);
			$sql_where=" where ".$sql_where;
		}
		$sql_order=" order by l.CreatedOn desc";
		$sql_page =" limit ".(($page-1)*$pageSize).",".$pageSize." ";

		$ds=DB::getData( $sql_select.$sql_from.$sql_where.$sql_order.$sql_page);
		if($ds){
			$ds=json_encode($ds);
			$ds=json_decode($ds);
		}
		return $ds;	
	}
}

?>