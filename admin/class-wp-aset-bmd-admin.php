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
			'post_status' => 'publish'
		));

		$link_dashboard_sewa = $this->functions->generatePage(array(
			'nama_page' => 'Data Aset Yang Disewakan',
			'content' => '[dashboard_aset_disewakan]',
        	'show_header' => 1,
        	'no_key' => 1,
			'post_status' => 'publish'
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

		$basic_options_container = Container::make( 'theme_options', __( 'Aset BMD' ) )
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

		Container::make( 'theme_options', __( 'Tampilan Beranda' ) )
			->set_page_parent( $basic_options_container )
		    ->add_tab( __( 'Background' ), array(
		    	Field::make( 'complex', 'crb_background', 'Background Header' )
		    		->add_fields( 'header_utama', array(
				        Field::make( 'image', 'gambar', 'Gambar' )
		        			->set_value_type('url')
		        			->set_default_value(plugin_dir_url(dirname(__FILE__)).'public/images/bg_video.jpg')
		        		) ),
		        Field::make( 'image', 'crb_background_fitur', 'Background Fitur' )
        			->set_value_type('url')
        			->set_default_value(plugin_dir_url(dirname(__FILE__)).'public/images/bg_fitur.jpg'),
		        Field::make( 'image', 'crb_background_pratinjau', 'Background Pratinjau' )
        			->set_value_type('url')
        			->set_default_value(plugin_dir_url(dirname(__FILE__)).'public/images/bg_pratinjau.jpg'),
		        Field::make( 'image', 'crb_background_video', 'Background Video' )
        			->set_value_type('url')
        			->set_default_value(plugin_dir_url(dirname(__FILE__)).'public/images/bg_video.jpg')
		    ) )
		    ->add_tab( __( 'Logo & Menu' ), array(
		        Field::make( 'image', 'crb_menu_logo', __( 'Gambar Logo' ) )
		        	->set_value_type('url')
        			->set_default_value('https://via.placeholder.com/135x25'),
		        Field::make( 'image', 'crb_menu_logo_loading', __( 'Gambar Loading' ) )
		        	->set_value_type('url')
        			->set_default_value(plugin_dir_url(dirname(__FILE__)).'public/images/logo.png'),
		    	Field::make( 'textarea', 'crb_menu_kanan', __( 'Menu Kanan' ) )
        			->set_default_value(''
						.'<li class="active"><a href="#header" class="scroll">Beranda</a></li>'
						.'<li class=""><a href="#testimoni" class="scroll">Testimoni</a></li>'
						.'<li class=""><a href="#fitur" class="scroll">Fitur</a></li>'
						.'<li class=""><a href="#pratinjau" class="scroll">Pratinjau</a></li>'
						.'<li class=""><a href="#demo-video" class="scroll">Video</i></a></li>'
						.'<li class=""><a href="#monitoring" class="scroll">Monitoring</a></li>'),
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
		    ->add_tab( __( 'Monitoring Data' ), array(
		        Field::make( 'textarea', 'crb_judul_monitoring', __( 'Judul' ) )
        			->set_default_value('<span>Monitoring</span> <span style="color: #000">SIMATA</span>'),
		        Field::make( 'text', 'crb_total_nilai', __( 'Total nilai aset pemerintah daerah' ) )
            		->set_attribute('type', 'number')
        			->set_default_value('6977197616941.44'),
		        Field::make( 'text', 'crb_jumlah_sub_unit', __( 'Jumlah sub unit' ) )
            		->set_attribute('type', 'number')
        			->set_default_value('114')
		    ) )
		    ->add_tab( __( 'Sewa Aset' ), array(
		        Field::make( 'textarea', 'crb_judul_sewa_aset', __( 'Judul' ) )
        			->set_default_value('<span>Aset</span> <span style="color: #000">Disewakan</span>'),
		        Field::make( 'text', 'crb_total_potensi_aset', __( 'Total nilai potensi aset yang disewakan' ) )
            		->set_attribute('type', 'number')
        			->set_default_value('5000000000'),
		        Field::make( 'text', 'crb_jumlah_aset_disewakan', __( 'Jumlah aset disewakan' ) )
            		->set_attribute('type', 'number')
        			->set_default_value('5000000000'),
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
        			->set_default_value(plugin_dir_url(dirname(__FILE__)).'public/images/lokasi.png'),
	        	Field::make( 'color', 'crb_warna_gedung', 'Warna garis aset Gedung dan Bangunan' )
	        		->set_default_value('#CC0003'),
	        	Field::make( 'image', 'crb_icon_gedung', 'Icon aset Gedung dan Bangunan' )
	        		->set_value_type('url')
        			->set_default_value(plugin_dir_url(dirname(__FILE__)).'public/images/lokasi.png'),
	        	Field::make( 'color', 'crb_warna_jalan', 'Warna garis aset Jalan, Jaringan dan Irigrasi' )
	        		->set_default_value('#005ACC'),
	        	Field::make( 'image', 'crb_icon_jalan', 'Icon aset Jaringan dan Irigrasi' )
	        		->set_value_type('url')
        			->set_default_value(plugin_dir_url(dirname(__FILE__)).'public/images/lokasi.png')
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
