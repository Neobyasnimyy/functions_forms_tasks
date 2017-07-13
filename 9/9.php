<?php

// Написать функцию, которая переворачивает строку. Было "abcde", должна выдать "edcba".
// Ввод текста реализовать с помощью формы.
include '9.html';
$string = $_GET['string'];

// лучший вариант
//echo strrev($string);

function myStrrev(string $str): string {
    $result='';
    for ($i=mb_strlen($str)-1;$i>=0;$i--){
        $result.=mb_substr($str, $i, 1, 'UTF-8');
    }
    return $result;
};
?>
<p>Результат: <?php echo myStrrev($string)?></p>
