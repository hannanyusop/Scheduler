<?php
namespace Util;

class Gabes{

    public static function getDetail($array){

        return [
            'name' => self::getName($array),
            'best_duration' => self::getBestDuration($array),
            'generation'   => self::getGenerationSize($array)
        ];
    }
    private static function getName($array){

        $names = ['gabes', 'ga', 'GABES']; #algorithm name

        $string = $array[0];
        foreach ($names as $name){
            if (strpos($string, $name) !== false) {
                return strtoupper($name);
            }
        }
        return false;
    }

    private static function getBestDuration($array){

        $usual_key = [20, 21];

        $keyword = "BestDuration";

        $duration = false;
        foreach ($usual_key as $key){

            $test[$key]  = $string = $array[$key];

            $possibles = explode(" ",$string);
            foreach ($possibles as $snip){

                if(!$duration){
                    if (strpos($snip, $keyword) !== false) {

                        $arr = explode("=",$snip);
                        $duration =  $arr[1];
                    }
                }
            }

        }

        return str_replace(',', '', $duration);
    }

    private static function getGenerationSize($array){

        $usual_key = [3,4,5];

        $generation = 0;

        $test = [];
        foreach ($usual_key as $key){

            if($generation == 0){
                $test[$key]  = $string = $array[$key];
                $possibles  = explode(":",$string);
                $generation = (isset($possibles[1]))? $possibles[1] : 0;
            }
        }
        return (int)$generation;
    }

}