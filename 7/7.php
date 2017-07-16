<?php

$message = [];
$comments = [];
$file = "comment.txt";
if (!empty($_POST)===true) {

    $name = strip_tags($_POST['name']);
    $comment = mb_convert_encoding(strip_tags($_POST['comment']),'UTF-8');
    $text = $name."->".$comment;
    if (empty($name)===true||empty($comment)===true){
        $message[]= "Каждое поле должно быть заполненно";
    }else{
        if (preg_match('/[^(\w) | (\x7F-\xFF) | (\s)]/',$name)){
            $message[]="Имя может содержать только буквенные символы, знаки подчеркивания и пробелы.";
        }

        if (empty($message)===true){
            // записываем коммент
            if (($handle = @fopen($file, 'a')) && (fwrite($handle, $text.PHP_EOL))) {

                $message[]= "Спасибо за комментарий";
                fclose($handle);
            }else{
                $message[]= "Ошибка записи";
            }
        }
    }
}

    if (file_exists($file)){
        if ($handle = @fopen($file, "r")){
            while (($buffer = fgets($handle)) !== false) {
                $comments[]=$buffer;
            }
            fclose($handle);
        }else{
            $message[]= "Ошибка чтения файла с коментариями. Обратитесь к администратору.";
        }
    }else{
        $message[]= "У вас есть возможность сделать первый комментарий.";
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Comments</title>

    <!-- 1. Подключаем скомпилированный и минимизированный файл CSS Bootstrap 3 -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- 2. Подключаем библиотеку jQuery, необходимую для работы скриптов Bootstrap 3 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- 3. Подключаем скомпилированный и минимизированный файл JavaScript платформы Bootstrap 3 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>

    <style>
        body{
            background-color: whitesmoke;
        }
        .container{
            margin-top: 40px;
        }
        .form-group  textarea{
            resize: vertical;
            /*padding: 5px;*/
        }
        #getcomment{
            padding-right: 15px;
        }
        .title{
            background-color: rgba(255, 253, 195, 0.98);
        }
        .row-comment{
            margin-top: 10px;
        }
        .display-block{
            display: block;
        }
        form{
            display: none;
        }
    </style>
</head>
<body>

<div class="container">

    <?php if (file_exists($file)):?>
    <div class="row">
        <div class="col-md-1 col-md-offset-4 col-xs-2 col-xs-offset-2 col title">
            <h4>Имя</h4>
        </div>
        <div class="col-md-4 col-xs-6 col title">
            <h4>Комментарий</h4>
        </div>
    </div>
    <?php endif; ?>

    <?php if (!empty($comments)===true):?>
        <?php foreach ($comments as $item):
            $item= explode("->",$item)?>
            <div class="row row-comment">
                <div class="col-md-1 col-md-offset-4 col-xs-2 col-xs-offset-2 col">
                        <p><?php echo $item[0];?></p>
                </div>
                <div class="col-md-4 col-xs-6 col">
                    <p><?php echo $item[1];?></p>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>



    <div class="row ">
        <div class="col-md-5 col-md-offset-3 col-xs-8 col-xs-offset-2">
            <div class="form-group" id="addcomment">
                <div class=" text-center ">
                    <button type="submit" class="btn btn-primary">Добавить комментарий</button>
                </div>
            </div>

            <?php if (empty($message)===false):?>
                <div class="alert alert-info" role="alert">
                    <?php foreach ($message as $error):?>
                        <p><?php echo $error;?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form class="form-horizontal" action="7.php" method="POST" novalidate>

                <div class="form-group">
                    <label for="name" class="col-md-4 control-label">Ваше имя :</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="name" id="name" placeholder="Имя" >
                    </div>
                </div>
                <div class="form-group">
                    <label for="message" class="col-md-4  control-label">Комментарий :</label>
                    <div class="col-md-8">
                        <textarea rows="5" class="form-control" name="comment" id="message" placeholder="Новый коментарий...." ></textarea>
                    </div>
                </div>
                <div class="form-group" id="getcomment">
                    <div class=" text-right ">
                        <button type="submit" class="btn btn-primary">Отправить</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        // после click добавляем класс
        $('#addcomment').click(function () {
            $('form').toggleClass('display-block');
        });

    });
</script>

</body>
</html>