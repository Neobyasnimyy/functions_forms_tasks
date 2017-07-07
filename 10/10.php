<?php

// Написать функцию, которая считает количество уникальных слов в тексте.
// Слова разделяются пробелами. Текст должен вводиться с формы.

include '10.html';
$string = $_GET['string'];

function unique($str):int {
    $array=explode(' ',mb_strtolower($str));
    return count(array_unique($array));
}
?>

<p>Результат: <?php echo unique($string)?></p>
