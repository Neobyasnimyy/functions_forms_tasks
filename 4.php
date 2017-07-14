<?php

// Написать функцию, которая выводит список файлов в заданной директории.
// Директория задается как параметр функции.


// pathName путь к директории, относительно данного файла, выводит все что есть в директории
function myFun($pathName):array {
    return scandir($pathName,SCANDIR_SORT_NONE);
}

echo "<pre><h4>Первая функция</h4>";
print_r(myFun("/"));
foreach (myFun("/") as $item){
    echo $item."<br>";
}
echo "<hr><h4>Вторая функция</h4> <br>";


// данная функция выводит только файлы в заданной директории
function myFun2(string $dirName){
    $rezult = [];
    if (is_dir($dirName)){
        if ($handle = @opendir($dirName)) { // открываем каталог для чтения
            while (false !== ($entry = readdir($handle))) {
                if (is_file($entry)){
                    $rezult[]= $entry;
                }
            }
            closedir($handle); // закрываем каталог
            if (empty($rezult)){
                $rezult="В заданной директории отсутствуют файлы";
            }
        }else
            $rezult[]="Не удалось открыть каталог";
    }else
        $rezult[]= "Не существует ['$dirName'] директории!!!";
    return $rezult;
}

print_r(myFun2("."));

echo "</pre>";