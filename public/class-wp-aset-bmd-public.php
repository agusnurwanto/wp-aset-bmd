<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/agusnurwanto
 * @since      1.0.0
 *
 * @package    Wp_Aset_Bmd
 * @subpackage Wp_Aset_Bmd/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wp_Aset_Bmd
 * @subpackage Wp_Aset_Bmd/public
 * @author     Agus Nurwanto <agusnurwantomuslim@gmail.com>
 */
class Wp_Aset_Bmd_Public {

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

	private $functions;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version, $functions ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->functions = $functions;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Aset_Bmd_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Aset_Bmd_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-aset-bmd-public.css', array(), $this->version, 'all' );
		wp_enqueue_style($this->plugin_name . 'bootstrap', plugin_dir_url(__FILE__) . 'css/bootstrap.min.css', array(), $this->version, 'all');
		wp_enqueue_style($this->plugin_name . 'select2', plugin_dir_url(__FILE__) . 'css/select2.min.css', array(), $this->version, 'all');
		wp_enqueue_style($this->plugin_name . 'datatables', plugin_dir_url(__FILE__) . 'css/jquery.dataTables.min.css', array(), $this->version, 'all');

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Aset_Bmd_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Aset_Bmd_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-aset-bmd-public.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script($this->plugin_name . 'bootstrap', plugin_dir_url(__FILE__) . 'js/bootstrap.bundle.min.js', array('jquery'), $this->version, false);
		wp_enqueue_script($this->plugin_name . 'select2', plugin_dir_url(__FILE__) . 'js/select2.min.js', array('jquery'), $this->version, false);
		wp_enqueue_script($this->plugin_name . 'datatables', plugin_dir_url(__FILE__) . 'js/jquery.dataTables.min.js', array('jquery'), $this->version, false);
		wp_localize_script( $this->plugin_name, 'ajax', array(
		    'url' => admin_url( 'admin-ajax.php' )
		));

	}

	function dashboard_aset(){
		// untuk disable render shortcode di halaman edit page/post
		if(!empty($_GET) && !empty($_GET['post'])){
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-aset-bmd-dasboard-aset.php';
	}

	function detail_aset($atts){
		// untuk disable render shortcode di halaman edit page/post
		if(!empty($_GET) && !empty($_GET['post'])){
			return '';
		}
		global $post;
		global $wpdb;
		$params = shortcode_atts( array(
			'kd_lokasi' => '0.0.0.0.0.0.0.0',
			'kd_barang' => '0.0.0.0.0.0.0',
			'kd_register' => '0',
			'jenis_aset' => ''
		), $atts );
		$kd_lokasi = explode('.', $params['kd_lokasi']);
		$Kd_Prov = (int) $kd_lokasi[1];
        $Kd_Kab_Kota = (int) $kd_lokasi[2];
        $Kd_Bidang = (int) $kd_lokasi[3];
        $Kd_Unit = (int) $kd_lokasi[4];
        $Kd_Sub = (int) $kd_lokasi[5];
        $Kd_UPB = (int) $kd_lokasi[6];
        $Kd_Kecamatan = (int) $kd_lokasi[7];
        $Kd_Desa = (int) $kd_lokasi[8];

		$kd_barang = explode('.', $params['kd_barang']);
		$Kd_Aset8 = (int) $kd_barang[0];
		$Kd_Aset80 = (int) $kd_barang[1];
		$Kd_Aset81 = (int) $kd_barang[2];
		$Kd_Aset82 = (int) $kd_barang[3];
		$Kd_Aset83 = (int) $kd_barang[4];
		$Kd_Aset84 = (int) $kd_barang[5];
		$Kd_Aset85 = (int) $kd_barang[6];
		$No_Reg8 = (int) $params['kd_register'];

		$nama_skpd = $this->functions->CurlSimda(array(
    		'query' => "
				SELECT Nm_UPB 
				from ref_upb 
				where Kd_Prov = $Kd_Prov
	            AND Kd_Kab_Kota = $Kd_Kab_Kota 
	            AND Kd_Bidang = $Kd_Bidang 
	            AND Kd_Unit = $Kd_Unit 
	            AND Kd_Sub = $Kd_Sub 
	            AND Kd_UPB = $Kd_UPB
			",
			'no_debug' => 0
		));
		$params['nama_skpd'] = $nama_skpd[0]->Nm_UPB;
		$nama_pemda = get_option('_crb_bmd_nama_pemda');
		$tahun_anggaran = get_option('_crb_bmd_tahun_anggaran');
		$api_key = get_option( '_crb_apikey_simda_bmd' );
        if($params['jenis_aset'] == 'tanah'){
			require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-aset-bmd-detail-aset-tanah.php';
        }
	}

	function daftar_aset(){
		// untuk disable render shortcode di halaman edit page/post
		if(!empty($_GET) && !empty($_GET['post'])){
			return '';
		}
		if(empty($_GET['key'])){
		    die('Halaman tidak dapat diakses!');
		}
		global $wpdb;
		$nama_pemda = get_option('_crb_bmd_nama_pemda');
		$tahun_anggaran = get_option('_crb_bmd_tahun_anggaran');
		$api_key = get_option( '_crb_apikey_simda_bmd' );
		$params = $this->functions->decode_key($_GET['key']);

		$limit = '';
		if(
		    !empty($_GET)
		    && !empty($_GET['limit'])
		    && is_numeric($_GET['limit'])
		){
		    $limit = 'top '.$_GET['limit'];
		}
		if(!empty($params['kd_lokasi'])){
			$kd_lokasi = explode('.', $params['kd_lokasi']);
			$Kd_Prov = (int) $kd_lokasi[1];
            $Kd_Kab_Kota = (int) $kd_lokasi[2];
            $Kd_Bidang = (int) $kd_lokasi[3];
            $Kd_Unit = (int) $kd_lokasi[4];
            $Kd_Sub = (int) $kd_lokasi[5];
            $Kd_UPB = (int) $kd_lokasi[6];
            $Kd_Kecamatan = (int) $kd_lokasi[7];
            $Kd_Desa = (int) $kd_lokasi[8];
			require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-aset-bmd-daftar-aset-rinci.php';
		}else{
			require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-aset-bmd-daftar-aset.php';
		}
	}

	function get_link_daftar_aset($options=array('get' => array())){
		$custom_url = array();
		foreach($options['get'] as $key => $val){
			$custom_url[] = array('key' => $key, 'value' => $val);
		}
		$link = $this->functions->generatePage(array(
			'nama_page' => 'Daftar Aset Barang Milik Daerah',
			'content' => '[daftar_aset]',
			'post_status' => 'public',
			'custom_url' => $custom_url
		));
		return $link['url'];
	}

	function get_total_skpd(){
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil total aset SKPD!'
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option( '_crb_apikey_simda_bmd' )) {
				if (!empty($_POST['data'])) {
					$where = ' where Kd_Prov=\''.$_POST['data']['Kd_Prov'].'\' and Kd_Kab_Kota=\''.$_POST['data']['Kd_Kab_Kota'].'\' and Kd_Bidang=\''.$_POST['data']['Kd_Bidang'].'\' and Kd_Unit=\''.$_POST['data']['Kd_Unit'].'\' and Kd_Sub=\''.$_POST['data']['Kd_Sub'].'\' and Kd_UPB=\''.$_POST['data']['Kd_UPB'].'\'';
				    if(!empty($_POST['data']['Kd_Kecamatan'])){
				        $where .= ' and Kd_Kecamatan=\''.$_POST['data']['Kd_Kecamatan'].'\'';
				    }else{
				        $where .= ' and Kd_Kecamatan is null';
				    }
				    if(!empty($_POST['data']['Kd_Desa'])){
				        $where .= ' and Kd_Desa=\''.$_POST['data']['Kd_Desa'].'\'';
				    }else{
				        $where .= ' and Kd_Desa is null';
				    }

				    $harga = 0;
				    if(empty($_POST['jenis_aset']) || $_POST['jenis_aset'] == 'tanah'){
					    $tanah = $this->functions->CurlSimda(array(
					        'query' => 'select sum(Luas_M2) as jml, COUNT(*) as jml_bidang, sum(Harga) as harga from ta_kib_a'.$where,
					        'no_debug' => 1
					    ));
				    	$harga += $tanah[0]->harga;
					}
				    if(empty($_POST['jenis_aset']) || $_POST['jenis_aset'] == 'mesin'){
					    $mesin = $this->functions->CurlSimda(array(
					        'query' => 'select COUNT(*) as jml, sum(Harga) as harga from ta_kib_b'.$where,
					        'no_debug' => 1
					    ));
				    	$harga += $mesin[0]->harga;
				    }
				    if(empty($_POST['jenis_aset']) || $_POST['jenis_aset'] == 'bangunan'){
					    $gedung = $this->functions->CurlSimda(array(
					        'query' => 'select COUNT(*) as jml, sum(Harga) as harga from ta_kib_c'.$where,
					        'no_debug' => 1
					    ));
				    	$harga += $gedung[0]->harga;
				    }
				    if(empty($_POST['jenis_aset']) || $_POST['jenis_aset'] == 'jalan'){
					    $jalan = $this->functions->CurlSimda(array(
					        'query' => 'select sum(Panjang) as jml, sum(Harga) as harga from ta_kib_d'.$where,
					        'no_debug' => 1
					    ));
				    	$harga += $jalan[0]->harga;
				    }
				    if(empty($_POST['jenis_aset']) || $_POST['jenis_aset'] == 'aset_tetap'){
					    $tetap_lainnya = $this->functions->CurlSimda(array(
					        'query' => 'select COUNT(*) as jml, sum(Harga) as harga from ta_kib_e'.$where,
					        'no_debug' => 1
					    ));
				    	$harga += $tetap_lainnya[0]->harga;
				    }
				    if(empty($_POST['jenis_aset']) || $_POST['jenis_aset'] == 'bangunan_dalam_pengerjaan'){
					    $gedung_pengerjaan = $this->functions->CurlSimda(array(
					        'query' => 'select COUNT(*) as jml, sum(Harga) as harga from ta_kib_f'.$where,
					        'no_debug' => 1
					    ));
				    	$harga += $gedung_pengerjaan[0]->harga;
				    }
				    $jenis_aset = '';
				    if(!empty($_POST['jenis_aset'])){
				    	$jenis_aset = $_POST['jenis_aset'];
				    }
				    $ret['data'] = array(
				    	'tanah' => $tanah,
				    	'mesin' => $mesin,
				    	'gedung' => $gedung,
				    	'jalan' => $jalan,
				    	'tetap_lainnya' => $tetap_lainnya,
				    	'gedung_pengerjaan' => $gedung_pengerjaan,
				    	'kd_lokasi' => $_POST['data']['kd_lokasi'],
				    	'total' => number_format($harga,2,",","."),
				    	'total_asli' => $harga,
				    	'jenis_aset' => $jenis_aset,
				    	'where' => $where
				    );
				} else {
					$ret['status'] = 'error';
					$ret['message'] = 'Format ID SKPD Salah!';
				}
			} else {
				$ret['status'] = 'error';
				$ret['message'] = 'APIKEY tidak sesuai!';
			}
		}
		die(json_encode($ret));
	}

	function get_nama_jenis_aset($options=array()){
		$nama_jenis_aset = '';
		$table_simda = '';
		if($options['jenis_aset'] == 'tanah'){
		    $nama_jenis_aset = 'Aset Tanah';
		    $table_simda = 'Ta_KIB_A';
		}else if($options['jenis_aset'] == 'mesin'){
		    $nama_jenis_aset = 'Aset Mesin';
		    $table_simda = 'Ta_KIB_B';
		}else if($options['jenis_aset'] == 'bangunan'){
		    $nama_jenis_aset = 'Aset Bangunan';
		    $table_simda = 'Ta_KIB_C';
		}else if($options['jenis_aset'] == 'jalan'){
		    $nama_jenis_aset = 'Aset Jalan Irigrasi';
		    $table_simda = 'Ta_KIB_D';
		}else if($options['jenis_aset'] == 'aset_tetap'){
		    $nama_jenis_aset = 'Aset Tetap seperti buku, tanaman, hewan';
		    $table_simda = 'Ta_KIB_E';
		}else if($options['jenis_aset'] == 'bangunan_dalam_pengerjaan'){
		    $nama_jenis_aset = 'Aset Kontruksi Dalam Pengerjaan';
		    $table_simda = 'Ta_KIB_F';
		}
		return array(
			'nama' => $nama_jenis_aset,
			'table_simda' => $table_simda
		);
	}

	function cek_edit_post($options){
		$cek_edit = false;
		if(is_user_logged_in()){
		    $user_id = get_current_user_id();
		    $cek_lokasi = true;
		    if($this->functions->user_has_role($user_id, 'user_aset_skpd')){
		    	$kd_lokasi_user = get_user_meta($user_id, '_crb_kd_lokasi', true);
		    	$cek_lokasi = false;
		    	if(!empty($kd_lokasi_user)){
		    		$lok = explode('.', $kd_lokasi_user);
		    		if(
		    			(!empty($lok[0]) && $lok[0] == $options['Kd_Prov'])
		    			&& (!empty($lok[1]) && $lok[1] == $options['Kd_Kab_Kota'])
		    			&& (!empty($lok[2]) && $lok[2] == $options['Kd_Bidang'])
		    			&& (!empty($lok[3]) && $lok[3] == $options['Kd_Unit'])
		    			&& (!empty($lok[4]) && $lok[4] == $options['Kd_Sub'])
		    			&& (!empty($lok[5]) && $lok[5] == $options['Kd_UPB'])
		    			&& (!empty($lok[6]) && $lok[6] == $options['Kd_Kecamatan'])
		    			&& (!empty($lok[7]) && $lok[7] == $options['Kd_Desa'])
		    		){
		    			$cek_lokasi = true;
		    		}
		    	}
		    }
		    if($this->functions->user_has_role($user_id, 'user_aset_unit_skpd')){
		    	$kd_lokasi_user = get_user_meta($user_id, '_crb_kd_lokasi', true);
		    	$cek_lokasi = false;
		    	if(!empty($kd_lokasi_user)){
		    		$lok = explode('.', $kd_lokasi_user);
		    		if(
		    			(!empty($lok[0]) && $lok[0] == $options['Kd_Prov'])
		    			&& (!empty($lok[1]) && $lok[1] == $options['Kd_Kab_Kota'])
		    			&& (!empty($lok[2]) && $lok[2] == $options['Kd_Bidang'])
		    			&& (!empty($lok[3]) && $lok[3] == $options['Kd_Unit'])
		    		){
		    			$cek_lokasi = true;
		    		}
		    	}
		    }
		    if($this->functions->user_has_role($user_id, 'user_aset_sub_unit_skpd')){
		    	$kd_lokasi_user = get_user_meta($user_id, '_crb_kd_lokasi', true);
		    	$cek_lokasi = false;
		    	if(!empty($kd_lokasi_user)){
		    		$lok = explode('.', $kd_lokasi_user);
		    		if(
		    			(!empty($lok[0]) && $lok[0] == $options['Kd_Prov'])
		    			&& (!empty($lok[1]) && $lok[1] == $options['Kd_Kab_Kota'])
		    			&& (!empty($lok[2]) && $lok[2] == $options['Kd_Bidang'])
		    			&& (!empty($lok[3]) && $lok[3] == $options['Kd_Unit'])
		    			&& (!empty($lok[4]) && $lok[4] == $options['Kd_Sub'])
		    		){
		    			$cek_lokasi = true;
		    		}
		    	}
		    }
		    if(
		        $cek_lokasi
		        || $this->functions->user_has_role($user_id, 'administrator')
		    ){
		        $cek_edit = true;
		    }
		}
		return $cek_edit;
	}
}
