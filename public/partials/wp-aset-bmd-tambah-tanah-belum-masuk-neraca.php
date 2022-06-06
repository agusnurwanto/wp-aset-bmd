<?php 
    require_once BMD_PLUGIN_PATH . 'public/partials/wp-aset-bmd-tambah-abm-header.php';
?>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Penggunaan</label>
                <div class="col-md-4">
                    <input <?php echo $disabled; ?> type="text" class="form-control" name="penggunaan" value="<?php echo $abm_penggunaan; ?>">
                </div>
                <label class="col-md-2 col-form-label">Luas (M2)</label>
                <div class="col-md-4">
                    <input <?php echo $disabled; ?> type="text"  class="form-control" name="luas" value="<?php echo $abm_luas; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Letak / Alamat*</label>
                <div class="col-md-10">
                    <textarea <?php echo $disabled; ?> class="form-control" name="alamat"><?php echo $abm_alamat; ?></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Tahun Pengadaan</label>
                <div class="col-md-4">
                    <input <?php echo $disabled; ?> type="date"  class="form-control" name="tgl_pengadaan" value="<?php echo $abm_tgl_pengadaan; ?>">
                </div>
                <label class="col-md-2 col-form-label">Hak</label>
                <div class="col-md-4">
                    <input <?php echo $disabled; ?> type="text"  class="form-control" name="hak" value="<?php echo $abm_hak; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Tanggal Sertifikat</label>
                <div class="col-md-4">
                    <input <?php echo $disabled; ?> type="date"  class="form-control" name="tgl_sertifikat" value="<?php echo $abm_tgl_sertifikat; ?>">
                </div>
                <label class="col-md-2 col-form-label">Nomor Sertifikat</label>
                <div class="col-md-4">
                    <input <?php echo $disabled; ?> type="number"  class="form-control" name="nomor_sertifikat" value="<?php echo $abm_nomor_sertifikat; ?>">
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
                <label class="col-md-2 col-form-label">Koordinat Latitude</label>
                <div class="col-md-4">
                    <input <?php echo $disabled; ?> type="text" class="form-control" name="latitude" value="<?php echo $koordinatX; ?>" placeholder="-7.7524434396470605">
                </div>
                <label class="col-md-2 col-form-label">Koordinat Longitude</label>
                <div class="col-md-4">
                    <input <?php echo $disabled; ?> type="text" class="form-control" name="longitude" value="<?php echo $koordinatY; ?>" placeholder="111.51809306769144">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Polygon / Shape</label>
                <div class="col-md-10">
                    <textarea <?php echo $disabled; ?> class="form-control" name="polygon" placeholder="[{lat: -7.751975, lng: 111.517829},{lat: -7.752092, lng: 111.518424},{lat: -7.752815, lng: 111.518344},{lat: -7.752661, lng: 111.5177}]"><?php echo $polygon; ?></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2">Map</label>
                <div class="col-md-10">
                	<div style="height:600px; width: 100%;" id="map-canvas"></div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Sejarah</label>
                <div class="col-md-10">
                    <textarea <?php echo $disabled; ?> rows="10" class="form-control" name="sejarah"><?php echo $abm_meta_sejarah; ?></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Dokumen Kronologi</label>
                <div class="col-md-10">
                <?php 
                    if(empty($disabled)){
                        wp_editor($abm_meta_kronologi,'kronologi',array('textarea_name' => 'kronologi', 'textarea_rows' => 10));
                    }else{
                        echo do_shortcode($abm_meta_kronologi);
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
                        echo do_shortcode($abm_meta_foto);
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
                        echo do_shortcode($abm_meta_video);
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
        <?php if(empty($disabled)): ?>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Aksi</label>
                <div class="col-md-10">
                    <a onclick="simpan_aset(); return false;" href="#" class="btn btn-primary">Simpan</a>
                    <a href="<?php echo $aset_belum_masuk_neraca['url']; ?>" class="btn btn-success">Kembali</a>
                </div>
            </div>
        <?php elseif(!empty($disabled) && !empty($allow_edit_post)): ?>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Aksi</label>
                <div class="col-md-10">
                    <a href="<?php echo $aset_belum_masuk_neraca['url']; ?>" class="btn btn-success">Kembali</a>
                    <a href="<?php echo $link_edit; ?>" class="btn btn-primary">Edit Post</a>
                    <a onclick="return confirm('Apakah anda yakin untuk menghapus aset ini?');" href="<?php echo $link_delete; ?>" class="btn btn-danger">Delete Post</a>
                </div>
            </div>
        <?php else: ?>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Aksi</label>
                <div class="col-md-10">
                    <a href="<?php echo $aset_belum_masuk_neraca['url']; ?>" class="btn btn-success">Kembali</a>
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
		var alamat = jQuery('textarea[name="alamat"]').val();
		if(alamat == ''){
			return alert("Letak / Alamat aset tidak boleh kosong!");
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
                "penggunaan": jQuery('input[name="penggunaan"]').val(),
                "luas": jQuery('input[name="luas"]').val(),
                "alamat": alamat,
                "tgl_pengadaan": jQuery('input[name="tgl_pengadaan"]').val(),
                "hak": jQuery('input[name="hak"]').val(),
                "tgl_sertifikat": jQuery('input[name="tgl_sertifikat"]').val(),
                "nomor_sertifikat": jQuery('input[name="nomor_sertifikat"]').val(),
                "asal_usul": jQuery('input[name="asal_usul"]').val(),
                "harga": jQuery('input[name="harga"]').val(),
                "keterangan": keterangan,
                "sejarah": jQuery('textarea[name="sejarah"]').val(),
                "kronologi": tinyMCE.get('kronologi').getContent(),
                "foto": tinyMCE.get('foto').getContent(),
                "video": tinyMCE.get('video').getContent(),
                "latitude": jQuery('input[name="latitude"]').val(),
                "longitude": jQuery('input[name="longitude"]').val(),
                "polygon": jQuery('textarea[name="polygon"]').val(),
                "disewakan": jQuery('input[name="disewakan"]:checked').val(),
                "nilai_sewa": jQuery('input[name="nilai_sewa"]').val(),
                "nama_sewa": jQuery('input[name="nama_sewa"]').val(),
                "alamat_sewa": jQuery('input[name="alamat_sewa"]').val(),
                "waktu_sewa_awal": jQuery('input[name="waktu_sewa_awal"]').val(),
                "waktu_sewa_akhir": jQuery('input[name="waktu_sewa_akhir"]').val(),
                "status_informasi": jQuery('input[name="status_informasi"]:checked').val(),
                "aset_perlu_tindak_lanjut": jQuery('input[name="aset_perlu_tindak_lanjut"]:checked').val(),
                "ket_aset_perlu_tindak_lanjut": jQuery('textarea[name="ket_aset_perlu_tindak_lanjut"]').val(),
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

    // Variabel Informasi Data
    window.nama_aset      = '<?php echo $abm_nama_aset; ?>';
    window.kode_aset      = '<?php echo $abm_kd_barang; ?>';
    window.status_aset    = '<?php if(!empty($abm_nomor_sertifikat)){ echo 'Bersertipikat'; }else{ echo 'Belum sertifikat'; } ?>';
    window.luas           = '<?php if(!empty($abm_luas)){ echo number_format($abm_luas,2,",","."); }; ?>';
    window.alamat         = '<?php echo $this->filter_string($abm_alamat); ?>';
    window.hak_tanah      = '<?php echo $abm_hak; ?>';
    window.tgl_sertipikat = '<?php echo $abm_tgl_sertifikat; ?>';
    window.no_sertipikat  = '<?php echo $abm_nomor_sertifikat; ?>';
    window.penggunaan     = '<?php echo $abm_penggunaan; ?>';
    window.keterangan     = '<?php echo $this->filter_string($abm_keterangan); ?>';
    window.warna_map      = '<?php echo $warna_map; ?>';
    window.ikon_map       = '<?php echo $ikon_map; ?>';
    window.cari_lokasi_aset = '<?php echo $this->filter_string($nama_pemda.' '.$abm_nama_upb.' '.$abm_keterangan); ?>';

    // Menampilkan Informasi Data
    window.contentString = '<br>' +
        '<table width="100%" border="0">' +
        '<tr>' +
        '<td width="33%" valign="top" height="25">Nama Aset</td><td valign="top"><center>:</center></td><td valign="top"><b>' + nama_aset + '</b></td>' +
        '</tr>' +
        '<tr>' +
        '<td valign="top" height="25">Kode Aset</td><td width="2%" valign="top"><center>:</center></td><td width="65%" valign="top">' + kode_aset + '</td>' +
        '</tr>' +
        '<tr>' +
        '<td valign="top" height="25">Status Aset</td><td valign="top"><center>:</center></td><td valign="top">' + status_aset + '</td>' +
        '</tr>' +
        '<tr>' +
        '<td valign="top" height="25">Luas</td><td valign="top"><center>:</center></td><td valign="top">' + luas + ' M&sup2;</td>' +
        '</tr>' +
        '<tr>' +
        '<td valign="top" height="25">Alamat</td><td valign="top"><center>:</center></td><td valign="top">' + alamat + '</td>' +
        '</tr>' +
        '<tr>' +
        '<td valign="top" height="25">Hak Tanah</td><td valign="top"><center>:</center></td><td valign="top">' + hak_tanah + '</td>' +
        '</tr>' +
        '<tr>' +
        '<td valign="top" height="25">Tgl Sertipikat</td><td valign="top"><center>:</center></td><td valign="top">' + tgl_sertipikat + '</td>' +
        '</tr>' +
        '<tr>' +
        '<td valign="top" height="25">No Sertipikat</td><td valign="top"><center>:</center></td><td valign="top">' + no_sertipikat + '</td>' +
        '</tr>' +
        '<tr>' +
        '<td valign="top" height="25">Penggunaan</td><td valign="top"><center>:</center></td><td valign="top">' + penggunaan + '</td>' +
        '</tr>' +
        '<tr>' +
        '<td valign="top" height="25">Keterangan</td><td valign="top"><center>:</center></td><td valign="top">' + keterangan + '</td>' +
        '</tr>' +
        '</table>';
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
    include plugin_dir_path(dirname(__FILE__)) . 'partials/wp-aset-bmd-maps.php'; 
?>