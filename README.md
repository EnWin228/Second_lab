# Second_lab
# Форум
## Текст задания
Разработать и реализовать клиент-серверную информационную систему, реализующую механизм CRUD.
## Ход работы
- Спроектировать пользовательский интерфейс
- Описать пользовательские сценарии работы
- Описать API сервера и хореографию
- Описать структуру базы данных
- Описать алгоритмы
## 1. [Пользовательский интерфейс](https://www.figma.com/file/OoXszTIiusU1alGn5qWHv0/Anonymus-chat?node-id=0%3A1&t=v3PKjZ6GzR3vprmx-1)
## 2. Пользовательские сценарии работы
Пользователь попадает на главную страницу index.php. Вводит любое текстовое сообщение и нажимает кнопку отправить. В случае корректного ввода данных, его сообщение появится на общей стене в обратном хронологическом порядке. Пользователи могут ставить лайки. Есть возможность удалять записи. Для этого пользователь нажимает на кнопку УДАЛИТЬ, и соответствующая запись удаляется. Пользователь может увидеть время каждого поста и добавить к ним комментарии.
## 3. [API сервера и хореография]()
## 4. Структура базы данных
Таблица *posts*
| Название | Тип | Длина | По умолчанию | Описание |
| :------: | :------: | :------: | :------: | :------: |
| **id** | INT  |  | NO | Автоматический идентификатор поста |
| **text** | TEXT |  | NO | Текст поста |
| **dtime** | TEXT|  | NULL | Дата создания поста |
| **likes** | INT |  | 0 | Количество лайков |

Таблица *likes*
| Название | Тип | Длина | NULL | Описание |
| :------: | :------: | :------: | :------: | :------: |
| **id** | INT  |  | NO | Автоматический идентификатор лайка |
| **userid** | INT |  | NO | ID пользователя |
| **postid** | INT |  | NO | ID поста |

## 5. Алгоритмы
1. [Добавление записи](https://imgur.com/a/SH2D4QU)
2. [Удаление записи](https://imgur.com/a/w8ARjPW)
3. [Реакция](https://imgur.com/a/Kk5NxFf)
## 6. Примеры HTTP запросов/ответов
<br>GET /web/index.php HTTP/1.1
<br>Host: localhost
<br>Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9
<br>sec-ch-ua: "Not?A_Brand";v="8", "Chromium";v="108", "Google Chrome";v="108"
<br>sec-ch-ua-mobile: ?0
<br>sec-ch-ua-platform: "Windows"
<br>Upgrade-Insecure-Requests: 1
<br>User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36

<br>HTTP/1.1 200 OK
<br>Connection: Keep-Alive
<br>Content-Type: text/html; charset=UTF-8
<br>Date: Sat, 24 Dec 2022 07:13:25 GMT
<br>Keep-Alive: timeout=5, max=100
<br>Server: Apache/2.4.54 (Win64) PHP/8.1.10
<br>Transfer-Encoding: chunked
<br>X-Powered-By: PHP/8.1.10

<br>POST /web/comments.php HTTP/1.1
<br>Host: localhost
<br>Accept: */*
<br>Content-Type: application/x-www-form-urlencoded; charset=UTF-8
<br>sec-ch-ua: "Not?A_Brand";v="8", "Chromium";v="108", "Google Chrome";v="108"
<br>sec-ch-ua-mobile: ?0
<br>sec-ch-ua-platform: "Windows"
<br>User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36
<br>X-Requested-With: XMLHttpRequest

## 7. Важные части кода
1. Функция проставления лайков с помощью AJAX
```js
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
```
