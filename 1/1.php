<?php

include '1.html';

$textarea1 = $_GET['textarea1'];
$textarea2 = $_GET['textarea2'];

function getCommonWords( string $a,string $b): array {
    // заменяем знаки препинания на пробел
    $a = str_replace([',','.',':',';','?','!','(',')'], " ",$a);
    $b = str_replace([',','.',':',';','?','!','(',')'], " ",$b);
    // приводим все к нижнему регистру, чтобы сранение было регистронезависимым
    $a = mb_strtolower($a);
    $b = mb_strtolower($b);
    // преобразуем все слова в массив
    $array1 = explode(" ", $a);
    $array2 = explode(" ", $b);
    $result=[];
    // сравниваем каждый элемент между двух массивов
    foreach ($array1 as $item1){
        foreach ($array2 as $item2){
            if ($item1==$item2 and !empty($item1)){
                $result[]=$item1;
            }
        }
    }

    if (empty($result)){
        $result[] = "Нет совпадений";
    }
    $result = array_unique($result);
    return $result;
}
$result= getCommonWords($textarea1,$textarea2);
print "<p>Повторяющиеся слова: ";
foreach ($result as $item){
    print $item.' ';
}
print "</p>";