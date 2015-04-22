<?php
/*
data server config
*/
define('SAE_MYSQL_USER', 'root');
define('SAE_MYSQL_PASS', '123456');
define('SAE_MYSQL_HOST_M', '127.0.0.1');
define('SAE_MYSQL_HOST_S', '127.0.0.1');
define('SAE_MYSQL_PORT', '3306');
define('SAE_MYSQL_DB', 'hp');

define('SAE_ACCESSKEY', '123456');
define('SAE_SECRETKEY', '123456');

/*cache server config */
define('HTTP_PORT','80') ;
define('HTTPS_PORT','443') ;
define('REDIS_HOST','127.0.0.1') ;
define('REDIS_PORT','6379') ;

//redis app number
define("APP_NUMBER",10) ;

define("ROOTDIR",$_SERVER["DOCUMENT_ROOT"].DIRECTORY_SEPARATOR) ;

// errno define
define("SAE_Success", 0); // OK
define("SAE_ErrKey", 1); // invalid accesskey or secretkey
define("SAE_ErrForbidden", 2); // access fibidden for quota limit
define("SAE_ErrParameter", 3); // parameter not exist or invalid
define("SAE_ErrInternal", 500); // internal Error
define("SAE_ErrUnknown", 999); // unknown error

$_SERVER['HTTP_APPNAME']='HP';

abstract class SaeObject implements SaeInterface
{
	function __construct(){
	}
}
interface SaeInterface
{
	public function errmsg();
	public function errno();
}

function get_appname()
{
	return $_SERVER['HTTP_APPNAME'] ;
}
function sae_debug($str = NULL)
{
	if(!$str)return false;
	else
	{
		echo $str.'<br>';
	}
}
?>