<?php
class PD{
	public $User_ID=0;
	public $User_Account;
	public $User_Image;
	public $User_NickName;
	public $User_SecretKey;
	public static function GetPD(){
		$rtn=new PD();		
		$tv=NULL;
		if(isset($_SESSION["Fanx_Session"])){$tv=$_SESSION["Fanx_Session"];}
		if ((!$tv)&& isset($_COOKIE["Fanx_Session"])) {			
			$t=$_COOKIE["Fanx_Session"];
			parse_str($t, $tv);
		}
		if($tv){
			if(isset($tv["User_ID"]))
				$rtn->User_ID=floatval($tv["User_ID"]);
			if(isset($tv["User_Account"]))
				$rtn->User_Account=$tv["User_Account"];	
			if(isset($tv["User_Image"]))
				$rtn->User_Image=$tv["User_Image"];
			if(isset($tv["User_NickName"]))
				$rtn->User_Email=$tv["User_NickName"];
			if(isset($tv["User_SecretKey"]))
				$rtn->User_SecretKey=$tv["User_SecretKey"];
		}
		return $rtn; 
	}
	public static function SetValue($key,$value){
		$tv=NULL;
		if(isset($_SESSION["Fanx_Session"])){$tv=$_SESSION["Fanx_Session"];}
		if ((!$tv)&& isset($_COOKIE["Fanx_Session"])) {			
			$t=$_COOKIE["Fanx_Session"];
			parse_str($t, $tv);
		}
		if($tv){
			$tv[$key]=$value;			
			$_SESSION['Fanx_Session'] = $tv;
			setcookie('Fanx_Session', http_build_query($tv),time()+3600,"/");	
		}
	}
	public static function GetValue($key){
		$tv=NULL;
		if(isset($_SESSION["Fanx_Session"])){$tv=$_SESSION["Fanx_Session"];}
		if ((!$tv)&& isset($_COOKIE["Fanx_Session"])) {			
			$t=$_COOKIE["Fanx_Session"];
			parse_str($t, $tv);
		}
		if($tv&&isset($tv[$key])){
			return $tv[$key];				
		}
		return null;
	}

