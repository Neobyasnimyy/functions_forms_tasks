<?php

// Есть текстовый файл. Необходимо удалить из него все слова, длина которых превыщает N символов.
// Значение N задавать через форму. Проверить работу на кириллических строках - найти ошибку, найти решение.


if (!empty($_POST)===true) {
    $message = '';

    $name = $_POST['name'];
    $lenght = $_POST['lenght'];
    $saveName=$_POST['saveName'];
    if(!file_exists($name)) {
        $message.="Файл \"$name\" не найден";
    }elseif (preg_match('/[^(\w) | (\x7F-\xFF) | (\s)]/', $saveName)){
        $message= "Имя может содержать только буквенные символы, знаки подчеркивания и пробелы";
    }else{
        $str = file_get_contents(__DIR__.'\\'.$name);
        $array = mb_split("\s", $str);
        foreach ($array as $key => $item){
            if (mb_strlen($item)>$lenght){
                unset($array[$key]);
            }
        }
        $strNew=implode(' ', $array);
        if (file_put_contents($saveName.'.txt',$strNew)){
            $message = "Данные сохранены в ".$saveName.".txt";
        }else{
            $message = "Ошибка записи";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <style>
        body{
            text-align: center;
        }
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {-webkit-appearance: none;
            margin:0;}
    </style>
</head>
<body>
<br><br>
<form action="3.php" method="POST">
    <p>Введите название файла: </p>
    <p><input  type="text" name="name" placeholder="3.txt" required></p>
    <p>Введите длинну слов необходимых для удаления: </p>
    <p><input  type="number" name="lenght" value="1" min="1" required></p>
    <p>Введите название  файла для сохранения: </p>
    <p><input  type="text" name="saveName" placeholder="new" required></p>
    <p><input type="submit" name="submit" value="Отправить" ></p>
    <?php if (!empty($message)){
        print "<p>$message</p>";
    }
    ?>

</form>
</body>
</html>
