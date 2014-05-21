<?php
class phplog
{
	static function writelog($msg)
	{
		echo "$msg<BR>";
		date_default_timezone_set(timezone);
		$today = date("Y.m.d");
		$dirname = dirname(__FILE__).'/logfiles';
		if(is_dir($dirname) || mkdir($dirname))
		{
			;
		}
		else 
		{
			return false;
		}

		$filename = $dirname."/log_$today.txt";
		$file = false;
		if(!file_exists($filename))
		{
			$file = fopen($filename,'w');
			if($file == false)
			{
				return false;
			}
		}
		else if(!is_writable($filename))
		{
			return false;
		}
		if($file == false && !($file = fopen($filename,'a')))
		{
			return false;
		}

		if(fwrite($file, date("Y.m.d H:i:s")."\t$msg\r\n") === false)
		{
			fclose($file);
			return false;
		}
		fclose($file);
		return true;
	}
	static function querydb_log($msg)
	{
		$filename = "log_querydb.txt";
		$file = false;
		if(!file_exists($filename))
		{
			$file = fopen($filename,'w');
			if($file == false)
			{
				return false;
			}
		}
		else if(!is_writable($filename))
		{
			return false;
		}
		if($file == false && !($file = fopen($filename,'a')))
		{
			return false;
		}

		if(fwrite($file, $msg."\r\n") === false)
		{
			fclose($file);
			return false;
		}
		fclose($file);
		return true;
	}
}
?>