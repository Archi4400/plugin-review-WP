<?php
add_shortcode( 'callbackShortcodeForm', 'shortcodeForm' );
function shortcodeForm() {
    ob_start();

    $reviewPluginOptions = get_option('review-arthur');
    ?>
        <h3 style="text-align: center; margin-top: 35px;"><?php echo $reviewPluginOptions['title_form']; ?><h3/>
    <form id="add_review" class="review-arthur">
        <div class="inputs">
            <input class="review-arthur__name" type="text" name="name" placeholder="Your name" required>
            <input class="review-arthur__mail" type="email" name="mail" placeholder="E-mail" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required>
        </div>
        <textarea class="review-arthur__text" name="message" placeholder="Your message" required></textarea>
        <div class="review-arthur__bottom">
            <div class="rating__group">
                <input class="rating__star" type="radio" name="rating" value="1" aria-label="Awful">
                <input class="rating__star" type="radio" name="rating" value="2" aria-label="so-so">
                <input class="rating__star" type="radio" name="rating" value="3" aria-label="Fine">
                <input class="rating__star" type="radio" name="rating" value="4" aria-label="Okay">
                <input class="rating__star" type="radio" name="rating" value="5" aria-label="Super" checked>
            </div>
            <?php //Условие на проверку , если в админке выключили получение отзывовов!
            if ( !$reviewPluginOptions['disable_submit'] ): ?>
                <input class="btn" type="submit" value="Submit" <?php do_action( 'btn_color'); ?>>
            <?php else : ?>
                <div id="review-submit" class="btn" <?php do_action( 'btn_color'); ?>>Submit</div>
            <?php endif; ?>
        </div>
    </form>
    <div class="overlay-review"></div>
    <div class="popup-review" id="popup-review-send">
        <span class="popup-review__close"></span>
        <p class="popup-review__info"><?php echo $reviewPluginOptions['success_text']; ?></p>
    </div>
    <?php
    $output = ob_get_contents();
    ob_end_clean();

    return $output;
    ?>
<?php } ?>
