<?php
ini_set('error_reporting', E_ALL);
$str="А Васька слушает да ест. А воз и ныне там. А вы друзья как ни садитесь, все в музыканты не годитесь. 
        А король-то — голый. А ларчик просто открывался. А там хоть трава не расти.";

print "Входная строка: ".$str."<br>";

function reverseStr(string $str):string
{
    $result='';
    $array = mb_split("\.", $str);
    krsort($array);
    foreach ($array as $item){
        if ($item!=" " and !empty($item))
        {
            $result.=$item.". ";
        }
    }
    return $result;
}
echo "Первая функция: ".reverseStr($str)."<br>";

function reverseStr2(string $str):string
{
    $array = explode(". ", $str);
    krsort($array);
    $result='';
    foreach ($array as $item){
        if ($item[-1]=='.'){
            $result.=$item." ";
        }else{
            $result.=$item.". ";
        }
    }
    return $result;
}

echo "Вторая функция: ".reverseStr2($str)."<br>";