<?php

// Написать функцию, которая выводит список файлов в заданной директории.
// Директория задается как параметр функции.


function myFun($dirName):array {
    return scandir($dirName,SCANDIR_SORT_NONE);
}

echo "<pre>";
print_r(myFun("/"));
foreach (myFun("/") as $item){
    echo $item."<br>";
}
echo "</pre>";