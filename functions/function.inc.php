<?php 

	function empty_div($keyword='', $description='', $class='')
	{
		$div = "<div class='empty-div ".$class."'> 
					<div class='content'>
						<h3>No records found</h3>
							<p>There are no <span style='font-weight:bold' class='text text-warning'>".$keyword."</span> available at the moment. Once you add <span style='font-weight:bold' class='text text-warning'>".$keyword."</span> you will be able to ".$description." specific ".$keyword.".</p>";
		$div .= "</div></div>";	
		return $div;
	}
	function delete_modal()
	{
		return "<div class='modal' id='Modal'>
					<div class='modal-dialog modal-dialog-centered'>
						<div class='modal-content'>
							<div class='modal-body'>
							    <span class='btn-close' style='float:right;margin-top:-20px'>&#x2715</span>
								<h4 align='center'> Are you sure you want to delete?</h4>
								<div class='btn-group'>
									<a id='yes' class='btn btn-primary'>Yes</a>
									<a href='' class='btn btn-danger'>No</a>
								</div>
							</div>
						</div>
					</div>
				</div>";
	}
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