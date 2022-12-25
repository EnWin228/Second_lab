<?php
require ("db.php");

if (isset($_POST['liked'])) {
    $postid = $_POST['postid'];
    $result = mysqli_query($db, "SELECT * FROM posts WHERE id=$postid");
    $row = mysqli_fetch_array($result);
    $n = $row['likes'];

    mysqli_query($db, "INSERT INTO likes (userid, postid) VALUES (1, $postid)");
    mysqli_query($db, "UPDATE posts SET likes=$n+1 WHERE id=$postid");

    echo $n+1;
    exit();
}
if (isset($_POST['unliked'])) {
    $postid = $_POST['postid'];
    $result = mysqli_query($db, "SELECT * FROM posts WHERE id=$postid");
    $row = mysqli_fetch_array($result);
    $n = $row['likes'];

    mysqli_query($db, "DELETE FROM likes WHERE postid=$postid AND userid=1");
    mysqli_query($db, "UPDATE posts SET likes=$n-1 WHERE id=$postid");

    echo $n-1;
    exit();
}
if (isset($_GET['pageno'])) {
    // Если да то переменной $pageno присваиваем его
    $pageno = $_GET['pageno'];
} else { // Иначе
    // Присваиваем $pageno один
    $pageno = 1;
}

// Назначаем количество данных на одной странице
$size_page = 4;
// Вычисляем с какого объекта начать выводить
$offset = ($pageno-1) * $size_page;


$count_sql = "SELECT COUNT(*) FROM `posts`";
// Отправляем запрос для получения количества элементов
$result = mysqli_query($db, $count_sql);
// Получаем результат
$total_rows = mysqli_fetch_array($result)[0];
// Вычисляем количество страниц
$total_pages = ceil($total_rows / $size_page);
// Создаём SQL запрос для получения данных
$sql = "SELECT * FROM `posts` ORDER BY id DESC LIMIT $offset, $size_page";
// Отправляем SQL запрос
$res_data = mysqli_query($db, $sql);
// Цикл для вывода строк


// Retrieve posts from the database
$posts = mysqli_query($db, "SELECT * FROM posts ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chat</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
<div class="container">
    <h1> Анонимный чат </h1>

    <form class = "posting" action="add.php" method="post" enctype="multipart/form-data">
        <input required class="form-control" type="text" name="list" id ="list" placeholder="Введите текст поста...">
        <input required class="btn btn-dark" type="file" name="file" id="file" accept="image/jpeg">
<!--  <label class="custom-file-label" for="file">Выберите файл</label>-->
        <button class="btn btn-dark" type="submit" name="send"> Добавить </button>
    </form>
</div>

<!-- display posts gotten from the database  -->
<?php while ($row = mysqli_fetch_array($res_data)) { ?>
<?php echo '<ul>';?>
    <div class="post">
        <button class="btn-outline-dark" type="submit" id="del" data-id="<?php echo $row['id']; ?>"> Удалить </button>
        <div class="content_block hide" >
        <?php echo $row['text']; ?>
        </div>
        <a class="content_toggle" href="#">Подробнее</a>
        <img src="<?php echo $row['image']?>">
        <p><?php echo $row['dtime'];?></p>
        <div>
            <?php
            
            $results = mysqli_query($db, "SELECT * FROM likes WHERE userid=1 AND postid=".$row['id']."");

            if (mysqli_num_rows($results) == 1 ): ?>
                
                <span class="unlike fa fa-thumbs-up" data-id="<?php echo $row['id']; ?>"></span>
                <span class="like hide fa fa-thumbs-o-up" data-id="<?php echo $row['id']; ?>"></span>
            <?php else: ?>
               
                <span class="like fa fa-thumbs-o-up" data-id="<?php echo $row['id']; ?>"></span>
                <span class="unlike hide fa fa-thumbs-up" data-id="<?php echo $row['id']; ?>"></span>
            <?php endif ?>

            <span class="likes_count"><?php echo $row['likes']; ?> likes</span>
        </div>
    </div>
    <?php echo '</ul>';?>
<?php } ?>
<div>
<ul class="pagination">
    <li class="page-item"><a class = "page-link" href="?pageno=1">First</a></li>
    <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
        <a class = "page-link" href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Prev</a>
    </li>
    <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
        <a class = "page-link" href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Next</a>
    </li>
    <li class="page-item"><a class = "page-link" href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
</ul>
</div>
<!-- Add Jquery to page -->
<script src="node_modules/jquery/dist/jquery.js"></script>
<script>
    $(document).ready(function(){
        // when the user clicks on like
        $('.like').on('click', function(){
            var postid = $(this).data('id');
            $post = $(this);

            $.ajax({
                url: 'index.php',
                type: 'post',
                data: {
                    'liked': 1,
                    'postid': postid
                },
                success: function(response){
                    $post.parent().find('span.likes_count').text(response + " likes");
                    $post.addClass('hide');
                    $post.siblings().removeClass('hide');
                }
            });
        });

        // when the user clicks on unlike
        $('.unlike').on('click', function(){
            var postid = $(this).data('id');
            $post = $(this);

            $.ajax({
                url: 'index.php',
                type: 'post',
                data: {
                    'unliked': 1,
                    'postid': postid
                },
                success: function(response){
                    $post.parent().find('span.likes_count').text(response + " likes");
                    $post.addClass('hide');
                    $post.siblings().removeClass('hide');
                }
            });
        });
    });


    $(document).ready(function() {
        $(".btn-outline-dark").click(function(){
            var id = $(this).data('id');// При нажатии на кнопку
            $.ajax({ // Аякс
                type: "POST", // Тип отправки "POST"
                url: "./delete.php", // Куда отправляем(в какой файл)
                data: {"id": id}, // Что передаем и под каким значением
                cache: false, // Убираем кеширование
                success: function(response){
                    window.location.href='index.php';
                }
            });
        });
    });
</script>
</body>
</html>
