<?php
/**
 * Plugin Name:       MBR Wolfie Slots
 * Plugin URI:        https://littlewebshack.com/mbr-wolfie-slots/
 * Description:       Wolfie — Moonlight Slots. A moonlit four-reel slot simulator with play tokens, synthesized sound and the Big Prize Run. Add it to any page with the [mbr_wolfie] shortcode. Play tokens only: no purchases, no cash prizes.
 * Version:           1.0.1
 * Requires at least: 6.3
 * Requires PHP:      7.4
 * Author:            Robert Palmer
 * Author URI:        https://madebyrobert.co.uk/
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       mbr-wolfie-slots
 *
 * @package MBR_Wolfie_Slots
 */

defined( 'ABSPATH' ) || exit;

define( 'MBR_WOLFIE_VERSION', '1.0.1' );
define( 'MBR_WOLFIE_FILE', __FILE__ );
define( 'MBR_WOLFIE_DIR', plugin_dir_path( __FILE__ ) );
define( 'MBR_WOLFIE_URL', plugin_dir_url( __FILE__ ) );

/*
 * Self-hosted updates via Plugin Update Checker (bundled in includes/vendor).
 *
 * MBR_WOLFIE_UPDATE_URL is the metadata endpoint polled for updates. Define it
 * in wp-config.php to override it without editing this file (an update never
 * overwrites wp-config). Define it as an empty string to switch update checks off.
 *
 * Remember: bump the Version header above each time you publish, or PUC has no
 * higher version to offer and no update notice appears.
 */
if ( ! defined( 'MBR_WOLFIE_UPDATE_URL' ) ) {
	define( 'MBR_WOLFIE_UPDATE_URL', 'https://raw.githubusercontent.com/HarbourBob/mbr-updates/main/mbr-wolfie-slots.json' );
}
if ( '' !== MBR_WOLFIE_UPDATE_URL && file_exists( MBR_WOLFIE_DIR . 'includes/vendor/plugin-update-checker/plugin-update-checker.php' ) ) {
	require_once MBR_WOLFIE_DIR . 'includes/vendor/plugin-update-checker/plugin-update-checker.php';
	if ( class_exists( '\\YahnisElsts\\PluginUpdateChecker\\v5\\PucFactory' ) ) {
		$GLOBALS['mbr_wolfie_update_checker'] = \YahnisElsts\PluginUpdateChecker\v5\PucFactory::buildUpdateChecker(
			MBR_WOLFIE_UPDATE_URL,
			MBR_WOLFIE_FILE,
			'mbr-wolfie-slots'
		);
	}
}

/**
 * Registers the Wolfie shortcode and loads its assets only where the game appears.
 */
final class MBR_Wolfie_Slots {

	/**
	 * Shortcode tags. [mbr_wolfie] is primary; [wolfie] is a friendly alias
	 * that is only registered if nothing else on the site has claimed it.
	 */
	const PRIMARY_TAG = 'mbr_wolfie';
	const ALIAS_TAG   = 'wolfie';

	/**
	 * Hook everything up.
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'register_shortcodes' ) );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'register_assets' ) );
	}

	/**
	 * Register shortcode(s).
	 */
	public static function register_shortcodes() {
		add_shortcode( self::PRIMARY_TAG, array( __CLASS__, 'render' ) );
		if ( ! shortcode_exists( self::ALIAS_TAG ) ) {
			add_shortcode( self::ALIAS_TAG, array( __CLASS__, 'render' ) );
		}
	}

	/**
	 * Register assets, and enqueue them early (in the <head>) when we can tell
	 * the current page contains the game. This avoids a flash of unstyled
	 * content. The shortcode callback enqueues as a fallback for anything we
	 * can't detect up front (widgets, page builders, template calls).
	 */
	public static function register_assets() {
		wp_register_style(
			'mbr-wolfie',
			MBR_WOLFIE_URL . 'assets/css/wolfie.css',
			array(),
			MBR_WOLFIE_VERSION
		);

		wp_register_script(
			'mbr-wolfie-engine',
			MBR_WOLFIE_URL . 'assets/js/engine.js',
			array(),
			MBR_WOLFIE_VERSION,
			array(
				'in_footer' => true,
				'strategy'  => 'defer',
			)
		);

		wp_register_script(
			'mbr-wolfie-app',
			MBR_WOLFIE_URL . 'assets/js/app.js',
			array( 'mbr-wolfie-engine' ),
			MBR_WOLFIE_VERSION,
			array(
				'in_footer' => true,
				'strategy'  => 'defer',
			)
		);

		if ( self::page_has_game() ) {
			self::enqueue();
		}
	}

	/**
	 * Enqueue the registered assets.
	 */
	private static function enqueue() {
		wp_enqueue_style( 'mbr-wolfie' );
		wp_enqueue_script( 'mbr-wolfie-app' );
	}

	/**
	 * Does the current singular post contain the shortcode?
	 * Checks post content and Elementor data.
	 *
	 * @return bool
	 */
	private static function page_has_game() {
		$found = false;

		if ( is_singular() ) {
			$post = get_post();

			if ( $post instanceof WP_Post ) {
				foreach ( array( self::PRIMARY_TAG, self::ALIAS_TAG ) as $tag ) {
					if ( has_shortcode( $post->post_content, $tag ) ) {
						$found = true;
						break;
					}
				}

				if ( ! $found ) {
					$elementor = get_post_meta( $post->ID, '_elementor_data', true );
					if ( is_string( $elementor ) && '' !== $elementor
						&& ( false !== strpos( $elementor, '[' . self::PRIMARY_TAG ) || false !== strpos( $elementor, '[' . self::ALIAS_TAG ) ) ) {
						$found = true;
					}
				}
			}
		}

		/**
		 * Force the Wolfie assets to load (or not) on the current request.
		 *
		 * @param bool $found Whether the game was detected on this page.
		 */
		return (bool) apply_filters( 'mbr_wolfie_load_assets', $found );
	}

	/**
	 * Interpret yes/no style shortcode attributes.
	 *
	 * @param mixed $value Attribute value.
	 * @return bool
	 */
	private static function is_on( $value ) {
		return ! in_array( strtolower( trim( (string) $value ) ), array( 'no', 'false', '0', 'off', 'hide' ), true );
	}

	/**
	 * Shortcode callback.
	 *
	 * Attributes:
	 *  - intro="no"   hide the large WOLFIE title block (handy when the page already has a heading)
	 *  - header="no"  hide the top bar (brand, sound toggle, How to play)
	 *
	 * @param array|string $atts Shortcode attributes.
	 * @return string
	 */
	public static function render( $atts ) {
		$atts = shortcode_atts(
			array(
				'intro'  => 'yes',
				'header' => 'yes',
			),
			$atts,
			self::PRIMARY_TAG
		);

		self::enqueue();

		$show_intro  = self::is_on( $atts['intro'] );
		$show_header = self::is_on( $atts['header'] );

		ob_start();
		include MBR_WOLFIE_DIR . 'templates/game.php';
		return (string) ob_get_clean();
	}
}

MBR_Wolfie_Slots::init();
