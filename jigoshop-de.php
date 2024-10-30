<?php
/**
 * Main plugin file.
 * This plugin extends the Jigoshop shop plugin with fully translated German language
 * packs. - Jigoshop endlich komplett auf deutsch und immer aktuell!
 *
 * @package   Jigoshop German (de_DE)
 * @author    David Decker
 * @link      http://twitter.com/deckerweb
 * @copyright Copyright 2012, David Decker - DECKERWEB
 *
 * @credits   Inspired and based on the plugin "WooCommerce (nl)" by Pronamic, NL.
 * @author    Pronamic, NL / Remco Tolsma
 * @link      http://pronamic.eu/
 * @link      http://twitter.com/pronamic
 *
 * Plugin Name: Jigoshop German (de_DE)
 * Plugin URI: http://genesisthemes.de/en/wp-plugins/jigoshop-de/
 * Description: This plugin extends the Jigoshop shop plugin with fully translated German language packs. - Jigoshop endlich komplett auf deutsch und immer aktuell!
 * Version: 1.7.5
 * Author: David Decker - DECKERWEB
 * Author URI: http://deckerweb.de/
 * License: GPLv2 or later
 * License URI: http://www.opensource.org/licenses/gpl-license.php
 * Text Domain: jigoshop-german
 * Domain Path: /jsde-languages/
 *
 * Copyright 2012 David Decker - DECKERWEB
 *
 *     This file is part of Jigoshop German (de_DE),
 *     a plugin for WordPress.
 *
 *     Jigoshop German (de_DE) is free software:
 *     You can redistribute it and/or modify it under the terms of the
 *     GNU General Public License as published by the Free Software
 *     Foundation, either version 2 of the License, or (at your option)
 *     any later version.
 *
 *     Jigoshop German (de_DE) is distributed in the hope that
 *     it will be useful, but WITHOUT ANY WARRANTY; without even the
 *     implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR
 *     PURPOSE. See the GNU General Public License for more details.
 *
 *     You should have received a copy of the GNU General Public License
 *     along with WordPress. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Setting constants
 *
 * @since 1.0.0
 */
/** Set constant for the plugin directory */
define( 'JSDE_PLUGIN_DIR', dirname( __FILE__ ) );

/** Set constant path to the Plugin basename (folder) */
define( 'JSDE_PLUGIN_BASEDIR', dirname( plugin_basename( __FILE__ ) ) );


add_action( 'init', 'ddw_jsde_init' );
/**
 * Load the text domain for translation of the plugin.
 * Load admin helper functions - only within 'wp-admin'.
 * 
 * @since 1.0.0
 */
function ddw_jsde_init() {

	/** Set filter for plugin's languages directory */
	$jsde_lang_dir = JSDE_PLUGIN_BASEDIR . '/jsde-languages/';
	$jsde_lang_dir = apply_filters( 'jsde_filter_lang_dir', $jsde_lang_dir );

	/** Load plugin textdomain plus translation files */
	load_plugin_textdomain( 'jigoshop-german', false, $jsde_lang_dir );

	/** If 'wp-admin' include admin helper functions */
	if ( is_admin() ) {
		require_once( JSDE_PLUGIN_DIR . '/includes/jsde-admin.php' );
	}

	/** Add "Settings Page" link to plugin page - only within 'wp-admin' */
	if ( is_admin() && current_user_can( 'manage_options' ) ) {
		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ) , 'ddw_jsde_settings_page_link' );
	}

}  // end of function ddw_jsde_init


/**
 * Returns current plugin's header data in a flexible way.
 *
 * @since 1.6.2
 *
 * @uses get_plugins()
 *
 * @param $jsde_plugin_value
 * @param $jsde_plugin_folder
 * @param $jsde_plugin_file
 *
 * @return string Plugin data.
 */
function ddw_jsde_plugin_get_data( $jsde_plugin_value ) {

	if ( ! function_exists( 'get_plugins' ) ) {
		require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	}

	$jsde_plugin_folder = get_plugins( '/' . plugin_basename( dirname( __FILE__ ) ) );
	$jsde_plugin_file = basename( ( __FILE__ ) );

	return $jsde_plugin_folder[ $jsde_plugin_file ][ $jsde_plugin_value ];

}  // end of function ddw_jsde_plugin_get_data


