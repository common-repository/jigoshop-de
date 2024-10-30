<?php
/**
 * Helper functions for the admin - plugin links.
 *
 * @package    Jigoshop German (de_DE)
 * @subpackage Admin
 * @author     David Decker - DECKERWEB
 * @copyright  Copyright 2012, David Decker - DECKERWEB
 * @license    http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link       http://genesisthemes.de/en/wp-plugins/jigoshop-de/
 * @link       http://twitter.com/deckerweb
 *
 * @since 1.0.0
 */

/**
 * Setting internal plugin helper links constants
 *
 * @since 1.6.0
 */
define( 'JSDE_URL_TRANSLATE',		'http://translate.wpautobahn.com/projects/wordpress-plugins-deckerweb/jigoshop-de' );
define( 'JSDE_URL_WPORG_FAQ',		'http://wordpress.org/extend/plugins/jigoshop-de/faq/' );
define( 'JSDE_URL_WPORG_FORUM',		'http://wordpress.org/support/plugin/jigoshop-de' );
define( 'JSDE_URL_WPORG_PROFILE',	'http://profiles.wordpress.org/daveshine/' );
define( 'JSDE_PLUGIN_LICENSE', 		'GPLv2+' );
if ( get_locale() == 'de_DE' || get_locale() == 'de_AT' || get_locale() == 'de_CH' || get_locale() == 'de_LU' ) {
	define( 'JSDE_URL_DONATE', 	'http://deckerweb.de/sprachdateien/spenden/' );
	define( 'JSDE_URL_PLUGIN',	'http://genesisthemes.de/plugins/jigoshop-de/' );
	define( 'JSDE_IS_GERMAN', 	true );
} else {
	define( 'JSDE_URL_DONATE', 	'http://genesisthemes.de/en/donate/' );
	define( 'JSDE_URL_PLUGIN',	'http://genesisthemes.de/en/wp-plugins/jigoshop-de/' );
	define( 'JSDE_IS_GERMAN', 	true );
}


/**
 * Add "Settings" link to plugin page
 *
 * @since 1.6.0
 *
 * @param  $jsde_links
 * @param  $jsde_settings_link
 *
 * @return strings settings link
 */
function ddw_jsde_settings_page_link( $jsde_links ) {

	/** Jigoshop Admin link */
	$jsde_settings_link = sprintf( '<a href="%s" title="%s">%s</a>' , admin_url( 'admin.php?page=jigoshop_settings' ) , __( 'Go to the Jigoshop settings page', 'jigoshop-german' ) , __( 'Jigoshop Settings', 'jigoshop-german' ) );

	/** Set the order of the links */
	array_unshift( $jsde_links, $jsde_settings_link );

	/** Display plugin settings links */
	return $jsde_links;

}  // end of function ddw_jsde_settings_page_link


add_filter( 'plugin_row_meta', 'ddw_jsde_plugin_links', 10, 2 );
/**
 * Add various support links to plugin page
 *
 * @since 1.0.0
 *
 * @param  $jsde_links
 * @param  $jsde_file
 *
 * @return strings plugin links
 */
function ddw_jsde_plugin_links( $jsde_links, $jsde_file ) {

	/** Capability check */
	if ( ! current_user_can( 'install_plugins' ) ) {

		return $jsde_links;

	}  // end-if cap check

	/** List additional links only for this plugin */
	if ( $jsde_file == JSDE_PLUGIN_BASEDIR . '/jigoshop-de.php' ) {

		$jsde_links[] = '<a href="' . esc_url_raw( JSDE_URL_WPORG_FAQ ) . '" target="_new" title="' . __( 'FAQ', 'jigoshop-german' ) . '">' . __( 'FAQ', 'jigoshop-german' ) . '</a>';
		$jsde_links[] = '<a href="' . esc_url_raw( JSDE_URL_WPORG_FORUM ) . '" target="_new" title="' . __( 'Support', 'jigoshop-german' ) . '">' . __( 'Support', 'jigoshop-german' ) . '</a>';
		$jsde_links[] = '<a href="' . esc_url_raw( JSDE_URL_TRANSLATE ) . '" target="_new" title="' . __( 'Translations', 'jigoshop-german' ) . '">' . __( 'Translations', 'jigoshop-german' ) . '</a>';
		$jsde_links[] = '<a href="' . esc_url_raw( JSDE_URL_DONATE ) . '" target="_new" title="' . __( 'Donate', 'jigoshop-german' ) . '"><strong>' . __( 'Donate', 'jigoshop-german' ) . '</strong></a>';

	}  // end-if plugin check

	/** Output the links */
	return $jsde_links;

}  // end of function ddw_jsde_plugin_links


