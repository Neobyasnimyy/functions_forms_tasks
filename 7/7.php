<?php

//
$message = [];
$comments = [];
$file = "comments.txt";

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
            if ($handle = @fopen($file, 'a')) {
                fwrite($handle, $text."->".date('j-m-Y g:i').PHP_EOL);
                flock ($handle,LOCK_EX);//Блокировка файла,на запись другими процессами
                $message[]= "Спасибо за комментарий";
                flock ($handle,LOCK_UN);//СНЯТИЕ БЛОКИРОВКИ
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

    <!-- Latest compiled and minified CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <script
            src="https://code.jquery.com/jquery-3.2.1.min.js"
            integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
            crossorigin="anonymous"></script>
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
        <div class="col-md-2 col-md-offset-3 col-xs-2 col-xs-offset-2 col title">
            <h4>Имя</h4>
        </div>
        <div class="col-md-3 col-xs-6 col title">
            <h4>Комментарий</h4>
        </div>
    </div>
    <?php endif; ?>

    <?php if (!empty($comments)===true):?>
        <?php foreach ($comments as $item):
            $item= explode("->",$item)?>
            <div class="row row-comment">
                <div class="col-md-2 col-md-offset-3 col-xs-2 col-xs-offset-2 col">
                    <p><?php echo $item[0];?></p>
                    <p><?php echo $item[2];?></p>
                </div>
                <div class="col-md-3 col-xs-6 col">
                    <p><?php echo $item[1];?></p>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>



    <div class="row ">
        <div class="col-md-5 col-md-offset-3 col-xs-8 col-xs-offset-2">
            <?php if (empty($message)===false):?>
                <div class="alert alert-info" role="alert">
                    <?php foreach ($message as $error):?>
                        <p><?php echo $error;?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="form-group" id="addcomment">
                <div class=" text-center ">
                    <button type="submit" class="btn btn-primary">Добавить комментарий</button>
                </div>
            </div>

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