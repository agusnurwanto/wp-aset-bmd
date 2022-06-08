<?php 
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
$rek_0_selected = '1.3';
$rek_1_selected = '1.3.05';
$rek_2_selected = '1.3.05';
$rek_3_selected = '';
$rek_4_selected = '';
$rek_5_selected = '';

require_once BMD_PLUGIN_PATH . 'public/partials/wp-aset-bmd-tambah-abm-header.php';
?>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Judul</label>
                <div class="col-md-4">
                    <input <?php echo $disabled; ?> type="text" class="form-control" name="judul" value="<?php echo $abm_meta_judul; ?>">
                </div>
                <label class="col-md-2 col-form-label">Pencipta</label>
                <div class="col-md-4">
                    <input <?php echo $disabled; ?> type="text"  class="form-control" name="pencipta" value="<?php echo $abm_meta_pencipta; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Bahan</label>
                <div class="col-md-4">
                    <input type="text" <?php echo $disabled; ?> class="form-control" name="bahan" value="<?php echo $abm_bahan; ?>">
                </div>
                <label class="col-md-2 col-form-label">Ukuran</label>
                <div class="col-md-4">
                    <input type="text" <?php echo $disabled; ?> class="form-control" name="ukuran" value="<?php echo $abm_meta_ukuran; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Tanggal Perolehan</label>
                <div class="col-md-10">
                    <input <?php echo $disabled; ?> type="date"  class="form-control" name="tgl_perolehan" value="<?php echo $abm_meta_tgl_perolehan; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Asal Usul</label>
                <div class="col-md-4">
                    <input <?php echo $disabled; ?> type="text"  class="form-control" name="asal_usul" value="<?php echo $abm_asal_usul; ?>">
                </div>
                <label class="col-md-2 col-form-label">Harga (Rp)</label>
                <div class="col-md-4">
                    <input <?php echo $disabled; ?> type="text"  class="form-control" name="harga" value="<?php echo $abm_harga; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Keterangan*</label>
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
<?php require_once BMD_PLUGIN_PATH . 'public/partials/wp-aset-bmd-tambah-abm-footer.php'; ?>
<script type="text/javascript" src="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/js/select2.min.js"></script>
<script type="text/javascript">
	window.upb = <?php echo json_encode($new_upbs); ?>;
	jQuery(document).ready(function(){
		jQuery('.select2').select2();
		jQuery('#pilih_upb').on('change', function(){
			var kd_upb = jQuery(this).val();
            if(kd_upb != ''){
    			jQuery('input[name="kode_upb"]').val(kd_upb);
    			jQuery('input[name="nama_upb"]').val(upb[kd_upb].Nm_UPB);
    			jQuery('input[name="kecamatan"]').val(upb[kd_upb].Nm_Kecamatan);
    			jQuery('input[name="desa"]').val(upb[kd_upb].Nm_Desa);
            }else{
                jQuery('input[name="kode_upb"]').val('');
                jQuery('input[name="nama_upb"]').val('');
                jQuery('input[name="kecamatan"]').val('');
                jQuery('input[name="desa"]').val('');
            }
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
                "judul": jQuery('input[name="judul"]').val(),
                "pencipta": jQuery('input[name="pencipta"]').val(),
                "bahan": jQuery('input[name="bahan"]').val(),
                "ukuran": jQuery('input[name="ukuran"]').val(),
                "tgl_perolehan": jQuery('input[name="tgl_perolehan"]').val(),
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
                "nilai_sewa": jQuery('input[name="nilai_sewa"]').val(),
                "nama_sewa": jQuery('input[name="nama_sewa"]').val(),
                "alamat_sewa": jQuery('input[name="alamat_sewa"]').val(),
                "waktu_sewa_awal": jQuery('input[name="waktu_sewa_awal"]').val(),
                "waktu_sewa_akhir": jQuery('input[name="waktu_sewa_akhir"]').val(),
                "status_informasi": jQuery('input[name="status_informasi"]:checked').val(),
                "aset_perlu_tindak_lanjut": jQuery('input[name="aset_perlu_tindak_lanjut"]:checked').val(),
                "ket_aset_perlu_tindak_lanjut": jQuery('textarea[name="ket_aset_perlu_tindak_lanjut"]').val(),
                "mutasi_aset": jQuery('input[name="mutasi_aset"]:checked').val(),
                "ket_mutasi_aset": jQuery('textarea[name="ket_mutasi_aset"]').val(),
                "ket_penggunaan_aset": jQuery('textarea[name="ket_penggunaan_aset"]').val(),
                "ket_potensi_penggunaan": jQuery('textarea[name="ket_potensi_penggunaan"]').val()
            };
        <?php 
            if(!empty($allow_edit_post) && !empty($edit)){
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
                    if(!empty($allow_edit_post) && empty($edit)){
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
<?php
    if(empty($disabled)){
        $allow_edit_post = true;
        if(
            empty($params)
            || empty($params['key'])
            || empty($params['key']['edit'])
        ){
            $params = array('key' => array('edit' => true));
        }else{
            $params['key']['edit'] = true;
        }
    }else{
        $allow_edit_post = false;
        if(
            empty($params)
            || empty($params['key'])
            || empty($params['key']['edit'])
        ){
            $params = array('key' => array('edit' => false));
        }else{
            $params['key']['edit'] = false;
        }
    }
?>