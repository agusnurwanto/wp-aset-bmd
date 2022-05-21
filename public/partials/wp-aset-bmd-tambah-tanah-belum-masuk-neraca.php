<?php
	$nama_pemda = get_option('_crb_bmd_nama_pemda');
	$tahun_anggaran = get_option('_crb_bmd_tahun_anggaran');
	$api_key = get_option( '_crb_apikey_simda_bmd' );
	$data_jenis = $this->get_nama_jenis_aset(array('jenis_aset' => $params['key']['jenis_aset']));
	$api_googlemap = get_option( '_crb_google_api' );
	$api_googlemap = "https://maps.googleapis.com/maps/api/js?key=$api_googlemap&callback=initMap&libraries=places";
	$warna_map = get_option('_crb_warna_tanah');
	$ikon_map  = get_option('_crb_icon_tanah');
	$sql = "
		SELECT 
			u.*, 
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
	";
	$upbs = $this->functions->CurlSimda(array(
		'query' => $sql,
		'no_debug' => 0
	));
	$list_upb = '<option value="">Pilih UPB</option>';
	$new_upbs = array();
	foreach($upbs as $i => $val){
		$nama_upb = $val->Nm_UPB;

		$alamat = array();
		if(!empty($val->Nm_Kecamatan)){
		    $alamat[] = 'Kec. '.$val->Nm_Kecamatan;
		}
		if(!empty($val->Nm_Desa)){
		    $alamat[] = 'Desa/Kel. '.$val->Nm_Desa;
		}
		if(!empty($alamat)){
		    $alamat = ' ('.implode(', ', $alamat).')';
		}else{
		    $alamat = '';
		}

		$kd_upb = '12.'.$this->functions->CekNull($val->Kd_Prov).'.'.$this->functions->CekNull($val->Kd_Kab_Kota).'.'.$this->functions->CekNull($val->Kd_Bidang).'.'.$this->functions->CekNull($val->Kd_Unit).'.'.$this->functions->CekNull($val->Kd_Sub).'.'.$this->functions->CekNull($val->Kd_UPB).'.'.$this->functions->CekNull($val->Kd_Kecamatan).'.'.$this->functions->CekNull($val->Kd_Desa);
		$upbs[$i]->kd_upb = $kd_upb;
		$new_upbs[$kd_upb] = $upbs[$i];
		$list_upb .= '<option value="'.$kd_upb.'">'.$kd_upb.'-'.$nama_upb.$alamat.'</option>';
	}
	$_POST['api_key'] = $api_key;
	$_POST['tipe'] = 'rek_0';
	$_POST['selected'] = '1.3';
	$rek_0_ret = $this->get_rek_barang(true);
	$rek_0 = $rek_0_ret['html'];
	$_POST['tipe'] = 'rek_1';
	$_POST['selected'] = '1.3.1';
	$rek_1_ret = $this->get_rek_barang(true);
	$rek_1 = $rek_1_ret['html'];
	$_POST['tipe'] = 'rek_2';
	$_POST['selected'] = '1.3.1.1';
	$rek_2_ret = $this->get_rek_barang(true);
	$rek_2 = $rek_2_ret['html'];
	$_POST['tipe'] = 'rek_3';
	$_POST['selected'] = '1.3.1.1';
	$rek_3_ret = $this->get_rek_barang(true);
	$rek_3 = $rek_3_ret['html'];
	$rek_4 = '<option value="">Pilih Rekening Aset 4</option>';
	$rek_5 = '<option value="">Pilih Rekening Aset 5</option>';
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
        <h2 class="text-center">Tambah Data Barang Milik Daerah<br><?php echo $data_jenis['nama']; ?></h2>
        <form>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Pilih Unit Pengelola Barang</label>
                <div class="col-md-10">
                    <select class="form-control select2" id="pilih_upb"><?php echo $list_upb; ?></select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Kode UPB</label>
                <div class="col-md-4">
                    <input type="text" disabled class="form-control" name="kode_upb" value="">
                </div>
                <label class="col-md-2 col-form-label">Nama Unit Pengelola Barang</label>
                <div class="col-md-4">
                    <input type="text" disabled class="form-control" name="nama_upb" value="">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-md-2 col-form-label">Kecamatan</label>
                <div class="col-md-4">
                    <input type="text" disabled class="form-control" name="kecamatan" value="">
                </div>
                <label class="col-md-2 col-form-label">Desa / Kelurahan</label>
                <div class="col-md-4">
                    <input type="text" disabled class="form-control" name="desa" value="">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2">
                    <select class="form-control select2 rek_aset" id="rek_0"><?php echo $rek_0; ?></select>
                </div>
                <div class="col-md-2">
                    <select class="form-control select2 rek_aset" id="rek_1"><?php echo $rek_1; ?></select>
                </div>
                <div class="col-md-2">
                    <select class="form-control select2 rek_aset" id="rek_2"><?php echo $rek_2; ?></select>
                </div>
                <div class="col-md-2">
                    <select class="form-control select2 rek_aset" id="rek_3"><?php echo $rek_3; ?></select>
                </div>
                <div class="col-md-2">
                    <select class="form-control select2 rek_aset" id="rek_4"><?php echo $rek_4; ?></select>
                </div>
                <div class="col-md-2">
                    <select class="form-control select2 rek_aset" id="rek_5"><?php echo $rek_5; ?></select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Kode Barang</label>
                <div class="col-md-4">
                    <input type="text" disabled class="form-control" id="kd_barang" value="">
                </div>
                <label class="col-md-2 col-form-label">Nomor Register</label>
                <div class="col-md-4">
                    <input type="text" disabled class="form-control" id="kd_register" value="">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Nama Aset</label>
                <div class="col-md-10">
                    <input type="text" disabled class="form-control" id="nama_aset" value="">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Aksi</label>
                <div class="col-md-10">
                    <a onclick="simpan_aset(); return false;" href="#" class="btn btn-primary">Simpan</a> <a style="margin-left: 10px;" href="<?php echo $aset_belum_masuk_neraca['url']; ?>" class="btn btn-danger">Kembali</a>
                </div>
            </div>
       	</form>
    </div>
