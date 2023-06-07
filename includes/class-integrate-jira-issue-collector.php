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
 * @package    Integrate_Jira_Issue_Collector
 * @subpackage Integrate_Jira_Issue_Collector/includes
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
 * @package    Integrate_Jira_Issue_Collector
 * @subpackage Integrate_Jira_Issue_Collector/includes
 * @author     Josh Hargreaves <me@joshhargreaves.co.uk>
 */
class Integrate_Jira_Issue_Collector {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Integrate_Jira_Issue_Collector_Loader    $loader    Maintains and registers all hooks for the plugin.
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
		if ( defined( 'Integrate_Jira_Issue_Collector_VERSION' ) ) {
			$this->version = Integrate_Jira_Issue_Collector_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'integrate-jira-issue-collector';
		$this->prefix = 'ijic_plugin';

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
	 * - Integrate_Jira_Issue_Collector_Loader. Orchestrates the hooks of the plugin.
	 * - Integrate_Jira_Issue_Collector_i18n. Defines internationalization functionality.
	 * - Integrate_Jira_Issue_Collector_Admin. Defines all hooks for the admin area.
	 * - Integrate_Jira_Issue_Collector_Public. Defines all hooks for the public side of the site.
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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-integrate-jira-issue-collector-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-integrate-jira-issue-collector-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-integrate-jira-issue-collector-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-integrate-jira-issue-collector-public.php';

		$this->loader = new Integrate_Jira_Issue_Collector_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Integrate_Jira_Issue_Collector_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Integrate_Jira_Issue_Collector_i18n();

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

		$plugin_admin = new Integrate_Jira_Issue_Collector_Admin( $this->get_plugin_name(), $this->get_version() );

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

		$plugin_public = new Integrate_Jira_Issue_Collector_Public( $this->get_plugin_name(), $this->get_version() );

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
	 * @return    Integrate_Jira_Issue_Collector_Loader    Orchestrates the hooks of the plugin.
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
			'Integrate Jira Issue Collector',// page title  
			'Issue Collector',// menu title  
			'manage_options',// capability  
			'integrate-jira-issue-collector',// menu slug  
			array($this, 'settings_page' )  // callback function  
		);  
	}

	public function register_settings() {
		register_setting( $this->prefix.'_options', $this->prefix.'_options', $this->prefix.'_options_validate' );
		add_settings_section( 'collector_url', 'Collector Settings', array( $this, $this->prefix.'_section_text'), $this->prefix );
		add_settings_field( $this->prefix.'_setting_collector_url', 'Collector URL', array( $this, $this->prefix.'_setting_collector_url'), $this->prefix, 'collector_url' );
	}

	function ijic_plugin_section_text() {
		echo '<p>Here you can set all the options for using the API</p>';
	}

	function ijic_plugin_setting_collector_url() {
		$options = get_option( $this->prefix.'_options' );
		echo "<textarea rows='8' cols='80' id='ijic_plugin_setting_collector_url' name='ijic_plugin_options[collector_url]' type='text'/>" . esc_textarea( $options['collector_url'] ) . "</textarea>";
	}

	function admin_inline_js() {
		$options = get_option( $this->prefix.'_options' );
		echo "<script type='text/javascript'\n";
		echo 'src = '. $options['collector_url'].'>';
		echo "\n</script>"; 
	}

	function display_issue_collector(){
		add_action( 'admin_print_scripts', array( $this, 'admin_inline_js') );
	}


	public function settings_page(){
		?>
		<h2>Integrate Jira Issue Collector</h2>
		<form action="options.php" method="post">
			<?php 
			settings_fields( $this->prefix.'_options' );
			do_settings_sections( 'ijic_plugin' ); ?>
			<input name="submit" class="button button-primary" type="submit" value="<?php esc_attr_e( 'Save' ); ?>" />
		</form>
		<?php
	}

}
