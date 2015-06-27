<?php

if($action=="privmsg"){
  if(substr($msg,0,5)=="!join"){
    $t=explode(" ",$msg, 3);
    if(isset($t[2])){
      IRC_Join($t[1],$t[2]);
    }else{
      IRC_Join($t[1]);
    }
  }
}

?>