add_action( 'load-toplevel_page_jigoshop', 'ddw_jsde_jigoshop_help_tab', 5 );
add_action( 'load-jigoshop_page_jigoshop_reports', 'ddw_jsde_jigoshop_help_tab', 5 );
add_action( 'load-jigoshop_page_jigoshop_system_info', 'ddw_jsde_jigoshop_help_tab', 5 );
add_action( 'load-jigoshop_page_jigoshop_settings', 'ddw_jsde_jigoshop_help_tab', 5 );
/**
 * Create and display plugin help tab.
 *
 * @since 1.6.0
 *
 * @global mixed $jsde_jigoshop_screen
 */
function ddw_jsde_jigoshop_help_tab() {

	global $jsde_jigoshop_screen;

	$jsde_jigoshop_screen = get_current_screen();

	/** Display help tabs only for WordPress 3.3 or higher */
	if( ! class_exists( 'WP_Screen' )
		|| ! $jsde_jigoshop_screen
	) {
		return;
	}

	/** Add the help tab */
	$jsde_jigoshop_screen->add_help_tab( array(
		'id'       => 'jsde-jigoshop-help',
		'title'    => __( 'Jigoshop German (de_DE)', 'jigoshop-german' ),
		'callback' => 'ddw_jsde_jigoshop_help_content',
	) );

	/** Add help sidebar */
	$jsde_jigoshop_screen->set_help_sidebar(
		'<p><strong>' . __( 'More about the plugin author', 'jigoshop-german' ) . '</strong></p>' .
		'<p>' . __( 'Social:', 'jigoshop-german' ) . '<br /><a href="http://twitter.com/deckerweb" target="_blank" title="@ Twitter">Twitter</a> | <a href="http://www.facebook.com/deckerweb.service" target="_blank" title="@ Facebook">Facebook</a> | <a href="http://deckerweb.de/gplus" target="_blank" title="@ Google+">Google+</a> | <a href="' . esc_url_raw( ddw_jsde_plugin_get_data( 'AuthorURI' ) ) . '" target="_blank" title="@ deckerweb.de">deckerweb</a></p>' .
		'<p><a href="' . esc_url_raw( JSDE_URL_WPORG_PROFILE ) . '" target="_blank" title="@ WordPress.org">@ WordPress.org</a></p>'
	);

}  // end of function ddw_jsde_jigoshop_help_tab


/**
 * Create and display plugin help tab content.
 *
 * @since 1.6.0
 *
 * @global mixed $jsde_jigoshop_screen, $pagenow
 */
