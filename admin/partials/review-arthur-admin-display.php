<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    review_arthur
 * @subpackage review_arthur/admin/partials
 */
?>
<h1 class="title">Plugin seting</h1>
<p class="notice notice-info inline"><br>Place use shortcode <b>[callbackShortcodeForm]</b> in your templates to show the review form<br><br>
Place use shortcode <b>[callbackShortcodeOutputReview]</b> in your templates to show reviews<br><br></p>

<form method="post" name="my_options" action="options.php">

    <?php

    // Загрузить все значения элементов формы
    $options = get_option($this->review_arthur);

    // текущие состояние опций
    $btn_color = $options['btn_color'];
    $btn_color_text = $options['btn_color_text'];
    $title_form = $options['title_form'];
    $success_text = $options['success_text'];
    $disable_submit = $options ? $options['disable_submit'] : null;

    // Выводит скрытые поля формы на странице настроек
    settings_fields( $this->review_arthur );
    do_settings_sections( $this->review_arthur );

    ?>

<!--    <h2>--><?php //echo esc_html( get_admin_page_title() ); ?><!--</h2>-->

    <fieldset>
        <legend class="screen-reader-text"><span><?php _e('Color button', $this->review_arthur);?></span></legend>
        <label for="<?php echo $this->review_arthur;?>-btn_color">
            <span><?php esc_attr_e('Color button', $this->review_arthur);?></span>
        </label>
        <br>
        <input type="text"
               class="regular-text" id="<?php echo $this->review_arthur;?>-btn_color"
               name="<?php echo $this->review_arthur;?>[btn_color]"
               value="<?php if(!empty($btn_color)) esc_attr_e($btn_color, $this->review_arthur);?>"
               placeholder="<?php esc_attr_e('Color button', $this->review_arthur);?>" />
    </fieldset>
    <br>
    <fieldset>
        <legend class="screen-reader-text"><span><?php _e('Color text', $this->review_arthur);?></span></legend>
        <label for="<?php echo $this->review_arthur;?>-btn_color_text">
            <span><?php esc_attr_e('Color text', $this->review_arthur);?></span>
        </label>
        <br>
        <input type="text"
               class="regular-text" id="<?php echo $this->review_arthur;?>-btn_color_text"
               name="<?php echo $this->review_arthur;?>[btn_color_text]"
               value="<?php if(!empty($btn_color_text)) esc_attr_e($btn_color_text, $this->review_arthur);?>"
               placeholder="<?php esc_attr_e('Color text', $this->review_arthur);?>" />
    </fieldset>
    <br>
    <fieldset>
        <legend class="screen-reader-text"><span><?php _e('Title form', $this->review_arthur);?></span></legend>
        <label for="<?php echo $this->review_arthur;?>-title_form">
            <span><?php esc_attr_e('Title form', $this->review_arthur);?></span>
        </label>
        <input type="text"
               class="regular-text large-text" id="<?php echo $this->review_arthur;?>-title_form"
               name="<?php echo $this->review_arthur;?>[title_form]"
               value="<?php if(!empty($title_form)) esc_attr_e($title_form, $this->review_arthur);?>"
               placeholder="<?php esc_attr_e('Title form', $this->review_arthur);?>" />
    </fieldset>
    <br>
    <fieldset>
        <legend class="screen-reader-text"><span><?php _e('Success send text', $this->review_arthur);?></span></legend>
        <label for="<?php echo $this->review_arthur;?>-success_text">
            <span><?php esc_attr_e('Success send text', $this->review_arthur);?></span>
        </label>
        <input type="text"
               class="regular-text large-text" id="<?php echo $this->review_arthur;?>-success_text"
               name="<?php echo $this->review_arthur;?>[success_text]"
               value="<?php if(!empty($success_text)) esc_attr_e($success_text, $this->review_arthur);?>"
               placeholder="<?php esc_attr_e('Text', $this->review_arthur);?>" />
    </fieldset>
    <br>
    <fieldset>
        <legend class="screen-reader-text"><span>Don't get feedback (leave only the form)</span></legend>
        <label for="users_can_register">
            <input type="checkbox"
                   id="<?php echo $this->review_arthur;?>-disable_submit"
                   name="<?php echo $this->review_arthur;?>[disable_submit]"
                   value="1"
                   <?php checked( 1, $disable_submit ) ?> />

            <span><?php esc_attr_e( "Don't get feedback (leave only the form)", "WpAdminStyle" ); ?></span>
        </label>
    </fieldset>

    <?php submit_button(__('Save all changes', $this->review_arthur), 'primary','submit', TRUE); ?>

</form>
