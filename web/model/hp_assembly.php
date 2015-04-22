<?php
class HP_Assembly{
	public $ID;
	public $Name;
	public $Title;
	public $Path;
	public $Param;
	public $Description;
	public $Authority=1;
	private static $memcachekey="HP_Assembly.AllPage";
	private static $memcachePageFile="HP_Assembly.PageFile";
	public static function GetItem($name){
		if(!$name)
			return null;
		$all=self::GetAll();
		$rtn=null;
		if($all&&count($all)>0){			
			foreach($all as $k=>$v){
				if($v->Name==$name)
				{
					$rtn=$v;
					break;
				}
			}			
		}
		if(!$rtn){
			$newName="";
			if(is_file(ROOTDIR.'uilib/'.$name.'.ui.html')){
			     $newName='uilib/'.$name.'.ui.html';
			}
			if(is_file(ROOTDIR.'uilib/'.$name.'.ui.htm')){
			     $newName='uilib/'.$name.'.ui.htm';
			}
			if(!$newName){
				if(is_file(ROOTDIR.'uilib/'.$name.'.ui.php')){
				     $newName='uilib/'.$name.'.ui.php';
				}
			}
			if($newName){
				$rtn=new HP_Assembly;
			    $rtn->Path=$newName;
			}
		}
		return $rtn;
	}
	public static function GetAll(){
		$allData=null;
		$mmc=memcache_init();
		if($mmc){
			$allData=memcache_get($mmc,self::$memcachekey);
		}
		if($allData&&count($allData)>0)
			return $allData;
		
		$sql="select id as ID,ass_name as Name,ass_title as Title,ass_path as Path,ass_param as Param,ass_authority as Authority,ass_description as Description from hp_assembly order by id";		
		$ds= DB::getData( $sql);
		if($ds!=null&&isset($ds)&& count($ds)>0){
			$rtn=array();
			foreach($ds as $k=>$v){
				$rtnItem=new HP_Assembly();
				$rtnItem->ID=$v["ID"];
				$rtnItem->Name=$v["Name"];
				$rtnItem->Title=$v["Title"];
				$rtnItem->Path=$v["Path"];
				$rtnItem->Param=$v["Param"];
				$rtnItem->Description=$v["Description"];
				$rtnItem->Authority=intval($v["Authority"]);
				array_push($rtn,$rtnItem);
			}
			if($rtn&&count($rtn)>0){
				memcache_set($mmc,self::$memcachekey,$rtn);
				return $rtn;
			}
		}
		return null;
	}
}
?>