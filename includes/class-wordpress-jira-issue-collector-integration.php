<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://https://www.joshhargreaves.co.uk
 * @since      1.0.0
 *
 * @package    Wordpress_Jira_Issue_Collector_Integration
 * @subpackage Wordpress_Jira_Issue_Collector_Integration/includes
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
 * @package    Wordpress_Jira_Issue_Collector_Integration
 * @subpackage Wordpress_Jira_Issue_Collector_Integration/includes
 * @author     Josh Hargreaves <me@joshhargreaves.co.uk>
 */
class Wordpress_Jira_Issue_Collector_Integration {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Wordpress_Jira_Issue_Collector_Integration_Loader    $loader    Maintains and registers all hooks for the plugin.
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
	 * The unique prefix of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $prefix    The string used as a prefix for functions.
	 */
	protected $prefix;

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
		if ( defined( 'WORDPRESS_JIRA_ISSUE_COLLECTOR_INTEGRATION_VERSION' ) ) {
			$this->version = WORDPRESS_JIRA_ISSUE_COLLECTOR_INTEGRATION_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'wordpress-jira-issue-collector-integration';
		$this->prefix = 'wjici_plugin';

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
	 * - Wordpress_Jira_Issue_Collector_Integration_Loader. Orchestrates the hooks of the plugin.
	 * - Wordpress_Jira_Issue_Collector_Integration_i18n. Defines internationalization functionality.
	 * - Wordpress_Jira_Issue_Collector_Integration_Admin. Defines all hooks for the admin area.
	 * - Wordpress_Jira_Issue_Collector_Integration_Public. Defines all hooks for the public side of the site.
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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wordpress-jira-issue-collector-integration-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wordpress-jira-issue-collector-integration-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wordpress-jira-issue-collector-integration-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wordpress-jira-issue-collector-integration-public.php';

		$this->loader = new Wordpress_Jira_Issue_Collector_Integration_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Wordpress_Jira_Issue_Collector_Integration_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Wordpress_Jira_Issue_Collector_Integration_i18n();

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

		$plugin_admin = new Wordpress_Jira_Issue_Collector_Integration_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_init',$this, 'register_settings');
		$this->loader->add_action( 'admin_init',$this, 'display_issue_collector');
		$this->loader->add_action( 'admin_menu', $this, 'add_admin_menu_links');

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Wordpress_Jira_Issue_Collector_Integration_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

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
	 * @return    Wordpress_Jira_Issue_Collector_Integration_Loader    Orchestrates the hooks of the plugin.
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

	public function add_admin_menu_links() {
		add_options_page(
			'Wordpress Jira Issue Collector Integration',// page title  
			'Issue Collector',// menu title  
			'manage_options',// capability  
			'wordpress-jira-issue-collector-integration',// menu slug  
			array($this, 'settings_page' )  // callback function  
		);  
	}

	public function register_settings() {
		register_setting( $this->prefix.'_options', $this->prefix.'_options', $this->prefix.'_options_validate' );
		add_settings_section( 'collector_url', 'Collector Settings', array( $this, $this->prefix.'_section_text'), $this->prefix );
		add_settings_field( $this->prefix.'_setting_collector_url', 'Collector URL', array( $this, $this->prefix.'_setting_collector_url'), $this->prefix, 'collector_url' );
	}

	function wjici_plugin_section_text() {
		echo '<p>Here you can set all the options for using the API</p>';
	}

	function wjici_plugin_setting_collector_url() {
		$options = get_option( $this->prefix.'_options' );
		echo "<textarea rows='8' cols='80' id='wjici_plugin_setting_collector_url' name='wjici_plugin_options[collector_url]' type='text'/>" . esc_textarea( $options['collector_url'] ) . "</textarea>";
	}

	function display_issue_collector(){
		$options = get_option( $this->prefix.'_options' );
		echo 'hi';
		echo '<script type="text/javascript" src="' . esc_js( esc_url( $options['collector_url'])) . '"</script>';
	}


	public function settings_page(){
		?>
		<h2>Wordpress Jira Issue Collector Integration</h2>
		<form action="options.php" method="post">
			<?php 
			settings_fields( $this->prefix.'_options' );
			do_settings_sections( 'wjici_plugin' ); ?>
			<input name="submit" class="button button-primary" type="submit" value="<?php esc_attr_e( 'Save' ); ?>" />
		</form>
		<?php
	}

}
