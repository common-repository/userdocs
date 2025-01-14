<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://endif.media
 * @since      1.0.0
 *
 * @package    Userdocs
 * @subpackage Userdocs/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Userdocs
 * @subpackage Userdocs/includes
 * @author     Ethan Allen <yourfriendethan@gmail.com>
 */
class Userdocs {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Userdocs_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'userdocs';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Userdocs_Loader. Orchestrates the hooks of the plugin.
	 * - Userdocs_i18n. Defines internationalization functionality.
	 * - Userdocs_Admin. Defines all hooks for the admin area.
	 * - Userdocs_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-userdocs-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-userdocs-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-userdocs-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-userdocs-public.php';

		/**
		 * The class responsible for displaying and saving plugin settings in the admin-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/plugin-options.php';

		$this->loader = new Userdocs_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Userdocs_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Userdocs_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Userdocs_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'init', $plugin_admin, 'setup_post_types' );
		//$this->loader->add_action( 'admin_menu', $plugin_admin, 'create_menu' );
		$this->loader->add_action( 'add_meta_boxes_userdocs', $plugin_admin, 'setup_userdocs_metaboxes' );
		$this->loader->add_action( 'post_updated', $plugin_admin, 'save_taxonomy_details', 10, 2 );
		/*$this->loader->add_filter( 'userdoc_name', $plugin_admin, 'change_post_type_text' );
		$this->loader->add_filter( 'userdoc_singular_name', $plugin_admin, 'change_post_type_text' );
		$this->loader->add_filter( 'userdoc_menu_name', $plugin_admin, 'change_post_type_text' );
		$this->loader->add_filter( 'userdoc_all_items', $plugin_admin, 'change_post_type_text' );
		$this->loader->add_filter( 'userdoc_add_new_item', $plugin_admin, 'change_post_type_text' );
		$this->loader->add_filter( 'userdoc_not_found', $plugin_admin, 'change_post_type_text' );
		$this->loader->add_filter( 'userdoc_label', $plugin_admin, 'change_post_type_text' );

		$this->loader->add_filter( 'userdoc_tax_name', $plugin_admin, 'change_post_type_text' );
		$this->loader->add_filter( 'userdoc_tax_singular_name', $plugin_admin, 'change_post_type_text' );
		$this->loader->add_filter( 'userdoc_tax_menu_name', $plugin_admin, 'change_post_type_text' );
		$this->loader->add_filter( 'userdoc_tax_all_items', $plugin_admin, 'change_post_type_text' );
		$this->loader->add_filter( 'userdoc_tax_add_new_item', $plugin_admin, 'change_post_type_text' );
		$this->loader->add_filter( 'userdoc_tax_edit_item', $plugin_admin, 'change_post_type_text' );
		$this->loader->add_filter( 'userdoc_tax_not_found', $plugin_admin, 'change_post_type_text' );
		$this->loader->add_filter( 'userdoc_tax_label', $plugin_admin, 'change_post_type_text' );*/

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Userdocs_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );

		$this->loader->add_filter('generate_rewrite_rules',$plugin_public, 'slug_rewrite');
		$this->loader->add_action('init', $plugin_public, 'register_shortcodes' );
		$this->loader->add_filter('the_content', $plugin_public, 'filter_archive_content');
		add_filter('widget_text', 'do_shortcode');
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Userdocs_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
