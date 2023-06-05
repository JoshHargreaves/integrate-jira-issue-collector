<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://https://www.joshhargreaves.co.uk
 * @since      1.0.0
 *
 * @package    Wordpress_Jira_Issue_Collector_Integration
 * @subpackage Wordpress_Jira_Issue_Collector_Integration/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Wordpress_Jira_Issue_Collector_Integration
 * @subpackage Wordpress_Jira_Issue_Collector_Integration/includes
 * @author     Josh Hargreaves <me@joshhargreaves.co.uk>
 */
class Wordpress_Jira_Issue_Collector_Integration_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wordpress-jira-issue-collector-integration',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
