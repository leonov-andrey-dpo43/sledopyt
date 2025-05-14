<?php

require __DIR__ . '/vendor/autoload.php';
require_once 'connect.php';
require_once 'init_db.php';
$flag = 0;
$url = 'https://54.xn--b1aew.xn--p1ai/news';
$short_url = 'https://54.xn--b1aew.xn--p1ai';
$client = new \GuzzleHttp\Client([
    'headers' => [
        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36'
    ]
]);
$resp = $client->request('GET', $url);
$html = $resp->getBody()->getContents();

$document = new \DiDom\Document();
$document->loadHtml($html);

$post_list = $document->find('.sl-item');
$count = count($post_list);
for ($i = $count - 1; $i >= 0; $i--) {
    $id_struct = "mvd_054";
    $record_date = time();
    $post_date = trim($post_list[$i]->find('.sl-item-date')[0]->text());
    $post_head = trim($post_list[$i]->find('.sl-item-title')[0]->text());
    $post_lead = trim($post_list[$i]->find('.sl-item-text')[0]->text());
    $post_link = $short_url . trim($post_list[$i]->find('.sl-item-title a')[0]->attr('href'));
    $post_body = null;

    $get_chek_record = "(SELECT * FROM posts_publications WHERE post_link = '$post_link')";
    $chek_record = mysqli_query($connect, $get_chek_record);
    $rec_count = mysqli_num_rows($chek_record);

    if ($rec_count == 0) {

        $get_post = $client->request('GET', $post_link);
        $get_text_post = $get_post->getBody()->getContents();

        $text_post = new \DiDom\Document();
        $text_post->loadHtml($get_text_post);
        $get_text = $text_post->find('.ln-content-holder .article p');
        $count = count($get_text);

        for ($k = 0; $k < $count; $k++) {
            $post_body = $post_body . $get_text[$k]->text();
        }

        $insert_sql = "INSERT INTO posts_publications (id_struct, record_date , post_date, post_head , post_lead , post_body , post_link) 
        VALUES('$id_struct', '$record_date', '$post_date', '$post_head' , '$post_lead' , '$post_body' , '$post_link')";

        mysqli_query($connect, $insert_sql);
        $flag = 1;
        //echo "Запись произведена<br>";
    } else {
        //echo "Запись существует<br>";
        continue;
    }
}
if ($flag == 1) {
    echo ("Добавлены новые записи");
} else {
    echo ("Новых записей нет");
}
//echo date('d.m.Y H:i:s', time());
?>