	/**
	    * 随机字符
	    * 
	    * @access public
	    * @param int $length 字符长度，小于30，如8 
	    * @return string 
	    */
	public static function CreateRand( $length = 8 ) {  
		// 密码字符集，可任意添加你需要的字符  
		$chars ="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()";  
		$str ="";  
		for ( $i = 0; $i < $length; $i++ )  
		{
			$str .= $chars[ mt_rand(0, strlen($chars) - 1) ];  
		}  
		return $str;  
	}
	public static function ToBool($str){
		if(!$str)	return 0;
		if($str=='false') return 0;
		return 1;
	}
	public static function ToInt($str){
		return	intval($str);
	}
	public static function ToLong($str){
		return floatval($str);
	}
	public static function ToDecimal($str){
		return floatval($str);
	}
	public static function GetHTML_Empty($content){
		$html='<div class="empty-bt clearfix">';
		$html.='<div class="empty-bt-pic"></div><div class="empty-bt-txt">'.$content.'</div>';
		$html.='</div>';
		return  $html;
	}
	public static function GetHTML_Alert($message,$title=false){
		$html='<div class="alert alert-warning alert-dismissible fade in" role="alert">';
      	$html.='<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>';      	
      	if(isset($title)){
      		$html.='<h4 id="oh-snap!-you-got-an-error!">'.$title.'</h4>';
      	}
      	$html.='<p>'.$message.'</p>';
      	$html.='</div>';
      	return $html;
	}
	/**
	 * 友好的时间显示
	 *
	 * @param int    $sTime 待显示的时间
	 * @param string $type  类型. normal | mohu | full | ymd | other
	 * @param string $alt   已失效
	 * @return string
	 */
	 public static function FTime($sTime) {
		if (!$sTime)
			return '';
		$cTime=time();
		$sTime= strtotime($sTime);				
		$dTime      =   $cTime - $sTime;
		$dDay       =   intval(date("z",$cTime)) - intval(date("z",$sTime));
		$dYear      =   intval(date("Y",$cTime)) - intval(date("Y",$sTime));		
		if( $dTime < 60 ){
			return $dTime."秒前";
		}elseif( $dTime < 3600 ){
			return intval($dTime/60)."分钟前";
		}elseif( $dTime >= 3600 && $dDay == 0  ){
			return intval($dTime/3600)."小时前";
		}elseif( $dDay > 0 && $dDay<=7 ){
			return intval($dDay)."天前";
		}elseif( $dDay > 7 &&  $dDay <= 30 ){
			return intval($dDay/7) . '周前';
		}elseif( $dDay > 30 ){
			return intval($dDay/30) . '个月前';
		}
	 }
	 public static function HTML_FIsTrue($value){	 	
      if ($value&&$value!=null && ($value=='1' || $value==1)){
      	return '<i class="text-success strong">√</i>';
      } 
	 }
	public static function Run($bpName,$param=null){
		$bpName=str_replace('.','_',$bpName);
		$From="BP";
		if(!class_exists($bpName)){
			if(class_exists($bpName.'_BP')){
				$bpName=$bpName.'_BP';
			}
		}
		if(class_exists($bpName)){	
			$obj=new $bpName;
			$obj->PD=PD::GetPD();
			if($param){
				$param=json_encode($param);
				$param=json_decode($param);
				$obj->Param=$param;
			}
			$obj->From=$From;
			$rtn=$obj->Run();
			unset($obj);
			return $rtn;
		}else{
			throw new Exception("不存在此服务：".$bpName);
		}
	}
	public static function WriteFile($url){
		/*判断图片的url是否为空，如果为空停止函数*/
		if($url==""){
			return false;
		}
		/*取得图片的扩展名，存入变量$ext中*/
		$file_ext=strtolower(strrchr($url,"."));
		/*读取图片*/
		$f = new SaeFetchurl();
		$img_data = $f->fetch($url);
		
		$pd=PD::GetPD();
		$object = '/'.$pd->User.'/' .date("Ymd"). time () .'-'. rand ( 1, 9999 ).$file_ext;
		
		$s = new SaeStorage();
		$rtnUrl= $s->write("media" ,$object , $img_data );
		if($rtnUrl){
			if(strpos($rtnUrl,"http")!==0){$rtnUrl="http://".$rtnUrl;}
			return $rtnUrl;
		}else{
			return false;
		}
	}
	public static function UpdateFile($file){
		$srcFile=$file['tmp_name'];
		$file_name = $file['name'];
		$file_ext=strtolower( strrchr( $file_name , '.' ) );
		
		$pd=PD::GetPD();
		$object = '/'.$pd->User.'/' .date("Ymd"). time () .'-'. rand ( 1, 9999 ).$file_ext;
		
		$s = new SaeStorage();
		$rtnUrl= $s->upload("media" ,$object , $srcFile );
		if($rtnUrl){
			if(strpos($rtnUrl,"http")!==0){$rtnUrl="http://".$rtnUrl;}
			return $rtnUrl;
		}else{
			return false;
		}
	}
	public static function DeleteFile($url){
		$pt = strrpos($url,"media")+strlen("media"); 
		$object=substr ($url,$pt);
		$s = new SaeStorage();
		return $s->delete ("media" ,$object);
	}
	public static function IsEmail($value){
		if (preg_match('/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+\.([a-zA-Z0-9_-])+/',$value)){ 
			return true;
		}
		return false; 
	}
	public static function IsPhone($value){
		if (preg_match('/^(1(([35][0-9])|(47)|[8][0126789]))\d{8}$/',$value)){ 
			return true;
		}
		return false; 
	}
	
	public static function GetCurrentURL(){
		$url='http://'.$_SERVER['SERVER_NAME'];
		if($_SERVER["SERVER_PORT"]!='80'){			
			$url .=':'.$_SERVER["SERVER_PORT"];		}
		$url .=$_SERVER["REQUEST_URI"];
		return $url;
	}
	public static function OauthCheck($die=true){
        if(PD::GetValue("User_ID")<=0){            
            if($die){
                header("Location:/account/reflogin?continue=".PD::GetCurrentURL()); exit;
            }
            return false;
        }
        return true;
    }
}
?>