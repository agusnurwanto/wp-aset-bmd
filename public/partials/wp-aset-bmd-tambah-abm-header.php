<?php
$nama_pemda = get_option('_crb_bmd_nama_pemda');
$tahun_anggaran = get_option('_crb_bmd_tahun_anggaran');
$api_key = get_option( '_crb_apikey_simda_bmd' );
$api_googlemap = get_option( '_crb_google_api' );
$api_googlemap = "https://maps.googleapis.com/maps/api/js?key=$api_googlemap&callback=initMap&libraries=places,drawing";
$warna_map = get_option('_crb_warna_tanah');
$ikon_map  = get_option('_crb_icon_tanah');

$where = 'WHERE 1=1';
if(is_user_logged_in()){
    $user_id = get_current_user_id();
    if(
        $this->functions->user_has_role($user_id, 'user_aset_skpd')
        || $this->functions->user_has_role($user_id, 'user_aset_unit_skpd')
        || $this->functions->user_has_role($user_id, 'user_aset_sub_unit_skpd')
    ){
        $kd_lokasi_user = get_user_meta($user_id, '_crb_kd_lokasi', true);
        if(!empty($kd_lokasi_user)){
            $lok = explode('.', $kd_lokasi_user);
            if(!empty($lok[0])){
                $where .= ' AND u.Kd_Prov='.$lok[0];
            }
            if(!empty($lok[1])){
                $where .= ' AND u.Kd_Kab_Kota='.$lok[1];
            }
            if(!empty($lok[2])){
                $where .= ' AND u.Kd_Bidang='.$lok[2];
            }
            if(!empty($lok[3])){
                $where .= ' AND u.Kd_Unit='.$lok[3];
            }
            if(!empty($lok[4])){
                $where .= ' AND u.Kd_Sub='.$lok[4];
            }
            if(!empty($lok[5])){
                $where .= ' AND u.Kd_UPB='.$lok[5];
            }
            if(!empty($lok[6])){
                $where .= ' AND u.Kd_Kecamatan='.$lok[6];
            }
            if(!empty($lok[7])){
                $where .= ' AND u.Kd_Desa='.$lok[7];
            }
        }else{
            $where .= ' AND 1=2';
        }
    }else if(false == $this->functions->user_has_role($user_id, 'administrator')){
        $where .= ' AND 1=2';
    }
}
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
    $where
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
    $selected = '';
    if($abm_kd_upb == $kd_upb){
        $selected = 'selected';
    }
	$list_upb .= '<option value="'.$kd_upb.'" '.$selected.'>'.$kd_upb.'-'.$nama_upb.$alamat.'</option>';
}
$rek_0_selected = '1.3';
$rek_1_selected = '1.3.01';
$rek_2_selected = '1.3.01.01';
$rek_3_selected = '1.3.01.01';
$rek_4_selected = '';
$rek_5_selected = '';
if(!empty($abm_kd_barang)){
    $kd_barang = explode('.', $abm_kd_barang);
    $rek_0_selected = $kd_barang[0].'.'.$kd_barang[1];
    $rek_1_selected = $rek_0_selected.'.'.$this->functions->CekNull($kd_barang[2]);
    $rek_2_selected = $rek_1_selected.'.'.$this->functions->CekNull($kd_barang[3]);
    $rek_3_selected = $rek_2_selected.'.'.$this->functions->CekNull($kd_barang[4]);
    $rek_4_selected = $rek_3_selected.'.'.$this->functions->CekNull($kd_barang[5]);
    $rek_5_selected = $rek_4_selected.'.'.$this->functions->CekNull($kd_barang[6], 3);
}
$_POST['api_key'] = $api_key;
$_POST['tipe'] = 'rek_0';
$_POST['selected'] = $rek_0_selected;
$rek_0_ret = $this->get_rek_barang(true);
$rek_0 = $rek_0_ret['html'];
$_POST['tipe'] = 'rek_1';
$_POST['selected'] = $rek_1_selected;
$rek_1_ret = $this->get_rek_barang(true);
$rek_1 = $rek_1_ret['html'];
$_POST['tipe'] = 'rek_2';
$_POST['selected'] = $rek_2_selected;
$rek_2_ret = $this->get_rek_barang(true);
$rek_2 = $rek_2_ret['html'];
$_POST['tipe'] = 'rek_3';
$_POST['selected'] = $rek_3_selected;
$rek_3_ret = $this->get_rek_barang(true);
$rek_3 = $rek_3_ret['html'];
$rek_4 = '<option value="">Pilih Rekening Aset 4</option>';
if(!empty($rek_4_selected)){
    $_POST['tipe'] = 'rek_4';
    $_POST['selected'] = $rek_4_selected;
    $rek_4_ret = $this->get_rek_barang(true);
    $rek_4 = $rek_4_ret['html'];
}
$rek_5 = '<option value="">Pilih Rekening Aset 5</option>';
if(!empty($rek_5_selected)){
    $_POST['tipe'] = 'rek_5';
    $_POST['selected'] = $rek_5_selected;
    $rek_5_ret = $this->get_rek_barang(true);
    $rek_5 = $rek_5_ret['html'];
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
<?php if(!empty($disabled)): ?>
    <h2 class="text-center">Data Detail Aset Belum Masuk Neraca<br>Jenis Aset <?php echo $data_jenis['nama']; ?></h2>
<?php else: ?>
    <h2 class="text-center">Tambah Data Aset Belum Masuk Neraca<br>Jenis Aset <?php echo $data_jenis['nama']; ?></h2>
<?php endif; ?>
    <form>
        <div class="form-group row">
            <label class="col-md-2 col-form-label">Pilih Unit Pengelola Barang*</label>
            <div class="col-md-10">
                <select <?php echo $disabled; ?> class="form-control select2" id="pilih_upb"><?php echo $list_upb; ?></select>
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
            <div class="col-md-4">
                <select <?php echo $disabled; ?> class="form-control select2 rek_aset" id="rek_0"><?php echo $rek_0; ?></select>
            </div>
            <div class="col-md-4">
                <select <?php echo $disabled; ?> class="form-control select2 rek_aset" id="rek_1"><?php echo $rek_1; ?></select>
            </div>
            <div class="col-md-4">
                <select <?php echo $disabled; ?> class="form-control select2 rek_aset" id="rek_2"><?php echo $rek_2; ?></select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-4">
                <select <?php echo $disabled; ?> class="form-control select2 rek_aset" id="rek_3"><?php echo $rek_3; ?></select>
            </div>
            <div class="col-md-4">
                <select <?php echo $disabled; ?> class="form-control select2 rek_aset" id="rek_4"><?php echo $rek_4; ?></select>
            </div>
            <div class="col-md-4">
                <select <?php echo $disabled; ?> class="form-control select2 rek_aset" id="rek_5"><?php echo $rek_5; ?></select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-2 col-form-label">Kode Barang</label>
            <div class="col-md-4">
                <input type="text" disabled class="form-control" name="kd_barang" value="">
            </div>
            <label class="col-md-2 col-form-label">Nomor Register</label>
            <div class="col-md-4">
                <input type="text" disabled class="form-control" name="kd_register" value="<?php echo $abm_kd_register; ?>" placeholder="Akan diisi otomatis oleh sistem!">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-2 col-form-label">Nama Aset*</label>
            <div class="col-md-10">
                <input type="text" disabled class="form-control" name="nama_aset" value="">
            </div>
        </div>