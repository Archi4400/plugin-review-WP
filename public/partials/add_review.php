<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Подключаем необходимые файлы
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');
require_once(ABSPATH . 'wp-admin/includes/image.php');
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/media.php');

// Получение отправленных данных
$user_name    = trim($_POST['name']);
$user_message = trim($_POST['message']);
$user_rating  = trim($_POST['rating']);
// $review_type = trim($_POST['review_type']); # можно передать термин таксономии

$post_data = array(
    'post_author'   => 1,
    'post_status'   => 'pending',               # статус - «На утверждении»
    'post_type'     => 'reviews',               # тип записи - «Отзывы»
    'post_title'    => $user_name, # заголовок отзыва
    'post_content'  => $user_message,           # текст отзыва
    'post_excerpt'  => $user_rating,           # рейтинг
    // 'tax_input' => ['{Название таксономии}' => array($review_type)],
);

// Вставляем запись в базу данных
$post_id = wp_insert_post( $post_data );

// Добавляем остальные поля
//update_field( 'rejting', $user_rating, $post_id ); # рейтинг ACF
update_post_meta( $post_id, 'rating_key', $user_rating );

// Необходимо для записи таксономии «tax_input»
// wp_set_object_terms( $post_id, $review_type, '{Название таксономии}' );
