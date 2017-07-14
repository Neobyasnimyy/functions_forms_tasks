<?php

@mkdir("gallery", 0777);// создаем новую директорию
$uploadDir = './gallery/'; // путь к нашей новой директории
if (!empty($_POST)===true) {

    $arr = explode(".", $_FILES['image']['name']);
    $format = ["jpg","png","bmp","gif","jpeg"];

    if(in_array($arr[count($arr)-1], $format)) {// проверяем формат файлов, соответствует нашему списку
        $uploadFile = $uploadDir . basename($_FILES['image']['name']);// создаем путь к новому файлу
        // картинка сохранена во временной директории, необходима ее скопировать
        if (copy($_FILES['image']['tmp_name'], $uploadFile)){
            $message = "<h3>Файл загружен</h3>";
        }
    }
    else
        $message= "<h3>Не правильный формат</h3>";
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
        img{
            max-height: 200px;
            max-width: 200px;
        }
    </style>
</head>
<body>
<br>
<?php if (!empty($message)){
    print "<p>$message</p>";
}
?>
<br>
    <form action="6.php" method="POST" enctype="multipart/form-data">
        <h3>Добавить картинку</h3>
        <br>
        <p><input type="file" name="image" accept="image/*"></p>
        <p><input type="submit" value="Загрузить" name="submit"></p>
    </form>
    <!--проверяем если есть наша функция то получаем массив элементов в нем-->
    <?php if((is_dir($uploadDir)) and ($arr =scandir($uploadDir))): ?>
        <table>
            <tr>
            <?php foreach($arr as $item): ?>
                    <td>
                        <?php if (!is_dir($uploadDir.$item)){
                            if (exif_imagetype($uploadDir.$item)!=false){
                                echo '<img src="'.$uploadDir.$item.'" >';
                            }
                        }
                        ?>
                    </td>
            <?php endforeach ?>
            </tr>
        </table>
    <?php endif ?>
</body>
</html>
