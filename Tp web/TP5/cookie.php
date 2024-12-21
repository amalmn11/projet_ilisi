<?php

setcookie("visiteur","ilisi",time()+60*60*24);
var_dump($_COOKIE);


if(isset($_COOKIE['visiteur']))
{
    $comt=$_COOKIE['visiteur']+1;
}
else{

    $comt=1;
}

echo 'le nombre de compte visité'.$comt;

?>