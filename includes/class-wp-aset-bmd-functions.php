<?php
class Wp_Aset_Bmd_Simda
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
	
	private $opsi_nilai_rincian;

	private $status_koneksi_simda;
	
	public $custom_mapping;

	public function __construct($plugin_name, $version){

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->status_koneksi_simda = true;
	}

	function CurlSimda($options, $debug=false, $debug_req=false){
		if(
			false == $this->status_koneksi_simda
			|| (
				!empty($_GET) 
				&& !empty($_GET['no_simda'])
			)
		){
			return;
		}
        $query = $options['query'];
        $curl = curl_init();
        $req = array(
            'api_key' => get_option( '_crb_apikey_simda_bmd' ),
            'query' => $query,
            'db' => get_option('_crb_db_simda_bmd')
        );
        set_time_limit(0);
        $req = http_build_query($req);
        $url = get_option( '_crb_url_api_simda_bmd' );
    	if($debug_req){
        	print_r($req); die($url);
    	}
        if(empty($url)){
        	return false;
        }
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $req,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_CONNECTTIMEOUT => 0,
            CURLOPT_TIMEOUT => 10000
        ));

        $response = curl_exec($curl);
        // die($response);
        $err = curl_error($curl);

        curl_close($curl);

        $debug_option = 1;
        if ($err) {
        	$this->status_koneksi_simda = false;
        	$msg = "cURL Error #:".$err." (".$url.")";
        	if($debug_option == 1){
            	die($msg);
        	}else{
        		return $msg;
        	}
        } else {
        	if($debug){
            	print_r($response); die();
        	}
            $ret = json_decode($response);
            if(!empty($ret->error)){
            	if(empty($options['no_debug']) && $debug_option==1){
                	echo "<pre>".print_r($ret, 1)."</pre>"; die();
                }
            }else{
            	if(isset($ret->msg)){
                	return $ret->msg;
            	}else{
        			$this->status_koneksi_simda = false;
            		$msg = $response.' (terkoneksi tapi gagal parsing data!)';
        			if($debug_option == 1){
            			die($msg);
            		}else{
            			return $msg;
            		}
            	}
            }
        }
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

	public function decode_key($value){
		$key = base64_decode($value);
		$key_db = md5(get_option( '_crb_apikey_simda_bmd' ));
		$key = explode($key_db, $key);
		$get = array();
		if(!empty($key[2])){
			$all_get = explode('&', $key[2]);
			foreach ($all_get as $k => $v) {
				$current_get = explode('=', $v);
				$get[$current_get[0]] = $current_get[1];
			}
		}
		return $get;
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
		$post_type = 'page';
		$status = 'private';
		if(!empty($options['post_status'])){
			$status = $options['post_status'];
		}
		if(!empty($options['post_type'])){
			$post_type = $options['post_type'];
		}

		$custom_post = get_page_by_title($options['nama_page'], OBJECT, $post_type);
		$_post = array(
			'post_title'	=> $options['nama_page'],
			'post_content'	=> $options['content'],
			'post_type'		=> $post_type,
			'post_status'	=> $status,
			'comment_status'	=> 'closed'
		);
		if (empty($custom_post) || empty($custom_post->ID)) {
			$id = wp_insert_post($_post);
			$_post['insert'] = 1;
			$_post['ID'] = $id;
			$custom_post = get_page_by_title($options['nama_page'], OBJECT, $post_type);
			if(empty($options['show_header'])){
				update_post_meta($custom_post->ID, 'ast-main-header-display', 'disabled');
				update_post_meta($custom_post->ID, 'footer-sml-layout', 'disabled');
			}
			update_post_meta($custom_post->ID, 'ast-breadcrumbs-content', 'disabled');
			update_post_meta($custom_post->ID, 'ast-featured-img', 'disabled');
			update_post_meta($custom_post->ID, 'site-content-layout', 'page-builder');
			update_post_meta($custom_post->ID, 'site-post-title', 'disabled');
			update_post_meta($custom_post->ID, 'site-sidebar-layout', 'no-sidebar');
			update_post_meta($custom_post->ID, 'theme-transparent-header-meta', 'disabled');
		}else if(!empty($option['update'])){
			$_post['ID'] = $custom_post->ID;
			wp_update_post( $_post );
			$_post['update'] = 1;
		}
		if(!empty($options['custom_url'])){
			$custom_post->custom_url = $options['custom_url'];
		}
		if(!empty($options['no_key'])){
			$link = get_permalink($custom_post);
		}else{
			$link = $this->get_link_post($custom_post);
		}
		return array(
			'title' => $options['nama_page'],
			'url' => $link
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

	public function CekNull($number, $length=2){
        $l = strlen($number);
        $ret = '';
        for($i=0; $i<$length; $i++){
            if($i+1 > $l){
                $ret .= '0';
            }
        }
        $ret .= $number;
        return $ret;
    }

	function gen_user_aset($user = array()){
		global $wpdb;
		if(!empty($user)){
			$username = $user['loginname'];
			$email = $username.'@qodrbee.com';
			$nama_role = $user['role'];
			$role = get_role($nama_role);
			if(empty($role)){
				add_role( $nama_role, $user['nama_role'], array( 
					'read' => true,
					'edit_posts' => true,
					'upload_files' => true,
					'edit_published_posts' => true,
					'publish_posts' => true,
					'edit_others_posts' => true,
					'read_private_posts' => true,
					'edit_private_posts' => true
				) );
			}
			$insert_user = username_exists($username);
			$option = array(
				'user_login' => $username,
				'user_pass' => $user['pass'],
				'user_email' => $email,
				'first_name' => $user['nama'],
				'display_name' => $user['nama'],
				'role' => $nama_role
			);
			if(!$insert_user){
				$insert_user = wp_insert_user($option);
			}else{
				$option['ID'] = $insert_user;
				wp_update_user($option);
			}

			$meta = array(
			    '_crb_nama_skpd' => $user['nama'],
			    '_crb_kd_lokasi' => $user['loginname']
			);
			if(!empty($user['desa'])){
				$meta['_crb_desa'] = $user['desa'];
			}
			if(!empty($user['kecamatan'])){
				$meta['_crb_kecamatan'] = $user['kecamatan'];
			}
		    foreach( $meta as $key => $val ) {
		      	update_user_meta( $insert_user, $key, $val ); 
		    }
		}
	}

	function user_has_role($user_id, $role_name, $return=false){
		if(empty($user_id)){
			return false;
		}
	    $user_meta = get_userdata($user_id);
	    $user_roles = $user_meta->roles;
	    if($return){
	    	return $user_roles;
	    }else{
	    	return in_array($role_name, $user_roles);
	    }
	}
}