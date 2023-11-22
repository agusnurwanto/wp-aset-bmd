<?php
global $wpdb;
$nama_pemda = get_option('_crb_bmd_nama_pemda');
$tahun_anggaran = get_option('_crb_bmd_tahun_anggaran');
$api_key = get_option( '_crb_apikey_simda_bmd' );

$no_plat = '';
$aset = '';
$kode_upb = '';
$kode_barang = '';
if(!empty($_GET) && !empty($_GET['no_plat'])){
	$no_plat = $_GET['no_plat'];
	$sql = $wpdb->prepare("
	    SELECT 
			a.*,
	        r.Nm_Aset5,
	        d.Nm_UPB,
	        e.Nm_Kecamatan,
	        f.Nm_Desa
	    from Ta_KIB_B a
	    LEFT JOIN ref_upb d ON d.Kd_Prov = a.Kd_Prov
	        AND d.Kd_Kab_Kota = a.Kd_Kab_Kota
	        AND d.Kd_Bidang = a.Kd_Bidang
	        AND d.Kd_Unit = a.Kd_Unit
	        AND d.Kd_Sub = a.Kd_Sub
	        AND d.Kd_UPB = a.Kd_UPB
	        AND (d.Kd_Kecamatan = a.Kd_Kecamatan OR d.Kd_Kecamatan is null)
	        AND (d.Kd_Desa = a.Kd_Desa OR d.Kd_Desa is null)
	    LEFT JOIN ref_kecamatan e on e.Kd_Prov=a.Kd_Prov
	        AND e.Kd_Kab_Kota = a.Kd_Kab_Kota
	        AND e.Kd_Kecamatan = a.Kd_Kecamatan
	    LEFT JOIN ref_desa f on f.Kd_Prov=a.Kd_Prov
	        AND f.Kd_Kab_Kota = a.Kd_Kab_Kota
	        AND f.Kd_Kecamatan = a.Kd_Kecamatan
	        AND f.Kd_Desa = a.Kd_Desa
	    LEFT JOIN Ref_Rek5_108 r on r.kd_aset=a.Kd_Aset8 
	        and r.kd_aset0=a.Kd_Aset80 
	        and r.kd_aset1=a.Kd_Aset81 
	        and r.kd_aset2=a.Kd_Aset82 
	        and r.kd_aset3=a.Kd_Aset83 
	        and r.kd_aset4=a.Kd_Aset84 
	        and r.kd_aset5=a.Kd_Aset85
	    where a.Nomor_Polisi=%s
	", $no_plat);
	$aset = $this->functions->CurlSimda(array(
	    'query' => $sql 
	));
	$html = '<table class="table table-bordered">';
	if(!empty($aset)){
		foreach($aset as $val){
			$val->kode_upb = '12.'.$this->functions->CekNull($val->Kd_Prov).'.'.$this->functions->CekNull($val->Kd_Kab_Kota).'.'.$this->functions->CekNull($val->Kd_Bidang).'.'.$this->functions->CekNull($val->Kd_Unit).'.'.$this->functions->CekNull($val->Kd_Sub).'.'.$this->functions->CekNull($val->Kd_UPB).'.'.$this->functions->CekNull($val->Kd_Kecamatan).'.'.$this->functions->CekNull($val->Kd_Desa);
			$val->kode_barang = $val->Kd_Aset8.'.'.$val->Kd_Aset80.'.'.$this->functions->CekNull($val->Kd_Aset81).'.'.$this->functions->CekNull($val->Kd_Aset82).'.'.$this->functions->CekNull($val->Kd_Aset83).'.'.$this->functions->CekNull($val->Kd_Aset84).'.'.$this->functions->CekNull($val->Kd_Aset85, 3).'.'.$this->functions->CekNull($val->No_Reg8, 3);
			$kode_upb = $val->kode_upb;
			$kode_barang = $val->kode_barang;
			foreach($val as $k => $v){
				if(is_numeric($k)){
					continue;
				}
				$html .= '
				<tr>
					<td>'.$k.'</td>
					<td>:</td>
					<td><b>'.$v.'</b></td>
				</tr>';
			}
		}
	}
	$html .= '</table>';
	$aset = '
		<div class="form-group row">
            <div class="col-md-12">
                '.$html.'
            </div>
        </div>';
}

?>
<style type="text/css">
    .warning {
        background: #f1a4a4;
    }
    .hide, nav.post-navigation, header.entry-header {
        display: none;
    }
</style>
<div class="cetak">
    <div style="padding: 10px;">
    	<div class="row">
    		<div class="col-md-6">
		        <h2 class="text-center">Cek Plat Nomor Mesin</h2>
		        <form>
		            <div class="form-group row">
		                <label class="col-md-4 col-form-label">Masukan Plat Nomor</label>
		                <div class="col-md-8">
		                    <input type="text" class="form-control" name="no_plat" value="<?php echo $no_plat; ?>" placeholder="AE 8081 EP">
		                </div>
		            </div>
		            <div class="form-group row">
					    <div class="col-md-12">
					        <button class="btn btn-primary">Cari</button>
					    </div>
					</div>
					<?php echo $aset; ?>
		       	</form>
		    </div>
    		<div class="col-md-6">
		        <h2 class="text-center">Get URL Halaman Aset</h2>
		        <form>
		            <div class="form-group row">
		                <label class="col-md-4 col-form-label">Masukan Kode UPB</label>
		                <div class="col-md-8">
		                    <input type="text" class="form-control" name="no_upb" value="<?php echo $kode_upb; ?>" placeholder="">
		                </div>
		            </div>
		            <div class="form-group row">
		                <label class="col-md-4 col-form-label">Pilih Jenis Aset</label>
		                <div class="col-md-8">
		                    <select class="form-control" id="pilih_jenis_aset">
		                    	<option value="tanah">Tanah</option>
		                    	<option value="mesin" selected>Mesin</option>
		                    	<option value="bangunan">Bangunan</option>
		                    	<option value="jalan">Jalan</option>
		                    	<option value="aset_tetap">Aset Tetap Lainnya</option>
		                    	<option value="bangunan_dalam_pengerjaan">Kontruksi Dalam Pengerjaan</option>
		                    </select>
		                </div>
		            </div>
		            <div class="form-group row">
		                <label class="col-md-4 col-form-label">Masukan Kode Barang</label>
		                <div class="col-md-8">
		                    <input type="text" class="form-control" name="kode_barang" value="<?php echo $kode_barang; ?>" placeholder="">
		                </div>
		            </div>
		            <div class="form-group row">
					    <div class="col-md-12">
					        <button class="btn btn-primary" onclick="get_data_barang(); return false;">Proses</button>
					    </div>
					</div>
					<div id="result_get_barang"></div>
		       	</form>
		    </div>
		</div>
    </div>
</div>
<script type="text/javascript">
function get_data_barang(){
	var kd_upb = jQuery('input[name="no_upb"]').val();
    if(kd_upb == ''){
        return alert('Kode UPB tidak boleh kosong!');
    }
    var jenis_aset = jQuery('#pilih_jenis_aset').val();
    if(jenis_aset == ''){
        return alert('Jenis aset tidak boleh kosong!');
    }
    var kd_barang = jQuery('input[name="kode_barang"]').val();
    if(kd_barang.split('.').length < 8){
        return alert('Format kode barang harus diisi full dengan termasuk kode register!');
    }

    jQuery('#wrap-loading').show();
    jQuery.ajax({
        url: ajax.url,
        type: "post",
        data: {
            action: 'get_data_barang',
            api_key: "<?php echo $api_key; ?>",
            kd_upb: kd_upb,
            status_aset: 1,
            jenis_aset: jenis_aset,
            kd_barang: kd_barang
        },
        dataType: "json",
        success: function(data){
            jQuery('#wrap-loading').hide();
            if(data.status == 'success'){
            	var html = ''
            		+'<table class="table table-bordered">'
            			+'<tr>'
            				+'<td>Nama Aset</td>'
            				+'<td>:</td>'
            				+'<td>'+data.nm_aset+'</td>'
            			+'</tr>'
            			+'<tr>'
            				+'<td>URL Halaman</td>'
            				+'<td>:</td>'
            				+'<td><a href="'+data.url+'" target="_blank">'+data.url+'</a></td>'
            			+'</tr>'
            		+'</table>';
                jQuery('#result_get_barang').html(html);
            }else{
                alert(data.message);
            }
        },
        error: function(e) {
            console.log(e);
        }
    });
}
</script>