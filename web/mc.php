<?php session_start();
	include($_SERVER["DOCUMENT_ROOT"]."/lotusphp/Lotus.php");
	if(isset($_REQUEST["k"])){
		$k=strip_tags($_REQUEST["k"]);		
		$m = memcache_init();
		memcache_delete($m, $k, 1);
	}else{
		$m = memcache_init();
		memcache_flush($m);
	}
?>