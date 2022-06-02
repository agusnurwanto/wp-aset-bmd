<?php
	$nama_pemda = get_option('_crb_bmd_nama_pemda');
	$tahun_anggaran = get_option('_crb_bmd_tahun_anggaran');
	$api_key = get_option( '_crb_apikey_simda_bmd' );
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

    $list_kondisi = ['Pilih Kondisi','Baik','Rusak Ringan','Rusak Berat','Hilang'];
    $kondisi_aset = '';
    foreach ($list_kondisi as $value) {
        $selected = $abm_kondisi_aset == $value ? 'selected' : '';
        $kondisi_aset .= '<option '.$selected.' value="'.$value.'">'.$value.'</option>';
    }
    $kondisi_aset_simda_bmd = '';
    foreach ($list_kondisi as $value) {
        $selected = $abm_kondisi_aset_simda_bmd == $value ? 'selected' : '';
        $kondisi_aset_simda_bmd .= '<option '.$selected.' value="'.$value.'">'.$value.'</option>';
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
        <h2 class="text-center">Tambah Data Barang Milik Daerah<br><?php echo $data_jenis['nama']; ?></h2>
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
                    <input type="text" disabled class="form-control" name="nama_aset" value="<?php echo $abm_nama_aset; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Nomor Polisi</label>
                <div class="col-md-4">
                    <input type="text" <?php echo $disabled; ?> class="form-control" name="no_polisi" value="<?php echo $abm_no_polisi; ?>">
                </div>
                <label class="col-md-2 col-form-label">Merk</label>
                <div class="col-md-4">
                    <input type="text" <?php echo $disabled; ?> class="form-control" name="merk" value="<?php echo $abm_merk; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Type</label>
                <div class="col-md-4">
                    <input type="text" <?php echo $disabled; ?> class="form-control" name="type" value="<?php echo $abm_type; ?>">
                </div>
                <label class="col-md-2 col-form-label">CC</label>
                <div class="col-md-4">
                    <input type="text" <?php echo $disabled; ?> class="form-control" name="besar_cc" value="<?php echo $abm_besar_cc; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Bahan</label>
                <div class="col-md-4">
                    <input type="text" <?php echo $disabled; ?> class="form-control" name="bahan" value="<?php echo $abm_bahan; ?>">
                </div>
                <label class="col-md-2 col-form-label">Tanggal Perolehan</label>
                <div class="col-md-4">
                    <input type="date" <?php echo $disabled; ?> class="form-control" name="tgl_perolehan" value="<?php echo $abm_tgl_perolehan; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Nomor Rangka</label>
                <div class="col-md-4">
                    <input type="text" <?php echo $disabled; ?> class="form-control" name="no_rangka" value="<?php echo $abm_no_rangka; ?>">
                </div>
                <label class="col-md-2 col-form-label">Nomor Mesin</label>
                <div class="col-md-4">
                    <input type="text" <?php echo $disabled; ?> class="form-control" name="no_mesin" value="<?php echo $abm_no_mesin; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Nomor Pabrik</label>
                <div class="col-md-4">
                    <input type="text" <?php echo $disabled; ?> class="form-control" name="no_pabrik" value="<?php echo $abm_no_pabrik; ?>">
                </div>
                <label class="col-md-2 col-form-label">Nomor BPKB</label>
                <div class="col-md-4">
                    <input type="text" <?php echo $disabled; ?> class="form-control" name="no_bpkb" value="<?php echo $abm_no_bpkb; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Asal Usul</label>
                <div class="col-md-4">
                    <input type="text" <?php echo $disabled; ?> class="form-control" name="asal_usul" value="<?php echo $abm_asal_usul; ?>">
                </div>
                <label class="col-md-2 col-form-label">Harga</label>
                <div class="col-md-4">
                    <input type="text" <?php echo $disabled; ?> class="form-control" name="harga" value="<?php echo $abm_harga; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Keterangan</label>
                <div class="col-md-10">
                    <textarea <?php echo $disabled; ?>  class="form-control" name="keterangan"><?php echo $abm_keterangan; ?></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Kondisi Aset</label>
                <div class="col-md-4">
                    <select <?php echo $disabled; ?> id="kondisi_aset" name="kondisi_aset" class="form-control"><?php echo $kondisi_aset; ?></select>
                </div>
                <label class="col-md-2 col-form-label">Kondisi Aset SIMDA BMD</label>
                <div class="col-md-4">
                    <select <?php echo $disabled; ?> id="kondisi_aset_simda_bmd" name="kondisi_aset_simda_bmd" class="form-control"><?php echo $kondisi_aset_simda_bmd; ?></select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Keterangan Kondisi Aset</label>
                <div class="col-md-10">
                    <textarea <?php echo $disabled; ?>  class="form-control" name="keterangan_kondisi_aset"><?php echo $abm_meta_keterangan_kondisi_aset; ?></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Sejarah</label>
                <div class="col-md-10">
                    <textarea <?php echo $disabled; ?> class="form-control" name="sejarah"><?php echo $abm_meta_sejarah; ?></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Kronologi</label>
                <div class="col-md-10">
                <?php 
                    if(empty($disabled)){
                        wp_editor($abm_meta_kronologi,'kronologi',array('textarea_name' => 'kronologi', 'textarea_rows' => 10));
                    }else{
                        echo $abm_meta_kronologi;
                    }
                ?>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Foto</label>
                <div class="col-md-10">
                <?php 
                    if(empty($disabled)){
                        wp_editor($abm_meta_foto,'foto',array('textarea_name' => 'foto', 'textarea_rows' => 10));
                    }else{
                        echo $abm_meta_foto;
                    }
                ?>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Video</label>
                <div class="col-md-10">
                <?php 
                    if(empty($disabled)){
                        wp_editor($abm_meta_video,'video',array('textarea_name' => 'video', 'textarea_rows' => 10));
                    }else{
                        echo $abm_meta_video;
                    }
                ?>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Disewakan / Tidak</label>
                <div class="col-md-4">
                    <label style="margin-left: 15px;"><input type="radio" <?php echo $disabled.' '.$checked_sewa; ?> name="disewakan" value="1"> Telah Disewakan</label>
                    <label style="margin-left: 15px;"><input type="radio" <?php echo $disabled.' '.$checked_tidak_sewa; ?> name="disewakan" value="2"> Tidak Disewakan</label>
                    <label style="margin-left: 15px;"><input type="radio" <?php echo $disabled.' '.$potensi_disewakan; ?> name="disewakan" value="3"> Potensi Akan Disewakan</label>
                </div>
                <label class="col-md-2 col-form-label">Nilai Sewa</label>
                <div class="col-md-4">
                    <input <?php echo $disabled; ?> type="number" class="form-control" name="nilai_sewa" value="<?php echo $abm_meta_nilai_sewa; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Keterangan Potensi Penggunaan</label>
                <div class="col-md-10">
                    <textarea <?php echo $disabled; ?> class="form-control" name="ket_potensi_penggunaan"><?php echo $abm_meta_ket_potensi_penggunaan; ?></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Nama Penyewa</label>
                <div class="col-md-4">
                    <input <?php echo $disabled; ?> type="text" class="form-control" name="nama_sewa" value="<?php echo $abm_meta_nama_sewa; ?>">
                </div>
                <label class="col-md-2 col-form-label">Alamat Penyewa</label>
                <div class="col-md-4">
                    <input <?php echo $disabled; ?> type="text" class="form-control" name="alamat_sewa" value="<?php echo $abm_meta_alamat_sewa; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Waktu Awal Sewa</label>
                <div class="col-md-4">
                    <input <?php echo $disabled; ?> type="date" class="form-control" name="waktu_sewa_awal" value="<?php echo $abm_meta_waktu_sewa_awal; ?>">
                </div>
                <label class="col-md-2 col-form-label">Waktu Akhir Sewa</label>
                <div class="col-md-4">
                    <input <?php echo $disabled; ?> type="date" class="form-control" name="waktu_sewa_akhir" value="<?php echo $abm_meta_waktu_sewa_akhir; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Keterangan Penggunaan Aset yang Disewakan</label>
                <div class="col-md-10">
                    <textarea <?php echo $disabled; ?> class="form-control" name="ket_penggunaan_aset"><?php echo $abm_meta_ket_penggunaan_aset; ?></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Aset Perlu Tindak Lanjut</label>
                <div class="col-md-10">
                    <label><input type="checkbox" <?php echo $disabled.' '.$checked_tindak_lanjut; ?> name="aset_perlu_tindak_lanjut" value="1"> Ya / Tidak</label>
                    <textarea <?php echo $disabled; ?> class="form-control" name="ket_aset_perlu_tindak_lanjut"><?php echo $abm_meta_keterangan_aset_perlu_tindak_lanjut; ?></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Status informasi aset</label>
                <div class="col-md-10">
                    <label><input type="radio" <?php echo $disabled.' '.$checked_private; ?> name="status_informasi" value="1"> Privasi / rahasia</label>
                    <label style="margin-left: 15px;"><input type="radio" <?php echo $disabled.' '.$checked_publish; ?> name="status_informasi" value="2"> Informasi untuk masyarakat umum</label>
                </div>
            </div>
        <?php if(empty($disabled) && !empty($allow_edit_post)): ?>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Aksi</label>
                <div class="col-md-10">
                    <a onclick="simpan_aset(); return false;" href="#" class="btn btn-primary">Simpan</a> <a style="margin-left: 10px;" href="<?php echo $aset_belum_masuk_neraca['url']; ?>" class="btn btn-danger">Kembali</a>
                </div>
            </div>
        <?php elseif(!empty($disabled) && !empty($allow_edit_post)): ?>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Aksi</label>
                <div class="col-md-10">
                    <a href="<?php echo $link_edit; ?>" class="btn btn-primary">Edit Post</a> <a onclick="return confirm('Apakah anda yakin untuk menghapus aset ini?');" href="<?php echo $link_delete; ?>" class="btn btn-danger">Delete Post</a>
                </div>
            </div>
        <?php endif; ?>
        </form>
    </div>
</div>
<script type="text/javascript" src="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/js/select2.min.js"></script>
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
        jQuery('#pilih_upb').trigger('change');
		jQuery('.rek_aset').on('change', function(){
			var id = jQuery(this).attr('id');
			var kd_barang = jQuery(this).val();
			var val = jQuery(this).find('option:selected').text().split(' ');
			var nama_aset = '';
			if(id == 'rek_5'){
				val.shift();
				nama_aset = val.join(' ');
				jQuery('input[name="kd_barang"]').val(kd_barang);
				jQuery('input[name="nama_aset"]').val(nama_aset);
				return;
			}
			var val_id_rek = +(id.split('rek_')[1]) + 1;
            jQuery('#wrap-loading').show();
            jQuery.ajax({
                url: ajax.url,
                type: "post",
                data: {
                    "action": "get_rek_barang",
                    "api_key": "<?php echo $api_key; ?>",
                    "tipe": 'rek_'+val_id_rek,
                    "selected": kd_barang+'.xx'
                },
                dataType: "json",
                success: function(data){
                	if(data.status == 'error'){
                		return alert(data.message);
                	}
                    jQuery('#wrap-loading').hide();
					if(id == 'rek_0'){
						jQuery('#rek_1').html(data.html);
						jQuery('#rek_2').html('<option value="">Pilih Rekening Aset 2</option>');
						jQuery('#rek_3').html('<option value="">Pilih Rekening Aset 3</option>');
						jQuery('#rek_4').html('<option value="">Pilih Rekening Aset 4</option>');
						jQuery('#rek_5').html('<option value="">Pilih Rekening Aset 5</option>');
					}else if(id == 'rek_1'){
						jQuery('#rek_2').html(data.html);
						jQuery('#rek_3').html('<option value="">Pilih Rekening Aset 3</option>');
						jQuery('#rek_4').html('<option value="">Pilih Rekening Aset 4</option>');
						jQuery('#rek_5').html('<option value="">Pilih Rekening Aset 5</option>');
					}else if(id == 'rek_2'){
						jQuery('#rek_3').html(data.html);
						jQuery('#rek_4').html('<option value="">Pilih Rekening Aset 4</option>');
						jQuery('#rek_5').html('<option value="">Pilih Rekening Aset 5</option>');
					}else if(id == 'rek_3'){
						jQuery('#rek_4').html(data.html);
						jQuery('#rek_5').html('<option value="">Pilih Rekening Aset 5</option>');
					}else if(id == 'rek_4'){
						jQuery('#rek_5').html(data.html);
					}
					jQuery('input[name="kd_barang"]').val(kd_barang);
					jQuery('input[name="nama_aset"]').val(nama_aset);
                },
                error: function(e) {
                    console.log(e);
                    return alert('Error, harap hubungi admin!');
                }
            });
		});
        if(jQuery('#rek_5').val() != ''){
            jQuery('#rek_5').trigger('change');
        }else if(jQuery('#rek_4').val() != ''){
            jQuery('#rek_4').trigger('change');
        }else if(jQuery('#rek_3').val() != ''){
            jQuery('#rek_3').trigger('change');
        }else if(jQuery('#rek_2').val() != ''){
            jQuery('#rek_2').trigger('change');
        }else if(jQuery('#rek_1').val() != ''){
            jQuery('#rek_1').trigger('change');
        }else if(jQuery('#rek_0').val() != ''){
            jQuery('#rek_0').trigger('change');
        }
	});

	function simpan_aset(){
		var kd_upb = jQuery('#pilih_upb').val();
		if(kd_upb == ''){
			return alert("Unit Pengelola Barang (UPB) tidak boleh kosong!");
		}
		var nama_aset = jQuery('input[name="nama_aset"]').val();
		if(nama_aset == ''){
			return alert("Nama Aset tidak boleh kosong!");
		}
		var keterangan = jQuery('textarea[name="keterangan"]').val();
		if(keterangan == ''){
			return alert("Keterangan aset tidak boleh kosong!");
		}
        if(confirm("Apakah anda yakin untuk menyimpan data ini?")){
            jQuery('#wrap-loading').show();
            var upb = jQuery('#pilih_upb option:selected').text().split(' ');
            upb.shift();
            var data_post = {
                "action": "simpan_aset_belum_masuk_neraca",
                "api_key": "<?php echo $api_key; ?>",
                "jenis_aset": "<?php echo $data_jenis['jenis']; ?>",
                "kd_upb": kd_upb,
                "nama_upb": upb.join(' '),
                "kd_barang": jQuery('input[name="kd_barang"]').val(),
                "nama_aset": nama_aset,
                "no_polisi": jQuery('input[name="no_polisi"]').val(),
                "merk": jQuery('input[name="merk"]').val(),
                "type": jQuery('input[name="type"]').val(),
                "besar_cc": jQuery('input[name="besar_cc"]').val(),
                "bahan": jQuery('input[name="bahan"]').val(),
                "tgl_perolehan": jQuery('input[name="tgl_perolehan"]').val(),
                "no_rangka": jQuery('input[name="no_rangka"]').val(),
                "no_mesin": jQuery('input[name="no_mesin"]').val(),
                "no_pabrik": jQuery('input[name="no_pabrik"]').val(),
                "no_bpkb": jQuery('input[name="no_bpkb"]').val(),
                "asal_usul": jQuery('input[name="asal_usul"]').val(),
                "harga": jQuery('input[name="harga"]').val(),
                "keterangan": keterangan,
                "kondisi_aset": jQuery('#kondisi_aset :selected').val(),
                "kondisi_aset_simda_bmd": jQuery('#kondisi_aset_simda_bmd :selected').val(),
                "keterangan_kondisi_aset": jQuery('textarea[name="keterangan_kondisi_aset"]').val(),
                "sejarah": jQuery('textarea[name="sejarah"]').val(),
                "kronologi": tinyMCE.get('kronologi').getContent(),
                "foto": tinyMCE.get('foto').getContent(),
                "video": tinyMCE.get('video').getContent(),
                "disewakan": jQuery('input[name="disewakan"]:checked').val(),
                "ket_potensi_penggunaan": jQuery('textarea[name="ket_potensi_penggunaan"]').val(),
                "nilai_sewa": jQuery('input[name="nilai_sewa"]').val(),
                "nama_sewa": jQuery('input[name="nama_sewa"]').val(),
                "alamat_sewa": jQuery('input[name="alamat_sewa"]').val(),
                "waktu_sewa_awal": jQuery('input[name="waktu_sewa_awal"]').val(),
                "waktu_sewa_akhir": jQuery('input[name="waktu_sewa_akhir"]').val(),
                "ket_penggunaan_aset": jQuery('textarea[name="ket_penggunaan_aset"]').val(),
                "aset_perlu_tindak_lanjut": jQuery('input[name="aset_perlu_tindak_lanjut"]:checked').val(),
                "ket_aset_perlu_tindak_lanjut": jQuery('textarea[name="ket_aset_perlu_tindak_lanjut"]').val(),
                "status_informasi": jQuery('input[name="status_informasi"]:checked').val()
            };
            <?php 
                if(!empty($allow_edit_post)){
                    echo "data_post.id_post = ".$post->ID.';';
                }
            ?>
        
            jQuery.ajax({
                url: ajax.url,
                type: "post",
                data: data_post,
                dataType: "json",
                success: function(data){
                    jQuery('#wrap-loading').hide();
                    alert(data.message);
                <?php 
                    if(empty($allow_edit_post)){
                        echo "window.location.href='".$aset_belum_masuk_neraca['url']."';";
                    }
                ?>
                },
                error: function(e) {
                    console.log(e);
                }
            });
        }
    }
</script>