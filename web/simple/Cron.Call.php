<?php session_start();
header('Content-Type: text/html; charset=UTF-8');
if(!isset($_REQUEST["Op"])){
	return;
}
include_once("../lotusphp/Lotus.php");
/*查询是否有未执行的JOB*/
$now=date('Y-m-d H:i:s',strtotime('+5 second'));//时间偏移量：+5 second;

$sql="select r.ID,r.IsSerial from Sys_Request as r where r.State=1 and r.EndTime>='".$now."' and r.DataStatus=4";
$sql_where=" and (r.ExecutingCount=1)";/*执行一次的*/
$sql_where .=" or (r.ExecutingCount=-1 and (r.ExecutingTime is null or r.ExecutingTime<='".$now."'))" ;/*永远执行的,且本周期还未执行的*/
$sql .=$sql_where;
$tmp=DB::getData($sql);
if($tmp){	
	$serialList=array();
	$paralleList=array();
	
	foreach($tmp as $k=>$v){
		if($v["IsSerial"]=="1"){
			$serialList[]=array("url"=>"http://".$_SERVER['HTTP_HOST']."/simple/Request.Run.php","postdata"=>"Request=".$v["ID"]);
		}else{
			$paralleList[]=array("url"=>"http://".$_SERVER['HTTP_HOST']."/simple/Request.Run.php","postdata"=>"Request=".$v["ID"]);
		}
	}
	if(count($paralleList)>0){
		$paralleQueue = new SaeTaskQueue("paralle");//并行队列
		$paralleQueue->addTask($paralleList);
		//将任务推入队列
		$ret = $paralleQueue->push();
		//任务添加失败时输出错误码和错误信息
		if ($ret === false){
			var_dump($paralleQueue->errmsg());
		}
		unset($paralleQueue);
	}
	
	if(count($serialList)>0){
		$serialQueue = new SaeTaskQueue('serial');//串行队列
		$serialQueue->addTask($serialList);
		//将任务推入队列
		$ret = $serialQueue->push();
		//任务添加失败时输出错误码和错误信息
		if ($ret === false){
			var_dump($serialQueue->errmsg());
		}
		unset($serialQueue);
	}
	
	unset($paralleList,$serialList);
}
unset($tmp,$sql,$sql_where);
?>
