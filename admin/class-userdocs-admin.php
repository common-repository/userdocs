<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://endif.media
 * @since      1.0.0
 *
 * @package    Userdocs
 * @subpackage Userdocs/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Userdocs
 * @subpackage Userdocs/admin
 * @author     Ethan Allen <yourfriendethan@gmail.com>
 */
class Userdocs_Admin {

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
		$this->options = new UserDocs_Plugin_Options('UserDocs', $this->plugin_name . '_settings', $this->plugin_name . '_settings');

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function setup_post_types() {
		$labels = array(
			'name'                  => _x('UserDocs', $this->plugin_name),// shows up edit post type screen
			'singular_name'         => _x('UserDoc', $this->plugin_name),
			'menu_name'             => _x('UserDocs', $this->plugin_name),//left hand nav menu title
			'all_items'             => _x('All UserDocs', $this->plugin_name),
			'add_new_item'          => _x('Add new UserDoc', $this->plugin_name),
			'edit_item'             => _x('Edit UserDoc', $this->plugin_name),
			'not_found'             => _x('No UserDocs found', $this->plugin_name),
		);
		$args = array(
			'label'                 => _x('UserDoc', $this->plugin_name),
			'labels'                => $labels,
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'menu_icon'			    => 'dashicons-info',
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
		);
		register_post_type( 'userdocs', $args );

		$labels = array(
			'name'                       => _x('Topics', $this->plugin_name),// shows up edit post type screen
			'singular_name'              => _x('Topic', $this->plugin_name),
			'menu_name'                  => _x('Topics', $this->plugin_name),
			'new_item_name'              => _x('New Topic', $this->plugin_name),
			'add_new_item'               => _x('Add New Topic', $this->plugin_name),
			'edit_item'                  => _x('Edit Topic', $this->plugin_name),
			'not_found'                  => _x('Topic not found', $this->plugin_name),
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => false,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_quick_edit'         => false,
			'meta_box_cb'                => false,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => false,
			'rewrite'                    => array('slug' => 'userdocs', 'with_front' => false)
		);
		register_taxonomy( 'userdocs_taxonomy', array( 'userdocs' ), $args );
	}

	/**
	 * Register the menu for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function create_menu(){
		add_submenu_page(
			'edit.php?post_type=' . $this->plugin_name,
			__('Settings', $this->plugin_name),
			__('Settings', $this->plugin_name),
			'manage_options',
			$this->plugin_name . '_settings',
			array($this, 'options_page'));
	}

	/**
	 * Function that displays the options form.
	 *
	 * @since    1.0.0
	 */
	public function options_page() {

		$options = $this->option_fields();
		$active_tab = isset($_GET[ 'tab' ]) ? $_GET[ 'tab' ] : 'general';
		$this->options->render_form($options, sanitize_text_field($active_tab));

	}

