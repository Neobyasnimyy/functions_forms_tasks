<?php
$form_display=true;
@mkdir("gallery", 0777);// создаем новую директорию
$uploadDir = './gallery/'; // путь к нашей новой директории
if (!empty($_POST)===true) {
    $message='';

    $arr = explode(".", $_FILES['image']['name']);
    $format = ["jpg","png","bmp","gif","jpeg"];
    $size = $_FILES['image']['size'];
    $type = $_FILES['image']['type'];
    if(in_array($arr[count($arr)-1], $format)!==true) {// проверяем формат файлов, соответствует нашему списку
        $message.= "<h4>Не правильный формат</h4><br>";
    }
    if ($size>2*1024*1024){
        $message.= "<h4>Превышен объем загружаемой картинки.</h4><br>Допустимый 2Мб.<br>";
    }
    // проверяем тип файла
    if (($type != "image/jpg") && ($type != "image/jpeg") && ($type !="image/gif")&&($type !="image/png")&&($type !="image/vnd.microsoft.icon")&&($type !="image/pjpeg")){
        $message .= "<h4>Не правильный тип файла</h4><br>";
    }
    // создаем путь к новому файлу и добавляем в новае название рандомные чила, чтобы названия файлов не повторялись
    $uploadFile = $uploadDir .date('jmYgis'). ".".$arr[1];

    // картинка сохранена во временной директории, необходима ее скопировать
    if (empty($message)===true) {
        // отправляем файл
        if (copy($_FILES['image']['tmp_name'], $uploadFile)) {
            $message .= "<h4>Файл загружен</h4><br>";
            $form_display= false;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gallery</title>
    <style>
        body{
            text-align: center;
        }
        img{
            height: 200px;
            max-width 200px;
        }
        form{
            display: <?php echo ($form_display)?"block":'none'?>;
        }
        table{
            margin: 10px auto;
        }
    </style>
</head>
<body>
<br>
<?php if (!empty($message)){
    print $message;
}
?>
<form action="6.php" method="POST" enctype="multipart/form-data" >
    <h3>Добавить картинку</h3>
    <p><input type="file" name="image" accept="image/*"></p>
    <p><input type="submit" value="Загрузить" name="submit"></p>
</form>
<!--проверяем если есть наша функция то получаем массив элементов в нем-->
<?php if((is_dir($uploadDir)) and ($arr =scandir($uploadDir))): ?>
    <table>
        <tr>
            <?php $count = 0; foreach($arr as $item){
                if (!is_dir($uploadDir.$item)){ // проверяем что файл не директория
                    if (exif_imagetype($uploadDir.$item)!=false){// проверяем что файл изображения
                        if ($count%5===0){// если больше 5 картинок в строке, то начинаеться новая строка
                            echo "</tr><tr>";
                        }
                        $url = $uploadDir.$item;
                        echo '<td><a href="'.$url.'"><img src="'.$uploadDir.$item.'" ></a></td>';
                        $count++;
                    }
                }
            }
            ?>
        </tr>
    </table>
<?php endif ?>
<script>

</script>
</body>
</html>
