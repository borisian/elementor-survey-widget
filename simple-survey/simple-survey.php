<?php

/**
 * Plugin Name:      Simple Survey  
 * Description:      Simple Survey Maker for Elementor.
 * Version:          1.2
 * Author:           Boris F.
 * Text Domain:      simple-survey
 * Requires Plugins: elementor
 * Elementor tested up to: 3.20.2
 * Elementor Pro tested up to: 3.20.1
 */

final class Plugin
{

    /**
     * Minimum Elementor Version
     *
     * @since 1.0.0
     * @var string Minimum Elementor version required to run the addon.
     */
    const MINIMUM_ELEMENTOR_VERSION = '3.20.0';

    /**
     * Minimum PHP Version
     *
     * @since 1.0.0
     * @var string Minimum PHP version required to run the addon.
     */
    const MINIMUM_PHP_VERSION = '7.4';

    /**
     * Constructor
     *
     * Perform some compatibility checks to make sure basic requirements are meet.
     * If all compatibility checks pass, initialize the functionality.
     *
     * @since 1.0.0
     * @access public
     */
    public function __construct()
    {
        if ($this->is_compatible()) {
            add_action('elementor/init', [$this, 'init']);
        }
    }

    /**
     * Compatibility Checks
     *
     * Checks whether the site meets the addon requirement.
     *
     * @since 1.0.0
     * @access public
     */
    public function is_compatible()
    {

        // Check if Elementor is installed and activated
        if (!did_action('elementor/loaded')) {
            add_action('admin_notices', [$this, 'admin_notice_missing_main_plugin']);
            return false;
        }

        // Check for required Elementor version
        if (!version_compare(ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=')) {
            add_action('admin_notices', [$this, 'admin_notice_minimum_elementor_version']);
            return false;
        }

        // Check for required PHP version
        if (version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {
            add_action('admin_notices', [$this, 'admin_notice_minimum_php_version']);
            return false;
        }

        return true;
    }

    /**
     * Admin notice
     *
     * Warning when the site doesn't have Elementor installed or activated.
     *
     * @since 1.0.0
     * @access public
     */
    public function admin_notice_missing_main_plugin()
    {

        if (isset($_GET['activate'])) unset($_GET['activate']);

        $message = sprintf(
            /* translators: 1: Plugin name 2: Elementor */
            esc_html__('"%1$s" requires "%2$s" to be installed and activated.', 'elementor-test-addon'),
            '<strong>' . esc_html__('Elementor Test Addon', 'elementor-test-addon') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'elementor-test-addon') . '</strong>'
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    /**
     * Admin notice
     *
     * Warning when the site doesn't have a minimum required Elementor version.
     *
     * @since 1.0.0
     * @access public
     */
    public function admin_notice_minimum_elementor_version()
    {

        if (isset($_GET['activate'])) unset($_GET['activate']);

        $message = sprintf(
            /* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-test-addon'),
            '<strong>' . esc_html__('Elementor Test Addon', 'elementor-test-addon') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'elementor-test-addon') . '</strong>',
            self::MINIMUM_ELEMENTOR_VERSION
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    /**
     * Admin notice
     *
     * Warning when the site doesn't have a minimum required PHP version.
     *
     * @since 1.0.0
     * @access public
     */
    public function admin_notice_minimum_php_version()
    {

        if (isset($_GET['activate'])) unset($_GET['activate']);

        $message = sprintf(
            /* translators: 1: Plugin name 2: PHP 3: Required PHP version */
            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-test-addon'),
            '<strong>' . esc_html__('Elementor Test Addon', 'elementor-test-addon') . '</strong>',
            '<strong>' . esc_html__('PHP', 'elementor-test-addon') . '</strong>',
            self::MINIMUM_PHP_VERSION
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }



    /**
     * Initialize
     *
     * Load the addons functionality only after Elementor is initialized.
     *
     * Fired by `elementor/init` action hook.
     *
     * @since 1.0.0
     * @access public
     */
    public function init()
    {
        // Import Widget
        require_once(__DIR__ . '/includes/widget-manager.php');
    }
}

// JavaScript
function register_my_plugin_scripts()
{
    wp_register_script('my-elementor-widget-script', plugins_url('/assets/js/index.js', __FILE__), ['jquery'], '1.0.0', true);
    wp_enqueue_script('my-elementor-widget-script');
}
add_action('wp_enqueue_scripts', 'register_my_plugin_scripts');

// Styles
function my_plugin_frontend_stylesheets() {

	wp_register_style( 'frontend-style', plugins_url( 'assets/css/index.css', __FILE__ ) );
	wp_enqueue_style( 'frontend-style' );

}
add_action( 'elementor/frontend/after_enqueue_styles', 'my_plugin_frontend_stylesheets' );


new Plugin();