</div>
<script type="text/javascript" src="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/js/select2.js"></script>
<script type="text/javascript">
	window.upb = <?php echo json_encode($new_upbs); ?>;
	jQuery(document).ready(function(){
		jQuery('.select2').select2();
		jQuery('#pilih_upb').on('change', function(){
			var kd_upb = jQuery(this).val();
			jQuery('input[name="kode_upb"]').val(upb[kd_upb].kd_upb);
			jQuery('input[name="nama_upb"]').val(upb[kd_upb].Nm_UPB);
			jQuery('input[name="kecamatan"]').val(upb[kd_upb].Nm_Kecamatan);
			jQuery('input[name="desa"]').val(upb[kd_upb].Nm_Desa);
		});
		jQuery('.rek_aset').on('change', function(){
			var id = jQuery(this).attr('id');
			var kd_barang = jQuery(this).val();
			var val = jQuery(this).find('option:selected').text().split(' ');
            jQuery('#wrap-loading').show();
            jQuery.ajax({
                url: ajax.url,
                type: "post",
                data: {
                    "action": "get_rek_barang"
                },
                dataType: "json",
                success: function(data){
                    jQuery('#wrap-loading').hide();
                    return alert(data.message);
                },
                error: function(e) {
                    console.log(data);
                    console.log(e);
                    return alert(data.message);
                }
            });
			var nama_aset = '';
			if(id == 'rek_0'){
				jQuery('#rek_1').html('');
				jQuery('#rek_2').html('');
				jQuery('#rek_3').html('');
				jQuery('#rek_4').html('');
				jQuery('#rek_5').html('');
			}else if(id == 'rek_1'){
				jQuery('#rek_2').html('');
				jQuery('#rek_3').html('');
				jQuery('#rek_4').html('');
				jQuery('#rek_5').html('');
			}else if(id == 'rek_2'){
				jQuery('#rek_3').html('');
				jQuery('#rek_4').html('');
				jQuery('#rek_5').html('');
			}else if(id == 'rek_3'){
				jQuery('#rek_4').html('');
				jQuery('#rek_5').html('');
			}else if(id == 'rek_4'){
				jQuery('#rek_5').html('');
			}else if(id == 'rek_5'){
				val.shift();
				nama_aset = val.join(' ');
			}
			jQuery('#kd_barang').val(kd_barang);
			jQuery('#nama_aset').val(nama_aset);
		});
	});
</script>