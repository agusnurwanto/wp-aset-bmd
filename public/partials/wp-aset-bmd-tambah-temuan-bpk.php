<?php

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
    $pilih_jenis_aset = '<option value="">Pilih Jenis Aset</option>';
    if (!empty($jenis_aset) && $jenis_aset != '' ) {
        $pilih_jenis_aset = '<option value="">'.$jenis_aset.'</option>';
    }

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
        <h2 class="text-center">Tambah Data Temuan BPK<br>( Badan Pemeriksa Keuangan )</h2>
        <form>
            <div class="form-group row">
                <label class="col-md-2 col-form-label" >Status Neraca</label>
                <div class="col-md-4">
                    <label style="margin-left: 15px;"><input type="radio" <?php $checked_sudah_neraca; ?> name="status_neraca" value="1"> Sudah masuk neraca </label>
                    <label style="margin-left: 15px;"><input type="radio" <?php $checked_belum_neraca; ?> name="status_neraca" value="2"> Belum masuk neraca </label>
                </div>
                <label class="col-md-2 col-form-label">Jenis Aset</label>
                <div class="col-md-4">
                    <select class="form-control select2" id="pilih_jenis_aset" <?php echo $disabled; ?>>
                        <?php echo $pilih_jenis_aset; ?>
                        <option value="tanah">Tanah</option>
                        <option value="bangunan">Bangunan</option>
                        <option value="mesin">Mesin</option>
                        <option value="jalan">Jalan</option>
                        <option value="aset_tetap">Aset Tetap</option>
                        <option value="bangunan_dalam_pengerjaan">Bangunan Dalam Pengerjaan</option>
                    </select>
                </div>
                
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">OPD yang menindaklanjuti</label>
                <div class="col-md-4">
                    <select class="form-control select2" id="pilih_opd_temuan_bpk" <?php echo $disabled; ?>><?php echo $list_upb; ?></select>
                </div>
                <label class="col-md-2 col-form-label">Kode Barang Temuan</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="kode_barang" <?php echo $disabled; ?>/>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Jenis Temuan BPK</label>
                <div class="col-md-4">
                    <select class="form-control" name="judul_temuan_bpk"><?php echo $option_judul_temuan_bpk; ?>"</select>
                </div>
                <label for="inputEmail3" class="col-md-2 col-form-label">Tanggal Temuan</label>
                <div class="col-md-4">
                    <input type="date" class="form-control" name="tanggal_temuan_bpk" value="<?php echo $tanggal_temuan_bpk; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Keterangan</label>
                <div class="col-md-10">
                    <textarea class="form-control" name="keterangan_temuan_bpk" placeholder="Keterangan Data Temuan BPK"><?php echo $keterangan_temuan_bpk; ?></textarea>
                </div>
            </div>
            
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Lampiran</label>
                <div class="col-md-10">
                    <?php 
                        wp_editor($lampiran_temuan_bpk,'lampiran_temuan_bpk',array('textarea_name' => 'lampiran_temuan_bpk', 'textarea_rows' => 20)); 
                    ?>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Aksi</label>
                <div class="col-md-10">
                    <a onclick="simpan_temuan_bpk(); return false;" href="#" class="btn btn-primary">Simpan</a> <a style="margin-left: 10px;" href="<?php echo $temuan_bpk['url']; ?>" class="btn btn-danger">Kembali</a>
                </div>
            </div>
       	</form>
    </div>
</div>

<script>
    function simpan_temuan_bpk(){
        if(confirm("Apakah anda yakin untuk menimpan data ini?")){
            jQuery('#wrap-loading').show();
            jQuery.ajax({
                url: ajax.url,
                type: "post",
                data: {
                    "action": "simpan_temuan_bpk",
                    "api_key": "<?php echo $api_key; ?>",
                    "status_neraca": jQuery('input[name="status_neraca"]:checked').val(),
                    "pilih_jenis_aset": jQuery( "#pilih_jenis_aset option:selected" ).text(),
                    "judul_temuan_bpk": jQuery('select[name="judul_temuan_bpk"]').val(),
                    "tanggal_temuan_bpk": jQuery('input[name="tanggal_temuan_bpk"]').val(),
                    "keterangan_temuan_bpk": jQuery('textarea[name="keterangan_temuan_bpk"]').val(),
                    "lampiran_temuan_bpk": tinyMCE.get('lampiran_temuan_bpk').getContent(),
                    "pilih_opd_temuan_bpk": jQuery('select[id="pilih_opd_temuan_bpk"]').val(),
                },
                dataType: "json",
                success: function(data){
                    jQuery('#wrap-loading').hide();
                    return alert(data.message);
                },
                error: function(e) {
                    console.log(e);
                    return alert(data.message);
                }
            });
        };
    }


</script>