function ddw_jsde_jigoshop_help_content() {

	echo '<h3>' . __( 'Plugin', 'jigoshop-german' ) . ': ' . __( 'Jigoshop German (de_DE)', 'jigoshop-german' ) . ' <small>v' . esc_attr( ddw_jsde_plugin_get_data( 'Version' ) ) . '</small></h3>' .		
		'<ul>';

		/** FAQ/Legal info for German users */
		if ( JSDE_IS_GERMAN ) {

			$jsde_legal_style = 'style="color: #cc0000;"';

			echo '<li ' . $jsde_legal_style . '"><em><strong>Haftungsausschluss:</strong> Durch den Einsatz dieses Plugins und der damit angebotenen Sprachdateien entstehen KEINE Garantien für eine korrekte Funktionsweise oder etwaige Verpflichtungen durch den Übersetzer bzw. Plugin-Anbieter! — Alle Angaben ohne Gewähr. Änderungen und Irrtümer ausdrücklich vorbehalten. Verwendung des Plugins inkl. Sprachdateien geschieht ausschliesslich auf eigene Verantwortung!</em></li>' .
				'<li><strong ' . $jsde_legal_style . '><em>Hinweis 1:</em></strong> Dieses Plugin ist ein reines Sprach-/ Übersetzungs-Plugin, es hat nichts mit "Rechtssicherheit" zu tun. Für alle rechtlichen Fragen ist der Shop-Betreiber zuständig, nicht die "Sprachdatei"!</li>' .
				'<li><strong ' . $jsde_legal_style . '><em>Hinweis 2:</em></strong> Eine RechtsBERATUNG zu diesem Themenkomplex kann NUR durch einen ANWALT erfolgen (am besten auf Online-Recht spezilisierte Anwälte!). Bitte auch Infos in den einschlägigen Blogs für Shopbetreiber, der (Fach-) Presse sowie von den Industrie- und Handelskammern beachten. -- Ich als Übersetzer und Plugin-Entwickler kann via Sprachdatei KEINE "Rechtssicherheit" garantieren, dies können nur Shop-Betreiber selbst, mit anwaltlicher Unterstützung!</li>' .
				'<li><strong ' . $jsde_legal_style . '><em>Hinweis 3:</em></strong> JA, die sogenannte "Button-Lösung" wird seit Version 1.5 dieses Plugins und Sprachdatei-Version 1.2 (aka Jigoshop 1.2+) unterstützt. &mdash; Weitere Informationen bei den <a href="' . esc_url_raw( JSDE_URL_WPORG_FAQ ) . '" target="_new" title="Häufige Fragen (FAQ)"><em>Häufigen Fragen (FAQ)</em></a></li>';

		}  // end if isGerman check

		echo '<li><em>' . __( 'Other, recommended Jigoshop plugins', 'jigoshop-german' ) . '</em>:';

			/** Optional: recommended plugins */
			if ( ! defined( 'JSABA_PLUGIN_BASEDIR' ) ) {

				echo '<br />&raquo; <a href="http://wordpress.org/extend/plugins/jigoshop-admin-bar-addition/" target="_new" title="Jigoshop Admin Bar Addition">Jigoshop Admin Bar Addition</a> &mdash; Dieses Plugin fügt der WordPress Wergzeugleiste bzw. Adminbar nützliche Administratorenlinks und Ressourcen für das Jigoshop Shop-Plugin hinzu.';

			}  // end-if plugin check

		echo '<br />&raquo; <a href="http://ddwb.me/jscc" target="_new" title="' . __( 'More premium plugins/extensions at CodeCanyon Marketplace', 'jigoshop-german' ) . ' &hellip;">' . __( 'More premium plugins/extensions at CodeCanyon Marketplace', 'jigoshop-german' ) . ' &hellip;</a>' .
		'<br />&raquo; <a href="http://wordpress.org/extend/plugins/search.php?q=jigoshop" target="_new" title="' . __( 'More free plugins/extensions at WordPress.org', 'jigoshop-german' ) . ' &hellip;">' . __( 'More free plugins/extensions at WordPress.org', 'jigoshop-german' ) . ' &hellip;</a></li>' .
		'</ul>';

		echo '<p><strong>' . __( 'Important plugin links:', 'jigoshop-german' ) . '</strong>' . 
		'<br /><a href="' . esc_url_raw( JSDE_URL_PLUGIN ) . '" target="_new" title="' . __( 'Plugin website', 'jigoshop-german' ) . '">' . __( 'Plugin website', 'jigoshop-german' ) . '</a> | <a href="' . esc_url_raw( JSDE_URL_WPORG_FAQ ) . '" target="_new" title="' . __( 'FAQ', 'jigoshop-german' ) . '">' . __( 'FAQ', 'jigoshop-german' ) . '</a> | <a href="' . esc_url_raw( JSDE_URL_WPORG_FORUM ) . '" target="_new" title="' . __( 'Support', 'jigoshop-german' ) . '">' . __( 'Support', 'jigoshop-german' ) . '</a> | <a href="' . esc_url_raw( JSDE_URL_TRANSLATE ) . '" target="_new" title="' . __( 'Translations', 'jigoshop-german' ) . '">' . __( 'Translations', 'jigoshop-german' ) . '</a> | <a href="' . esc_url_raw( JSDE_URL_DONATE ) . '" target="_new" title="' . __( 'Donate', 'jigoshop-german' ) . '"><strong ' . $jsde_legal_style . '>' . __( 'Donate', 'jigoshop-german' ) . '</strong></a></p>';

		echo '<p><a href="http://www.opensource.org/licenses/gpl-license.php" target="_new" title="' . esc_attr( JSDE_PLUGIN_LICENSE ). '">' . esc_attr( JSDE_PLUGIN_LICENSE ). '</a> &copy; ' . date( 'Y' ) . ' <a href="' . esc_url_raw( ddw_jsde_plugin_get_data( 'AuthorURI' ) ) . '" target="_new" title="' . esc_attr__( ddw_jsde_plugin_get_data( 'Author' ) ) . '">' . esc_attr__( ddw_jsde_plugin_get_data( 'Author' ) ) . '</a></p>';

}  // end of function ddw_jsde_jigoshop_help_tab
