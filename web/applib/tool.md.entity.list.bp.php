<?php
class Tool_MD_Entity_List_BP  extends Sys_BP{	
	public function Run(){
		$pd=$this->PD;
		if(!$pd){
			throw new Exception("无上下文环境!");
		}
		$objPram=$this->Param;		
		
		$page=1;$pageSize=20;
		if(isset($objPram->Page)&&$objPram->Page>0){$page=$objPram->Page;}
		if(isset($objPram->PageSize)&&$objPram->PageSize>0){$pageSize=$objPram->PageSize;}

		$sql_select="";$sql_from="";$sql_where="";$sql_order="";$sql_page="";
		$sql_select ="select l.ID,l.Name,l.FullName,l.DisplayName,l.Description,l.DefaultTable";
     	$sql_select.=",l.ClassType,l.ForOBAImport,l.IsMain,l.ReturnIsCollection,l.ReturnIsEntityKey,l.ReturnDataID as ReturnDataTypeID";
		$sql_select.=",r.FullName as ReturnDataTypeFullName,r.DisplayName as ReturnDataTypeDisplayName,com.AssemblyName as AssemblyName";
		$sql_select.=",com.Type as AssemblyType";
		$sql_from.=" From MD_Entity as l ";
		$sql_from.=" left join MD_Entity as r on l.ReturnDataID=r.ID";
		$sql_from.=" left join MD_AppComponent as com on l.Component=com.ID";
		$sql_where.=" Where l.ClassType>0  ";
		if(isset($objPram->ClassType)&&$objPram->ClassType){
			$sql_where.=" and l.ClassType in (".$objPram->ClassType.") ";
		}
		if(isset($objPram->Key)&&$objPram->Key){
			$sql_where.=" and (";
			$sql_where.=" l.Name like '%".$objPram->Key."%' or l.FullName like '%".$objPram->Key."%' or l.DefaultTable='".$objPram->Key."'  ";
			$sql_where.=" or l.DisplayName like '%".$objPram->Key."%' or l.Description like '%".$objPram->Key."%'  ";
			$sql_where.=")";
		}
		$sql_order=" order by l.Name";
		
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