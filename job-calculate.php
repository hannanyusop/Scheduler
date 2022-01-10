<?php
include 'main.php';

    if(isset($_FILES['file'])){

        $result  = [];
        $file  = $_FILES['file'];
        $array = file($file['tmp_name']);
        $name  = getName($array[0]);
        $best_duration = getBestDuration($array[21]);
        $result = [
            'name' => $name,
            'duration' => $best_duration
        ];

        dd($result);
    }else{
        echo "No file found!";
    }



?>