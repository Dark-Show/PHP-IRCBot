<?php

function IRC_PRIVMSG($usr, $msg, $ch, $host){
global $ROOT;
global $fp;
global $version;
global $chan;
global $nick;
global $myip;
$action="privmsg";
include($ROOT."plugin.parse.php");
}

function IRC_UserJoin($usr, $host, $ch){
global $ROOT;
global $fp;
global $version;
global $chan;
global $nick;
global $myip;
$action="userjoin";
include($ROOT."plugin.parse.php");
}

function IRC_UserPart($usr, $host, $ch){
global $ROOT;
global $fp;
global $version;
global $chan;
global $nick;
global $myip;
$action="userpart";
include($ROOT."plugin.parse.php");
}

function IRC_Names($ch,$names){
global $ROOT;
global $fp;
global $version;
global $chan;
global $nick;
$action="channames";
include($ROOT."plugin.parse.php");
}

function IRC_Nick($usr){
global $ROOT;
global $fp;
global $version;
global $chan;
global $nick;
$nick=$usr;
$action="nickchange";
include($ROOT."plugin.parse.php");
fwrite($fp, "NICK ".$usr."\r\n");
}

function IRC_NOTICE($usr, $msg, $tar){
global $ROOT;
global $fp;
global $version;
global $chan;
global $nick;
$action="notice";
include($ROOT."plugin.parse.php");
}

function IRC_PostNotice($tar, $msg){
global $ROOT;
global $fp;
global $version;
global $chan;
global $nick;
$action="postnotice";
include($ROOT."plugin.parse.php");
fwrite($fp, "NOTICE ".$tar." :".$msg."\r\n");
}

function IRC_Rejoin(){
global $ROOT;
global $fp;
global $version;
global $chan;
global $nick;
$action="chanrejoin";
include($ROOT."plugin.parse.php");
$temp=explode(" ",$chan);
foreach($temp as $c){IRC_Join($c);}
}

function IRC_Join($ch,$ps=""){
global $ROOT;
global $fp;
global $version;
global $chan;
global $nick;
$action="chanjoin";
include($ROOT."plugin.parse.php");
if(substr($ch,0,1)!=="#"){$ch="#".$ch;}
$out="JOIN ".$ch;
if($ps!==""){$out.=" ".$ps;}
$out.="\r\n";
fwrite($fp, $out);
}


function IRC_Mode($ch,$flags,$users){
global $ROOT;
global $fp;
global $version;
global $chan;
global $nick;
$action="setmode";
include($ROOT."plugin.parse.php");
fwrite($fp, "MODE ".$ch." ".$flags." ".$users."\r\n");
}

function IRC_Raw($raw){
global $ROOT;
global $fp;
global $version;
global $chan;
global $nick;
$action="sendraw";
include($ROOT."plugin.parse.php");
fwrite($fp, $raw."\r\n");
}

function IRC_Part($ch){
global $ROOT;
global $fp;
global $version;
global $chan;
global $nick;
$action="chanpart";
include($ROOT."plugin.parse.php");
if(substr($ch,0,1)!=="#"){$ch="#".$ch;}
$out="PART ".$ch."\r\n";
fwrite($fp, $out);
}

function IRC_Post($tar,$msg){
global $ROOT;
global $fp;
global $version;
global $chan;
global $nick;
$action="msgpost";
include($ROOT."plugin.parse.php");
fwrite($fp, "PRIVMSG ".$tar." :".$msg."\r\n");
}

?>