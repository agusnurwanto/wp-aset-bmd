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

	private $simda;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version, $simda ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->simda = $simda;

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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-aset-bmd-admin.js', array( 'jquery' ), $this->version, false );

	}

    function allow_access_private_post(){
    	if(
    		!empty($_GET) 
    		&& !empty($_GET['key'])
    	){
    		$key = base64_decode($_GET['key']);
    		$key_db = md5(get_option( '_crb_apikey_simda_bmd' ));
    		$key = explode($key_db, $key);
    		$valid = 0;
    		if(
    			!empty($key[1]) 
    			&& $key[0] == $key[1]
    			&& is_numeric($key[1])
    		){
    			$tgl1 = new DateTime();
    			$date = substr($key[1], 0, strlen($key[1])-3);
    			$tgl2 = new DateTime(date('Y-m-d', $date));
    			$valid = $tgl2->diff($tgl1)->days+1;
    		}
    		if($valid == 1){
	    		global $wp_query;
		        // print_r($wp_query);
		        // print_r($wp_query->queried_object); die('tes');
		        if(!empty($wp_query->queried_object)){
		    		if($wp_query->queried_object->post_status == 'private'){
						wp_update_post(array(
					        'ID'    =>  $wp_query->queried_object->ID,
					        'post_status'   =>  'publish'
				        ));
				        die('<script>window.location =  window.location.href;</script>');
					}else{
						wp_update_post(array(
					        'ID'    =>  $wp_query->queried_object->ID,
					        'post_status'   =>  'private'
				        ));
					}
				}else if($wp_query->found_posts >= 1){
					global $wpdb;
					$sql = $wp_query->request;
					$post = $wpdb->get_results($sql, ARRAY_A);
					if(!empty($post)){
						if($post[0]['post_status'] == 'private'){
							wp_update_post(array(
						        'ID'    =>  $post[0]['ID'],
						        'post_status'   =>  'publish'
					        ));
					        die('<script>window.location =  window.location.href;</script>');
						}else{
							wp_update_post(array(
						        'ID'    =>  $post[0]['ID'],
						        'post_status'   =>  'private'
					        ));
						}
					}
				}
			}
    	}
    }

	function gen_key($key_db = false, $options = array()){
		$now = time()*1000;
		if(empty($key_db)){
			$key_db = md5(get_option( '_crb_apikey_simda_bmd' ));
		}
		$tambahan_url = '';
		if(!empty($options['custom_url'])){
			$custom_url = array();
			foreach ($options['custom_url'] as $k => $v) {
				$custom_url[] = $v['key'].'='.$v['value'];
			}
			$tambahan_url = $key_db.implode('&', $custom_url);
		}
		$key = base64_encode($now.$key_db.$now.$tambahan_url);
		return $key;
	}

	public function get_link_post($custom_post){
		$link = get_permalink($custom_post);
		$options = array();
		if(!empty($custom_post->custom_url)){
			$options['custom_url'] = $custom_post->custom_url;
		}
		if(strpos($link, '?') === false){
			$link .= '?key=' . $this->gen_key(false, $options);
		}else{
			$link .= '&key=' . $this->gen_key(false, $options);
		}
		return $link;
	}

	public function generatePage($options = array()){
		$custom_post = get_page_by_title($options['nama_page'], OBJECT, 'page');

		$_post = array(
			'post_title'	=> $options['nama_page'],
			'post_content'	=> $options['content'],
			'post_type'		=> 'page',
			'post_status'	=> 'private',
			'comment_status'	=> 'closed'
		);
		if (empty($custom_post) || empty($custom_post->ID)) {
			$id = wp_insert_post($_post);
			$_post['insert'] = 1;
			$_post['ID'] = $id;
			$custom_post = get_page_by_title($options['nama_page'], OBJECT, 'page');
			update_post_meta($custom_post->ID, 'ast-breadcrumbs-content', 'disabled');
			update_post_meta($custom_post->ID, 'ast-featured-img', 'disabled');
			update_post_meta($custom_post->ID, 'ast-main-header-display', 'disabled');
			update_post_meta($custom_post->ID, 'footer-sml-layout', 'disabled');
			update_post_meta($custom_post->ID, 'site-content-layout', 'page-builder');
			update_post_meta($custom_post->ID, 'site-post-title', 'disabled');
			update_post_meta($custom_post->ID, 'site-sidebar-layout', 'no-sidebar');
			update_post_meta($custom_post->ID, 'theme-transparent-header-meta', 'disabled');
		}else if(!empty($option['update'])){
			$_post['ID'] = $custom_post->ID;
			wp_update_post( $_post );
			$_post['update'] = 1;
		}
		return array(
			'title' => $options['nama_page'],
			'url' => $this->get_link_post($custom_post)
		);
	}

	public function generateRandomString($length = 10) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}

	function get_status_simda(){
		$cek_status_koneksi_simda = $this->simda->CurlSimda(array(
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
			$pemda = $this->simda->CurlSimda(array(
				'query' => 'select * from ref_pemda',
				'no_debug' => true
			));
			$user = $this->simda->CurlSimda(array(
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

		$link_dashboard = $this->generatePage(array(
			'nama_page' => 'Dasboard Aset Barang Milik Daerah',
			'content' => '[dashboard_aset]'
		));

		// disable carbon field on public
		if( !is_admin() ){
        	return;
        }

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
	        	Field::make( 'html', 'crb_simda_bmd_referensi_html' )
	            	->set_html( 'Referensi: <a target="_blank" href="https://github.com/agusnurwanto/wp-aset-bmd">https://github.com/agusnurwanto/wp-aset-bmd</a>' ),
	        	Field::make( 'html', 'crb_simda_bmd_koneksi_html' )
	            	->set_html( '<b>Configurasi Koneksi Database SIMDA BMD ( Status: '.$status['html'].' )</b>' ),
	            Field::make( 'text', 'crb_url_api_simda_bmd', 'URL API SIMDA' )
            	->set_help_text('Scirpt PHP SIMDA API dibuat terpisah di <a href="https://github.com/agusnurwanto/SIMDA-API-PHP" target="_blank">SIMDA API PHP</a>.'),
	            Field::make( 'text', 'crb_apikey_simda_bmd', 'APIKEY SIMDA' )
	            	->set_default_value($this->generateRandomString()),
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
	            	->set_default_value($kepala_umum_jabatan)
	        ) );
	}
}
