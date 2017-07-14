<?php

// Написать функцию, которая выводит список файлов в заданной директории.
// Директория задается как параметр функции.


// pathName путь к директории, относительно данного файла
function myFun($pathName):array {
    return scandir($pathName,SCANDIR_SORT_NONE);
}

echo "<pre>";
print_r(myFun("/"));
foreach (myFun("/") as $item){
    echo $item."<br>";
}
echo "</pre>";