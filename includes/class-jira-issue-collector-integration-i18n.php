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
 * @package    Integrate_Jira_Issue_Collector
 * @subpackage Integrate_Jira_Issue_Collector/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Integrate_Jira_Issue_Collector
 * @subpackage Integrate_Jira_Issue_Collector/includes
 * @author     Josh Hargreaves <me@joshhargreaves.co.uk>
 */
class Integrate_Jira_Issue_Collector_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'integrate-jira-issue-collector',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
