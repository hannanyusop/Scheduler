<?php

if(!function_exists('dd')){

    function dd($var){

        var_dump($var);
        exit();
    }
}

function getName($string){

    $names = ['gabes', 'test']; #algorithm name

    foreach ($names as $name){
        if (strpos($string, $name) !== false) {
            return $name;
        }
    }
    return false;
}

function getBestDuration($string){

    $key = "BestDuration";
    $possibles = explode(" ",$string);
    foreach ($possibles as $snip){

        if (strpos($snip, $key) !== false) {

            $arr = explode("=",$snip);
            return $arr[1];
        }
    }


}
?>