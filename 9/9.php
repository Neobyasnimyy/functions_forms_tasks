<?php

// Написать функцию, которая переворачивает строку. Было "abcde", должна выдать "edcba".
// Ввод текста реализовать с помощью формы.
include '9.html';
$string = $_GET['string'];

// лучший вариант
//echo strrev($string);

function myStrrev(string $str): string {
    $result='';
    for ($i=strlen($str)-1;$i>=0;$i--){
        $result.=$str[$i];
    }
    return $result;
};
?>
<p>Результат: <?php echo myStrrev($string)?></p>
