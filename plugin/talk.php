<?php

if($action=="privmsg"){
  if(substr($msg,0,6)=="!speak"){
    $t=explode(" ",$msg, 3);
    IRC_Post($t[1], "<".$usr."> ".trim($t[2]));
  }
  if(substr($msg,0,7)=="!action"){
    $t=explode(" ",$msg, 3);
    IRC_Post($t[1], chr(1)."ACTION ".trim($t[2]).chr(1));
  }
}

?>
