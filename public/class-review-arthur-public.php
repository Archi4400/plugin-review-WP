<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    review_arthur
 * @subpackage review_arthur/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    review_arthur
 * @subpackage review_arthur/public
 * @author     Your Name <email@example.com>
 */
class review_arthur_Public {

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
	 * @param      string    $review_arthur       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $review_arthur, $version ) {

		$this->review_arthur = $review_arthur;
		$this->version = $version;
        $this->my_plugin_options = get_option($this->review_arthur);

	}

    //============ Подключение CSS
	public function enqueue_styles() {
		wp_enqueue_style( $this->review_arthur, plugin_dir_url( __FILE__ ) . 'css/review-arthur-public.min.css', array(), $this->version, 'all' );
	}

    //============ Побключение JS
	public function enqueue_scripts() {
		wp_enqueue_script( $this->review_arthur, plugin_dir_url( __FILE__ ) . 'js/review-arthur-public.js', array( 'jquery' ), $this->version, true );
	}

	//============ цвет для кнопки из админки
    public function add_color_btn(){

	    $btnBackgroundColor = $this->my_plugin_options['btn_color'];
	    $btnTextColor = $this->my_plugin_options['btn_color_text'];

        if( !empty($btnBackgroundColor) )
        {
            echo "style='color: $btnTextColor; background: $btnBackgroundColor;'";
        }
    }
}
