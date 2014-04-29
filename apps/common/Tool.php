<?php

namespace NagatoPHP\Common;
use Phalcon\Mvc\User\Component;

class Tool extends Component {

	public function getIP(){
		if (@$_SERVER["HTTP_X_FORWARDED_FOR"])
			$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		else if (@$_SERVER["HTTP_CLIENT_IP"])
			$ip = $_SERVER["HTTP_CLIENT_IP"];
		else if (@$_SERVER["REMOTE_ADDR"])
			$ip = $_SERVER["REMOTE_ADDR"];
		else if (@getenv("HTTP_X_FORWARDED_FOR"))
			$ip = getenv("HTTP_X_FORWARDED_FOR");
		else if (@getenv("HTTP_CLIENT_IP"))
			$ip = getenv("HTTP_CLIENT_IP");
		else if (@getenv("REMOTE_ADDR"))
			$ip = getenv("REMOTE_ADDR");
		else
			$ip = FALSE;
		return $ip;
	} 

	public function mksize($bytes){
		$bytes = max(0, $bytes);
		if ($bytes < 1000)
			return number_format($bytes) . " B";
		elseif ($bytes < 1000 * 1024)
			return number_format($bytes / 1024, 2) . " KB";
		elseif ($bytes < 1000 * 1048576)
			return number_format($bytes / 1048576, 2) . " MB";
		elseif ($bytes < 1000 * 1073741824)
			return number_format($bytes / 1073741824, 2) . " GB";
		elseif ($bytes < 1000 * 1099511627776)
			return number_format($bytes / 1099511627776, 2) . " TB";
		else
			return number_format($bytes / 1125899906842624, 2) . " PB";
	}

	public function getPagebar($page){
	}

}
