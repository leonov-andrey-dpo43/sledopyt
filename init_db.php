<?php
require_once 'connect.php';

$table_name = 'posts_publications'; 

$result = mysqli_query($connect, "SHOW TABLES LIKE '$table_name'");

if (mysqli_num_rows($result) == 0) {
    $create_table_sql = "
        CREATE TABLE $table_name (
            id_post BIGINT AUTO_INCREMENT PRIMARY KEY,
            id_struct VARCHAR(15) NULL,
            record_date INT NULL,
            post_date TINYTEXT NULL,
            post_head VARCHAR(350) NULL,
            post_lead TEXT NULL,
            post_body TEXT NULL,
            post_link VARCHAR(255) NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ";
    
    if (!mysqli_query($connect, $create_table_sql)) {
        die("Ошибка создания таблицы: " . mysqli_error($connect));
    } 
}

?>