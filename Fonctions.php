<?php

function codep($date){
    $now=time();
    $date2=strtotime('$date');
    $tmp=abs($now-$date2);
    $tmp = floor($tmp/1000);    
    $sec = $tmp % 60;
    if (($sec>124144000) && ($sec<788400000))
        return '4-25';
    else{
        if ($sec>2049840000)
            return '65+';
        else 
            return 'TP';}
}

function datedebutabo(){
    return time();
}
?>
