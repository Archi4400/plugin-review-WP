<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    review_arthur
 * @subpackage review_arthur/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    review_arthur
 * @subpackage review_arthur/admin
 * @author     Your Name <email@example.com>
 */
class review_arthur_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $review_arthur    The ID of this plugin.
	 */
	private $review_arthur;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $review_arthur       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $review_arthur, $version ) {

		$this->review_arthur = $review_arthur;
		$this->version = $version;
        $this->my_plugin_options = get_option($this->review_arthur);

	}


	public function enqueue_styles() {
//стили
		wp_enqueue_style( $this->review_arthur, plugin_dir_url( __FILE__ ) . 'css/review-arthur-admin.min.css', array(), $this->version, 'all' );

	}

//скрипт
	public function enqueue_scripts() {

		wp_enqueue_script( $this->review_arthur, plugin_dir_url( __FILE__ ) . 'js/review-arthur-admin.js', array( 'jquery' ), $this->version, false );

	}

	//==================
    /**
     * Register the administration menu for this plugin into the WordPress Dashboard menu.
     */

    public function add_plugin_admin_menu() {

        /*
         * Add a settings page for this plugin to the Settings menu.
        */
        add_options_page( 'Review by Arthur and Base Options Functions Setup', 'Review by Arthur', 'manage_options', $this->review_arthur, array($this, 'display_plugin_setup_page')
        );
    }

    /**
     * Add settings action link to the plugins page.
     */

    public function add_action_links( $links ) {

        $settings_link = array(
            '<a href="' . admin_url( 'options-general.php?page=' . $this->review_arthur ) . '">' . __('Settings', $this->review_arthur) . '</a>',
        );
        return array_merge(  $settings_link, $links );

    }

    /**
     * Render the settings page for this plugin.
     */

    public function display_plugin_setup_page() {

        include_once( 'partials/review-arthur-admin-display.php' );

    }


    //валидация страницы настроек
    /**
     * Validate options
     */
    public function validate($input) {
        $valid = array();
        $valid['btn_color'] = (isset($input['btn_color']) && !empty($input['btn_color'])) ? $input['btn_color'] : '';
        $valid['btn_color_text'] = (isset($input['btn_color_text']) && !empty($input['btn_color_text'])) ? $input['btn_color_text'] : '';
        $valid['title_form'] = (isset($input['title_form']) && !empty($input['title_form'])) ? $input['title_form'] : '';
        $valid['success_text'] = (isset($input['success_text']) && !empty($input['success_text'])) ? $input['success_text'] : '';
        $valid['disable_submit'] = (isset($input['disable_submit']) && !empty($input['disable_submit'])) ? $input['disable_submit'] : '';
        return $valid;
    }

    /**
     * Update all options
     */
    public function options_update() {
        register_setting($this->review_arthur, $this->review_arthur, array($this, 'validate'));
    }

}

//=====кастоиный тип записи Review

// ==== shortcode
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/shortcode/form.php';
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/shortcode/output-review.php';



//Условие на проверку , если в админке выключили получение отзывовов!
$reviewPluginOptions = get_option('review-arthur');
if ( !$reviewPluginOptions['disable_submit'] ){
    /**
     * Новый тип записи - «Отзывы»
     **/
    add_action( 'init', 'register_post_type_reviews' );
    function register_post_type_reviews(){
        register_post_type('reviews', array(
            'label'  => null,
            'labels' => [
                'name'               => 'Reviews',
                'singular_name'      => 'Review',
                'add_new'            => 'Add review',
                'add_new_item'       => 'Adding a review',
                'edit_item'          => 'Editing a review',
                'new_item'           => 'New review',
                'view_item'          => 'View Review',
                'search_items'       => 'Search reviews',
                'not_found'          => 'Not found',
                'not_found_in_trash' => 'Not found in the basket',
                'menu_name'          => 'Reviews',
            ],
            'description'            => 'Reviews',
            'exclude_from_search'    => false,
            'public'                 => true,
            'capability_type'        => 'page',
            'hierarchical'           => false,
            'show_in_menu'           => null,
            'show_in_rest'           => null,
            'rest_base'              => null,
            'menu_position'          => null,
            'menu_icon'              => 'dashicons-format-status',
            'supports'               => [
                'title',
                'editor',
                //'excerpt',
                // 'trackbacks',
                'custom-fields',
                // 'comments',
                // 'revisions',
                // 'thumbnail',
                // 'author',
                // 'page-attributes',
            ],
            'has_archive'         => false,
            'rewrite'             => true,
            'query_var'           => true,
        ) );
    }

    /**
     * Уведомления о новых неопубликованных отзывах
     **/
    add_action( 'admin_menu', 'add_user_menu_bubble' );
    function add_user_menu_bubble() {
        global $menu;

        $count = wp_count_posts('reviews')->pending; # на утверждении
        if ($count) {
            foreach ($menu as $key => $value) {
                if ( $menu[$key][2] == 'edit.php?post_type=reviews' ) {
                    $menu[$key][0] .= '<span class="awaiting-mod"><span class="pending-count">'.$count.'</span></span>';
                    break;
                }
            }
        }
    }

## метабокс поля для рейтинга
    add_action('add_meta_boxes', 'review_arthur_add_custom_box');
    function review_arthur_add_custom_box(){
        $screens = array( 'reviews');
        add_meta_box( 'review_arthur_sectionid', 'Rating', 'review_arthur_meta_box_callback', $screens );
    }

// HTML код блока
    function review_arthur_meta_box_callback( $post, $meta ){
        $screens = $meta['args'];

        // Используем nonce для верификации
        wp_nonce_field( plugin_basename(__FILE__), 'review_arthur_noncename' );

        // значение поля
        $value = get_post_meta( $post->ID, 'rating_key', 1 );

        // Поля формы для введения данных
        echo '<label for="review_arthur_new_field">' . __("Rating star", 'review_arthur_textdomain' ) . '</label> ';
        echo '<input type="text" id="review_arthur_new_field" name="review_arthur_new_field" value="'. $value .'" size="2" />';
    }

## Сохраняем данные, когда пост сохраняется
    add_action( 'save_post', 'review_arthur_save_postdata' );
    function review_arthur_save_postdata( $post_id ) {
        // Убедимся что поле установлено.
        if ( ! isset( $_POST['review_arthur_new_field'] ) )
            return;

        // проверяем nonce нашей страницы, потому что save_post может быть вызван с другого места.
        if ( ! wp_verify_nonce( $_POST['review_arthur_noncename'], plugin_basename(__FILE__) ) )
            return;

        // если это автосохранение ничего не делаем
        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
            return;

        // проверяем права юзера
        if( ! current_user_can( 'edit_post', $post_id ) )
            return;

        // Все ОК. Теперь, нужно найти и сохранить данные
        // Очищаем значение поля input.
        $my_data = sanitize_text_field( $_POST['review_arthur_new_field'] );

        // Обновляем данные в базе данных.
        update_post_meta( $post_id, 'rating_key', $my_data );
    }
}




