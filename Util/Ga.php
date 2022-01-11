<?php
namespace Util;

class Ga{

    public static function getDetail($array){

//        dd($array);
        return [
            'name' => self::getName($array),
            'best_duration' => self::getBestDuration($array),
            'generation'   => self::getGenerationSize($array)
        ];
    }
    private static function getName($array){

        $names = ['ga']; #algorithm name

        $string = $array[0];
        foreach ($names as $name){
            if (strpos($string, $name) !== false) {
                return strtoupper($name);
            }
        }
        return false;
    }

    private static function getBestDuration($array){

        $usual_key = [38];

        $keyword = "Duration";

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

        $usual_key = [36];
        $keyword = "generation";
        $generation = false;

        foreach ($usual_key as $key){

            $test[$key]  = $string = $array[$key];

            $possibles = explode(" ",$string);

            foreach ($possibles as $snip){

                if(!$generation){
                    if (strpos($snip, $keyword) !== false) {

                        $arr = explode("=",$snip);
                        $generation =  $arr[1];
                    }
                }
            }

        }

        return $generation;
    }
}