	/**
	 * Function that builds the options array for Plugin_Settings class.
	 *
	 * @since    1.0.0
	 */
	public function option_fields() {
		$options = array(
			/** Payment Gateways Settings */
			'general' => apply_filters($this->plugin_name . '_settings_general',
				array(
					'userdoc_name' => array(
						'id'   => 'userdoc_name',
						'label' => __( 'UserDoc name', $this->plugin_name ),
						//'desc' => __( 'Upload or choose a logo to be displayed at the top of PDF invoices and quotes.', 'invoice-app' ),
						'type' => 'text',
					),
					'userdoc_singular_name' => array(
						'id'   => 'userdoc_singular_name',
						'label' => __( 'Singular name', $this->plugin_name ),
						//'desc' => __( '', '' ),
						'type' => 'text',
					),
					'userdoc_menu_name' => array(
						'id'   => 'userdoc_menu_name',
						'label' => __( 'Menu name', $this->plugin_name ),
						//'desc' => __( '', 'invoice-app' ),
						'type' => 'text',
					),
					'userdoc_all_items' => array(
						'id'   => 'userdoc_all_items',
						'label' => __( 'All items menu label', $this->plugin_name ),
						//'desc' => __( '', '' ),
						'type' => 'text',
					),
					'userdoc_add_new_item' => array(
						'id'   => 'userdoc_add_new_item',
						'label' => __( 'New post message', $this->plugin_name ),
						//'desc' => __( '', '' ),
						'type' => 'text',
					),
					'userdoc_edit_item' => array(
						'id'   => 'userdoc_edit_item',
						'label' => __( 'Edit items message', $this->plugin_name ),
						//'desc' => __( '', '' ),
						'type' => 'text',
					),
					'userdoc_not_found' => array(
						'id'   => 'userdoc_not_found',
						'label' => __( 'No posts found message', $this->plugin_name ),
						//'desc' => __( '', '' ),
						'type' => 'text',
					),
					'userdoc_view_item' => array(
						'id'   => 'userdoc_label',
						'label' => __( 'Label for UserDocs', $this->plugin_name ),
						'desc' => __( '', '' ),
						'type' => 'text',
					),
				)
			),
			/** Payment Gateways Settings */
			'categories' => apply_filters($this->plugin_name . '_settings_taxonomies',
				array(
					'userdoc_tax_name' => array(
						'id'   => 'userdoc_tax_name',
						'label' => __( 'Doc category', $this->plugin_name ),
						'desc' => __( 'What are you documenting? ie. products, softwares, bike plans',  $this->plugin_name ),
						'type' => 'text',
					),
					'userdoc_tax_singular_name' => array(
						'id'   => 'userdoc_tax_singular_name',
						'label' => __( 'Doc category singular name', $this->plugin_name ),
						'desc' => __( 'Singular version of the above. ie. product, software, bike plan',  $this->plugin_name ),
						'type' => 'text',
					),
					'userdoc_tax_menu_name' => array(
						'id'   => 'userdoc_tax_menu_name',
						'label' => __( 'Menu name', $this->plugin_name ),
						'desc' => __( 'This text will show up in the menu to the left.', $this->plugin_name ),
						'type' => 'text',
					),
					'userdoc_tax_add_new_item' => array(
						'id'   => 'userdoc_tax_add_new_item',
						'label' => __( 'Add new item text', $this->plugin_name ),
						'type' => 'text',
					),
					'userdoc_tax_edit_item' => array(
						'id'   => 'userdoc_tax_edit_item',
						'label' => __( 'Edit item text', $this->plugin_name ),
						'type' => 'text',
					),
					'userdoc_tax_update_item' => array(
						'id'   => 'userdoc_tax_update_item',
						'label' => __( 'Update item text', $this->plugin_name ),
						'type' => 'text',
					),
					'userdoc_tax_not_found' => array(
						'id'   => 'userdoc_tax_not_found',
						'label' => __( 'No categories found message', $this->plugin_name ),
						'desc' => __( 'This message will display if there are no categories in the list.', '' ),
						'type' => 'text',
					),
				)
			),
		);
		return apply_filters( $this->plugin_name . '_settings_group', $options );
	}

	public function setup_userdocs_metaboxes(){
		$plugin_settings = get_option($this->plugin_name . '_settings');
		add_meta_box('UserDocs', "This document belongs with&hellip;", array(&$this, 'taxonomy_details'), 'userdocs', 'side');
	}

	/**
	 * maybe use wp_category_checklist().
	 */
	public function taxonomy_details(){
		$selected = (!empty($_GET['post'])) ? wp_get_post_terms(intval($_GET['post']), 'userdocs_taxonomy')[0]->term_id : null;
		wp_dropdown_categories(array(
			'taxonomy'        =>  'userdocs_taxonomy',
			'orderby'         =>  'name',
			'selected'        =>  $selected,
			'hierarchical'    =>  true,
			'depth'           =>  3,
			'show_count'      =>  false, // Show # listings
			'hide_empty'      =>  false, // Don't show businesses w/o listings
		));
	}

	/**
	 * @param $post_id
	 * @param $post
	 */
	public function save_taxonomy_details($post_id, $post){
		if ($post->post_type == 'userdocs')
			if (!empty($_REQUEST['cat']))
				wp_set_object_terms( $post_id, intval($_REQUEST['cat']), 'userdocs_taxonomy', false );
	}

}
