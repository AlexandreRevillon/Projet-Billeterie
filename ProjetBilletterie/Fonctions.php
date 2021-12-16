<?php

function age($date) { 
     $age = date('Y') - date('Y', strtotime($date)); 
    if (date('md') < date('md', strtotime($date))) { 
        return $age - 1; 
    } 
    return $age; 
}


function codep($date){
    $age = age($date);
    if (($age>3) && ($age<26)){
        return '4-25';
    } else{
        if ($age>25){
            return '65+';
        } else {
            return 'TP';
        }
    }
}
?>
