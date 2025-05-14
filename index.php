<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Следопыт - ГУ МВД России по Новосибирской области</title>
    <link rel="stylesheet" href="./styles/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="nav_bar">
        <a href="#" class="bar_active_link">
            <div class="active_bar_item left_bar_item bar_text">
                МВД
            </div>
        </a>
        <a href="#" class="bar_no_active_link">
            <div class="no_active_bar_item bar_text">
                Следственный<br>комитет
            </div>
        </a>
        <a href="#" class="bar_no_active_link">
            <div class="no_active_bar_item bar_text">
                Прокуратура
            </div>
        </a>
        <a href="#" class="bar_no_active_link">
            <div class="no_active_bar_item right_bar_item bar_text">
                Органы<br>власти
            </div>
        </a>
    </div>
    <div class="bar_cutter"></div>
    <div class="check_btn_cont"><button onclick="checkNews()" id="check_btn">Обновить новости</button></div>
    <?php
    require_once 'connect.php';
    require_once 'init_db.php';    
    $sort_1 = "SELECT * FROM posts_publications WHERE id_struct LIKE 'mvd%' ORDER BY id_post DESC";
    $posts = mysqli_query($connect, $sort_1);
    $posts = mysqli_fetch_all($posts);
    foreach ($posts as $post) {
        $post_key = $post[1];

        date_default_timezone_set('Asia/Novosibirsk');
        $date_time = $post[2];
        $months = [
            1 => 'января',
            2 => 'февраля',
            3 => 'марта',
            4 => 'апреля',
            5 => 'мая',
            6 => 'июня',
            7 => 'июля',
            8 => 'августа',
            9 => 'сентября',
            10 => 'октября',
            11 => 'ноября',
            12 => 'декабря'
        ];
        $monthNumber = (int) date('m', $date_time); 
        $monthName = $months[$monthNumber]; 
        $formattedDate = date('d', $date_time) . ' ' . $monthName . ' ' . date('H:i', $date_time);
        $date_time = $formattedDate;
        ?>

        <div class="post_item" id="app">
            <?= '<div class="mvd">ГУ МВД России по Новосибирской области</div>' ?>
            <div class="post_title">
                <?= '<a target="_blank" href="' . $post[7] . '" class="link_title">' ?>     <?= $post[4] ?></a>
            </div>
            <div class="post_lead">
                <?= $post[5] ?>
            </div>
            <div class="post_footer">
                <div class="post_time">
                    <?= $date_time ?>
                </div>
            </div>
        </div>
        </div>
        <?php
    }
    ?>
    <script>
        function checkNews() {
            
            fetch('mvd_parser.php') // Отправляем запрос на PHP-скрипт
                .then(response => response.text())
                .then(data => {
                    if (data == "Новых записей нет"){
                        alert('Новых записей нет');
                    }else {
                        location.reload();
                        alert('Новости обновлены');
                    }
                })
                .catch(error => {
                    console.error('Ошибка:', error);
                    alert('Произошла ошибка при обновлении БД');
                });
        }
    </script>
</body>

</html>