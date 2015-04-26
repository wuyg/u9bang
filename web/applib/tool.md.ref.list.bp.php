<?php
class Tool_MD_Ref_List_BP  extends Sys_BP{	
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

		$sql_select ="select rc.ID";
     $sql_select.=",rc.Name,rc.DisplayName,rc.IsMultiSelect,rc.IsForMultOrg,rc.Width,rc.Height,rc.GroupName,rc.URI,rc.RefType";
     $sql_select.=",r.Filter,r.RefEntityID,c.FullName as RefEntityName,rc.ClassName,rc.Assembly,rc.Path";
     $sql_select.=" From MD_UIReference as r";
     $sql_select.=" Inner Join MD_UIRefComponent as rc on r.Component=rc.ID";
     $sql_select.=" Inner Join MD_Entity as c on r.RefEntityID=c.ID ";
     $sql_where.=" Where 1=1";
    if(isset($objPram->Key)&&$objPram->Key){
       $sql_where.=" and (rc.Name like '%".$objPram->Key."%' or rc.DisplayName like '%".$objPram->Key."%' or  c.FullName like '%".$objPram->Key."%' ) ";
    }
    if(isset($objPram->Entity)&&$objPram->Entity){
        $sql_where.=" and c.ID='".$objPram->Entity."' ";
    }
    $sql_order.="  Order By rc.Name";

		
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