<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    review_arthur
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

$params = array(
    'posts_per_page' => -1, // все посты
    'post_type'	=> 'reviews' //тип записи
);
$q = new WP_Query( $params );
if( $q->have_posts() ) : // если посты по заданным параметрам найдены
    while( $q->have_posts() ) : $q->the_post();
        wp_delete_post( $q->post->ID, true ); // второй параметр функции true означает, что пост будут удаляться, минуя корзину
    endwhile;
endif;
wp_reset_postdata();
