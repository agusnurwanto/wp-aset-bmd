<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://github.com/agusnurwanto
 * @since      1.0.0
 *
 * @package    Wp_Aset_Bmd
 * @subpackage Wp_Aset_Bmd/includes
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
 * @package    Wp_Aset_Bmd
 * @subpackage Wp_Aset_Bmd/includes
 * @author     Agus Nurwanto <agusnurwantomuslim@gmail.com>
 */
class Wp_Aset_Bmd {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Wp_Aset_Bmd_Loader    $loader    Maintains and registers all hooks for the plugin.
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
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;
	protected $functions;

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
		if ( defined( 'WP_ASET_BMD_VERSION' ) ) {
			$this->version = WP_ASET_BMD_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'wp-aset-bmd';

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
	 * - Wp_Aset_Bmd_Loader. Orchestrates the hooks of the plugin.
	 * - Wp_Aset_Bmd_i18n. Defines internationalization functionality.
	 * - Wp_Aset_Bmd_Admin. Defines all hooks for the admin area.
	 * - Wp_Aset_Bmd_Public. Defines all hooks for the public side of the site.
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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-aset-bmd-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-aset-bmd-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wp-aset-bmd-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wp-aset-bmd-public.php';

		$this->loader = new Wp_Aset_Bmd_Loader();

		// Functions tambahan
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-wp-aset-bmd-functions.php';

		$this->functions = new Wp_Aset_Bmd_Simda( $this->plugin_name, $this->version );

		$this->loader->add_action('template_redirect', $this->functions, 'allow_access_private_post', 0);

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Wp_Aset_Bmd_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Wp_Aset_Bmd_i18n();

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

		$plugin_admin = new Wp_Aset_Bmd_Admin( $this->get_plugin_name(), $this->get_version(), $this->functions );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action('carbon_fields_register_fields', $plugin_admin, 'crb_attach_simda_options');

		// untuk memfilter request post di dasboard wordpress
		// $this->loader->add_filter('posts_where_request', $plugin_admin, 'posts_where_request');

		$this->loader->add_action('wp_ajax_generate_user_aset',  $plugin_admin, 'generate_user_aset');	
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Wp_Aset_Bmd_Public( $this->get_plugin_name(), $this->get_version(), $this->functions );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		$this->loader->add_action('wp_ajax_get_total_skpd_all',  $plugin_public, 'get_total_skpd_all');
		$this->loader->add_action('wp_ajax_nopriv_get_total_skpd_all',  $plugin_public, 'get_total_skpd_all');

		$this->loader->add_action('wp_ajax_get_total_skpd',  $plugin_public, 'get_total_skpd');
		$this->loader->add_action('wp_ajax_nopriv_get_total_skpd',  $plugin_public, 'get_total_skpd');

		$this->loader->add_action('wp_ajax_get_rek_barang',  $plugin_public, 'get_rek_barang');
		$this->loader->add_action('wp_ajax_nopriv_get_rek_barang',  $plugin_public, 'get_rek_barang');

		$this->loader->add_action('wp_ajax_get_data_barang',  $plugin_public, 'get_data_barang');
		$this->loader->add_action('wp_ajax_nopriv_get_data_barang',  $plugin_public, 'get_data_barang');

		$this->loader->add_action('wp_ajax_simpan_aset_belum_masuk_neraca',  $plugin_public, 'simpan_aset_belum_masuk_neraca');
		$this->loader->add_action('wp_ajax_simpan_aset',  $plugin_public, 'simpan_aset');
		$this->loader->add_action('wp_ajax_simpan_temuan_bpk',  $plugin_public, 'simpan_temuan_bpk');

		add_shortcode('dashboard_aset',  array($plugin_public, 'dashboard_aset'));
		add_shortcode('dashboard_galeri',  array($plugin_public, 'dashboard_galeri'));
		add_shortcode('dashboard_aset_pemda',  array($plugin_public, 'dashboard_aset_pemda'));
		add_shortcode('daftar_aset',  array($plugin_public, 'daftar_aset'));
		add_shortcode('detail_aset',  array($plugin_public, 'detail_aset'));
		add_shortcode('dashboard_aset_disewakan',  array($plugin_public, 'dashboard_aset_disewakan'));
		add_shortcode('dashboard_aset_user',  array($plugin_public, 'dashboard_aset_user'));
		add_shortcode('dashboard_aset_tanah',  array($plugin_public, 'dashboard_aset_tanah'));
		add_shortcode('aset_per_unit',  array($plugin_public, 'aset_per_unit'));
		add_shortcode('peta_aset',  array($plugin_public, 'peta_aset'));
		add_shortcode('klasifikasi_aset',  array($plugin_public, 'klasifikasi_aset'));
		add_shortcode('aset_perlu_tindak_lanjut',  array($plugin_public, 'aset_perlu_tindak_lanjut'));
		add_shortcode('petunjuk_penggunaan',  array($plugin_public, 'petunjuk_penggunaan'));
		add_shortcode('aset_belum_masuk_neraca',  array($plugin_public, 'aset_belum_masuk_neraca'));
		add_shortcode('tambah_aset_belum_masuk_neraca',  array($plugin_public, 'tambah_aset_belum_masuk_neraca'));
		add_shortcode('get_all_posts',  array($plugin_public, 'get_all_posts'));
		add_shortcode('tambah_data_temuan_bpk',  array($plugin_public, 'tambah_data_temuan_bpk'));
		add_shortcode('temuan_bpk',  array($plugin_public, 'temuan_bpk'));
		add_shortcode('mutasi_aset',  array($plugin_public, 'mutasi_aset'));
		add_shortcode('tanggapan_publik',  array($plugin_public, 'tanggapan_publik'));
		add_shortcode('update_release',  array($plugin_public, 'update_release'));
		add_shortcode('dokumentasi_sistem',  array($plugin_public, 'dokumentasi_sistem'));
		add_shortcode('cek_plat_no',  array($plugin_public, 'cek_plat_no'));
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
	 * @return    Wp_Aset_Bmd_Loader    Orchestrates the hooks of the plugin.
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

}
