<?php

// Написать форму комментариев, за основу взять форму обратной связи при отпрвке почты.
// Только вместо почтовой отравки, обеспечить сохранение сообщений в файл.
// Разобраться с извлечением комментариев из файла. Блок записи написать с учетом исключительной блокировки на время записи.


$message = [];
$comments = [];
$file = "comments.txt";

if (!empty($_POST) === true) {

    $name = strip_tags($_POST['name']);
    $email = strip_tags($_POST['email']);
    $comment = mb_convert_encoding(strip_tags($_POST['comment']), 'UTF-8');
    $text = [];

    if (empty($name) === true || empty($comment) === true || empty($email) === true) {
        $message[] = "Каждое поле должно быть заполненно";
    } else {
        if (preg_match('/[^(\w) | (\x7F-\xFF) | (\s)]/', $name)) {
            $message[] = "Имя может содержать только буквенные символы, знаки подчеркивания и пробелы.";
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message[] = "Введите дейстительный email.";
        }

        if (empty($message) === true) {
            // записываем коммент

            if ($handle = @fopen($file, 'a')) {
                $text['name'] = $name;
                $text['comment'] = $comment;
                $text['email'] = $comment;
                $text['data'] = date('j-m-Y g:i');
                fwrite($handle, serialize($text) . PHP_EOL);
                flock($handle, LOCK_EX);//Блокировка файла,на запись другими процессами
                $message[] = "Спасибо за комментарий";
                flock($handle, LOCK_UN);//СНЯТИЕ БЛОКИРОВКИ
                fclose($handle);
                header('Location: test.php'); // редирект, обнуляет пост запрос
            } else {
                $message[] = "Ошибка записи";
            }
        }
    }
}

if (file_exists($file)) {
    if ($handle = @fopen($file, "r")) {
        while (($buffer = fgets($handle)) !== false) {
            $comments[] = $buffer;
        }
        fclose($handle);
    } else {
        $message[] = "Ошибка чтения файла с коментариями. Обратитесь к администратору.";
    }
} else {
    $message[] = "У вас есть возможность сделать первый комментарий.";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Comments</title>

    <!-- Latest compiled and minified CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <script
        src="https://code.jquery.com/jquery-3.2.1.min.js"
        integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
        crossorigin="anonymous"></script>
    <style>
        body {
            background-color: whitesmoke;
        }

        .container {
            margin-top: 40px;
        }

        .form-group textarea {
            resize: vertical;
            /*padding: 5px;*/
        }

        #getcomment {
            padding-right: 15px;
        }

        .title {
            background-color: rgba(255, 253, 195, 0.98);
        }

        .row-comment {
            margin-top: 10px;
        }

        .display-block {
            display: block;
        }

        form {
            display: none;
        }
    </style>
</head>
<body>

<div class="container">

    <?php if (file_exists($file)): ?>
        <div class="row">
            <div class="col-md-2 col-md-offset-2 col-xs-3 col title">
                <h4>Имя</h4>
            </div>
            <div class="col-md-4 col-xs-6 col title">
                <h4>Комментарий</h4>
            </div>
            <div class="col-md-2 col-xs-3 col title">
                <h4>Обратный адресс</h4>
            </div>
        </div>
    <?php endif; ?>

    <?php if (!empty($comments) === true): ?>
        <?php foreach ($comments as $item):
            $item = unserialize($item); ?>
            <div class="row row-comment">
                <div class="col-md-2 col-md-offset-2 col-xs-3  col">
                    <p><?php echo $item["name"]; ?></p>
                    <p><?php echo $item["data"]; ?></p>
                </div>
                <div class="col-md-4 col-xs-6 col">
                    <p><?php echo $item["comment"]; ?></p>
                </div>
                <div class="col-md-2 col-xs-3 col">
                    <p><?php echo $item["email"]; ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>


    <div class="row ">
        <div class="col-md-5 col-md-offset-3 col-xs-8 col-xs-offset-2">
            <?php if (empty($message) === false): ?>
                <div class="alert alert-info" role="alert">
                    <?php foreach ($message as $error): ?>
                        <p><?php echo $error; ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="form-group" id="addcomment">
                <div class=" text-center ">
                    <button type="submit" class="btn btn-primary">Добавить комментарий</button>
                </div>
            </div>


            <form class="form-horizontal" action="test.php" method="POST" novalidate>

                <div class="form-group">
                    <label for="name" class="col-md-4 control-label">Ваше имя :</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="name" id="name"
                               placeholder="Имя" <?php if (isset($_POST['name'])) echo 'value="', $_POST['name'], '"'; ?>>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-md-4 control-label">Ваша почта :</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="email" id="email"
                               placeholder="andrey@gmail.com" <?php if (isset($_POST['email'])) echo 'value="', $_POST['email'], '"'; ?>>
                    </div>
                </div>
                <div class="form-group">
                    <label for="message" class="col-md-4  control-label">Комментарий :</label>
                    <div class="col-md-8">
                        <textarea rows="5" class="form-control" name="comment" id="message"
                                  placeholder="Новый коментарий...."><?php if (isset($_POST['comment'])) echo $_POST['comment']; ?></textarea>
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
    $(document).ready(function () {
        // после click добавляем класс
        $('#addcomment').click(function () {
            $('form').toggleClass('display-block');
        });

    });
</script>

</body>
</html>