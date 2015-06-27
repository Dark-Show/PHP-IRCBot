<?php
set_time_limit(0);
set_error_handler("ErrorHandler");

function ErrorHandler($errno, $errstr, $errfile, $errline){
	fwrite(STDERR,"$errstr in $errfile on $errline\n"); 
}
$myip="";

require("settings.php");
require($ROOT."irc.func.php");

if(is_dir($ROOT."plugin")){if($dh=opendir($ROOT."plugin")){
        while(($file=readdir($dh))!==false){
            if(is_file($ROOT."plugin/".$file) and ($file!="..")){
		if(substr($file,-3)=="php"){
			if(substr($file,0,3)=="inc"){include($ROOT."plugin/".$file);}
	   	}
	    }
	}
closedir($dh);
}}

$stop=false;
while(!$stop){
	$fp = fsockopen($serv, $port, $errno, $errstr, 15);
	if($fp){
		stream_set_blocking($fp,0);
		$data="";
		$out = "USER ".$realname." 0 * ".$realname."\r\n";
		IRC_Nick($nick);
		fwrite($fp, $out);
		while(!feof($fp) and !$stop){
			//$action="while";
			//include($ROOT."plugin.parse.php");
			$data=fgets($fp, 8000);
			if(substr($data,0,4)=="PING"){
				fwrite($fp,str_replace("PING","PONG",$data));
			}else{
				if(trim($data)==":".$nick." MODE ".$nick." :+i"){
					IRC_Rejoin($chan);
				}
				IRC_Parse($data);
				usleep_win(1000);
			}
		}
		fclose($fp);
	}
	sleep(30);
}

function IRC_Parse($data){
	global $ROOT;
	global $fp;
	global $version;
	global $chan;
	global $nick;
	global $alt_nick;
	global $myip;
	//$action="ircparse";
	//include($ROOT."plugin.parse.php");
	if(strlen($data)>1){
		$pos=strpos($data, ":" , 1);
		if($pos==0){
			$dim=count(explode(" ",$data));
		}else{
			$dim=count(explode(" ",substr($data,0,$pos)));
		}
		$data = explode(" ",$data,$dim);
		if($pos==9){
			echo("s".count($data));
		}

		if(count($data)>1){
			if((strpos($data[0], $nick)!==false) and ($data[1]=="JOIN")){
				$myip=gethostbyname(substr($data[0],strpos($data[0], "@")+1)); 
				return(0);
			}
			if($data[1]=="NOTICE"){
				IRC_NOTICE(substr($data[0],1,strpos($data[0], "!")),trim(substr($data[3],1)),$data[2]);
				return(0);
			}
			if($data[1]=="PRIVMSG"){
				IRC_PRIVMSG(substr($data[0],1,strpos($data[0], "!")-1),trim(substr($data[3],1)),$data[2],substr($data[0],strpos($data[0], "@")+1));
				return(0);
			}
			if($data[1]=="JOIN"){
				IRC_UserJoin(substr($data[0],1,strpos($data[0], "!")-1),substr($data[0],strpos($data[0], "@")+1),trim(substr($data[2],1)));
				return(0);
			}
			if($data[1]=="PART"){
				IRC_UserPart(substr($data[0],1,strpos($data[0], "!")-1),substr($data[0],strpos($data[0], "@")+1),trim($data[2]));
				return(0);
			}
			if($data[1]=="353"){
				IRC_Names($data[4],explode(" ",substr($data[5],1)));
				return(0);
			}
			if($data[1]=="376"){
				IRC_Rejoin($chan);
				return(0);
			}
			if($data[1]=="433"){
				IRC_Nick($alt_nick);
				$o=$alt_nick;
				$alt_nick=$nick;
				$nick=$o;
				unset($o);
			}
			if((strtolower($data[1])=="mode") and $data[2]==$nick){
				IRC_Rejoin();
				return(0);
			}
		}	
	}
}

function usleep_win( $micro_seconds ){
    if(@function_exists("socket_create") && @function_exists("socket_select")){
        $false = NULL;
        $socket = array( socket_create( AF_INET, SOCK_RAW, $false ) );
        socket_select( $false, $false, $socket, 0, $micro_seconds );
        return true;
    }else{
        return false;
    }
}

?>
