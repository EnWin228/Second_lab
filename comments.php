<?php include("db.php"); // Подключаемся к БД

    if( $_POST['author'] != ''&&  $_POST['message'] != ''){ // Если поля не пустые
        $post_id = $_POST['postid1'];
        $author = $_POST['author'];
        $author = addslashes($author);
        $author = htmlspecialchars($author);
        $author = stripslashes($author);
        // Обрабатываем данные

        $message = $_POST['message'];
        $message = addslashes($message);
        $message = htmlspecialchars($message);
        $message = stripslashes($message);
        // Обрабатываем данные

        $result = $db->query("INSERT INTO `comments` (`author`,`post_id`, `text`) VALUES ('$author','$post_id', '$message')"); // Передаем в БД значения
        if($result){
            echo 0; //Ваше сообшение успешно отправлено
        }else{
            echo 1; //Сообщение не отправлено. Ошибка базы данных
        }
    }else{
        echo 2; //Нельзя отправлять пустые сообщения
    }


// Если отключен JavaScript


