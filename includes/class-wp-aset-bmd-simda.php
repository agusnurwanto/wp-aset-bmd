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
}