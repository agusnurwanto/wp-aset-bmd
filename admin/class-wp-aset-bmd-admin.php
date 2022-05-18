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
	
	function get_categories_posts(){
		$categories = get_categories();
		$category_name = [];
		foreach ($categories as $key => $value) {
			$category_name[$value->slug] = $value->name;
		}

		return $category_name;
	}

	function crb_attach_simda_options(){
		global $wpdb;

		// disable carbon field on public
		if( !is_admin() ){
        	return;
        }

		$link_dashboard_homepage = $this->functions->generatePage(array(
			'nama_page' => 'Dashboard Aset Barang Milik Daerah',
			'content' => '[dashboard_aset]',
        	'show_header' => 1,
        	'no_key' => 1,
			'post_status' => 'publish'
		));
	    $link_dashboard_pemda = $this->functions->generatePage(array(
	        'nama_page' => 'Dashboard Aset Pemerintah Daerah',
	        'content' => '[dashboard_aset_pemda]',
	        'show_header' => 1,
	        'no_key' => 1,
	        'post_status' => 'publish'
	    ));
	    $link_aset_per_unit = $this->functions->generatePage(array(
	        'nama_page' => 'Aset Per Unit SKPD',
	        'content' => '[aset_per_unit]',
	        'show_header' => 1,
	        'no_key' => 1,
	        'post_status' => 'publish'
	    ));
	    $link_peta_aset = $this->functions->generatePage(array(
	        'nama_page' => 'Peta Aset Pemerintah Daerah',
	        'content' => '[peta_aset]',
	        'show_header' => 1,
	        'no_key' => 1,
	        'post_status' => 'publish'
	    ));
	    $link_dashboard_potensi_sewa = $this->functions->generatePage(array(
	        'nama_page' => 'Data Potensi Aset Yang Disewakan',
	        'content' => '[dashboard_aset_disewakan potensi="1"]',
	        'show_header' => 1,
	        'no_key' => 1,
	        'post_status' => 'publish'
	    ));
		$link_dashboard_sewa = $this->functions->generatePage(array(
			'nama_page' => 'Data Aset Yang Disewakan',
			'content' => '[dashboard_aset_disewakan]',
        	'show_header' => 1,
        	'no_key' => 1,
			'post_status' => 'publish'
		));
		$klasifikasi_aset = $this->functions->generatePage(array(
			'nama_page' => 'Klasifikasi Aset',
			'content' => '[klasifikasi_aset]',
        	'show_header' => 1,
        	'no_key' => 1,
			'post_status' => 'publish'
		));
	    $link_dashboard_tanah = $this->functions->generatePage(array(
	        'nama_page' => 'Data Aset Tanah',
	        'content' => '[dashboard_aset_tanah]',
	        'show_header' => 1,
	        'no_key' => 1,
	        'post_status' => 'publish'
	    ));
	    $aset_perlu_tindak_lanjut = $this->functions->generatePage(array(
	        'nama_page' => 'Aset Perlu Tindak Lanjut',
	        'content' => '[aset_perlu_tindak_lanjut]',
	        'show_header' => 1,
	        'no_key' => 1,
	        'post_status' => 'publish'
	    ));
		$link_dashboard_galeri = $this->functions->generatePage(array(
			'nama_page' => 'Galeri Aset',
			'content' => '[dashboard_galeri]',
        	'show_header' => 1,
        	'no_key' => 1,
			'post_status' => 'publish'
		));
		$petunjuk_penggunaan = $this->functions->generatePage(array(
			'nama_page' => 'Petunjuk Penggunaan',
			'content' => '[petunjuk_penggunaan]',
        	'show_header' => 1,
        	'no_key' => 1,
			'post_status' => 'publish'
		));
		$dokumentasi_sistem = $this->functions->generatePage(array(
			'nama_page' => 'Dokumentasi Sistem',
			'content' => '[dokumentasi_sistem]',
        	'show_header' => 1,
        	'no_key' => 1,
			'post_status' => 'publish'
		));
		$aset_belum_masuk_neraca = $this->functions->generatePage(array(
			'nama_page' => 'Aset Belum Masuk Neraca',
			'content' => '[aset_belum_masuk_neraca]',
        	'show_header' => 1,
        	'no_key' => 1,
			'post_status' => 'publish'
		));
		$temuan_bpk = $this->functions->generatePage(array(
			'nama_page' => 'Temuan BPK',
			'content' => '[temuan_bpk]',
        	'show_header' => 1,
        	'no_key' => 1,
			'post_status' => 'private'
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

		$skpd = $this->functions->CurlSimda(array(
		    'query' => '
		        select 
		            u.Kd_Prov, 
		            u.Kd_Kab_Kota, 
		            u.Kd_Bidang, 
		            u.Kd_Unit, 
		            u.Kd_Sub, 
		            b.Nm_Bidang, 
		            n.Nm_Unit, 
		            s.Nm_Sub_Unit
		        from ref_upb u
		        LEFT JOIN ref_bidang b ON b.Kd_Bidang=u.Kd_Bidang
		        LEFT JOIN Ref_Unit n ON n.Kd_Prov=u.Kd_Prov
		            AND n.Kd_Kab_Kota=u.Kd_Kab_Kota
		            AND n.Kd_Bidang=u.Kd_Bidang
		            AND n.Kd_Unit=u.Kd_Unit
                INNER JOIN ref_sub_unit s ON u.Kd_Prov=s.Kd_Prov
                    AND u.Kd_Kab_Kota = s.Kd_Kab_Kota 
                    AND u.Kd_Bidang = s.Kd_Bidang 
                    AND u.Kd_Unit = s.Kd_Unit 
                    AND u.Kd_Sub = s.Kd_Sub 
		        '
		));
		$cek_skpd = array();
		foreach($skpd as $k => $val){
		    $kd_bidang = '12.'.$this->functions->CekNull($val->Kd_Prov).'.'.$this->functions->CekNull($val->Kd_Kab_Kota).'.'.$this->functions->CekNull($val->Kd_Bidang);
		    $kd_lokasi = $kd_bidang.'.'.$this->functions->CekNull($val->Kd_Unit).'.'.$this->functions->CekNull($val->Kd_Sub);
		    if(empty($cek_skpd[$kd_lokasi])){
		        $cek_skpd[$kd_lokasi] = $val->Nm_Sub_Unit;
		    }else{
		        continue;
		    }
		}

		$kategori_post = $this->get_categories_posts();

		$basic_options_container = Container::make( 'theme_options', __( 'Aset BMD' ) )
			->set_page_menu_position( 4 )
	        ->add_fields( array(
	        	Field::make( 'html', 'crb_simda_bmd_dasboard' )
	            	->set_html( '
	            	<b>HALAMAN TERKAIT</b>
	            	<ul>
	            		<li><b>Beranda: <a target="_blank" href="'.$link_dashboard_homepage['url'].'">'.$link_dashboard_homepage['title'].'</a></b></li>
	            		<li><b>Aset Pemerintah Daerah: <a target="_blank" href="'.$link_dashboard_pemda['url'].'">'.$link_dashboard_pemda['title'].'</a></b></li>
	            		<li><b>Aset Per Unit SKPD: <a target="_blank" href="'.$link_aset_per_unit['url'].'">'.$link_aset_per_unit['title'].'</a></b></li>
	            		<li><b>Peta Aset: <a target="_blank" href="'.$link_peta_aset['url'].'">'.$link_peta_aset['title'].'</a></b></li>
	            		<li><b>Potensi Aset: <a target="_blank" href="'.$link_dashboard_potensi_sewa['url'].'">'.$link_dashboard_potensi_sewa['title'].'</a></b></li>
	            		<li><b>Aset Yang Disewakan: <a target="_blank" href="'.$link_dashboard_sewa['url'].'">'.$link_dashboard_sewa['title'].'</a></b></li>
	            		<li><b>Klasifikasi Aset: <a target="_blank" href="'.$klasifikasi_aset['url'].'">'.$klasifikasi_aset['title'].'</a></b></li>
	            		<li><b>Aset Tanah Bersertifikat: <a target="_blank" href="'.$link_dashboard_tanah['url'].'?sertifikat=1">'.$link_dashboard_tanah['title'].'</a></b></li>
	            		<li><b>Aset Tanah Tidak Bersertifikat: <a target="_blank" href="'.$link_dashboard_tanah['url'].'">'.$link_dashboard_tanah['title'].'</a></b></li>
	            		<li><b>Aset Perlu Tindak Lanjut: <a target="_blank" href="'.$aset_perlu_tindak_lanjut['url'].'">'.$aset_perlu_tindak_lanjut['title'].'</a></b></li>
	            		<li><b>Galeri: <a target="_blank" href="'.$link_dashboard_galeri['url'].'">'.$link_dashboard_galeri['title'].'</a></b></li>
	            		<li><b>Petunjuk Penggunaan: <a target="_blank" href="'.$petunjuk_penggunaan['url'].'">'.$petunjuk_penggunaan['title'].'</a></b></li>
	            		<li><b>Dokumentasi Sistem: <a target="_blank" href="'.$dokumentasi_sistem['url'].'">'.$dokumentasi_sistem['title'].'</a></b></li>
	            		<li><b>Aset Belum Masuk Neraca: <a target="_blank" href="'.$aset_belum_masuk_neraca['url'].'">'.$aset_belum_masuk_neraca['title'].'</a></b></li>
	            		<li><b>Temuan BPK: <a target="_blank" href="'.$temuan_bpk['url'].'">'.$temuan_bpk['title'].'</a></b></li>
	            	</ul>
	            	' ),
	        	Field::make( 'html', 'crb_simda_bmd_referensi_html' )
	            	->set_html( '<b>Referensi: <a target="_blank" href="https://github.com/agusnurwanto/wp-aset-bmd">https://github.com/agusnurwanto/wp-aset-bmd</a></b>' ),
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
	            	->set_html( 'Upload file excel .xlsx untuk custom username sub unit : <input type="file" id="file-excel" onchange="filePicked(event);"><br>Contoh format file excel bisa <a target="_blank" href="'.BMD_PLUGIN_URL . 'excel/contoh.xlsx">download di sini</a>. Sheet file excel yang akan diimport harus diberi nama <b>data</b>.' ),
		        Field::make( 'html', 'crb_textarea_html' )
	            	->set_html( 'Data JSON : <textarea id="data-excel" class="cf-select__input"></textarea>' ),
		        Field::make( 'html', 'crb_save_button' )
	            	->set_html( '<a onclick="import_excel(); return false" href="javascript:void(0);" class="button button-primary">Import Excel Custom username Sub Unit</a>' )
	        ) );

		Container::make( 'theme_options', __( 'Tampilan Beranda' ) )
			->set_page_parent( $basic_options_container )
			->add_tab( __( 'Logo' ), array(
		        Field::make( 'image', 'crb_menu_logo_dashboard', __( 'Gambar Logo' ) )
		        	->set_value_type('url')
        			->set_default_value('https://via.placeholder.com/135x25'),
		        Field::make( 'textarea', 'crb_judul_header', __( 'Judul' ) )
		        	->set_default_value('<span class="rotate text-color">Si</span>stem Informasi <span class="rotate text-color">Ma</span>najemen Da<span class="rotate text-color">ta</span> Aset'),
		        Field::make( 'text', 'crb_menu_video_loading', __( 'Video Loading' ) )
        			->set_default_value(BMD_PLUGIN_URL.'public/images/video-loading.mp4'),
		        Field::make( 'text', 'crb_lama_loading', __( 'Lama Loading' ) )
        			->set_default_value('10000')
            		->set_attribute('type', 'number')
        			->set_help_text('Lama waktu untuk menghilangkan gambar atau video intro. Satuan dalam mili detik.'),
		    	Field::make( 'complex', 'crb_background_beranda', 'Background Beranda' )
		    		->add_fields( 'beranda', array(
				        Field::make( 'image', 'gambar', 'Gambar' )
		        			->set_value_type('url')
		        			->set_default_value(BMD_PLUGIN_URL.'public/images/bg_video.jpg')
		        		) ),
		    ) )
			->add_tab( __( 'Icon & Menu' ), array(
		        Field::make( 'image', 'crb_menu_logo_1', __( 'Gambar Menu 1' ) )
		        	->set_value_type('url')
        			->set_default_value(BMD_PLUGIN_URL . 'public/images/total-aset.png'),
		        Field::make( 'text', 'crb_menu_text_1', __( 'Text Menu 1' ) )
        			->set_default_value('Total Aset'),
		        Field::make( 'text', 'crb_menu_url_1', __( 'URL Menu 1' ) )
        			->set_default_value($link_dashboard_pemda['url']),
		        Field::make( 'rich_text', 'crb_menu_keterangan_1', __( 'Keterangan Menu 1' ) )
        			->set_default_value('keterangan'),
		        Field::make( 'image', 'crb_menu_logo_2', __( 'Gambar Menu 2' ) )
		        	->set_value_type('url')
        			->set_default_value(BMD_PLUGIN_URL . 'public/images/per-opd.png'),
		        Field::make( 'text', 'crb_menu_text_2', __( 'Text Menu 2' ) )
        			->set_default_value('Aset Per Unit SKPD'),
		        Field::make( 'text', 'crb_menu_url_2', __( 'URL Menu 2' ) )
        			->set_default_value($link_aset_per_unit['url']),
		        Field::make( 'rich_text', 'crb_menu_keterangan_2', __( 'Keterangan Menu 2' ) )
        			->set_default_value('keterangan'),
		        Field::make( 'image', 'crb_menu_logo_3', __( 'Gambar Menu 3' ) )
		        	->set_value_type('url')
        			->set_default_value(BMD_PLUGIN_URL . 'public/images/peta.png'),
		        Field::make( 'text', 'crb_menu_text_3', __( 'Text Menu 3' ) )
        			->set_default_value('Peta'),
		        Field::make( 'text', 'crb_menu_url_3', __( 'URL Menu 3' ) )
        			->set_default_value($link_peta_aset['url']),
		        Field::make( 'rich_text', 'crb_menu_keterangan_3', __( 'Keterangan Menu 3' ) )
        			->set_default_value('keterangan'),
		        Field::make( 'image', 'crb_menu_logo_4', __( 'Gambar Menu 4' ) )
		        	->set_value_type('url')
        			->set_default_value(BMD_PLUGIN_URL . 'public/images/disewakan.png'),
		        Field::make( 'text', 'crb_menu_text_4', __( 'Text Menu 4' ) )
        			->set_default_value('Aset Disewakan'),
		        Field::make( 'text', 'crb_menu_url_4', __( 'URL Menu 4' ) )
        			->set_default_value($link_dashboard_sewa['url']),
		        Field::make( 'rich_text', 'crb_menu_keterangan_4', __( 'Keterangan Menu 4' ) )
        			->set_default_value('keterangan'),
		        Field::make( 'image', 'crb_menu_logo_5', __( 'Gambar Menu 5' ) )
		        	->set_value_type('url')
        			->set_default_value(BMD_PLUGIN_URL . 'public/images/potensi.png'),
		        Field::make( 'text', 'crb_menu_text_5', __( 'Text Menu 5' ) )
        			->set_default_value('Potensi Aset'),
		        Field::make( 'text', 'crb_menu_url_5', __( 'URL Menu 5' ) )
        			->set_default_value($link_dashboard_potensi_sewa['url']),
		        Field::make( 'rich_text', 'crb_menu_keterangan_5', __( 'Keterangan Menu 5' ) )
        			->set_default_value('keterangan'),
		        Field::make( 'image', 'crb_menu_logo_6', __( 'Gambar Menu 6' ) )
		        	->set_value_type('url')
        			->set_default_value(BMD_PLUGIN_URL . 'public/images/klasifikasi.png'),
		        Field::make( 'text', 'crb_menu_text_6', __( 'Text Menu 6' ) )
        			->set_default_value('Klasifikasi Aset'),
		        Field::make( 'text', 'crb_menu_url_6', __( 'URL Menu 6' ) )
        			->set_default_value($klasifikasi_aset['url']),
		        Field::make( 'rich_text', 'crb_menu_keterangan_6', __( 'Keterangan Menu 6' ) )
        			->set_default_value('keterangan'),
		        Field::make( 'image', 'crb_menu_logo_7', __( 'Gambar Menu 7' ) )
		        	->set_value_type('url')
        			->set_default_value(BMD_PLUGIN_URL . 'public/images/sertifikat.png'),
		        Field::make( 'text', 'crb_menu_text_7', __( 'Text Menu 7' ) )
        			->set_default_value('Tanah Bersertifikat'),
		        Field::make( 'text', 'crb_menu_url_7', __( 'URL Menu 7' ) )
        			->set_default_value($link_dashboard_tanah['url'].'?sertifikat=1'),
		        Field::make( 'rich_text', 'crb_menu_keterangan_7', __( 'Keterangan Menu 7' ) )
        			->set_default_value('keterangan'.'?sertifikat=1'),
		        Field::make( 'image', 'crb_menu_logo_8', __( 'Gambar Menu 8' ) )
		        	->set_value_type('url')
        			->set_default_value(BMD_PLUGIN_URL . 'public/images/belum-sertifikat.png'),
		        Field::make( 'text', 'crb_menu_text_8', __( 'Text Menu 8' ) )
        			->set_default_value('Tanah Belum Bersertifikat'),
		        Field::make( 'text', 'crb_menu_url_8', __( 'URL Menu 8' ) )
        			->set_default_value($link_dashboard_tanah['url']),
		        Field::make( 'rich_text', 'crb_menu_keterangan_8', __( 'Keterangan Menu 8' ) )
        			->set_default_value('keterangan'),
		        Field::make( 'image', 'crb_menu_logo_9', __( 'Gambar Menu 9' ) )
		        	->set_value_type('url')
        			->set_default_value(BMD_PLUGIN_URL . 'public/images/perlu-tindak-lanjut.png'),
		        Field::make( 'text', 'crb_menu_text_9', __( 'Text Menu 9' ) )
        			->set_default_value('Aset Perlu Tindak Lanjut'),
		        Field::make( 'text', 'crb_menu_url_9', __( 'URL Menu 9' ) )
        			->set_default_value($aset_perlu_tindak_lanjut['url']),
		        Field::make( 'rich_text', 'crb_menu_keterangan_9', __( 'Keterangan Menu 9' ) )
        			->set_default_value('keterangan'),
		        Field::make( 'image', 'crb_menu_logo_10', __( 'Gambar Menu 10' ) )
		        	->set_value_type('url')
        			->set_default_value(BMD_PLUGIN_URL . 'public/images/galeri.png'),
		        Field::make( 'text', 'crb_menu_text_10', __( 'Text Menu 10' ) )
        			->set_default_value('Galeri'),
		        Field::make( 'text', 'crb_menu_url_10', __( 'URL Menu 10' ) )
        			->set_default_value($link_dashboard_galeri['url']),
		        Field::make( 'rich_text', 'crb_menu_keterangan_10', __( 'Keterangan Menu 10' ) )
		        	->set_default_value('keterangan'),
		        Field::make( 'image', 'crb_menu_logo_11', __( 'Gambar Menu 11' ) )
		        	->set_value_type('url')
        			->set_default_value(BMD_PLUGIN_URL . 'public/images/pedoman.png'),
		        Field::make( 'text', 'crb_menu_text_11', __( 'Text Menu 11' ) )
        			->set_default_value('Petunjuk Penggunaan'),
		        Field::make( 'text', 'crb_menu_url_11', __( 'URL Menu 11' ) )
        			->set_default_value($petunjuk_penggunaan['url']),
		        Field::make( 'rich_text', 'crb_menu_keterangan_11', __( 'Keterangan Menu 11' ) )
		        	->set_default_value('keterangan'),
		        Field::make( 'image', 'crb_menu_logo_0', __( 'Gambar Menu Lainya' ) )
		        	->set_value_type('url')
        			->set_default_value(BMD_PLUGIN_URL . 'public/images/lainnya.png'),
		        Field::make( 'text', 'crb_menu_text_0', __( 'Text Menu Lainya' ) )
        			->set_default_value('Lainnya'),
		        Field::make( 'rich_text', 'crb_menu_keterangan_0', __( 'Keterangan Menu Lainya' ) )
		        	->set_default_value('keterangan'),
		        Field::make( 'image', 'crb_menu_logo_12', __( 'Gambar Menu 12' ) )
		        	->set_value_type('url')
        			->set_default_value(BMD_PLUGIN_URL . 'public/images/dokumentasi.png'),
		        Field::make( 'text', 'crb_menu_text_12', __( 'Text Menu 12' ) )
        			->set_default_value('Dokumentasi Sistem'),
		        Field::make( 'text', 'crb_menu_url_12', __( 'URL Menu 12' ) )
        			->set_default_value($dokumentasi_sistem['url']),
		        Field::make( 'rich_text', 'crb_menu_keterangan_12', __( 'Keterangan Menu 12' ) )
		        	->set_default_value('keterangan'),
		        Field::make( 'image', 'crb_menu_logo_13', __( 'Gambar Menu 13' ) )
		        	->set_value_type('url')
        			->set_default_value(BMD_PLUGIN_URL . 'public/images/neraca.png'),
		        Field::make( 'text', 'crb_menu_text_13', __( 'Text Menu 13' ) )
        			->set_default_value('Aset Belum Masuk Neraca'),
		        Field::make( 'text', 'crb_menu_url_13', __( 'URL Menu 13' ) )
        			->set_default_value($aset_belum_masuk_neraca['url']),
		        Field::make( 'rich_text', 'crb_menu_keterangan_13', __( 'Keterangan Menu 13' ) )
		        	->set_default_value('keterangan'),
		        Field::make( 'image', 'crb_menu_logo_14', __( 'Gambar Menu 14' ) )
		        	->set_value_type('url')
        			->set_default_value(BMD_PLUGIN_URL . 'public/images/temuan-bpk.png'),
		        Field::make( 'text', 'crb_menu_text_14', __( 'Text Menu 14' ) )
        			->set_default_value('Temuan BPK'),
		        Field::make( 'text', 'crb_menu_url_14', __( 'URL Menu 14' ) )
        			->set_default_value($temuan_bpk['url']),
		        Field::make( 'rich_text', 'crb_menu_keterangan_14', __( 'Keterangan Menu 14' ) )
		        	->set_default_value('keterangan')
		    ) )
			->add_tab( __( 'Sub Unit' ), array(
				Field::make( 'multiselect', 'crb_sub_unit_pilihan', __( 'Sub Unit Pilihan' ) )
        			->add_options( $cek_skpd )
        			->set_help_text('Sub unit yang akan ditampilkan saat masuk ke halaman total aset per SKPD.')
		    ) )
			->add_tab( __( 'Petunjuk Penggunaan' ), array(
				Field::make( 'complex', 'crb_petunjuk_penggunaan', 'Keterangan Tambahan' )
		    		->add_fields( 'keterangan', array(
				        Field::make( 'text', 'judul', 'Judul' )
		        			->set_default_value('Petunjuk'),
				        Field::make( 'image', 'gambar', 'Gambar' )
		        			->set_value_type('url')
		        			->set_default_value('https://via.placeholder.com/100x100'),
				        Field::make( 'rich_text', 'deskripsi', 'Deskripsi' )
		        			->set_default_value('Penjelasan')
	        		) )
		    ) );

		Container::make( 'theme_options', __( 'Tampilan Galeri' ) )
			->set_page_parent( $basic_options_container )
		    ->add_tab( __( 'Logo & Menu' ), array(
		        Field::make( 'image', 'crb_menu_logo', __( 'Gambar Logo Galeri' ) )
		        	->set_value_type('url')
        			->set_default_value('https://via.placeholder.com/135x25'),
		    	Field::make( 'textarea', 'crb_menu_kanan', __( 'Menu Kanan' ) )
        			->set_default_value(''
						.'<li class="active"><a href="#header" class="scroll">Beranda</a></li>'
						.'<li class=""><a href="#testimoni" class="scroll">Testimoni</a></li>'
						.'<li class=""><a href="#fitur" class="scroll">Fitur</a></li>'
						.'<li class=""><a href="#pratinjau" class="scroll">Pratinjau</a></li>'
						.'<li class=""><a href="#blog" class="scroll">Blog</a></li>'
						.'<li class=""><a href="#demo-video" class="scroll">Video</i></a></li>'
						.'<li class=""><a href="#monitoring" class="scroll">Monitoring</a></li>'),
		    ) )
		    ->add_tab( __( 'Background' ), array(
		    	Field::make( 'complex', 'crb_background', 'Background Header' )
		    		->add_fields( 'header_utama', array(
				        Field::make( 'image', 'gambar', 'Gambar' )
		        			->set_value_type('url')
		        			->set_default_value(BMD_PLUGIN_URL.'public/images/bg_video.jpg')
		        		) ),
		        Field::make( 'image', 'crb_background_fitur', 'Background Fitur' )
        			->set_value_type('url')
        			->set_default_value(BMD_PLUGIN_URL.'public/images/bg_fitur.jpg'),
		        Field::make( 'image', 'crb_background_pratinjau', 'Background Pratinjau' )
        			->set_value_type('url')
        			->set_default_value(BMD_PLUGIN_URL.'public/images/bg_pratinjau.jpg'),
		        Field::make( 'image', 'crb_background_video', 'Background Video' )
        			->set_value_type('url')
        			->set_default_value(BMD_PLUGIN_URL.'public/images/bg_video.jpg')
		    ) )
		    ->add_tab( __( 'Header Utama' ), array(
		        Field::make( 'textarea', 'crb_judul_header_1', __( 'Judul' ) )
		        	->set_default_value('<span class="rotate text-color">Si</span>stem Informasi <span class="rotate text-color">Ma</span>najemen Da<span class="rotate text-color">ta</span> Aset'),
		        Field::make( 'textarea', 'crb_text_header_1', __( 'Text' ) )
		        	->set_default_value('Sistem Informasi Manajemen Data Aset atau bisa disingkat dengan SIMATA adalah aplikasi yang dikembangkan oleh Badan Pengelola Keuangan dan Aset Daerah Kabupaten Madiun (BPKAD) untuk menampilkan data aset pemerintah kabupaten Madiun secara daring. SIMATA terintegrasi dengan data aset di Sistem Informasi Manajemen Daerah Barang Milik Daerah (SIMDA BMD) dan dilengkapi dengan data meta lain seperti lokasi koordinat google map, foto aset, sejarah aset dan lain sebagainya.'),
		        Field::make( 'textarea', 'crb_tombol_header_1', __( 'Tombol' ) )
		        	->set_default_value('<span class=""><a href="#dokumentasi" class="btn slide-btn scroll" style="font-family: inherit; text-decoration: none;">Dokumentasi</a></span><span class=""><a href="#masuk" class="btn slide-btn bg-inverse scroll" style="font-family: inherit; text-decoration: none;">Masuk</a></span>'),
		        Field::make( 'image', 'crb_img_header_1', __( 'Gambar' ) )
		        	->set_value_type('url')
		        	->set_default_value('https://via.placeholder.com/498x266')
		    ) )
		    ->add_tab( __( 'Testimoni' ), array(
		        Field::make( 'complex', 'crb_testimoni' )
				    ->add_fields( 'testimoni', array(
				        Field::make( 'image', 'gambar', 'Gambar' )
		        			->set_value_type('url')
		        			->set_default_value('https://via.placeholder.com/300x367'),
				        Field::make( 'text', 'nama', 'Nama' )
		        			->set_default_value('Agus Nurwanto (2022) - <span>Masyarakat Umum</span>'),
				        Field::make( 'rich_text', 'pesan', 'Pesan' )
		        			->set_default_value('"Dengan adanya aplikasi SIMATA maka data Barang Milik Daerah (BMD) dapat diakses secara daring."')
				    ) )
		    ) )
		    ->add_tab( __( 'Fitur' ), array(
		        Field::make( 'textarea', 'crb_judul_fitur', __( 'Judul' ) )
        			->set_default_value('<span>Fitur</span> SIMATA'),
		        Field::make( 'image', 'crb_gambar_fitur', __( 'Gambar' ) )
        			->set_value_type('url')
        			->set_default_value('https://via.placeholder.com/359x358'),
		        Field::make( 'text', 'crb_fitur_icon1', 'Icon 1' )
					->set_default_value('<i class="fa fa-university fa-3x"></i>'),
		        Field::make( 'text', 'crb_fitur_judul1', 'Judul 1' )
					->set_default_value('TRANSPARANSI'),
		        Field::make( 'rich_text', 'crb_fitur_pesan1', 'Pesan 1' )
        			->set_default_value('<p>Barang milik daerah ditampilkan secara daring, sehingga bsia diakses oleh masyarakat umum.</p>'),
		        Field::make( 'text', 'crb_fitur_icon2', 'Icon 2' )
					->set_default_value('<i class="fa fa-book fa-3x"></i>'),
		        Field::make( 'text', 'crb_fitur_judul2', 'Judul 2' )
					->set_default_value('SEWA ASET'),
		        Field::make( 'rich_text', 'crb_fitur_pesan2', 'Pesan 2' )
        			->set_default_value('<p>Menampilkan data potensi aset dan aset yang disewakan.</p>'),
		        Field::make( 'text', 'crb_fitur_icon3', 'Icon 3' )
					->set_default_value('<i class="fa fa-lightbulb-o fa-3x"></i>'),
		        Field::make( 'text', 'crb_fitur_judul3', 'Judul 3' )
					->set_default_value('PERENCANAAN'),
		        Field::make( 'rich_text', 'crb_fitur_pesan3', 'Pesan 3' )
        			->set_default_value('<p>Membantu penyusunan Rencana Kebutuhan Barang Milik Daerah.</p>'),
		        Field::make( 'text', 'crb_fitur_icon4', 'Icon 4' )
					->set_default_value('<i class="fa fa-edit fa-3x"></i>'),
		        Field::make( 'text', 'crb_fitur_judul4', 'Judul 4' )
					->set_default_value('INVENTARISASI'),
		        Field::make( 'rich_text', 'crb_fitur_pesan4', 'Pesan 4' )
        			->set_default_value('<p>Mendukung proses pelaksanaan dan pelaporan kegiatan pendataan Aset.</p>'),
		        Field::make( 'text', 'crb_fitur_icon5', 'Icon 5' )
					->set_default_value('<i class="fa fa-binoculars fa-3x"></i>'),
		        Field::make( 'text', 'crb_fitur_judul5', 'Judul 5' )
					->set_default_value('PENGAWASAN'),
		        Field::make( 'rich_text', 'crb_fitur_pesan5', 'Pesan 5' )
        			->set_default_value('<p>Membantu kegiatan pengawasan & pengendalian BMD.</p>'),
		        Field::make( 'text', 'crb_fitur_icon6', 'Icon 6' )
					->set_default_value('<i class="fa fa-handshake-o fa-3x"></i>'),
		        Field::make( 'text', 'crb_fitur_judul6', 'Judul 6' )
					->set_default_value('PENGELOLAAN'),
		        Field::make( 'rich_text', 'crb_fitur_pesan6', 'Pesan 6' )
        			->set_default_value('<p>Membantu penyusunan & pengajuan permohonan BMD.</p>')
		    ) )
		    ->add_tab( __( 'Pratinjau' ), array(
		        Field::make( 'textarea', 'crb_judul_pratinjau', __( 'Judul' ) )
        			->set_default_value('Pratinjau <span>SIMATA</span>'),
		        Field::make( 'complex', 'crb_pratinjau' )
				    ->add_fields( 'gambar', array(
				        Field::make( 'image', 'gambar', 'Gambar' )
        				->set_value_type('url')
        				->set_default_value('https://via.placeholder.com/1024x576')
				    ) )
		    ) )
		    ->add_tab( __( 'Video' ), array(
		        Field::make( 'textarea', 'crb_judul_video', __( 'Judul' ) )
        			->set_default_value('<span>Tentang</span> SIMATA'),
				Field::make( 'text', 'crb_video_demo', 'Url Video Youtube' )
        			->set_default_value('https://www.youtube.com/embed/8wDyFBXkWaM?controls=0&autoplay=1')
        			->set_help_text('Masukan link youtube dengan format embed. Contoh https://www.youtube.com/embed/ZbXSzejdyEE?controls=0&autoplay=1'),
				Field::make( 'radio', 'crb_video_autoplay', 'Autoplay Video' )
					->add_options( array(
				        '1' => 'Iya',
				        '2' => 'Tidak'
				    ) )
        			->set_default_value('1')
        			->set_help_text('Jika dipilih iya, maka video akan otomatis dinyalakan ketika user melakukan event klik pada halaman.')
		    ) )
			->add_tab( __( 'Blog' ), array(
		        Field::make( 'textarea', 'crb_judul_blog', __( 'Judul' ) )
        			->set_default_value('<span>Monitoring</span> <span style="color: #000">SIMATA</span>'),
		        Field::make( 'select', 'crb_kategori_blog' )
            		->add_options($kategori_post)
		    ) )
		    ->add_tab( __( 'Monitoring Data' ), array(
		        Field::make( 'textarea', 'crb_judul_monitoring', __( 'Judul' ) )
        			->set_default_value('<span>Monitoring</span> <span style="color: #000">SIMATA</span>'),
		        Field::make( 'text', 'crb_total_nilai', __( 'Total nilai aset pemerintah daerah' ) )
            		->set_attribute('type', 'number')
        			->set_default_value('6977197616941.44'),
		        Field::make( 'textarea', 'crb_total_per_jenis', __( 'Data total aset per jenis aset' ) )
        			->set_default_value('[]'),
		        Field::make( 'textarea', 'crb_total_per_bidang', __( 'Data total aset per bidang urusan' ) )
        			->set_default_value('[]'),
		        Field::make( 'textarea', 'crb_total_per_skpd', __( 'Data total aset per unit SKPD' ) )
        			->set_default_value('[]'),
		        Field::make( 'text', 'crb_jumlah_sub_unit', __( 'Jumlah sub unit' ) )
            		->set_attribute('type', 'number')
        			->set_default_value('114')
		    ) )
		    ->add_tab( __( 'Sewa Aset' ), array(
		        Field::make( 'textarea', 'crb_judul_sewa_aset', __( 'Judul' ) )
        			->set_default_value('<span>Aset</span> <span style="color: #000">Disewakan</span>'),
		        Field::make( 'text', 'crb_total_potensi_aset', __( 'Jumlah aset yang belum disewakan' ) )
            		->set_attribute('type', 'number')
        			->set_default_value('500'),
		        Field::make( 'text', 'crb_jumlah_aset_disewakan', __( 'Jumlah aset disewakan' ) )
            		->set_attribute('type', 'number')
        			->set_default_value('500'),
		        Field::make( 'text', 'crb_jumlah_tanah_sertifikat', __( 'Jumlah aset tanah yang bersetifikat' ) )
            		->set_attribute('type', 'number')
        			->set_default_value('20'),
		        Field::make( 'text', 'crb_jumlah_tanah_belum_sertifikat', __( 'Jumlah aset tanah yang belum bersetifikat' ) )
            		->set_attribute('type', 'number')
        			->set_default_value('20')
		    ) );

		Container::make( 'theme_options', __( 'Google Maps' ) )
			->set_page_parent( $basic_options_container )
			->add_fields( array(
	        	Field::make( 'text', 'crb_google_api', 'Google Maps APIKEY' )
	        		->set_default_value('AIzaSyDBrDSUIMFDIleLOFUUXf1wFVum9ae3lJ0'),
	        	Field::make( 'color', 'crb_warna_tanah', 'Warna garis aset Tanah' )
	        		->set_default_value('#00cc00'),
	        	Field::make( 'image', 'crb_icon_tanah', 'Icon aset Tanah' )
	        		->set_value_type('url')
        			->set_default_value(BMD_PLUGIN_URL.'public/images/lokasi.png'),
	        	Field::make( 'color', 'crb_warna_gedung', 'Warna garis aset Gedung dan Bangunan' )
	        		->set_default_value('#CC0003'),
	        	Field::make( 'image', 'crb_icon_gedung', 'Icon aset Gedung dan Bangunan' )
	        		->set_value_type('url')
        			->set_default_value(BMD_PLUGIN_URL.'public/images/lokasi.png'),
	        	Field::make( 'color', 'crb_warna_jalan', 'Warna garis aset Jalan, Jaringan dan Irigrasi' )
	        		->set_default_value('#005ACC'),
	        	Field::make( 'image', 'crb_icon_jalan', 'Icon aset Jaringan dan Irigrasi' )
	        		->set_value_type('url')
        			->set_default_value(BMD_PLUGIN_URL.'public/images/lokasi.png')
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
							$user->kd_sub = $kd_sub;
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
