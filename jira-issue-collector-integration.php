<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://https://www.joshhargreaves.co.uk
 * @since             1.0.0
 * @package           Jira_Issue_Collector_Integration
 *
 * @wordpress-plugin
 * Plugin Name:       Jira Issue Collector Integration
 * Plugin URI:        https://joshhargreaves.co.uk
 * Description:       Easily integrate jira issue collector into the admin side of your wordpress site
 * Version:           1.0.0
 * Author:            Josh Hargreaves
 * Author URI:        https://https://www.joshhargreaves.co.uk
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       jira-issue-collector-integration
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'Jira_Issue_Collector_Integration_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-jira-issue-collector-integration-activator.php
 */
function activate_Jira_Issue_Collector_Integration() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-jira-issue-collector-integration-activator.php';
	Jira_Issue_Collector_Integration_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-jira-issue-collector-integration-deactivator.php
 */
function deactivate_Jira_Issue_Collector_Integration() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-jira-issue-collector-integration-deactivator.php';
	Jira_Issue_Collector_Integration_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_Jira_Issue_Collector_Integration' );
register_deactivation_hook( __FILE__, 'deactivate_Jira_Issue_Collector_Integration' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-jira-issue-collector-integration.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_Jira_Issue_Collector_Integration() {

	$plugin = new Jira_Issue_Collector_Integration();
	$plugin->run();

}
if( !defined('ABSPATH'))
{
    exit;
}

run_Jira_Issue_Collector_Integration();