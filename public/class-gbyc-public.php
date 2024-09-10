<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://modernearth.net
 * @since      1.0.0
 *
 * @package    Gbyc
 * @subpackage Gbyc/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Gbyc
 * @subpackage Gbyc/public
 * @author     Modern Earth <info@modernearth.net>
 */
class Gbyc_Public
{

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Gbyc_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Gbyc_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/gbyc-public.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Gbyc_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Gbyc_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/gbyc-public.js', array('jquery'), $this->version, false);
	}

	//enable only the settings that match the current country
	function gbyc_payment_gateway_by_country($available_gateways)
	{

		$default = esc_html(get_option('wc_gbyc_default'));
		$country1 = esc_html(get_option('wc_gbyc_country1'));
		$country2 = esc_html(get_option('wc_gbyc_country2'));
		$gateway1 = esc_html(get_option('wc_gbyc_gateway1'));
		$gateway2 = esc_html(get_option('wc_gbyc_gateway2'));

		if ($default && WC()->customer != NULL && !is_account_page()) {
			$new_gateways = array();
			if ($country1 && $gateway1 && WC()->customer->get_billing_country() == $country1) {
				$new_gateways[$gateway1] = $available_gateways[$gateway1];
			} elseif ($country2 && $gateway2 && WC()->customer->get_billing_country() == $country2) {
				$new_gateways[$gateway2] = $available_gateways[$gateway2];
			} else {
				$new_gateways[$default] = $available_gateways[$default];
			}

			return $new_gateways;
		}

		return $available_gateways;
	}
}
