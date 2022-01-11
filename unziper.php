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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Scheduler Report Generator</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>
<header id="header" class="fixed-top">
    <div class="container d-flex align-items-center justify-content-between">
        <h1 class="logo"><a href="index.php">Scheduler Report Generator</a></h1>
    </div>
</header>
<section id="hero" class="d-flex align-items-center">
    <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">
        <div class="m-2">
            <div class="mt-3">
                <h5>Algorithm Name   : <?= $outcome['name'] ?></h5>
                <h5>Generation Size  :  <?= $outcome['generation_size'] ?></h5>
                <h5>Total simulation :  <?= $outcome['simulation_count'] ?></h5>
            </div>
            <table class="table table-bordered">
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
                        <td><?= reformatTime($data['duration']) ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td class="font-weight-bold" colspan="<?=$key+2?>"> <b>Avarage : <?= reformatTime($outcome['average']) ?></b></td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="text-center">
            <a href="index.php" class="btn-get-started">Back</a>
        </div>
    </div>
</section>
<div id="preloader"></div>
<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="assets/vendor/purecounter/purecounter.js"></script>
<script src="assets/vendor/aos/aos.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

<!-- Template Main JS File -->
<script src="assets/js/main.js"></script>

</body>

</html>
