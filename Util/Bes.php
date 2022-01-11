<?php
namespace Util;

class Bes{

    public static function getDetail($array){

//        dd($array);
        return [
            'name' => self::getName($array),
            'best_duration' => self::getBestDuration($array),
            'generation'   => self::getGenerationSize($array)
        ];
    }
    private static function getName($array){

        $names = ['bes']; #algorithm name

        $string = $array[0];
        foreach ($names as $name){
            if (strpos($string, $name) !== false) {
                return strtoupper($name);
            }
        }
        return false;
    }

    private static function getBestDuration($array){

        $usual_key = [11];

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

        $usual_key = [8];

        $size = false;
        foreach ($usual_key as $key){

            $test[$key]  = $string = $array[$key];

            $possibles = explode(" ",$string);

            foreach ($possibles as $snip){

                if(is_numeric($snip)){
                    return $snip;
                }
            }
        }
        return $size;
    }

}