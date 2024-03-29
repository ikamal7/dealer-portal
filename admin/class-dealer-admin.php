<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://pureandgentleshop.com/
 * @since      1.0.0
 *
 * @package    Dealer
 * @subpackage Dealer/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Dealer
 * @subpackage Dealer/admin
 * @author     Kanak & Kamal <kamalhosen8920@gmail.com>
 */
class Dealer_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		add_action( 'admin_init', array( $this, 'add_new_user_role'));
		add_filter( 'login_redirect',  array( $this, 'my_login_redirect'), 10, 3 );

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Dealer_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Dealer_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/dealer-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Dealer_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Dealer_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/dealer-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function add_new_user_role()
	{
		add_role( 'dealer', 'Dealer', 'manage_options' );
		add_role( 'sales_r', 'Sales representative', 'read' );
	}

	function my_login_redirect( $redirect_to, $request, $user ) {
		//is there a user to check?
		global $user;
		if ( isset( $user->roles ) && is_array( $user->roles ) ) {
			if ( in_array( 'dealer', $user->roles ) ) {
				// redirect them to the default place
				$dealer_page = get_page_template_link(DEALER_PATH . '/includes/dealer-template.php');
				return $dealer_page;
			}elseif ( in_array( 'sales_r', $user->roles ) ) {
				// redirect them to the default place
				$sr_page = get_page_template_link(DEALER_PATH . '/includes/sr-template.php');
				return $sr_page;
			} else {
				return home_url();
			}
		} else {
			return $redirect_to;
		}
	}

}
