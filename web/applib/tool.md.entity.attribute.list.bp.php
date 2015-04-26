<?php
class Tool_MD_Entity_Attribute_List_BP  extends Sys_BP{	
	public function Run(){
		$pd=$this->PD;
		if(!$pd){
			throw new Exception("无上下文环境!");
		}
		$objPram=$this->Param;		
		$Entity=$objPram->Entity;
		$page=1;$pageSize=1000;
		if(isset($objPram->Page)&&$objPram->Page>0){$page=$objPram->Page;}
		if(isset($objPram->PageSize)&&$objPram->PageSize>0){$pageSize=$objPram->PageSize;}

		$sql_select="";$sql_from="";$sql_where="";$sql_order="";$sql_page="";

		$sql_select="select l.ID,l.Name,l.FullName,l.DisplayName,l.Description,l.DefaultTable";
     	$sql_select.=",l.ClassType,l.ForOBAImport,l.IsMain,l.ReturnIsCollection,l.ReturnIsEntityKey,l.ReturnDataID as ReturnDataTypeID";
     	$sql_select.=",r.FullName as ReturnDataTypeFullName,r.DisplayName as ReturnDataTypeDisplayName,r.ClassType as ReturnDataTypeClassType,com.AssemblyName as AssemblyName";
     	$sql_select.=",com.Type as AssemblyType";
     	$sql_from=" From MD_Entity as l ";
     	$sql_from.=" left join MD_Entity as r on l.ReturnDataID=r.ID";
     	$sql_from.=" left join MD_AppComponent as com on l.Component=com.ID";
     	$sql_from.=" Where l.ID='".$Entity."'";

		$res=DB::getLine( $sql_select.$sql_from.$sql_where.$sql_order.$sql_page);

		$res["Attr"]=DB::getData("CALL p_md_getEntityAttr('".$Entity."')");
		
		if($res){
			$res=json_encode($res);
			$res=json_decode($res);
		}
		return $res;
	}
}

?>