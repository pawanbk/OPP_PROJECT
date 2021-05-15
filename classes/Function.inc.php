<?php 
	function base_url($string='')
	{
		return 'http://localhost/OOP_PROJECT/'.$string;
	}
	function currentdate()
	{
		return date('Y-m-d');
	}
	function curdatetime()
	{
		return date('Y-m-d H:i:s');
	}
	function diffDate($date)
	{
		$now_timestamp = strtotime(date("Y-m-d"));
		if(strtotime($date)>$now_timestamp)
		{
		return true;
		}
		return false;
	}
	function getDateTimeDiff($date)
	{
		$now_timestamp = strtotime(date("Y:m:d H:i:s"));
		$diff_timestamp = $now_timestamp - strtotime($date);
		if($diff_timestamp<60)
		{
		return round($diff_timestamp/60).' seconds ago';
		}
		else if($diff_timestamp >=60 && $diff_timestamp<3600)
		{
		return round($diff_timestamp/60).' minutes ago';
		}
		else if($diff_timestamp >=3600 && $diff_timestamp<86400)
		{
		return round($diff_timestamp/3600).' hours ago';
		}
		else if($diff_timestamp >= 86400 && $diff_timestamp<(86400*30))
		{
		return round($diff_timestamp/86400).' days ago';
		}
		else if($diff_timestamp >= (86400*30) && $diff_timestamp<(86400*365))
		{
		return round($diff_timestamp/(86400*30)).' months ago';
		}
		else 
		{
		return round($diff_timestamp/(86400*365)).' years ago';
		}
	}


?>