<?php

if(1){
  if($action=="privmsg"){
    echo($ch." [".$usr."] ".$msg."\n");
  }
  if($action=="notice"){
    echo("NOTICE: ".$tar." [".$usr."] ".$msg."\n");
  }
  if($action=="postnotice"){
    echo($tar." > ".$msg."\n");
  }
  if($action=="chanjoin"){
    echo("Channel \"".$ch."\" Joined\n");
  }
  if($action=="chanpart"){
    echo("Channel \"".$ch."\" Parted\n");
  }
  if($action=="chanrejoin"){
    echo("Channel Rejoin Started\n");
  }
  if($action=="msgpost"){
    echo($tar." > ".$msg."\n");
  }
  if($action=="nickchange"){
    echo("Nickname is now ".$usr."\n");
  }
  if($action=="userjoin"){
    echo($usr." joined ".$ch."\n");
  }
  if($action=="userpart"){
    echo($usr." parted ".$ch."\n");
  }
}else{
  if($action=="ircparse"){
    echo($data);
  }
}
//@ob_end_flush(); 
//@ob_flush(); 
//@flush();
//@ob_start();

?>
