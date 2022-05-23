<?php
	$keterangan_temuan_bpk = '';
	$lampiran_temuan_bpk = '';

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
                <label class="col-md-2 col-form-label">Judul</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" placeholder="Judul Data Temuan BPK" name="judul_temuan_bpk">
                </div>
                <label for="inputEmail3" class="col-md-2 col-form-label">Tanggal Temuan</label>
                <div class="col-md-4">
                    <input type="date" class="form-control" name="tanggal_temuan_bpk" value="">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Keterangan</label>
                <div class="col-md-4">
                <textarea class="form-control" name="keterangan_temuan_bpk" placeholder="Keterangan Data Temuan BPK"><?php echo $keterangan_temuan_bpk; ?></textarea>
                </div>
                <label class="col-md-2 col-form-label">OPD yang menindaklanjuti</label>
                <div class="col-md-4">
                    <select class="form-control select2" id="pilih_opd_temuan_bpk"><?php echo $list_upb; ?></select>
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
                    <a onclick="simpan_temuan_bpk(); return false;" href="#" class="btn btn-primary">Simpan</a> <a style="margin-left: 10px;" href="<?php echo $aset_belum_masuk_neraca['url']; ?>" class="btn btn-danger">Kembali</a>
                </div>
            </div>
       	</form>
    </div>
</div>

<script>
    function simpan_temuan_bpk(){
        cek_simpan()
        .then(function(res){
            jQuery('#wrap-loading').show();
            jQuery.ajax({
                url: ajax.url,
                type: "post",
                data: {
                    "action": "simpan_aset",
                    "api_key": "<?php echo $api_key; ?>",
                    "id_post": "<?php echo $post->ID; ?>",
                    "judul_temuan_bpk": jQuery('input[name="judul_temuan_bpk"]').val(),
                    "tanggal_temuan_bpk": jQuery('input[name="tanggal_temuan_bpk"]').val(),
                    "keterangan_temuan_bpk": jQuery('textarea[name="keterangan_temuan_bpk"]').val(),
                    "lampiran_temuan_bpk": tinyMCE.get('lampiran_temuan_bpk').getContent(),
                    "pilih_opd_temuan_bpk": jQuery( "#pilih_opd_temuan_bpk option:selected" ).text(),
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
        });
    }
</script>