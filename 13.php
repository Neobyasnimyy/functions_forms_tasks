<?php

// 13. Есть строка $string = 'яблоко черешня вишня вишня черешня груша яблоко черешня вишня яблоко
// вишня вишня черешня груша яблоко черешня черешня вишня яблоко вишня вишня черешня вишня черешня груша
// яблоко черешня черешня вишня яблоко вишня вишня черешня черешня груша яблоко черешня вишня';
// Подсчитайте, сколько раз каждый фрукт встречается в этой строке.Выведите в виде списка в порядке уменьшения количества:

//Пример вывода:
//яблоко – 12
//черешня – 8
//груша – 5
//слива - 3

$string = "яблоко черешня вишня вишня черешня груша яблоко черешня вишня яблоко вишня вишня черешня груша яблоко черешня черешня вишня яблоко вишня вишня черешня вишня черешня груша яблоко черешня черешня вишня яблоко вишня вишня черешня черешня груша яблоко черешня вишня";
// разделяя пробелом преобразуем в массив
$array = explode(" ",$string);

// создаем новый массив и убираем повторяющиеся значения
$fruts = array_unique($array,SORT_STRING);

$new_array=[];
foreach ($fruts as $frut){
    // считаем количество повторяющихся фруктов в заданном массиве и записываем ключь значение в новый массив
    $new_array[$frut]=count(array_keys($array,$frut));
}
unset($frut);

// обычная функция сортировки от большего к меньшему
function my_sort($a,$b){
    return ($b<=>$a);
}
// сортируем по значению
uasort($new_array, 'my_sort');

// выводим
foreach ($new_array as $frut=>$count){
    print "$frut - $count<br>";
}