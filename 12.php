<?php

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
            $result.=$item.".";
        }
    }
    return $result;
}
echo "Первая функция: ".reverseStr($str)."<br>";

function reverseStr2(string $str):string
{
    $array = explode(".", $str);
    krsort($array);
    $result=implode(".",$array);
    return $result;
}

// сокращенная версия функции
function reverseStr3(string $str):string
{
    return implode(".",(explode(".", $str)));
}

echo "Вторая функция: ".reverseStr3($str)."<br>";