<?php
// Создать форму с элементом textarea. При отправке формы скрипт должен выдавать ТОП3 длинных слов в тексте.
// Реализовать с помощью функции.
include '2.html';

$textarea = $_GET['textarea'];

// возвращает массив с 10 самыми длинныит словами

function top3_lenght(string $a){
    // заменяем знаки препинания на пробел
    $a = str_replace([',','.',':',';','?','!','(',')'], " ",$a);
    // приводим все к нижнему регистру, чтобы сранение было регистронезависимым
    $a = mb_strtolower($a);
    // преобразуем все слова в массив
    $array = explode(" ", $a);
    function my_sort($a,$b){
        return (strlen($b) <=> strlen($a));
    }
    usort($array,"my_sort");
    return array_slice($array, 0, 3);
}
$top3= top3_lenght($textarea);
?>

<p>3 самых длинных слова: <?php print implode(", ", $top3) ?>.</p>
