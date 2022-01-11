<?php

if(!function_exists('dd')){

    function dd($var){

        var_dump($var);
        exit();
    }
}




function getFileType($array){

    $names = ['gabes', 'ga', 'GABES', 'bes']; #algorithm name

    $string = $array[0];
    foreach ($names as $name){
        if (strpos($string, $name) !== false) {
            return strtoupper($name);
        }
    }
    return false;
}
?>