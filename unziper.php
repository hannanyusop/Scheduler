<?php
include 'main.php';

use Util\Gabes;
use Util\Ga;
use Util\Bes;

$message = "";
if(isset($_POST)) {

    $file = $_FILES['zip']['tmp_name'];
    $dir  = 'temp';

    $files = glob($dir.'/*');

    #deleting old file
    foreach ($files as $old_file){
        unlink($old_file); # deleting
    }

    try {
        $zip  = new ZipArchive;
        $zip->open($file);
        $zip->extractTo($dir);
        $zip->close();

        $result  = [];
        $files = glob($dir.'/*');

        if(count($files) == 0){
            dd('no file');
        }

        #TODO: decide algo type
        $array = file($files[0]);

        $type = getFileType($array);

        if(!$type){
            dd('Invalid Algo Type.');
            echo "<script>alert('Invalid Algo Type.')</script>";
            header('index.php');
        }

        $outcome = [
            'name' => $type,
            'generation_size' => 0,
            'simulation_count' => 0,
            'cumulative_time' => 0,
            'average' => 0,
        ];

        foreach ($files as $new_file){

            $array = file($new_file);
            if($type == "GABES"){
                $detail = Gabes::getDetail($array);
            }elseif($type == "GA"){
                $detail = Ga::getDetail($array);
            }elseif($type == "BES"){
                $detail = Bes::getDetail($array);
            }

            $outcome['name']            = $detail['name'];
            $outcome['generation_size'] = $detail['generation'];
            $outcome['simulation_count'] =+1;
            $outcome['cumulative_time']  =+$detail['best_duration'];
            $result[] = [
                'file_name'       => $new_file,
                'duration'        => $detail['best_duration'],
            ];
        }

        $outcome['average'] = $outcome['cumulative_time'] / $outcome['simulation_count'];

    }Catch(Exception $exception){
        $message =  "<div id=\"failure\">".$exception->getMessage()."</div>";
    }
}
?>

<h4>Algorithm Name   : <?= $outcome['name'] ?></h4>
<h4>Generation Size  :  <?= $outcome['generation_size'] ?></h4>
<h4>Total simulation :  <?= $outcome['simulation_count'] ?></h4>
<table>
    <thead>
    <tr>
        <th>Simulation</th>
        <th>File Path</th>
        <th>Best Duration</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($result as $key => $data){ ?>
        <tr>
            <td> TASK <?= $key+1 ?></td>
            <td><?= $data['file_name'] ?></td>
            <td><?= $data['duration'] ?></td>
        </tr>
    <?php } ?>
    <tr>
        <td colspan="<?=$key+2?>"> Avarage : <?= $outcome['average'] ?></td>
    </tr>
    </tbody>
</table>

<a href="index.php">Run New Data</a>
