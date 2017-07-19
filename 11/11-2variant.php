<?php
// Второй Вариант
// Подскажите как находить любые имена и записывать с заглавной буквы?
echo $string ='а васька слушает да ест. а воз и ныне там. а вы друзья как ни садитесь, все в музыканты не годитесь. а король-то — голый. а ларчик просто открывался.а там хоть трава не расти.';
// Разделяем строку при нахождении точки с пробелом
echo "<br>";
$array = mb_split("\.\s", $string);

foreach ($array as &$item){
    // Берем первую букву, она находиьтся в первых двух байтах и поднимаем в верхний регистр
    $up = mb_strtoupper($item[0].$item[1]);
    // производим замену первой буквы на нее же, но в верхнем регистре
    $item= substr_replace($item,$up,0,2);
}
// преобразуем массив в строку с разделителем точка и пробел
echo $string=implode(". ", $array)."<br>";



function my_upper($str)
{
    $items = [];
/*    $clauses = explode('. ', $str); // расфасовываем каждое предложение в отдельный элемент массива $clauses*/
    $clauses = mb_split("\.(\s)?", $str);
    rtrim(end($clauses), '.'); // убираем точку у последнео предложения
    foreach ($clauses as $clause) {
        $items[] = mb_strtoupper(mb_substr($clause, 0, 1)) . mb_substr($clause, 1); // Первй символ в верхний регистр, остальные просто конкатенируются с ним
    }
    $text = implode('. ', $items);
    echo $text;
}

/* использование в коде*/
/*$proverb = "а воз и ныне там.а Васька слушает да ест. а вы, друзья, как ни садитесь, всё в музыканты не годитесь. а король-то — голый. а ларчик просто открывался.а там хоть трава не расти.";*/

my_upper($string);