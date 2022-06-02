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
		wp_enqueue_script($this->plugin_name . 'chart', plugin_dir_url(__FILE__) . 'js/chart.min.js', array('jquery'), $this->version, false);
		wp_localize_script( $this->plugin_name, 'ajax', array(
		    'url' => admin_url( 'admin-ajax.php' )
		));
		wp_enqueue_style( 'dashicons' );

	}

	function tambah_aset_belum_masuk_neraca(){
		global $post;
		if(!empty($_GET) && !empty($_GET['post'])){
			return '';
		}
		$disabled = '';
		$edit = false;
		if(!empty($_GET) && !empty($_GET['key'])){
			$params['key'] = $this->functions->decode_key($_GET['key']);
			if(!empty($params['key']['jenis_aset'])){
				$jenis_aset = $params['key']['jenis_aset'];
			}else if(!empty($params['key']['detail'])){
				$disabled = 'disabled';
			}else if(!empty($params['key']['edit'])){
				$edit = true;
			}
		}
		if(false == $edit && $disabled == ''){
			$abm_kd_upb = '';
			$abm_jenis_aset = '';
			$abm_nama_upb = '';
			$abm_kd_barang = '';
			$abm_kd_register = '';
			$abm_nama_aset = '';
			$abm_penggunaan = '';
			$abm_luas = '';
			$abm_alamat = '';
			$abm_tgl_pengadaan = '';
			$abm_hak = '';
			$abm_tgl_sertifikat = '';
			$abm_nomor_sertifikat = '';
			$abm_asal_usul = '';
			$abm_harga = '';
			$abm_keterangan = '';
			$koordinatX = '';
			$koordinatY = '';
			$polygon = '';
			$abm_meta_sejarah = '';
			$abm_meta_kronologi = '';
			$abm_meta_foto = '';
			$abm_meta_video = '';
			$abm_meta_disewakan = '';
			$abm_meta_nilai_sewa = '';
			$abm_meta_nama_sewa = '';
			$abm_meta_alamat_sewa = '';
			$abm_meta_waktu_sewa_awal = '';
			$abm_meta_waktu_sewa_akhir = '';
			$abm_meta_aset_perlu_tindak_lanjut = '';
			$abm_meta_keterangan_aset_perlu_tindak_lanjut = '';
			$abm_meta_ket_penggunaan_aset = '';
			$abm_meta_kondisi_aset_simata = '';
			$abm_meta_keterangan_kondisi_aset = '';
			$abm_meta_ket_potensi_penggunaan = '';
		}else{
			$abm_kd_upb = get_post_meta($post->ID, 'abm_kd_upb', true);
			$abm_jenis_aset = get_post_meta($post->ID, 'abm_jenis_aset', true);
			$abm_nama_upb = get_post_meta($post->ID, 'abm_nama_upb', true);
			$abm_kd_barang = get_post_meta($post->ID, 'abm_kd_barang', true);
			$abm_kd_register = get_post_meta($post->ID, 'abm_kd_register', true);
			$abm_nama_aset = get_post_meta($post->ID, 'abm_nama_aset', true);
			$abm_penggunaan = get_post_meta($post->ID, 'abm_penggunaan', true);
			$abm_luas = get_post_meta($post->ID, 'abm_luas', true);
			$abm_alamat = get_post_meta($post->ID, 'abm_alamat', true);
			$abm_tgl_pengadaan = get_post_meta($post->ID, 'abm_tgl_pengadaan', true);
			$abm_hak = get_post_meta($post->ID, 'abm_hak', true);
			$abm_tgl_sertifikat = get_post_meta($post->ID, 'abm_tgl_sertifikat', true);
			$abm_nomor_sertifikat = get_post_meta($post->ID, 'abm_nomor_sertifikat', true);
			$abm_asal_usul = get_post_meta($post->ID, 'abm_asal_usul', true);
			$abm_harga = get_post_meta($post->ID, 'abm_harga', true);
			$abm_keterangan = get_post_meta($post->ID, 'abm_keterangan', true);
			$koordinatX = get_post_meta($post->ID, 'abm_latitude', true);
			$koordinatY = get_post_meta($post->ID, 'abm_longitude', true);
			$polygon = get_post_meta($post->ID, 'abm_polygon', true);
			$abm_meta_sejarah = get_post_meta($post->ID, 'abm_meta_sejarah', true);
			$abm_meta_kronologi = get_post_meta($post->ID, 'abm_meta_kronologi', true);
			$abm_meta_foto = get_post_meta($post->ID, 'abm_meta_foto', true);
			$abm_meta_video = get_post_meta($post->ID, 'abm_meta_video', true);
			$abm_meta_disewakan = get_post_meta($post->ID, 'abm_meta_disewakan', true);
			$abm_meta_nilai_sewa = get_post_meta($post->ID, 'abm_meta_nilai_sewa', true);
			$abm_meta_nama_sewa = get_post_meta($post->ID, 'abm_meta_nama_sewa', true);
			$abm_meta_alamat_sewa = get_post_meta($post->ID, 'abm_meta_alamat_sewa', true);
			$abm_meta_waktu_sewa_awal = get_post_meta($post->ID, 'abm_meta_waktu_sewa_awal', true);
			$abm_meta_waktu_sewa_akhir = get_post_meta($post->ID, 'abm_meta_waktu_sewa_akhir', true);
			$abm_meta_aset_perlu_tindak_lanjut = get_post_meta($post->ID, 'abm_meta_aset_perlu_tindak_lanjut', true);
			$abm_meta_keterangan_aset_perlu_tindak_lanjut = get_post_meta($post->ID, 'abm_meta_keterangan_aset_perlu_tindak_lanjut', true);
			$abm_meta_ket_penggunaan_aset = get_post_meta($post->ID, 'abm_meta_ket_penggunaan_aset', true);
			$abm_meta_kondisi_aset_simata = get_post_meta($post->ID, 'abm_meta_kondisi_aset_simata', true);
			$abm_meta_keterangan_kondisi_aset = get_post_meta($post->ID, 'abm_meta_keterangan_kondisi_aset', true);
			$abm_meta_ket_potensi_penggunaan = get_post_meta($post->ID, 'abm_meta_ket_potensi_penggunaan', true);
			$jenis_aset = $abm_jenis_aset;
		}

		$checked_sewa = '';
		$checked_tidak_sewa = 'checked';
		$potensi_disewakan = '';
		if($abm_meta_disewakan == '1'){
			$checked_sewa = 'checked';
			$checked_tidak_sewa = '';
			$potensi_disewakan = '';
		}else if($abm_meta_disewakan == '3'){
			$checked_sewa = '';
			$checked_tidak_sewa = '';
			$potensi_disewakan = 'checked';
		}
		$checked_tindak_lanjut = '';
		if($abm_meta_aset_perlu_tindak_lanjut == '1'){
			$checked_tindak_lanjut = 'checked';
		}
		$checked_private = '';
		$checked_publish = 'checked';
		if($post->post_status == 'private'){
			$checked_private = 'checked';
			$checked_publish = '';
		}
		$lat_default = $koordinatX;
		$lng_default = $koordinatY;
		if(empty($lat_default) || empty($lng_default)){
			$center_map_default = get_option('_crb_google_map_center');
			if(!empty($center_map_default)){
				$center_map_default = explode(',', $center_map_default);
				$lat_default = $center_map_default[0];
				$lng_default = $center_map_default[1];
			}
		}
		if(empty($koordinatX)){
			$koordinatX = 0;
		}
		if(empty($koordinatY)){
			$koordinatY = 0;
		}
		if(empty($polygon)){
			$polygon = '[]';
		}

		$aset_belum_masuk_neraca = $this->functions->generatePage(array(
			'nama_page' => 'Aset Belum Masuk Neraca',
			'content' => '[aset_belum_masuk_neraca]',
        	'show_header' => 1,
        	'no_key' => 1,
			'post_status' => 'publish'
		));

		$Kd_Prov = 0;
        $Kd_Kab_Kota = 0;
        $Kd_Bidang = 0;
        $Kd_Unit = 0;
        $Kd_Sub = 0;
        $Kd_UPB = 0;
        $Kd_Kecamatan = 0;
        $Kd_Desa = 0;
		if(!empty($abm_kd_upb)){
			$kd_lokasi = explode('.', $abm_kd_upb);
			$Kd_Prov = (int) $kd_lokasi[1];
	        $Kd_Kab_Kota = (int) $kd_lokasi[2];
	        $Kd_Bidang = (int) $kd_lokasi[3];
	        $Kd_Unit = (int) $kd_lokasi[4];
	        $Kd_Sub = (int) $kd_lokasi[5];
	        $Kd_UPB = (int) $kd_lokasi[6];
	        $Kd_Kecamatan = (int) $kd_lokasi[7];
	        $Kd_Desa = (int) $kd_lokasi[8];
	    }
		$allow_edit_post = $this->cek_edit_post(array(
		    'Kd_Prov' => $Kd_Prov,
		    'Kd_Kab_Kota' => $Kd_Kab_Kota,
		    'Kd_Bidang' => $Kd_Bidang,
		    'Kd_Unit' => $Kd_Unit,
		    'Kd_Sub' => $Kd_Sub,
		    'Kd_UPB' => $Kd_UPB,
		    'Kd_Kecamatan' => $Kd_Kecamatan,
		    'Kd_Desa' => $Kd_Desa
		));
	    $user_id = get_current_user_id();
	    if($allow_edit_post){
	    	$post->custom_url = array(
	            array(
	                'key' =>'edit',
	                'value' => 1
	            )
	        );
	        $link_edit = $this->functions->get_link_post($post);

	        $daftar_abm = $aset_belum_masuk_neraca['post'];
	    	$daftar_abm->custom_url = array(
	            array(
	                'key' =>'delete',
	                'value' => $post->ID
	            ),
	            array(
	                'key' =>'skip',
	                'value' => 1
	            )
	        );
	        $link_delete = $this->functions->get_link_post($daftar_abm);
	    }

		$data_jenis = $this->get_nama_jenis_aset(array('jenis_aset' => $jenis_aset));
		
		if($data_jenis['jenis'] == 'tanah'){
			require_once BMD_PLUGIN_PATH . 'public/partials/wp-aset-bmd-tambah-tanah-belum-masuk-neraca.php';
		}else{
			echo "Jenis aset tidak ditemukan!";
		}
	}

	function aset_belum_masuk_neraca(){
		if(!empty($_GET) && !empty($_GET['post'])){
			return '';
		}
		require_once BMD_PLUGIN_PATH . 'public/partials/wp-aset-bmd-belum-masuk-neraca.php';
	}

	function petunjuk_penggunaan(){
		if(!empty($_GET) && !empty($_GET['post'])){
			return '';
		}
		require_once BMD_PLUGIN_PATH . 'public/partials/wp-aset-bmd-petunjuk-penggunaan.php';
	}

	function klasifikasi_aset(){
		if(!empty($_GET) && !empty($_GET['post'])){
			return '';
		}
		require_once BMD_PLUGIN_PATH . 'public/partials/wp-aset-bmd-klasifikasi-aset.php';
	}

	function peta_aset(){
		if(!empty($_GET) && !empty($_GET['post'])){
			return '';
		}
		require_once BMD_PLUGIN_PATH . 'public/partials/wp-aset-bmd-peta-aset.php';
	}

	function aset_per_unit(){
		if(!empty($_GET) && !empty($_GET['post'])){
			return '';
		}
		require_once BMD_PLUGIN_PATH . 'public/partials/wp-aset-bmd-per-sub-unit.php';
	}

	function dashboard_aset(){
		// untuk disable render shortcode di halaman edit page/post
		if(!empty($_GET) && !empty($_GET['post'])){
			return '';
		}
		require_once BMD_PLUGIN_PATH . 'public/partials/wp-aset-bmd-homepage.php';
	}

	function dashboard_galeri(){
		// untuk disable render shortcode di halaman edit page/post
		if(!empty($_GET) && !empty($_GET['post'])){
			return '';
		}
		require_once BMD_PLUGIN_PATH . 'public/partials/wp-aset-bmd-galeri.php';
	}

	function dashboard_aset_pemda(){
		// untuk disable render shortcode di halaman edit page/post
		if(!empty($_GET) && !empty($_GET['post'])){
			return '';
		}
		require_once BMD_PLUGIN_PATH . 'public/partials/wp-aset-bmd-total-aset-pemda.php';
	}

	function dashboard_aset_tanah(){
		// untuk disable render shortcode di halaman edit page/post
		if(!empty($_GET) && !empty($_GET['post'])){
			return '';
		}
		$api_googlemap = get_option( '_crb_google_api' );
		$api_googlemap = "https://maps.googleapis.com/maps/api/js?key=$api_googlemap&callback=initMap&libraries=places";
		require_once BMD_PLUGIN_PATH . 'public/partials/wp-aset-bmd-aset-tanah.php';
	}

	function dashboard_aset_disewakan($atts){
		// untuk disable render shortcode di halaman edit page/post
		if(!empty($_GET) && !empty($_GET['post'])){
			return '';
		}
		$params = shortcode_atts( array(
			'potensi' => '0'
		), $atts );
		$api_googlemap = get_option( '_crb_google_api' );
		$api_googlemap = "https://maps.googleapis.com/maps/api/js?key=$api_googlemap&callback=initMap&libraries=places";
		if($params['potensi'] == 1){
			require_once BMD_PLUGIN_PATH . 'public/partials/wp-aset-bmd-dasboard-potensi-aset-disewakan.php';
		}else{
			require_once BMD_PLUGIN_PATH . 'public/partials/wp-aset-bmd-dasboard-aset-disewakan.php';
		}
	}

	function aset_perlu_tindak_lanjut($atts){
		// untuk disable render shortcode di halaman edit page/post
		if(!empty($_GET) && !empty($_GET['post'])){
			return '';
		}
		// $params = shortcode_atts( array(
		// 	'potensi' => '0'
		// ), $atts );

		$api_googlemap = get_option( '_crb_google_api' );
		$api_googlemap = "https://maps.googleapis.com/maps/api/js?key=$api_googlemap&callback=initMap&libraries=places";
		require_once BMD_PLUGIN_PATH . 'public/partials/wp-aset-bmd-dasboard-perlu-tindak-lanjut.php';
	}

	function update_release(){
		if(!empty($_GET) && !empty($_GET['post'])){
			return '';
		}
		require_once BMD_PLUGIN_PATH . 'public/partials/wp-aset-bmd-release-update.php';
	}
	
	function dokumentasi_sistem(){
		if(!empty($_GET) && !empty($_GET['post'])){
			return '';
		}
		require_once BMD_PLUGIN_PATH . 'public/partials/wp-aset-bmd-dokumentasi-sistem.php';
	}

	function dashboard_aset_user(){
		// untuk disable render shortcode di halaman edit page/post
		if(!empty($_GET) && !empty($_GET['post'])){
			return '';
		}
		if(is_user_logged_in()){
			$user_id = um_user( 'ID' );
			$kd_lokasi_user = get_user_meta($user_id, '_crb_kd_lokasi', true);
			if(!empty($kd_lokasi_user)){
				$nama_skpd = get_user_meta($user_id, '_crb_nama_skpd', true);
		    	$link_detail_unit = $this->get_link_daftar_aset(
				    array('get' => 
				        array(
				            'kd_lokasi' => '12.'.$kd_lokasi_user, 
				            'nama_skpd' => $nama_skpd, 
				            'user' => 1, 
				            'daftar_aset' => 1
				        )
				    )
				);
				return '
				<ul style="text-align: center; margin-top: 15px;">
					<li style="list-style: none;"><a class="button button-primary" href="'.$link_detail_unit.'" target="_blank">Data Barang Milik Daerah '.$nama_skpd.'</a></li>
				</ul>';
		    }
		}
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
			'jenis_aset' => '',
			'key' => array()
		), $atts );
		if(!empty($_GET) && !empty($_GET['key'])){
			$params['key'] = $this->functions->decode_key($_GET['key']);
		}
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

		$sql = "
			SELECT 
				u.Nm_UPB, 
	            k.Nm_Kecamatan,
	            d.Nm_Desa
	        from ref_upb u
	        LEFT JOIN Ref_Kecamatan k ON k.Kd_Prov=u.Kd_Prov
	            AND k.Kd_Kab_Kota = u.Kd_Kab_Kota 
	            AND k.Kd_Kecamatan = u.Kd_Kecamatan
	        LEFT JOIN Ref_Desa d ON d.Kd_Prov=u.Kd_Prov
	            AND d.Kd_Kab_Kota = u.Kd_Kab_Kota 
	            AND d.Kd_Kecamatan = u.Kd_Kecamatan
	            AND d.Kd_Desa = u.Kd_Desa
			where u.Kd_Prov = $Kd_Prov
            AND u.Kd_Kab_Kota = $Kd_Kab_Kota 
            AND u.Kd_Bidang = $Kd_Bidang 
            AND u.Kd_Unit = $Kd_Unit 
            AND u.Kd_Sub = $Kd_Sub 
            AND u.Kd_UPB = $Kd_UPB
            AND (
            	u.Kd_Kecamatan = $Kd_Kecamatan
            	OR u.Kd_Kecamatan is null
            ) 
            AND (
            	u.Kd_Desa = $Kd_Desa
            	OR u.Kd_Desa is null
            )
		";
		$nama_skpd = $this->functions->CurlSimda(array(
    		'query' => $sql,
			'no_debug' => 0
		));
		$params['nama_skpd'] = '';
		if(!empty($nama_skpd) && !empty($nama_skpd[0]->Nm_UPB)){
			$params['nama_skpd'] = $nama_skpd[0]->Nm_UPB;
		}
		if(!empty($Kd_Kecamatan)){
			$sql = "
				SELECT 
		            k.Nm_Kecamatan
		        from Ref_Kecamatan k 
				where k.Kd_Prov = $Kd_Prov
	            AND k.Kd_Kab_Kota = $Kd_Kab_Kota 
	            AND k.Kd_Kecamatan = $Kd_Kecamatan
			";
			$kecamatan = $this->functions->CurlSimda(array(
	    		'query' => $sql,
				'no_debug' => 0
			));
			$params['kecamatan'] = $kecamatan[0]->Nm_Kecamatan;
		}else{
			$params['kecamatan'] = '';
		}
		if(!empty($Kd_Kecamatan) && !empty($Kd_Desa)){
			$sql = "
				SELECT 
		            d.Nm_Desa
		        from Ref_Desa d 
				where d.Kd_Prov = $Kd_Prov
	            AND d.Kd_Kab_Kota = $Kd_Kab_Kota 
	            AND d.Kd_Kecamatan = $Kd_Kecamatan
	            AND d.Kd_Desa = $Kd_Desa
			";
			$desa = $this->functions->CurlSimda(array(
	    		'query' => $sql,
				'no_debug' => 0
			));
			$params['desa'] = $desa[0]->Nm_Desa;
		}else{
			$params['kecamatan'] = '';
			$params['desa'] = '';
		}
		$nama_pemda = get_option('_crb_bmd_nama_pemda');
		$tahun_anggaran = get_option('_crb_bmd_tahun_anggaran');
		$api_key = get_option( '_crb_apikey_simda_bmd' );
		$data_jenis = $this->get_nama_jenis_aset(array('jenis_aset' => $params['jenis_aset']));
		$nama_jenis_aset = $data_jenis['nama'];
		$table_simda = $data_jenis['table_simda'];
		$api_googlemap = get_option( '_crb_google_api' );
		$api_googlemap = "https://maps.googleapis.com/maps/api/js?key=$api_googlemap&callback=initMap&libraries=places";
		
		if ($params['jenis_aset'] == 'tanah') {
			$warna_map = get_option('_crb_warna_tanah');
			$ikon_map  = get_option('_crb_icon_tanah');
		}

		if ($params['jenis_aset'] == 'bangunan') {
			$warna_map = get_option('_crb_warna_gedung');
			$ikon_map  = get_option('_crb_icon_gedung');
		}

		if ($params['jenis_aset'] == 'jalan') {
			$warna_map = get_option('_crb_warna_jalan');
			$ikon_map  = get_option('_crb_icon_jalan');
		}

		if(empty($nama_jenis_aset)){
		    die('Jenis Aset tidak ditemukan!');
		}

		$alamat = array();
		if(!empty($params['kecamatan'])){
		    $alamat[] = 'Kec. '.$params['kecamatan'];
		}
		if(!empty($params['desa'])){
		    $alamat[] = 'Desa/Kel. '.$params['desa'];
		}
		if(!empty($alamat)){
		    $alamat = '('.implode(', ', $alamat).')';
		}else{
		    $alamat = '';
		}

		$where = '';
		if(!empty($Kd_Kecamatan)){
		    $where .= $wpdb->prepare(' AND a.Kd_Kecamatan=%d', $Kd_Kecamatan);
		}
		if(!empty($Kd_Desa)){
		    $where .= $wpdb->prepare(' AND a.Kd_Desa=%d', $Kd_Desa);
		}

		$sql = $wpdb->prepare('
		    select 
		        a.*,
        		b.Harga as harga_asli,
		        r.Nm_Aset5
		    from '.$data_jenis['table_simda'].' a
    		LEFT JOIN '.$data_jenis['table_simda_harga'].' b ON a.IDPemda = b.IDPemda
	        LEFT JOIN Ref_Rek5_108 r on r.kd_aset=a.Kd_Aset8 
	            and r.kd_aset0=a.Kd_Aset80 
	            and r.kd_aset1=a.Kd_Aset81 
	            and r.kd_aset2=a.Kd_Aset82 
	            and r.kd_aset3=a.Kd_Aset83 
	            and r.kd_aset4=a.Kd_Aset84 
	            and r.kd_aset5=a.Kd_Aset85
		    where a.Kd_Prov=%d
		        AND a.Kd_Kab_Kota=%d 
		        AND a.Kd_Bidang=%d 
		        AND a.Kd_Unit=%d 
		        AND a.Kd_Sub=%d 
		        AND a.Kd_UPB=%d
		        AND a.Kd_Aset8=%d
		        AND a.Kd_Aset80=%d
		        AND a.Kd_Aset81=%d
		        AND a.Kd_Aset82=%d
		        AND a.Kd_Aset83=%d
		        AND a.Kd_Aset84=%d
		        AND a.Kd_Aset85=%d
		        AND a.No_Reg8=%d
		        '.$where.'
		    ',
		    $Kd_Prov,
		    $Kd_Kab_Kota,
		    $Kd_Bidang,
		    $Kd_Unit,
		    $Kd_Sub,
		    $Kd_UPB,
		    $Kd_Aset8,
		    $Kd_Aset80,
		    $Kd_Aset81,
		    $Kd_Aset82,
		    $Kd_Aset83,
		    $Kd_Aset84,
		    $Kd_Aset85,
		    $No_Reg8
		);
		$aset = $this->functions->CurlSimda(array(
		    'query' => $sql 
		));
		$aset[0]->Keterangan = trim(preg_replace('/\s\s+/', ' ', $aset[0]->Keterangan));
		$koordinatX = get_post_meta($post->ID, 'latitude', true);
		if(empty($koordinatX)){
		    $koordinatX = '0';
		}
		$koordinatY = get_post_meta($post->ID, 'longitude', true);
		if(empty($koordinatY)){
		    $koordinatY = '0';
		}
		$lat_default = $koordinatX;
		$lng_default = $koordinatY;
		if(empty($lat_default) || empty($lng_default)){
			$center_map_default = get_option('_crb_google_map_center');
			if(!empty($center_map_default)){
				$center_map_default = explode(',', $center_map_default);
				$lat_default = $center_map_default[0];
				$lng_default = $center_map_default[1];
			}
		}
		$polygon = get_post_meta($post->ID, 'polygon', true);
		if(empty($polygon)){
		    $polygon = '[]';
		}
		$meta_sejarah = get_post_meta($post->ID, 'meta_sejarah', true);
		$meta_kronologi = get_post_meta($post->ID, 'meta_kronologi', true);
		$meta_foto = get_post_meta($post->ID, 'meta_foto', true);
		$meta_video = get_post_meta($post->ID, 'meta_video', true);
		$meta_disewakan = get_post_meta($post->ID, 'meta_disewakan', true);
		$checked_sewa = '';
		$checked_tidak_sewa = 'checked';
		$potensi_disewakan = '';
		if($meta_disewakan == '1'){
			$checked_sewa = 'checked';
			$checked_tidak_sewa = '';
			$potensi_disewakan = '';
		}else if($meta_disewakan == '3'){
			$checked_sewa = '';
			$checked_tidak_sewa = '';
			$potensi_disewakan = 'checked';
		}
		$checked_private = '';
		$checked_publish = 'checked';
		if($post->post_status == 'private'){
			$checked_private = 'checked';
			$checked_publish = '';
		}
		$meta_tindak_lanjut = get_post_meta($post->ID, 'meta_aset_perlu_tindak_lanjut', true);
		$checked_tindak_lanjut = '';
		if($meta_tindak_lanjut == '1'){
			$checked_tindak_lanjut = 'checked';
		}
		$meta_mutasi_aset = get_post_meta($post->ID, 'meta_mutasi_aset', true);
		$checked_mutasi_aset = '';
		if($meta_mutasi_aset == '1'){
			$checked_mutasi_aset = 'checked';
		}
		$kondisi_aset_simata = get_post_meta($post->ID, 'meta_kondisi_aset_simata', true);

		$kondisi_simda = '';
		if(!empty($aset[0]->Kondisi)){
			$kondisi_simda = $this->get_kondisi_simda($aset[0]->Kondisi);
		}

		$nilai_sewa = get_post_meta($post->ID, 'meta_nilai_sewa', true);
		$nama_sewa = get_post_meta($post->ID, 'meta_nama_sewa', true);
		$alamat_sewa = get_post_meta($post->ID, 'meta_alamat_sewa', true);
		$waktu_sewa_awal = get_post_meta($post->ID, 'meta_waktu_sewa_awal', true);
		$waktu_sewa_akhir = get_post_meta($post->ID, 'meta_waktu_sewa_akhir', true);
		$aset_perlu_tindak_lanjut = get_post_meta($post->ID, 'meta_keterangan_aset_perlu_tindak_lanjut', true);
		$ket_mutasi_aset = get_post_meta($post->ID, 'meta_keterangan_mutasi_aset', true);
		$ket_penggunaan_aset = get_post_meta($post->ID, 'meta_ket_penggunaan_aset', true);
		
		$keterangan_kondisi_aset = get_post_meta($post->ID, 'meta_keterangan_kondisi_aset', true);
		$ket_potensi_penggunaan = get_post_meta($post->ID, 'meta_ket_potensi_penggunaan', true);
		$allow_edit_post = $this->cek_edit_post(array(
		    'Kd_Prov' => $Kd_Prov,
		    'Kd_Kab_Kota' => $Kd_Kab_Kota,
		    'Kd_Bidang' => $Kd_Bidang,
		    'Kd_Unit' => $Kd_Unit,
		    'Kd_Sub' => $Kd_Sub,
		    'Kd_UPB' => $Kd_UPB,
		    'Kd_Kecamatan' => $Kd_Kecamatan,
		    'Kd_Desa' => $Kd_Desa
		));
		$disabled = 'disabled';
		$link_post = get_permalink($post);
		if($allow_edit_post){
		    $post->custom_url = array(
		        array(
		            'key' =>'edit',
		            'value' => 1
		        )
		    );
		    $link_edit = $this->functions->get_link_post($post);
		    if(!empty($params['key']['edit'])){
		        $disabled = '';
		    	$api_googlemap .= '&libraries=drawing';
		    }
		}
		require_once BMD_PLUGIN_PATH . 'public/partials/wp-aset-bmd-detail-header.php';
        if($params['jenis_aset'] == 'tanah'){
			require_once BMD_PLUGIN_PATH . 'public/partials/wp-aset-bmd-detail-aset-tanah.php';
        }else if($params['jenis_aset'] == 'mesin'){
			require_once BMD_PLUGIN_PATH . 'public/partials/wp-aset-bmd-detail-aset-mesin.php';
        }else if($params['jenis_aset'] == 'bangunan'){
			require_once BMD_PLUGIN_PATH . 'public/partials/wp-aset-bmd-detail-aset-bangunan.php';
        }else if($params['jenis_aset'] == 'jalan'){
			require_once BMD_PLUGIN_PATH . 'public/partials/wp-aset-bmd-detail-aset-jalan.php';
        }else if($params['jenis_aset'] == 'aset_tetap'){
			require_once BMD_PLUGIN_PATH . 'public/partials/wp-aset-bmd-detail-aset-aset_tetap.php';
        }else if($params['jenis_aset'] == 'bangunan_dalam_pengerjaan'){
			require_once BMD_PLUGIN_PATH . 'public/partials/wp-aset-bmd-detail-aset-bangunan_dalam_pengerjaan.php';
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
		
		if(!empty($params['daftar_aset'])){
			if(!empty($params['kondisi_simata'])){
				require_once BMD_PLUGIN_PATH . 'public/partials/wp-aset-bmd-daftar-aset-meta.php';
			}else{
				require_once BMD_PLUGIN_PATH . 'public/partials/wp-aset-bmd-daftar-aset.php';
			}
		}else{
			$kd_lokasi = explode('.', $params['kd_lokasi']);
			$Kd_Prov = (int) $kd_lokasi[1];
            $Kd_Kab_Kota = (int) $kd_lokasi[2];
            $Kd_Bidang = (int) $kd_lokasi[3];
            $Kd_Unit = (int) $kd_lokasi[4];
            $Kd_Sub = (int) $kd_lokasi[5];
            $Kd_UPB = (int) $kd_lokasi[6];
            $Kd_Kecamatan = (int) $kd_lokasi[7];
            $Kd_Desa = (int) $kd_lokasi[8];
			if(!empty($params['kondisi_simata'])){
				require_once BMD_PLUGIN_PATH . 'public/partials/wp-aset-bmd-daftar-aset-meta-rinci.php';
			}else{
				require_once BMD_PLUGIN_PATH . 'public/partials/wp-aset-bmd-daftar-aset-rinci.php';
			}
		}
	}

	function get_kondisi($kode, $html=false){
		$selected_1 = '';
		$selected_2 = '';
		$selected_3 = '';
		$selected_4 = '';
		$selected_5 = '';
		$selected_6 = '';
		$color = '';
		if ($kode == 1) {
			$color = 'red';
			$kondisi = 'Baik';
			$selected_1 = 'selected';
		}else if ($kode == 2) {
			$color = 'green';
			$kondisi = 'Rusak Ringan';
			$selected_2 = 'selected';
		}else if ($kode == 3) {
			$color = 'blue';
			$kondisi = 'Rusak Berat';
			$selected_3 = 'selected';
		}else if ($kode == 4) {
			$color = 'orange';
			$kondisi = 'Hilang';
			$selected_4 = 'selected';
		}else if ($kode == 5) {
			$color = 'purple';
			$kondisi = 'Tidak Diketemukan';
			$selected_5 = 'selected';
		}else{
			$color = 'pink';
			$kondisi = 'Lainnya';
			$selected_6 = 'selected';
		}
		if(!$html){
			return array(
				'uraian' => $kondisi,
				'color' => $color
			);
		}else{
			return '
				<option value="">Pilih Kondisi</option>
				<option value="1" '.$selected_1.'>Baik</option>
                <option value="2" '.$selected_2.'>Rusak Ringan</option>
                <option value="3" '.$selected_3.'>Rusak Berat</option>
                <option value="4" '.$selected_4.'>Hilang</option>
			';
		}
	}

	function get_kondisi_simda($kode){
		global $wpdb;
		$kondisi = $this->functions->CurlSimda(array(
		    'query' => $wpdb->prepare("
		    	SELECT Uraian FROM ref_kondisi where Kd_Kondisi=%d
		    ", $kode)
		));
		return $kondisi[0]->Uraian;
	}

	function get_link_daftar_aset($options=array('get' => array())){
		$custom_url = array();
		foreach($options['get'] as $key => $val){
			$custom_url[] = array('key' => $key, 'value' => $val);
		}
		$link = $this->functions->generatePage(array(
			'nama_page' => 'Daftar Aset Barang Milik Daerah',
			'content' => '[daftar_aset]',
			'post_status' => 'publish',
        	'show_header' => 1,
			'custom_url' => $custom_url
		));
		return $link['url'];
	}

	function get_total_skpd_all($json = false){
		global $wpdb;
		$return = array(
			'status' => 'success',
			'message'	=> 'Berhasil get total per SKPD!'
		);
		if(!empty($_POST)){
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option( '_crb_apikey_simda_bmd' )) {
				$limit = '';
				if(
				    !empty($_POST['limit'])
				    && is_numeric($_POST['limit'])
				){
				    $limit = 'top '.$_POST['limit'];
				}
				$body_skpd = '';
				$skpd = $this->functions->CurlSimda(array(
				    'query' => '
				        select '.$limit.' 
				            u.Kd_Prov, 
				            u.Kd_Kab_Kota, 
				            u.Kd_Bidang, 
				            u.Kd_Unit, 
				            b.Nm_Bidang, 
				            n.Nm_Unit
				        from ref_upb u
				        LEFT JOIN ref_bidang b ON b.Kd_Bidang=u.Kd_Bidang
				        LEFT JOIN Ref_Unit n ON n.Kd_Prov=u.Kd_Prov
				            AND n.Kd_Kab_Kota=u.Kd_Kab_Kota
				            AND n.Kd_Bidang=u.Kd_Bidang
				            AND n.Kd_Unit=u.Kd_Unit
				        '
				));
				$no=0;
				$cek_skpd = array();
				$all_skpd = array();
				$all_bidang = array();
				foreach($skpd as $k => $val){
				    $kd_bidang = '12.'.$this->functions->CekNull($val->Kd_Prov).'.'.$this->functions->CekNull($val->Kd_Kab_Kota).'.'.$this->functions->CekNull($val->Kd_Bidang);
				    $kd_lokasi = $kd_bidang.'.'.$this->functions->CekNull($val->Kd_Unit);
				    if(empty($cek_skpd[$kd_lokasi])){
				        $cek_skpd[$kd_lokasi] = $kd_lokasi;
				    }else{
				        continue;
				    }
				    $no++;
				    $val->kd_lokasi = $kd_lokasi;
				    $_POST['data'] = (array) $val;
				    $total = $this->get_total_skpd(true);
				    if(empty($total['data']['total_asli'])){
				        continue;
				    }
				    $body_skpd .= '
				        <tr>
				            <td class="text-center">'.$kd_lokasi.'</td>
				            <td>'.$val->Nm_Unit.'</td>
				            <td class="text-right harga_total" data-kd_lokasi="'.$kd_lokasi.'" data-order="'.$total['data']['total_asli'].'">'.$total['data']['total'].'</td>
				            <td class="text-center"><a target="_blank" href="'.$this->get_link_daftar_aset(array('get' => array('kd_lokasi' => $kd_lokasi, 'nama_skpd' => $val->Nm_Unit, 'daftar_aset' => 1))).'" class="btn btn-primary">Detail</a></td>
				        </tr>
				    ';
				    $all_skpd[$kd_lokasi] = array(
				    	'nama' => $val->Nm_Unit,
				    	'total' => $total['data']['total_asli']
				    );
				    if(empty($all_bidang[$kd_bidang])){
				    	$all_bidang[$kd_bidang] = array(
				    		'nama' => $val->Nm_Bidang,
				    		'total' => 0
				    	);
				    }
				    $all_bidang[$kd_bidang]['total'] += $total['data']['total_asli'];
				}
				update_option('_crb_total_per_skpd', json_encode($all_skpd));
				update_option('_crb_total_per_bidang', json_encode($all_bidang));
				$return['html'] = $body_skpd;
			}else{
				$return = array(
					'status' => 'error',
					'message'	=> 'Api Key tidak sesuai!'
				);
			}
		}else{
			$return = array(
				'status' => 'error',
				'message'	=> 'Format tidak sesuai!'
			);
		}
		die(json_encode($return));
	}

	function get_total_skpd($json = false){
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil total aset SKPD!'
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option( '_crb_apikey_simda_bmd' )) {
				if (!empty($_POST['data'])) {
					$where = ' where 
						B.Kd_Hapus= \'0\' 
			            AND B.Kd_Data != \'3\' 
			            AND B.Kd_KA= \'1\'
						and B.Kd_Prov=\''.$_POST['data']['Kd_Prov'].'\' 
						and B.Kd_Kab_Kota=\''.$_POST['data']['Kd_Kab_Kota'].'\' 
						and B.Kd_Bidang=\''.$_POST['data']['Kd_Bidang'].'\' 
						and B.Kd_Unit=\''.$_POST['data']['Kd_Unit'].'\'';
				    if(!empty($_POST['data']['Kd_Sub'])){
				    	$where .= ' and B.Kd_Sub=\''.$_POST['data']['Kd_Sub'].'\'';
				    }
				    if(!empty($_POST['data']['Kd_UPB'])){
					    $where .= ' and B.Kd_UPB=\''.$_POST['data']['Kd_UPB'].'\'';
					    if(!empty($_POST['data']['Kd_Kecamatan'])){
					        $where .= ' and B.Kd_Kecamatan=\''.$_POST['data']['Kd_Kecamatan'].'\'';
					    }else{
					        $where .= ' and B.Kd_Kecamatan is null';
					    }
					    if(!empty($_POST['data']['Kd_Desa'])){
					        $where .= ' and B.Kd_Desa=\''.$_POST['data']['Kd_Desa'].'\'';
					    }else{
					        $where .= ' and B.Kd_Desa is null';
					    }
					}

				    $harga = 0;
				    if(empty($_POST['jenis_aset']) || $_POST['jenis_aset'] == 'tanah'){
					    $tanah = $this->functions->CurlSimda(array(
					        'query' => "
					        	select 
					        		sum(B.Luas_M2) as jml, 
					        		COUNT(B.Harga) as jml_bidang, 
					        		sum(C.Harga) as harga 
					        	from ta_kib_a B
					        	INNER JOIN Ta_Fn_KIB_A C ON C.IDPemda = B.IDPemda
					        	".$where,
					        'no_debug' => 0
					    ));
				    	$harga += $tanah[0]->harga;
					}
				    if(empty($_POST['jenis_aset']) || $_POST['jenis_aset'] == 'mesin'){
					    $mesin = $this->functions->CurlSimda(array(
					        'query' => "
					        	select 
					        		COUNT(B.Harga) as jml, 
					        		sum(C.Harga) as harga 
					        	from ta_kib_b B
					        	INNER JOIN Ta_Fn_KIB_B C ON C.IDPemda = B.IDPemda
					        	".$where,
					        'no_debug' => 0
					    ));
				    	$harga += $mesin[0]->harga;
				    }
				    if(empty($_POST['jenis_aset']) || $_POST['jenis_aset'] == 'bangunan'){
					    $gedung = $this->functions->CurlSimda(array(
					        'query' => "
					        	select 
					        		COUNT(B.Harga) as jml, 
					        		sum(C.Harga) as harga 
					        	from ta_kib_c B
					        	INNER JOIN Ta_Fn_KIB_C C ON C.IDPemda = B.IDPemda
					        	".$where,
					        'no_debug' => 0
					    ));
				    	$harga += $gedung[0]->harga;
				    }
				    if(empty($_POST['jenis_aset']) || $_POST['jenis_aset'] == 'jalan'){
					    $jalan = $this->functions->CurlSimda(array(
					        'query' => "
					        	select 
					        		sum(B.Panjang) as jml, 
					        		sum(C.Harga) as harga 
					        	from ta_kib_d B
					        	INNER JOIN Ta_Fn_KIB_D C ON C.IDPemda = B.IDPemda
					        	".$where,
					        'no_debug' => 0
					    ));
				    	$harga += $jalan[0]->harga;
				    }
				    if(empty($_POST['jenis_aset']) || $_POST['jenis_aset'] == 'aset_tetap'){
					    $tetap_lainnya = $this->functions->CurlSimda(array(
					        'query' => "
					        	select 
					        		COUNT(B.Harga) as jml, 
					        		sum(C.Harga) as harga 
					        	from ta_kib_e B
					        	INNER JOIN Ta_Fn_KIB_E C ON C.IDPemda = B.IDPemda
					        	".$where,
					        'no_debug' => 0
					    ));
				    	$harga += $tetap_lainnya[0]->harga;
				    }
				    if(empty($_POST['jenis_aset']) || $_POST['jenis_aset'] == 'bangunan_dalam_pengerjaan'){
					    $gedung_pengerjaan = $this->functions->CurlSimda(array(
					        'query' => "
					        	select 
					        		COUNT(B.Harga) as jml, 
					        		sum(C.Harga) as harga 
					        	from ta_kib_a B
					        	INNER JOIN Ta_Fn_KIB_F C ON C.IDPemda = B.IDPemda
					        	".$where,
					        'no_debug' => 0
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
		if($json){
			return $ret;
		}else{
			die(json_encode($ret));
		}
	}

	function get_nama_jenis_aset($options=array()){
		$nama_jenis_aset = '';
		$table_simda = '';
		$table_simda_harga = '';
		$color = '';
		$satuan = '';
		$satuan_rinci = '';
		$zIndex = 1;
		if($options['jenis_aset'] == 'tanah'){
		    $nama_jenis_aset = 'Tanah';
		    $table_simda = 'Ta_KIB_A';
		    $table_simda_harga = 'Ta_Fn_KIB_A';
			$color = 'red';
			$zIndex = 2;
			$satuan = 'Bidang Tanah';
			$satuan_rinci = 'Meter Persegi';
		}else if($options['jenis_aset'] == 'mesin'){
		    $nama_jenis_aset = 'Peralatan dan Mesin';
		    $table_simda = 'Ta_KIB_B';
		    $table_simda_harga = 'Ta_Fn_KIB_B';
			$color = 'green';
			$satuan = 'Aset';
			$satuan_rinci = 'Pcs';
		}else if($options['jenis_aset'] == 'bangunan'){
		    $nama_jenis_aset = 'Gedung dan Bangunan';
		    $table_simda = 'Ta_KIB_C';
		    $table_simda_harga = 'Ta_Fn_KIB_C';
			$color = 'blue';
			$zIndex = 3;
			$satuan = 'Gedung';
			$satuan_rinci = $satuan;
		}else if($options['jenis_aset'] == 'jalan'){
		    $nama_jenis_aset = 'Jalan, Jaringan dan Irigrasi';
		    $table_simda = 'Ta_KIB_D';
		    $table_simda_harga = 'Ta_Fn_KIB_D';
			$color = 'orange';
			$zIndex = 1;
			$satuan = 'Aset';
			$satuan_rinci = 'Meter (Panjang)';
		}else if($options['jenis_aset'] == 'aset_tetap'){
		    $nama_jenis_aset = 'Aset Tetap Lainnya';
		    $table_simda = 'Ta_KIB_E';
		    $table_simda_harga = 'Ta_Fn_KIB_E';
			$color = 'purple';
			$zIndex = 4;
			$satuan = 'Aset';
			$satuan_rinci = 'Meter (Panjang)';
		}else if($options['jenis_aset'] == 'bangunan_dalam_pengerjaan'){
		    $nama_jenis_aset = 'Kontruksi Dalam Pengerjaan';
		    $table_simda = 'Ta_KIB_F';
		    $table_simda_harga = 'Ta_Fn_KIB_A';
			$color = 'pink';
			$zIndex = 5;
			$satuan = 'Gedung';
			$satuan_rinci = $satuan;
		}
		return array(
			'jenis' => $options['jenis_aset'],
			'nama' => $nama_jenis_aset,
			'table_simda' => $table_simda,
			'table_simda_harga' => $table_simda_harga,
			'color' => $color,
			'satuan' => $satuan,
			'satuan_rinci' => $satuan_rinci,
			'zIndex' => $zIndex
		);
	}

	function get_all_posts(){
		if(!empty($_GET) && !empty($_GET['post'])){
			return '';
		}
		require_once BMD_PLUGIN_PATH . 'public/partials/wp-aset-bmd-posts.php';

	}
	
	function temuan_bpk(){
		if(!empty($_GET) && !empty($_GET['post'])){
			return '';
		}
		require_once BMD_PLUGIN_PATH . 'public/partials/wp-aset-bmd-temuan-bpk.php';

	}
	
	function tambah_data_temuan_bpk($atts){
		global $post;
		if(!empty($_GET) && !empty($_GET['post'])){
			return '';
		}

		$disabled = '';
		$edit = false;
		
		if(!empty($_GET) && !empty($_GET['key'])){
			$params['key'] = $this->functions->decode_key($_GET['key']);
			if(!empty($params['key']['edit'])){
				$edit = true;
			}else if(!empty($params['key']['detail'])){
				$disabled = 'disabled';
			}
		}
		
		$api_key = get_option('_crb_apikey_simda_bmd');
		$url_aset = '#';
		$nm_aset = '';
		if(false == $edit && $disabled != 'disabled'){
			$status_neraca = 1;
			$jenis_aset = '';
			$status_neraca = '';
			$jenis_aset = '';
			$pilih_opd_temuan_bpk = '';
			$judul_temuan_bpk = '';
			$option_judul_temuan_bpk = $this->get_opsi_jenis_temuan();
			$tanggal_temuan_bpk = '';
			$keterangan_temuan_bpk = '';
			$lampiran_temuan_bpk = '';
			$kode_barang_temuan = '';
			$nama_barang_temuan = '';
			$url_aset = '#';
			$nm_aset = '';
		}else{
			$status_neraca = get_post_meta($post->ID, 'meta_status_neraca', true);
			$jenis_aset = get_post_meta($post->ID, 'meta_pilih_jenis_aset', true);
			$pilih_opd_temuan_bpk = get_post_meta($post->ID, 'meta_pilih_opd_temuan_bpk', true);
			$judul_temuan_bpk = get_post_meta($post->ID, 'meta_judul_temuan_bpk', true);
			$option_judul_temuan_bpk = $this->get_opsi_jenis_temuan($judul_temuan_bpk);
			$tanggal_temuan_bpk = get_post_meta($post->ID, 'meta_tanggal_temuan_bpk', true);
			$keterangan_temuan_bpk = get_post_meta($post->ID, 'meta_keterangan_temuan_bpk', true);
			$lampiran_temuan_bpk = get_post_meta($post->ID, 'meta_lampiran_temuan_bpk', true);
			$kode_barang_temuan = get_post_meta($post->ID, 'meta_kode_barang_temuan', true);
			$nama_barang_temuan = get_post_meta($post->ID, 'meta_nama_barang_temuan', true);
			$post_id_aset = get_post_meta($post->ID, 'meta_post_id_aset', true);
			if(!empty($post_id_aset)){
				$url_aset = get_permalink($post_id_aset);
				$nm_aset = get_post_meta($post_id_aset, 'abm_nama_aset', true);
			}
		}

		$checked_sudah_neraca = 'checked';
		$checked_belum_neraca = '';
		if($status_neraca == '2'){
			$checked_sudah_neraca = '';
			$checked_belum_neraca = 'checked';
		}

		$options = array(
			'nama_page' => 'Temuan BPK',
			'content' => '[temuan_bpk]',
			'show_header' => 1,
			'no_key' => 1,
			'post_status' => 'private'
		);
		$data_temuan_bpk = $this->functions->generatePage($options);

		$allow_edit_post = false;
		if(is_user_logged_in()){
		    $user_id = get_current_user_id();
		    if($this->functions->user_has_role($user_id, 'administrator')){
		    	$allow_edit_post = true;
		    	$post->custom_url = array(
		            array(
		                'key' =>'edit',
		                'value' => 1
		            )
		        );
		        $link_edit = $this->functions->get_link_post($post);

		        $aksi_temuan_bpk = $data_temuan_bpk['post'];
		    	$aksi_temuan_bpk->custom_url = array(
		            array(
		                'key' =>'delete',
		                'value' => $post->ID
		            )
		        );
		        $link_delete = $this->functions->get_link_post($data_temuan_bpk);
		    }
		}

		require_once BMD_PLUGIN_PATH . 'public/partials/wp-aset-bmd-tambah-temuan-bpk.php';

	}

	function get_opsi_jenis_temuan($default=false){
		$jenis_temuan = $this->functions->get_option_complex('_crb_jenis_temuan', 'jenis');
        $jenis_temuan_options = '<option value="">Pilih jenis temuan BPK</option>';
        foreach($jenis_temuan as $val){
        	$selected = '';
        	if($default == $val['jenis']){
        		$selected = 'selected';
        	}
        	$jenis_temuan_options .= '<option '.$selected.' value="'.$val['jenis'].'">'.$val['jenis'].'</option>';
        }
        return $jenis_temuan_options;
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

	function simpan_aset(){
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil simpan aset!'
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option( '_crb_apikey_simda_bmd' )) {
				if (!empty($_POST['id_post'])) {
					$post = get_post($_POST['id_post']);
					if(!empty($post->ID)){
						update_post_meta($post->ID, 'latitude', $_POST['latitude']);
						update_post_meta($post->ID, 'longitude', $_POST['longitude']);
						update_post_meta($post->ID, 'polygon', $_POST['polygon']);
						update_post_meta($post->ID, 'meta_sejarah', $_POST['sejarah']);
						update_post_meta($post->ID, 'meta_kronologi', $_POST['kronologi']);
						update_post_meta($post->ID, 'meta_foto', $_POST['foto']);
						update_post_meta($post->ID, 'meta_video', $_POST['video']);
						update_post_meta($post->ID, 'meta_disewakan', $_POST['disewakan']);
						update_post_meta($post->ID, 'meta_nilai_sewa', $_POST['nilai_sewa']);
						update_post_meta($post->ID, 'meta_nama_sewa', $_POST['nama_sewa']);
						update_post_meta($post->ID, 'meta_alamat_sewa', $_POST['alamat_sewa']);
						update_post_meta($post->ID, 'meta_waktu_sewa_awal', $_POST['waktu_sewa_awal']);
						update_post_meta($post->ID, 'meta_waktu_sewa_akhir', $_POST['waktu_sewa_akhir']);
						update_post_meta($post->ID, 'meta_aset_perlu_tindak_lanjut', $_POST['aset_perlu_tindak_lanjut']);
						update_post_meta($post->ID, 'meta_keterangan_aset_perlu_tindak_lanjut', $_POST['ket_aset_perlu_tindak_lanjut']);
						update_post_meta($post->ID, 'meta_mutasi_aset', $_POST['mutasi_aset']);
						update_post_meta($post->ID, 'meta_keterangan_mutasi_aset', $_POST['ket_mutasi_aset']);
						update_post_meta($post->ID, 'meta_ket_penggunaan_aset', $_POST['ket_penggunaan_aset']);
						update_post_meta($post->ID, 'meta_kondisi_aset_simata', $_POST['kondisi_aset_simata']);
						update_post_meta($post->ID, 'meta_keterangan_kondisi_aset', $_POST['keterangan_kondisi_aset']);
						update_post_meta($post->ID, 'meta_ket_potensi_penggunaan', $_POST['ket_potensi_penggunaan']);
						$post_status = 'private';
						if(
							!empty($_POST['status_informasi'])
							&& $_POST['status_informasi'] == 2
						){
							$post_status = 'publish';
						}
						wp_update_post(array(
					        'ID'    =>  $post->ID,
					        'post_status'   =>  $post_status
				        ));
					}else{
						$ret['status'] = 'error';
						$ret['message'] = 'ID post aset tidak ditemukan!';
					}
				} else {
					$ret['status'] = 'error';
					$ret['message'] = 'Format data salah!';
				}
			} else {
				$ret['status'] = 'error';
				$ret['message'] = 'APIKEY tidak sesuai!';
			}
		}
		die(json_encode($ret));
	}
	
	function get_kd_register($post){
		global $wpdb;
		$args = array(
		   'meta_query' => array(
		       array(
		           'key' => 'abm_jenis_aset',
		           'value' => $post['jenis_aset'],
		           'compare' => '=',
		       ),
		       array(
		           'key' => 'abm_kd_upb',
		           'value' => $post['kd_upb'],
		           'compare' => '=',
		       ),
		       array(
		           'key' => 'abm_kd_barang',
		           'value' => $post['kd_barang'],
		           'compare' => '=',
		       )
		   	),
			'meta_key' => 'abm_kd_register',
			'orderby' => 'meta_value_num',
			'meta_type' => 'NUMERIC',
			'order' => 'DESC',
			'posts_per_page' => '1',
			'page' => '1'
		);
		$query = new WP_Query($args);
		$kd_register = 0;
		foreach($query->posts as $post){
			$kd_register = get_post_meta($post->ID, 'abm_kd_register', true);
			if(empty($kd_register)){
				$kd_register = 0;
			}
		}
		return $kd_register+1;
	}

	function generatePageDetailBelumMasukNeraca($opsi){
		$judul = 'ABM '.$opsi['jenis_aset'].' '.$opsi['kd_upb'].' '.$opsi['kd_barang'].' '.$opsi['kd_register'];
		$link = $this->functions->generatePage(array(
	        'nama_page' => $judul,
	        'content' => '[tambah_aset_belum_masuk_neraca]',
	        'post_status' => 'private',
	        'post_type' => $opsi['post_type'],
	        'show_header' => 1,
	        'no_key' => 1
	    ));
	    $post_id = $link['id'];
	    $url = $link['url'];
		return array(
			'id' => $post_id,
			'url' => $url,
			'title' => $judul
		);
	}

	function simpan_aset_belum_masuk_neraca(){
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil simpan aset!'
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option( '_crb_apikey_simda_bmd' )) {
				$post_id = false;
				if (!empty($_POST['id_post'])) {
					$post = get_post($_POST['id_post']);
					$kd_register = get_post_meta($post->ID, 'abm_kd_register', true);
					$post_id = $post->ID;
				}else{
					$post_type = 'post';
					$kd_register = $this->get_kd_register($_POST);
					$posts = $this->generatePageDetailBelumMasukNeraca(array(
						'kd_register' => $kd_register,
						'jenis_aset' => $_POST['jenis_aset'],
						'kd_upb' => $_POST['kd_upb'],
						'kd_barang' => $_POST['kd_barang'],
						'post_type' => 'post'
					));
					$post_id = $posts['id'];
				}
				if(!empty($post_id)){
					update_post_meta($post_id, 'abm_jenis_aset', $_POST['jenis_aset']);
					update_post_meta($post_id, 'abm_kd_upb', $_POST['kd_upb']);
					update_post_meta($post_id, 'abm_nama_upb', $_POST['nama_upb']);
					update_post_meta($post_id, 'abm_kd_barang', $_POST['kd_barang']);
					update_post_meta($post_id, 'abm_kd_register', $kd_register);
					update_post_meta($post_id, 'abm_nama_aset', $_POST['nama_aset']);
					update_post_meta($post_id, 'abm_penggunaan', $_POST['penggunaan']);
					update_post_meta($post_id, 'abm_luas', $_POST['luas']);
					update_post_meta($post_id, 'abm_alamat', $_POST['alamat']);
					update_post_meta($post_id, 'abm_tgl_pengadaan', $_POST['tgl_pengadaan']);
					update_post_meta($post_id, 'abm_hak', $_POST['hak']);
					update_post_meta($post_id, 'abm_tgl_sertifikat', $_POST['tgl_sertifikat']);
					update_post_meta($post_id, 'abm_nomor_sertifikat', $_POST['nomor_sertifikat']);
					update_post_meta($post_id, 'abm_asal_usul', $_POST['asal_usul']);
					update_post_meta($post_id, 'abm_harga', $_POST['harga']);
					update_post_meta($post_id, 'abm_keterangan', $_POST['keterangan']);
					update_post_meta($post_id, 'abm_latitude', $_POST['latitude']);
					update_post_meta($post_id, 'abm_longitude', $_POST['longitude']);
					update_post_meta($post_id, 'abm_polygon', $_POST['polygon']);
					update_post_meta($post_id, 'abm_meta_sejarah', $_POST['sejarah']);
					update_post_meta($post_id, 'abm_meta_kronologi', $_POST['kronologi']);
					update_post_meta($post_id, 'abm_meta_foto', $_POST['foto']);
					update_post_meta($post_id, 'abm_meta_video', $_POST['video']);
					update_post_meta($post_id, 'abm_meta_disewakan', $_POST['disewakan']);
					update_post_meta($post_id, 'abm_meta_nilai_sewa', $_POST['nilai_sewa']);
					update_post_meta($post_id, 'abm_meta_nama_sewa', $_POST['nama_sewa']);
					update_post_meta($post_id, 'abm_meta_alamat_sewa', $_POST['alamat_sewa']);
					update_post_meta($post_id, 'abm_meta_waktu_sewa_awal', $_POST['waktu_sewa_awal']);
					update_post_meta($post_id, 'abm_meta_waktu_sewa_akhir', $_POST['waktu_sewa_akhir']);
					update_post_meta($post_id, 'abm_meta_aset_perlu_tindak_lanjut', $_POST['aset_perlu_tindak_lanjut']);
					update_post_meta($post_id, 'abm_meta_keterangan_aset_perlu_tindak_lanjut', $_POST['ket_aset_perlu_tindak_lanjut']);
					update_post_meta($post_id, 'abm_meta_ket_penggunaan_aset', $_POST['ket_penggunaan_aset']);
					update_post_meta($post_id, 'abm_meta_kondisi_aset_simata', $_POST['kondisi_aset_simata']);
					update_post_meta($post_id, 'abm_meta_keterangan_kondisi_aset', $_POST['keterangan_kondisi_aset']);
					update_post_meta($post_id, 'abm_meta_ket_potensi_penggunaan', $_POST['ket_potensi_penggunaan']);
					$post_status = 'private';
					if(
						!empty($_POST['status_informasi'])
						&& $_POST['status_informasi'] == 2
					){
						$post_status = 'publish';
					}
					wp_update_post(array(
				        'ID'    =>  $post_id,
				        'post_status'   =>  $post_status
			        ));
				}else{
					$ret['status'] = 'error';
					$ret['message'] = 'ID post aset tidak ditemukan!';
				}
			} else {
				$ret['status'] = 'error';
				$ret['message'] = 'APIKEY tidak sesuai!';
			}
		}
		die(json_encode($ret));
	}

	
	function simpan_temuan_bpk(){
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil simpan temuan!'
		);

		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option( '_crb_apikey_simda_bmd' )) {
				
				$judul = 'Temuan BPK '.$_POST['judul_temuan_bpk'].' '.$_POST['pilih_opd_temuan_bpk'].' '.$_POST['kode_barang_temuan'];
				$post_type = 'post';
				$options = array(
					'nama_page' => $judul,
					'content' => '[tambah_data_temuan_bpk]',
					'post_status' => 'private',
					'post_type' => $post_type,
					'show_header' => 1,
					'no_key' => 1
				);
				if(empty($_POST['id_post'])){
					$link = $this->functions->generatePage($options);
					$post_id = $link['id'];
				}else{
					$post_id = $_POST['id_post'];
					$title = get_the_title($post_id);
					if($judul != $title){
						$options['post_id'] = $post_id;
						$this->functions->generatePage($options);
					}
				}

				if(!empty($post_id)){
					update_post_meta($post_id, 'meta_post_id_aset', $_POST['post_id_aset']);
					update_post_meta($post_id, 'meta_status_neraca', $_POST['status_neraca']);
					update_post_meta($post_id, 'meta_pilih_jenis_aset', $_POST['pilih_jenis_aset']);
					update_post_meta($post_id, 'meta_judul_temuan_bpk', $_POST['judul_temuan_bpk']);
					update_post_meta($post_id, 'meta_tanggal_temuan_bpk', $_POST['tanggal_temuan_bpk']);
					update_post_meta($post_id, 'meta_keterangan_temuan_bpk', $_POST['keterangan_temuan_bpk']);
					update_post_meta($post_id, 'meta_lampiran_temuan_bpk', $_POST['lampiran_temuan_bpk']);
					update_post_meta($post_id, 'meta_pilih_opd_temuan_bpk', $_POST['pilih_opd_temuan_bpk']);
					update_post_meta($post_id, 'meta_nama_opd_temuan_bpk', $_POST['nama_upb']);
					update_post_meta($post_id, 'meta_kode_barang_temuan', $_POST['kode_barang_temuan']);
					update_post_meta($post_id, 'meta_nama_barang_temuan', $_POST['nama_barang_temuan']);
					$post_status = 'private';

					if(
						!empty($_POST['status_informasi'])
						&& $_POST['status_informasi'] == 2
					){
						$post_status = 'publish';
					}
					wp_update_post(array(
						'ID'    =>  $post_id,
						'post_status'   =>  $post_status
					));
				}else{
					$ret['status'] = 'error';
					$ret['message'] = 'ID post aset tidak ditemukan!';
				}
			} else {
				$ret['status'] = 'error';
				$ret['message'] = 'APIKEY tidak sesuai!';
			}
			die(json_encode($ret));
		}
	}

	function get_total_aset_upb($table_simda, $params = array()){
		global $wpdb;
		$select_custom = '';
        if($table_simda == 'Ta_KIB_A'){
            $select_custom .= 'sum(a.Luas_M2) as luas, ';
        }
        $where = '';
        if(!empty($params['kd_lokasi'])){
        	$kode = explode('.', $params['kd_lokasi']);
        	$Kd_Prov = (int) $kode[1];
            $Kd_Kab_Kota = (int) $kode[2];
            $Kd_Bidang = (int) $kode[3];
            $Kd_Unit = (int) $kode[4];
            $Kd_Sub = (int) $kode[5];
            $where .= $wpdb->prepare(' WHERE a.Kd_Prov=%d', $Kd_Prov);
            $where .= $wpdb->prepare(' AND a.Kd_Kab_Kota=%d', $Kd_Kab_Kota);
            $where .= $wpdb->prepare(' AND a.Kd_Bidang=%d', $Kd_Bidang);
            $where .= $wpdb->prepare(' AND a.Kd_Unit=%d', $Kd_Unit);
            $where .= $wpdb->prepare(' AND a.Kd_Sub=%d', $Kd_Sub);
        }
        if(!empty($params['jenis_aset'])){
        	$select_custom .= '\''.$params['jenis_aset'].'\' as jenis_aset, ';
        	$select_custom .= '\''.$params['nama_aset'].'\' as nama_aset, ';
        }
        $skpd = $this->functions->CurlSimda(array(
            'query' => '
                select 
                    '.$select_custom.'
                    a.Kd_Prov, 
                    a.Kd_Kab_Kota, 
                    a.Kd_Bidang, 
                    a.Kd_Unit, 
                    a.Kd_Sub, 
                    a.Kd_UPB, 
                    a.Kd_Kecamatan, 
                    a.Kd_Desa, 
                    COUNT(a.Harga) as jml, 
                    sum(a.Harga) as harga,
                    u.Nm_UPB,
                    k.Nm_Kecamatan,
                    d.Nm_Desa,
                    s.Nm_Sub_Unit,
                    \''.$table_simda.'\' as table_simda
                from '.$table_simda.' a
                INNER JOIN ref_sub_unit s ON a.Kd_Prov=s.Kd_Prov
                    AND a.Kd_Kab_Kota = s.Kd_Kab_Kota 
                    AND a.Kd_Bidang = s.Kd_Bidang 
                    AND a.Kd_Unit = s.Kd_Unit 
                    AND a.Kd_Sub = s.Kd_Sub 
                LEFT JOIN ref_upb u ON a.Kd_Prov=u.Kd_Prov
                    AND a.Kd_Kab_Kota = u.Kd_Kab_Kota 
                    AND a.Kd_Bidang = u.Kd_Bidang 
                    AND a.Kd_Unit = u.Kd_Unit 
                    AND a.Kd_Sub = u.Kd_Sub 
                    AND a.Kd_UPB = u.Kd_UPB 
                LEFT JOIN Ref_Kecamatan k ON k.Kd_Prov=a.Kd_Prov
                    AND k.Kd_Kab_Kota = a.Kd_Kab_Kota 
                    AND k.Kd_Kecamatan = a.Kd_Kecamatan
                LEFT JOIN Ref_Desa d ON d.Kd_Prov=a.Kd_Prov
                    AND d.Kd_Kab_Kota = a.Kd_Kab_Kota 
                    AND d.Kd_Kecamatan = a.Kd_Kecamatan
                    AND d.Kd_Desa = a.Kd_Desa
                '.$where.'
                group by a.Kd_Prov, 
                    a.Kd_Kab_Kota, 
                    a.Kd_Bidang, 
                    a.Kd_Unit, 
                    a.Kd_Sub, 
                    a.Kd_UPB, 
                    a.Kd_Kecamatan, 
                    a.Kd_Desa,
                    s.Nm_Sub_Unit,
                    u.Nm_UPB,
                    k.Nm_Kecamatan,
                    d.Nm_Desa'
        ));
        return $skpd;
	}

	function set_lokasi_sub_unit_upb($params = array()){
		$set_lokasi = '';

		$nama_lokasi = !empty($params['lokasi']) ? $params['lokasi'] : '';
		$nama_upb = !empty($params['nama_upb']) ? $params['nama_upb'].', ' : '';
		$nama_sub_unit = !empty($params['nama_sub_unit']) ? $params['nama_sub_unit'].', ' : '';
		$nama_kecamatan = !empty($params['kecamatan']) ? 'Kec. '.$params['kecamatan'].', ' : '';
		$nama_desa = !empty($params['desa']) ? 'Desa/Kel. '.$params['desa'].', ' : '';

		$set_upb_sub_unit = $nama_upb.$nama_sub_unit;
		$perbandingan_upb_sub_unit = strpos($params['nama_upb'], $params['nama_sub_unit']);
		if($perbandingan_upb_sub_unit !== false ){
			$set_upb_sub_unit = $nama_upb;
		}
		$set_lokasi = $nama_lokasi === ''  || $nama_lokasi === '-' ? '-' : $set_upb_sub_unit.$nama_kecamatan.$nama_desa.$nama_lokasi;
		
		return $set_lokasi;
	}

	function get_rek_barang($no_die=false){
		global $wpdb;
		$return = array(
			'status' => 'success',
			'message'	=> 'Berhasil get rekening barang!'
		);
		if(!empty($_POST)){
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option( '_crb_apikey_simda_bmd' )) {
				$tipe = $_POST['tipe'];
				$val_selected = '';
				$where = 'where 1=1';
				if(!empty($_POST['selected'])){
					$val_selected = $_POST['selected'];
					$kode = explode('.', $val_selected);
					unset($kode[count($kode)-1]);
					foreach($kode as $k => $v){
						if($k == 0){
							$where .= ' AND Kd_Aset='.$v;
						}else{
							$where .= ' AND Kd_Aset'.($k-1).'='.$v;
						}
					}
				}
				$sql = '';
				$select_option = '';
				if($tipe == 'rek_0'){
					$sql = "
						SELECT 
							*
				        from Ref_Rek0_108
					";
					$select_option = '<option value="">Pilih Rekening Aset 0</option>';
					$rek_db = $this->functions->CurlSimda(array(
						'query' => $sql,
						'no_debug' => 0
					));
					foreach($rek_db as $i => $val){
						$kode = $val->Kd_Aset.'.'.$val->Kd_Aset0;
						$selected = '';
						if($val_selected == $kode){
							$selected = 'selected';
						}
						$select_option .= '<option '.$selected.' value="'.$kode.'">'.$kode.' '.$val->Nm_Aset0.'</option>';
					}
				}else if($tipe == 'rek_1'){
					$sql = "
						SELECT 
							*
				        from Ref_Rek1_108
				        $where
					";
					$select_option = '<option value="">Pilih Rekening Aset 1</option>';
					$rek_db = $this->functions->CurlSimda(array(
						'query' => $sql,
						'no_debug' => 0
					));
					foreach($rek_db as $i => $val){
						$kode = $val->Kd_Aset.'.'.$val->Kd_Aset0.'.'.$this->functions->CekNull($val->Kd_Aset1);
						$selected = '';
						if($val_selected == $kode){
							$selected = 'selected';
						}
						$select_option .= '<option '.$selected.' value="'.$kode.'">'.$kode.' '.$val->Nm_Aset1.'</option>';
					}
				}else if($tipe == 'rek_2'){
					$sql = "
						SELECT 
							*
				        from Ref_Rek2_108
				        $where
					";
					$select_option = '<option value="">Pilih Rekening Aset 2</option>';
					$rek_db = $this->functions->CurlSimda(array(
						'query' => $sql,
						'no_debug' => 0
					));
					foreach($rek_db as $i => $val){
						$kode = $val->Kd_Aset.'.'.$val->Kd_Aset0.'.'.$this->functions->CekNull($val->Kd_Aset1).'.'.$this->functions->CekNull($val->Kd_Aset2);
						$selected = '';
						if($val_selected == $kode){
							$selected = 'selected';
						}
						$select_option .= '<option '.$selected.' value="'.$kode.'">'.$kode.' '.$val->Nm_Aset2.'</option>';
					}
				}else if($tipe == 'rek_3'){
					$sql = "
						SELECT 
							*
				        from Ref_Rek3_108
				        $where
					";
					$select_option = '<option value="">Pilih Rekening Aset 3</option>';
					$rek_db = $this->functions->CurlSimda(array(
						'query' => $sql,
						'no_debug' => 0
					));
					foreach($rek_db as $i => $val){
						$kode = $val->Kd_Aset.'.'.$val->Kd_Aset0.'.'.$this->functions->CekNull($val->Kd_Aset1).'.'.$this->functions->CekNull($val->Kd_Aset2).'.'.$this->functions->CekNull($val->Kd_Aset3);
						$selected = '';
						if($val_selected == $kode){
							$selected = 'selected';
						}
						$select_option .= '<option '.$selected.' value="'.$kode.'">'.$kode.' '.$val->Nm_Aset3.'</option>';
					}
				}else if($tipe == 'rek_4'){
					$sql = "
						SELECT 
							*
				        from Ref_Rek4_108
				        $where
					";
					$select_option = '<option value="">Pilih Rekening Aset 4</option>';
					$rek_db = $this->functions->CurlSimda(array(
						'query' => $sql,
						'no_debug' => 0
					));
					foreach($rek_db as $i => $val){
						$kode = $val->Kd_Aset.'.'.$val->Kd_Aset0.'.'.$this->functions->CekNull($val->Kd_Aset1).'.'.$this->functions->CekNull($val->Kd_Aset2).'.'.$this->functions->CekNull($val->Kd_Aset3).'.'.$this->functions->CekNull($val->Kd_Aset4);
						$selected = '';
						if($val_selected == $kode){
							$selected = 'selected';
						}
						$select_option .= '<option '.$selected.' value="'.$kode.'">'.$kode.' '.$val->Nm_Aset4.'</option>';
					}
				}else if($tipe == 'rek_5'){
					$sql = "
						SELECT 
							*
				        from Ref_Rek5_108
				        $where
					";
					$select_option = '<option value="">Pilih Rekening Aset 5</option>';
					$rek_db = $this->functions->CurlSimda(array(
						'query' => $sql,
						'no_debug' => 0
					));
					foreach($rek_db as $i => $val){
						$kode = $val->Kd_Aset.'.'.$val->Kd_Aset0.'.'.$this->functions->CekNull($val->Kd_Aset1).'.'.$this->functions->CekNull($val->Kd_Aset2).'.'.$this->functions->CekNull($val->Kd_Aset3).'.'.$this->functions->CekNull($val->Kd_Aset4).'.'.$this->functions->CekNull($val->Kd_Aset5, 3);
						$selected = '';
						if($val_selected == $kode){
							$selected = 'selected';
						}
						$select_option .= '<option '.$selected.' value="'.$kode.'">'.$kode.' '.$val->Nm_Aset5.'</option>';
					}
				}
				$return['html'] = $select_option;
			}else{
				$return = array(
					'status' => 'error',
					'message'	=> 'Api Key tidak sesuai!'
				);
			}
		}else{
			$return = array(
				'status' => 'error',
				'message'	=> 'Format tidak sesuai!'
			);
		}
		if($no_die){
			return $return;
		}else{
			die(json_encode($return));
		}
	}

	function get_data_barang($no_die=false){
		global $wpdb;
		$return = array(
			'status' => 'success',
			'message'	=> 'Berhasil get data aset!'
		);
		if(!empty($_POST)){
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option( '_crb_apikey_simda_bmd' )) {
				$err = false;
				if(empty($err) && empty($_POST['kd_upb'])){
					$err = 'Kode UPB tidak boleh kosong!';
				}
				if(empty($err) && empty($_POST['status_aset'])){
					$err = 'Status aset tidak boleh kosong!';
				}
				if(empty($err) && empty($_POST['jenis_aset'])){
					$err = 'Jenis aset tidak boleh kosong!';
				}
				if(empty($err) && empty($_POST['kd_barang'])){
					$err = 'Kode barang tidak boleh kosong!';
				}
				if(empty($err)){
					$kd_barang = explode('.', $_POST['kd_barang']);
					if(count($kd_barang) < 8){
						$err = 'Format kode harus terdiri minimal 7 kode aset dan 1 kode register!';
					}
				}
				if(empty($err)){
					$kd_lokasi = explode('.', $_POST['kd_upb']);
					$Kd_Prov = (int) $kd_lokasi[1];
			        $Kd_Kab_Kota = (int) $kd_lokasi[2];
			        $Kd_Bidang = (int) $kd_lokasi[3];
			        $Kd_Unit = (int) $kd_lokasi[4];
			        $Kd_Sub = (int) $kd_lokasi[5];
			        $Kd_UPB = (int) $kd_lokasi[6];
			        $Kd_Kecamatan = (int) $kd_lokasi[7];
			        $Kd_Desa = (int) $kd_lokasi[8];

					$Kd_Aset8 = (int) $kd_barang[0];
					$Kd_Aset80 = (int) $kd_barang[1];
					$Kd_Aset81 = (int) $kd_barang[2];
					$Kd_Aset82 = (int) $kd_barang[3];
					$Kd_Aset83 = (int) $kd_barang[4];
					$Kd_Aset84 = (int) $kd_barang[5];
					$Kd_Aset85 = (int) $kd_barang[6];
					$No_Reg8 = (int) $kd_barang[7];
					$data_jenis = $this->get_nama_jenis_aset(array('jenis_aset' => $_POST['jenis_aset']));
					$where = '';
					if(!empty($Kd_Kecamatan)){
					    $where .= $wpdb->prepare(' AND a.Kd_Kecamatan=%d', $Kd_Kecamatan);
					}
					if(!empty($Kd_Desa)){
					    $where .= $wpdb->prepare(' AND a.Kd_Desa=%d', $Kd_Desa);
					}
					if($_POST['status_aset'] == 1){
						$sql = $wpdb->prepare('
						    select 
						        a.*,
				        		b.Harga as harga_asli,
						        r.Nm_Aset5
						    from '.$data_jenis['table_simda'].' a
				    		LEFT JOIN '.$data_jenis['table_simda_harga'].' b ON a.IDPemda = b.IDPemda
					        LEFT JOIN Ref_Rek5_108 r on r.kd_aset=a.Kd_Aset8 
					            and r.kd_aset0=a.Kd_Aset80 
					            and r.kd_aset1=a.Kd_Aset81 
					            and r.kd_aset2=a.Kd_Aset82 
					            and r.kd_aset3=a.Kd_Aset83 
					            and r.kd_aset4=a.Kd_Aset84 
					            and r.kd_aset5=a.Kd_Aset85
						    where a.Kd_Prov=%d
						        AND a.Kd_Kab_Kota=%d 
						        AND a.Kd_Bidang=%d 
						        AND a.Kd_Unit=%d 
						        AND a.Kd_Sub=%d 
						        AND a.Kd_UPB=%d
						        AND a.Kd_Aset8=%d
						        AND a.Kd_Aset80=%d
						        AND a.Kd_Aset81=%d
						        AND a.Kd_Aset82=%d
						        AND a.Kd_Aset83=%d
						        AND a.Kd_Aset84=%d
						        AND a.Kd_Aset85=%d
						        AND a.No_Reg8=%d
						        '.$where.'
						    ',
						    $Kd_Prov,
						    $Kd_Kab_Kota,
						    $Kd_Bidang,
						    $Kd_Unit,
						    $Kd_Sub,
						    $Kd_UPB,
						    $Kd_Aset8,
						    $Kd_Aset80,
						    $Kd_Aset81,
						    $Kd_Aset82,
						    $Kd_Aset83,
						    $Kd_Aset84,
						    $Kd_Aset85,
						    $No_Reg8
						);
						$aset_all = $this->functions->CurlSimda(array(
						    'query' => $sql 
						));
						$url = '';
						$nm_aset = '';
						$post_id = '';
						foreach($aset_all as $val){
							$kd_lokasi = '12.'.$this->functions->CekNull($val->Kd_Prov).'.'.$this->functions->CekNull($val->Kd_Kab_Kota).'.'.$this->functions->CekNull($val->Kd_Bidang).'.'.$this->functions->CekNull($val->Kd_Unit).'.'.$this->functions->CekNull($val->Kd_Sub).'.'.$this->functions->CekNull($val->Kd_UPB).'.'.$this->functions->CekNull($val->Kd_Kecamatan).'.'.$this->functions->CekNull($val->Kd_Desa);
    						$kd_barang = $val->Kd_Aset8.'.'.$val->Kd_Aset80.'.'.$this->functions->CekNull($val->Kd_Aset81).'.'.$this->functions->CekNull($val->Kd_Aset82).'.'.$this->functions->CekNull($val->Kd_Aset83).'.'.$this->functions->CekNull($val->Kd_Aset84).'.'.$this->functions->CekNull($val->Kd_Aset85, 3);
							$link = $this->functions->generatePage(array(
						        'nama_page' => $data_jenis['jenis'].' '.$kd_lokasi.' '.$kd_barang.' '.$No_Reg8,
						        'content' => '[detail_aset kd_lokasi="'.$kd_lokasi.'" kd_barang="'.$kd_barang.'" kd_register="'.$No_Reg8.'" jenis_aset="'.$data_jenis['jenis'].'"]',
						        'post_status' => 'private',
						        'post_type' => 'post',
						        'show_header' => 1,
						        'no_key' => 1
						    ));
							$url = $link['url'];
							$nm_aset = $val->Nm_Aset5;
							$post_id = $link['id'];
						}
						$return['post_id'] = $post_id;
						$return['nm_aset'] = $nm_aset;
						$return['url'] = $url;
						$return['query'] = $sql;
						if(empty($post_id)){
							$return['status'] = 'error';
							$return['message'] = 'Kode barang tidak ditemukan!';
						}
					}else{
						unset($kd_barang[7]);
						$kd_barang_all = implode('.', $kd_barang);
						$args = array(
						   'meta_query' => array(
						       array(
						           'key' => 'abm_jenis_aset',
						           'value' => $_POST['jenis_aset'],
						           'compare' => '=',
						       ),
						       array(
						           'key' => 'abm_kd_upb',
						           'value' => $_POST['kd_upb'],
						           'compare' => '=',
						       ),
						       array(
						           'key' => 'abm_kd_barang',
						           'value' => $kd_barang_all,
						           'compare' => '=',
						       ),
						       array(
						           'key' => 'abm_kd_register',
						           'value' => $No_Reg8,
						           'compare' => '=',
						       ),
						       array(
						           'key' => 'abm_kd_register',
						           'value' => $No_Reg8,
						           'compare' => '=',
						       )
						   )
						);
						$query = new WP_Query($args);
						$url = '';
						$nm_aset = '';
						$post_id = '';
						foreach($query->posts as $post){
					        $url = get_permalink($post);
					        $nm_aset = get_post_meta($post->ID, 'abm_nama_aset', true);
							$post_id = $post->ID;
						}
						$return['post_id'] = $post_id;
						$return['nm_aset'] = $nm_aset;
						$return['url'] = $url;
						$return['query'] = $wpdb->last_query;
						if(empty($post_id)){
							$return['status'] = 'error';
							$return['message'] = 'Kode barang tidak ditemukan!';
						}
					}
				}
				if(!empty($err)){
					$return = array(
						'status' => 'error',
						'message'	=> $err
					);
				}
			}else{
				$return = array(
					'status' => 'error',
					'message'	=> 'Api Key tidak sesuai!'
				);
			}
		}else{
			$return = array(
				'status' => 'error',
				'message'	=> 'Format tidak sesuai!'
			);
		}
		if($no_die){
			return $return;
		}else{
			die(json_encode($return));
		}
	}

	function filter_string($text){
		return addslashes(trim(preg_replace('/\s\s+/', ' ', $text)));
	}

	function get_comment($url){
		return '
			<div class="form-group row">
                <label class="col-md-2 col-form-label">Tanggapan Publik</label>
                <div class="col-md-10">
                    <div id="fb-root"></div>
                    <script>
                        (function (d, s, id) {
                        var js, fjs = d.getElementsByTagName(s)[0];
                        if (d.getElementById(id)) return;
                        js = d.createElement(s); js.id = id;
                        js.src = "//connect.facebook.net/id_ID/all.js#xfbml=1&appId=255775617964700";
                        fjs.parentNode.insertBefore(js, fjs);
                        }(document, "script", "facebook-jssdk"));
                    </script>
                    <div style="margin: auto;" class="fb-comments" data-href="'.$url.'" data-width="700" data-numposts="5"></div>
                </div>
            </div>
		';
	}
}
