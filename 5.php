<?php

// Написать функцию, которая выводит список файлов в заданной директории, которые содержат искомое слово.
// Директория и искомое слово задаются как параметры функции.

// функция ищет названия файлов содержащие искомое слово
function myFun1(string $dirName,string $sourceName){
    if (is_dir($dirName)){
        if ($handle = @opendir($dirName)) { // открываем каталог для чтения

         while (false !== ($entry = readdir($handle))) {
             if (preg_match("*$sourceName*",$entry)!==0){
                 echo "$entry\n<br>";
             }
         }
         closedir($handle); // закрываем каталог
        }
    }else
        echo "Не существует ['$dirName'] директории!!!";
}

myFun1('.','php');



// функция ищет искомое слово в файлах в заданнной директории, но плохо работает с кириллицей в некоторых форматов файлов
function myFun2(string $pathName,string $sourceName){
    if (is_dir($pathName)) {
        $arrFiles = scandir($pathName);
        $rezult = '';
        foreach ($arrFiles as $file) {
            if ((is_file($pathName."/".$file)) && ($file != '.') && ($file != '..')) {
                $str = file_get_contents($pathName."/".$file);
                $pos = strpos($str, $sourceName);

                if ($pos !== false) {
                    $rezult.=$file."\n\r<br>";
                }
            }
        }
        $rezult=(!empty($rezult))?$rezult:"Искомый файл не найден";
        echo $rezult;
    }else
        echo "Не существует ['$pathName'] директории!!!";
}

myFun2('.','директории');