/**
 * Helper functions for returning other order button strings.
 *
 * @since 1.5.0
 *
 * @return string text for order button
 */
	/**
	 * Helper function for returning order button string: "Zahlungspflichtig bestellen"
	 *
	 * @since 1.5.0
	 *
	 * @return order button string 'Zahlungspflichtig bestellen'
	 */
	function __jsde_order_button_zahlungspflichtig_bestellen() {

		return 'Zahlungspflichtig bestellen';
	}

	/**
	 * Helper function for returning order button string: "Zahlungspflichtigen Vertrag schließen"
	 *
	 * @since 1.5.0
	 *
	 * @return order button string 'Zahlungspflichtigen Vertrag schließen'
	 */
	function __jsde_order_button_zahlungspflichtigen_vertrag() {

		return 'Zahlungspflichtigen Vertrag schlie&szlig;en';
	}

	/**
	 * Helper function for returning order button string: "Kaufen"
	 *
	 * @since 1.5.0
	 *
	 * @return order button string 'Kaufen'
	 */
	function __jsde_order_button_kaufen() {

		return 'Kaufen';
	}

/** End of order button helper functions */


/**
 * Prevents Jigoshop overriding the loading of language files from this plugin
 * Removes plugin priority set by Jigoshop plugin itself
 * (Note: Needs deactivating and re-activating of the "Jigoshop" and "Jigoshop German (de_DE)" plugins!
 *
 * @since 1.2.0
 */
remove_action( 'activated_plugin', 'jigoshop_plugin_loads_first', 999 );


/**
 * Main plugin class.
 *
 * All code of this main class by Pronamic, NL, for the "WooCommerce (nl)" plugin
 * @author    Pronamic, NL / Remco Tolsma
 * @copyright Pronamic, NL / Remco Tolsma
 * @license   GPLv2
 * @link      http://pronamic.eu/
 * @link      http://twitter.com/pronamic
 *
 * Modifications needed for German plugin by David Decker (deckerweb).
 *
 * @since 1.0.0
 */
class Jigoshop_de_DE {

	/**
	 * The current langauge
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	private static $language;


	/**
	 * Flag for the German langauge
	 * true if current langauge is German, false otherwise
	 *
	 * @since 1.0.0
	 *
	 * @var boolean
	 */
	private static $_is_German;


	/**
	 * Bootstrap
	 *
	 * @since 1.0.0
	 */
	public static function bootstrap() {
		add_filter( 'load_textdomain_mofile', array( __CLASS__, 'load_mo_file' ), 10, 2 );
	}


	/**
	 * Check for installed/ used locale and textdomain .mo file
	 * Check for active WPML language code
	 *
	 * @since 1.0.0
	 *
	 * @param string $moFile
	 * @param string $domain
	 */
	public static function load_mo_file( $moFile, $domain ) {

		/** Check for installed/ used locale in WordPress */
		if ( self::$language == null ) {
			self::$language = get_option( 'WPLANG', WPLANG );
			self::$_is_German = ( self::$language == 'de_DE' );

			/** Check for active WPML language code ("WPML" plugin) */
			if (defined( 'ICL_LANGUAGE_CODE' ) ) {
				self::$_is_German = ICL_LANGUAGE_CODE == 'de';
			}
		}

		$newMofile = null;

		/** Jigoshop */
		$_is_jigoshop_domain = ( $domain == 'jigoshop' );

		if ( $_is_jigoshop_domain ) {

			$_is_jigoshop = strpos( $moFile, '/jigoshop/' ) !== false;

			if ( $_is_jigoshop ) {

				/** Get current Jigoshop version */
				$version = get_option( 'jigoshop_db_version', null );

				/** Check if informal .mo file version exists in custom theme/child theme folder */
				if ( file_exists( get_stylesheet_directory() . '/jigoshop/du-version/jigoshop-de_DE.mo' ) ) {
					$newMofile = get_stylesheet_directory() . '/jigoshop/du-version/jigoshop-de_DE.mo';

				/** Otherwise load default language version (= formal/ SIE-Version!) */
				} else {
					$newMofile = self::get_mo_file( 'jigoshop', $version, 'sie-version/' );
				}  // end if/else

			}  // end-if $_is_jigoshop

		}  // end-if $_is_jigoshop_domain

		if ( is_readable( $newMofile ) ) {
			$moFile = $newMofile;
		}

		return $moFile;

	}  // end of function load_mo_file


	/**
	 * Get the .mo file for the specified domain, version and language
	 *
	 * @since 1.0.0
	 */
	public static function get_mo_file( $domain, $version, $path = '' ) {

		$dir = dirname( __FILE__ );

		$moFile = $dir . '/languages/' . $domain . '/' . $version . '/' . $path . self::$language . '.mo';

		/** If specific version .mo file is not available point to the current public release (cpr) version */
		if ( !is_readable( $moFile ) ) {
			$moFile = $dir . '/languages/' . $domain . '/cpr/' . $path . self::$language . '.mo';
		}

		return $moFile;

	}  // end of function get_mo_file

}  // end of main class Jigoshop_de_DE


/** Start class */
Jigoshop_de_DE::bootstrap();
