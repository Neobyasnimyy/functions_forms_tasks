<!-- Коментарии у меня просто нет слов, я в шоке что php не может нормально работать с кирилицей,
    я потратил на эту задачу около 6 часов, я перелопатил интернет, перепробовал штук 30 разных функций из интернета
     и все они не работали должным образом.
    пришлите мне вариант как оно должно выглядеть -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <style>
        body{
            text-align: center;
        }
    </style>
</head>
<body>
<p>Функция каждое новое предложение начинает с большой буквы.</p>
<form action="11.php" method="GET" accept-charset="UTF-8">
    <p><textarea rows="8" cols="45" name="text" placeholder="Введите текст" ></textarea><br></p>
    <p><input type="submit" name="submit" value="Отправить" ></p>
</form>
<?php

if (isset($_GET['text'])) {

    $string = $_GET['text'];
    $array = mb_split("\.", $string);
    $new_string = '';
    foreach ($array as &$item) {
        $words = mb_split('\s', $item);
        foreach ($words as &$word) {

            if ($word!=" " and !empty($word)){
                $word=mb_convert_case($word, MB_CASE_TITLE, "UTF-8");
//                var_dump($word);
//                echo "<br>";

                break 1;
            }
        }
    $new_string.=implode(" ", $words).".";
    }
}
?>
<p>Результат: <?php echo $new_string?></p>
</body>
</html>