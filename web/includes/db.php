<?php
class DB{	
	private static $_conn;	
	public static function GetConn(){
		if(!isset($_conn)||$_conn==null)
			$_conn=new SaeMysql;
		return $_conn;
	}
	public static function runSql( $sql,$conn=null )
	{
		$conn=self::_prepareConn($conn);
		$rtn=$conn->runSql( $sql );
		if( $conn->errno() != 0 ){
			var_dump($sql);
			throw new Exception($conn->errmsg());
		}
		return $rtn;
	}
	public static function getData( $sql ,$conn=null )
	{
		$conn=self::_prepareConn($conn);
		$rtn=$conn->getData( $sql );
		if( $conn->errno() != 0 ){
			var_dump($sql);
			throw new Exception($conn->errmsg());
		}
		return $rtn;
	}
	public static function getLine( $sql ,$conn=null )
	{
		$conn=self::_prepareConn($conn);
		$rtn=$conn->getLine( $sql );
		if( $conn->errno() != 0 ){
			var_dump($sql);
			throw new Exception($conn->errmsg());
		}
		return $rtn;
	}
	public static function getVar( $sql ,$conn=null )
	{
		$conn=self::_prepareConn($conn);
		$rtn=$conn->getVar( $sql );
		if( $conn->errno() != 0 ){
			var_dump($sql);
			throw new Exception($conn->errmsg());
		}
		return $rtn;
	}
	public static function lastId($conn=null )
	{
		$conn=self::_prepareConn($conn);
		$rtn=$conn->lastId();
		if( $conn->errno() != 0 ){
			throw new Exception($conn->errmsg());
		}
		return $rtn;
	}
	public static function closeDb($conn=null )
	{
		$conn=self::_prepareConn($conn);
		$conn->closeDb();
		if( $conn->errno() != 0 ){
			throw new Exception($conn->errmsg());
		}
	}
	public static function escape( $str,$conn=null )
	{
		$conn=self::_prepareConn($conn);
		$rtn=$conn->escape($str);
		if( $conn->errno() != 0 ){
			throw new Exception($conn->errmsg());
		}
		return $rtn;
	}
	public static function ToString($str,$default=''){
		if(!isset($str)||$str==null)return $default;
		return self::escape($str);
	}
	public static function ToBool($str,$default=0){
		if(!isset($str)||$str==null)return $default;
		if(!$str)	return 0;
		if($str=='false') return 0;
		return 1;
	}
	public static function ToInt($str,$default=0){
		if(!isset($str)||$str==null)return $default;
		return	intval($str);
	}
	public static function ToLong($str,$default=0){
		if(!isset($str)||$str==null)return $default;
		return floatval($str);
	}
	public static function ToDecimal($str,$default=0){
		if(!isset($str)||$str==null)return $default;
		return floatval($str);
	}
	public static function CreateID($count=1){
		if(!isset($count))
			$count=1;		
		$sql="select maxid from sys_idlist";
		$minSN= DB::getVar( $sql);
		if($minSN){
			$sql="update sys_idlist set maxid=maxid+".$count;
			DB::runSql( $sql);
			return $minSN+1;
		}else{
			$minSN=intval(date("ymd",time()))*1000000;
			$sql="insert into sys_idlist(minid,maxid) values (".$minSN.",".($minSN+$count).")";
			DB::runSql( $sql);
			return $minSN;
		}
	}	
	private static function _prepareConn($conn=null )
	{
		if(!isset($conn)||$conn==null){
			$conn=self::GetConn();
		}
		return $conn;
	}
}
?>