<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/agusnurwanto
 * @since      1.0.0
 *
 * @package    Wp_Aset_Bmd
 * @subpackage Wp_Aset_Bmd/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Aset_Bmd
 * @subpackage Wp_Aset_Bmd/admin
 * @author     Agus Nurwanto <agusnurwantomuslim@gmail.com>
 */
use Carbon_Fields\Container;
use Carbon_Fields\Field;

class Wp_Aset_Bmd_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version, $functions ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->functions = $functions;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-aset-bmd-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name.'jszip', plugin_dir_url( __FILE__ ) . 'js/jszip.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name.'xlsx', plugin_dir_url( __FILE__ ) . 'js/xlsx.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-aset-bmd-admin.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'wp_aset_bmd', array(
		    'api_key' => get_option( '_crb_apikey_simda_bmd' )
		));

	}

	function get_status_simda(){
		$cek_status_koneksi_simda = $this->functions->CurlSimda(array(
			'query' => 'select top 1 * from ref_version ORDER BY Tgl_Update DESC',
			'no_debug' => true
		));
		$ket_simda = '<b style="color:red">Belum terkoneksi ke simda!</b>';
		$data = array(
			'nama_pemda' => '',
			'alamat_pemda' => '',
			'tahun_anggaran' => '',
			'kepala_daerah' => '',
			'kepala_daerah_jabatan' => '',
			'sekda' => '',
			'sekda_nip' => '',
			'sekda_jabatan' => '',
			'kepala_umum' => '',
			'kepala_umum_nip' => '',
			'kepala_umum_jabatan' => ''
		);
		if(!empty($cek_status_koneksi_simda)){
			$ket_simda = '<b style="color: green">Terkoneksi database SIMDABMD versi '.$cek_status_koneksi_simda[0]->LastAplDBVer.'</b>';
			$pemda = $this->functions->CurlSimda(array(
				'query' => 'select * from ref_pemda',
				'no_debug' => true
			));
			$user = $this->functions->CurlSimda(array(
				'query' => 'select top 1 * from ta_pemda ORDER BY tahun DESC',
				'no_debug' => true
			));
			$data = array(
				'nama_pemda' => $pemda[0]->Nm_Pemda,
				'alamat_pemda' => $pemda[0]->Alamat,
				'tahun_anggaran' => $user[0]->Tahun,
				'kepala_daerah' => $user[0]->Nm_PimpDaerah,
				'kepala_daerah_jabatan' => $user[0]->Jab_PimpDaerah,
				'sekda' => $user[0]->Nm_Sekda,
				'sekda_nip' => $user[0]->Nip_Sekda,
				'sekda_jabatan' => $user[0]->Jbt_Sekda,
				'kepala_umum' => $user[0]->Nm_Ka_Umum,
				'kepala_umum_nip' => $user[0]->Nip_Ka_Umum,
				'kepala_umum_jabatan' => $user[0]->Jbt_Ka_Umum
			);
		}
		return array(
			'html' => $ket_simda,
			'data' => $data
		);
	}

	function crb_attach_simda_options(){
		global $wpdb;

		// disable carbon field on public
		if( !is_admin() ){
        	return;
        }

		$link_dashboard = $this->functions->generatePage(array(
			'nama_page' => 'Dasboard Aset Barang Milik Daerah',
			'content' => '[dashboard_aset]',
        	'show_header' => 1,
        	'no_key' => 1,
			'post_status' => 'public'
		));

		$link_dashboard_sewa = $this->functions->generatePage(array(
			'nama_page' => 'Data Aset Yang Disewakan',
			'content' => '[dashboard_aset_disewakan]',
        	'show_header' => 1,
        	'no_key' => 1,
			'post_status' => 'public'
		));

        $status = $this->get_status_simda();
        $nama_pemda = $status['data']['nama_pemda'];
        $alamat_pemda = $status['data']['alamat_pemda'];
		$tahun_anggaran = $status['data']['tahun_anggaran'];
		$kepala_daerah = $status['data']['kepala_daerah'];
		$kepala_daerah_jabatan = $status['data']['kepala_daerah_jabatan'];
		$sekda = $status['data']['sekda'];
		$sekda_nip = $status['data']['sekda_nip'];
		$sekda_jabatan = $status['data']['sekda_jabatan'];
		$kepala_umum = $status['data']['kepala_umum'];
		$kepala_umum_nip = $status['data']['kepala_umum_nip'];
		$kepala_umum_jabatan = $status['data']['kepala_umum_jabatan'];

		Container::make( 'theme_options', __( 'Aset BMD' ) )
			->set_page_menu_position( 4 )
	        ->add_fields( array(
	        	Field::make( 'html', 'crb_simda_bmd_dasboard' )
	            	->set_html( '<b>Halaman Dasboard: <a target="_blank" href="'.$link_dashboard['url'].'">'.$link_dashboard['title'].'</a></b>' ),
	        	Field::make( 'html', 'crb_simda_bmd_dasboard_sewa' )
	            	->set_html( '<b>Halaman Data Aset Yang Disewakan: <a target="_blank" href="'.$link_dashboard_sewa['url'].'">'.$link_dashboard_sewa['title'].'</a></b>' ),
	        	Field::make( 'html', 'crb_simda_bmd_referensi_html' )
	            	->set_html( 'Referensi: <a target="_blank" href="https://github.com/agusnurwanto/wp-aset-bmd">https://github.com/agusnurwanto/wp-aset-bmd</a>' ),
	        	Field::make( 'html', 'crb_simda_bmd_koneksi_html' )
	            	->set_html( '<b>Configurasi Koneksi Database SIMDA BMD ( Status: '.$status['html'].' )</b>' ),
	            Field::make( 'text', 'crb_url_api_simda_bmd', 'URL API SIMDA' )
            	->set_help_text('Scirpt PHP SIMDA API dibuat terpisah di <a href="https://github.com/agusnurwanto/SIMDA-API-PHP" target="_blank">SIMDA API PHP</a>.'),
	            Field::make( 'text', 'crb_apikey_simda_bmd', 'APIKEY SIMDA' )
	            	->set_default_value($this->functions->generateRandomString()),
	            Field::make( 'text', 'crb_db_simda_bmd', 'Database SIMDA' ),
	            Field::make( 'text', 'crb_bmd_nama_pemda', 'Nama Pemerintah Daerah' )
	            	->set_default_value($nama_pemda),
	            Field::make( 'text', 'crb_bmd_alamat_pemda', 'Alamat Pemerintah Daerah' )
	            	->set_default_value($alamat_pemda),
	            Field::make( 'text', 'crb_bmd_tahun_anggaran', 'Tahun Anggaran' )
	            	->set_default_value($tahun_anggaran),
	            Field::make( 'text', 'crb_bmd_kepala_daerah', 'Kepala Daerah' )
	            	->set_default_value($kepala_daerah),
	            Field::make( 'text', 'crb_bmd_kepala_daerah_jabatan', 'Jabatan' )
	            	->set_default_value($kepala_daerah_jabatan),
	            Field::make( 'text', 'crb_bmd_sekda', 'Sekretaris Daerah' )
	            	->set_default_value($sekda),
	            Field::make( 'text', 'crb_bmd_sekda_nip', 'NIP Sekretaris Daerah' )
	            	->set_default_value($sekda_nip),
	            Field::make( 'text', 'crb_bmd_sekda_jabatan', 'Jabatan Sekretaris Daerah' )
	            	->set_default_value($sekda_jabatan),
	            Field::make( 'text', 'crb_bmd_kepala_umum', 'Kepala Umum' )
	            	->set_default_value($kepala_umum),
	            Field::make( 'text', 'crb_bmd_kepala_umum_nip', 'NIP Kepala Umum' )
	            	->set_default_value($kepala_umum_nip),
	            Field::make( 'text', 'crb_bmd_kepala_umum_jabatan', 'Jabatan Kepala Umum' )
	            	->set_default_value($kepala_umum_jabatan),
	            Field::make( 'html', 'crb_generate_user_aset' )
	            	->set_html( '<a id="generate_user_aset" onclick="return false;" href="#" class="button button-primary button-large">Generate User SKPD Unit, Sub Unit dan UPB dari database SIMDA BMD</a>' )
	            	->set_help_text('Username SKPD adalah kode lokasi dengan format (<b>Kd_Prov.Kd_Kab_Kota.Kd_Bidang.Kd_Unit.Kd_Sub.Kd_UPB.Kd_Kecamatan.Kd_Desa</b>). Contoh <b>13.5.1.1.1.1.9.5</b> dengan password default yang bisa dirubah sendiri oleh user.'),
		        Field::make( 'html', 'crb_upload_html' )
	            	->set_html( 'Upload file excel .xlsx untuk custom username sub unit : <input type="file" id="file-excel" onchange="filePicked(event);"><br>Contoh format file excel bisa <a target="_blank" href="'.plugin_dir_url( __FILE__ ) . 'excel/contoh.xlsx">download di sini</a>. Sheet file excel yang akan diimport harus diberi nama <b>data</b>.' ),
		        Field::make( 'html', 'crb_textarea_html' )
	            	->set_html( 'Data JSON : <textarea id="data-excel" class="cf-select__input"></textarea>' ),
		        Field::make( 'html', 'crb_save_button' )
	            	->set_html( '<a onclick="import_excel(); return false" href="javascript:void(0);" class="button button-primary">Import Excel Custom username Sub Unit</a>' )
	        ) );
	}

	function generate_user_aset(){
		global $wpdb;
		$ret = array();
		$ret['status'] = 'success';
		$ret['message'] = 'Berhasil Generate User Wordpress dari DB SIMDA BMD';
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option( '_crb_apikey_simda_bmd' )) {
				if(!empty($_POST['data'])){
					$skpd = $this->functions->CurlSimda(array(
					    'query' => '
					        select  
					            u.Kd_Prov, 
					            u.Kd_Kab_Kota, 
					            u.Kd_Bidang, 
					            u.Kd_Unit, 
					            u.Kd_Sub, 
					            u.Nm_Sub_Unit
					        from Ref_Sub_Unit u'
					));
					if(!empty($skpd)){
						$cek_sub = array();
						foreach($_POST['data'] as $user){
							if(
								!empty($user['kode_sub_unit']) 
								&& !empty($user['username'])
							){
								$cek_sub[$user['kode_sub_unit']] = $user;
							}
						}
						foreach ($skpd as $k => $user) {
							$user->pass = $_POST['pass'];
							$kd_sub = $user->Kd_Prov.'.'.$user->Kd_Kab_Kota.'.'.$user->Kd_Bidang.'.'.$user->Kd_Unit.'.'.$user->Kd_Sub;
							$user->nama = $user->Nm_Sub_Unit;
							$user->role = 'user_aset_sub_unit_skpd';
							$user->nama_role = 'User Aset Sub Unit';
							if(!empty($cek_sub[$kd_sub])){
								$user->loginname = $cek_sub[$kd_sub]['username'];
								$this->functions->gen_user_aset((array) $user);
							}
						}
					}
				}else{
					// generate user ref_upb
					$skpd = $this->functions->CurlSimda(array(
					    'query' => '
					        select  
					            u.Kd_Prov, 
					            u.Kd_Kab_Kota, 
					            u.Kd_Bidang, 
					            u.Kd_Unit, 
					            u.Kd_Sub, 
					            u.Kd_UPB, 
					            u.Kd_Kecamatan, 
					            u.Kd_Desa, 
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
					            AND d.Kd_Desa = u.Kd_Desa'
					));
					if(!empty($skpd)){
						foreach ($skpd as $k => $user) {
							$user->pass = $_POST['pass'];
							$user->loginname = $user->Kd_Prov.'.'.$user->Kd_Kab_Kota.'.'.$user->Kd_Bidang.'.'.$user->Kd_Unit.'.'.$user->Kd_Sub.'.'.$user->Kd_UPB.'.'.$user->Kd_Kecamatan.'.'.$user->Kd_Desa;
							$user->nama = $user->Nm_UPB;
							$user->kecamatan = $user->Nm_Kecamatan;
							$user->desa = $user->Nm_Desa;
							$user->role = 'user_aset_skpd';
							$user->nama_role = 'User Aset UPB';
							$this->functions->gen_user_aset((array) $user);
						}
					}
					// generate user ref_sub_unit
					$skpd = $this->functions->CurlSimda(array(
					    'query' => '
					        select  
					            u.Kd_Prov, 
					            u.Kd_Kab_Kota, 
					            u.Kd_Bidang, 
					            u.Kd_Unit, 
					            u.Kd_Sub, 
					            u.Nm_Sub_Unit
					        from Ref_Sub_Unit u'
					));
					if(!empty($skpd)){
						foreach ($skpd as $k => $user) {
							$user->pass = $_POST['pass'];
							$user->loginname = $user->Kd_Prov.'.'.$user->Kd_Kab_Kota.'.'.$user->Kd_Bidang.'.'.$user->Kd_Unit.'.'.$user->Kd_Sub;
							$user->nama = $user->Nm_Sub_Unit;
							$user->role = 'user_aset_sub_unit_skpd';
							$user->nama_role = 'User Aset Sub Unit';
							$this->functions->gen_user_aset((array) $user);
						}
					}
					// generate user ref_unit
					$skpd = $this->functions->CurlSimda(array(
					    'query' => '
					        select  
					            u.Kd_Prov, 
					            u.Kd_Kab_Kota, 
					            u.Kd_Bidang, 
					            u.Kd_Unit,
					            u.Nm_Unit
					        from Ref_Unit u'
					));
					if(!empty($skpd)){
						foreach ($skpd as $k => $user) {
							$user->pass = $_POST['pass'];
							$user->loginname = $user->Kd_Prov.'.'.$user->Kd_Kab_Kota.'.'.$user->Kd_Bidang.'.'.$user->Kd_Unit;
							$user->nama = $user->Nm_Unit;
							$user->role = 'user_aset_unit_skpd';
							$user->nama_role = 'User Aset Unit';
							$this->functions->gen_user_aset((array) $user);
						}
					}
				}
			} else {
				$ret['status'] = 'error';
				$ret['message'] = 'APIKEY tidak sesuai!';
			}
		} else {
			$ret['status'] = 'error';
			$ret['message'] = 'Format Salah!';
		}
		die(json_encode($ret));
	}

	function posts_where_request($where){
		global $wpdb;
		$user_id = get_current_user_id();
		if(
			$this->functions->user_has_role($user_id, 'user_aset_skpd')
			|| $this->functions->user_has_role($user_id, 'user_aset_unit_skpd')
			|| $this->functions->user_has_role($user_id, 'user_aset_sub_unit_skpd')
		){
			$kd_lokasi_user = get_user_meta($user_id, '_crb_kd_lokasi', true);
			$kd_lokasi = explode('.', $kd_lokasi_user);
			foreach($kd_lokasi as $i => $v){
				$kd_lokasi[$i] = $this->functions->CekNull($v);
			}
			$kd_lokasi_user = implode('.', $kd_lokasi);
			$where .= " AND ".$wpdb->prefix."posts.post_title like '%".$kd_lokasi_user."%'";
		}
		return $where;
	}
}
