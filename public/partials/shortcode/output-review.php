<?php
add_shortcode( 'callbackShortcodeOutputReview', 'shortcodeOutputReview' );
function shortcodeOutputReview() {
    ob_start();
    ?>
    <?php
    $mypost_Query = new WP_Query( array(
        'post_type'      => 'reviews', # тип записи
        'post_status'    => 'publish', # статус записи
        'posts_per_page' => -1,        # количество (-1 - все)
    ) );

    if ( $mypost_Query->have_posts() ) {?>
        <div class="review review_by_arthur">
            <h2>Rewiew</h2>
            <?php while ( $mypost_Query->have_posts() ) { $mypost_Query->the_post(); ?>

                <div class="review-item">
                    <div class="review-item__name"><?php the_title(); ?></div>
                    <time class="review-item__date"><?php the_time('j F Y'); ?></time>
                    <div class="rating">
                        <?php for ($r = 1; $r <= 5; $r++) { ?>
                            <?php if ((get_post_meta( get_the_ID(), 'rating_key', true)) < $r) { ?>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <path style="fill:#DADADA" d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z"/>
                                </svg>
                            <?php } else { ?>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <path style="fill:#ffc107" d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z"/>
                                </svg>
                            <?php } ?>
                        <?php } ?>
                    </div>
                    <div class="review-item__text"><?php the_content(); ?></div>
                </div>

            <?php } wp_reset_postdata(); // "сброс" ?>
        </div>
    <?php } //else { echo '<p>Извините, пока нет отзывов...</p>'; }
    ?>
    <?php
    $output = ob_get_contents();
    ob_end_clean();

    return $output;
    ?>
<?php } ?>
