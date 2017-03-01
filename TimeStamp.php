<?php
ini_set('date.timezone','Asia/Shanghai');
require_once('workflows.php');

class TimeStamp{

	public function getTimeStamp($query){
		$workflows = new Workflows();
		$now = time();
		$query = trim($query);
		if ($query == 'now') {
			$workflows->result(	$query,
				time(),
				'当前时间戳：'.time(),
				'当前时间：'.date('Y-m-d H:i:s',time()),
				'icon.png',false);
		}elseif ($query == (string)intval($query)) {
			$cle = $query-time();
			$d = floor($cle/3600/24);
			$h = floor(($cle%(3600*24))/3600);
			$m = floor(($cle%(3600*24))%3600/60);
			$s = floor(($cle%(3600*24))%60);
			$workflows->result(	$query,
				date('Y-m-d H:i:s',$query),
				'目标时间：'.date('Y-m-d H:i:s',$query),
				"当前时间差 $d 天 $h 小时 $m 分 $s 秒",
				'icon.png',false);
		}else{
			$query2 = strtotime($query)-time();
			$workflows->result(	$query,
				strtotime($query),
				'目标时间戳：'.strtotime($query),
				'当前时间差：'.$query2,
				'icon.png',false);
		}
		echo $workflows->toxml();

	}

}
