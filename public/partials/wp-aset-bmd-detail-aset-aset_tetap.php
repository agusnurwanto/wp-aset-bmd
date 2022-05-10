            <div class="form-group row">
                <label class="col-md-2 col-form-label">Judul</label>
                <div class="col-md-4">
                    <input type="text" disabled class="form-control" name="" value="<?php echo $aset[0]->Judul; ?>">
                </div>
                <label class="col-md-2 col-form-label">Pencipta</label>
                <div class="col-md-4">
                    <input type="text" disabled class="form-control" name="" value="<?php echo $aset[0]->Pencipta; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Bahan</label>
                <div class="col-md-4">
                    <input type="text" disabled class="form-control" name="<?php echo $aset[0]->Bahan; ?>">
                </div>
                <label class="col-md-2 col-form-label">Ukuran</label>
                <div class="col-md-4">
                    <input type="text" disabled class="form-control" name="<?php echo $aset[0]->Ukuran; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Tanggal Perolehan</label>
                <div class="col-md-10">
                    <input type="text" disabled class="form-control" name="" value="<?php echo $aset[0]->Tgl_Perolehan; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Asal Usul</label>
                <div class="col-md-4">
                    <input type="text" disabled class="form-control" name="" value="<?php echo $aset[0]->Asal_usul; ?>">
                </div>
                <label class="col-md-2 col-form-label">Harga (Rp)</label>
                <div class="col-md-4">
                    <input type="text" disabled class="form-control" name="" value="<?php echo number_format($aset[0]->Harga,2,",","."); ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Keterangan</label>
                <div class="col-md-10">
                    <textarea disabled class="form-control" name=""><?php echo $aset[0]->Keterangan; ?></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Sejarah</label>
                <div class="col-md-10">
                <?php 
                    if(!empty($params['key']['edit'])){
                        wp_editor($meta_sejarah,'sejarah',array('textarea_name' => 'sejarah', 'textarea_rows' => 20)); 
                    }else{
                        echo $meta_sejarah;
                    }
                ?>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Foto</label>
                <div class="col-md-10">
                <?php 
                    if(!empty($params['key']['edit'])){
                        wp_editor($meta_foto,'foto',array('textarea_name' => 'foto', 'textarea_rows' => 10)); 
                    }else{
                        echo $meta_foto;
                    }
                ?>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Video</label>
                <div class="col-md-10">
                <?php 
                    if(!empty($params['key']['edit'])){
                        wp_editor($meta_video,'video',array('textarea_name' => 'video', 'textarea_rows' => 10)); 
                    }else{
                        echo $meta_video;
                    }
                ?>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Disewakan / Tidak</label>
                <div class="col-md-4">
                    <label><input type="radio" <?php echo $disabled.' '.$checked_sewa; ?> name="disewakan" value="1"> Disewakan</label>
                    <label style="margin-left: 15px;"><input type="radio" <?php echo $disabled.' '.$checked_tidak_sewa; ?> name="disewakan" value="2"> Tidak Disewakan</label>
                </div>
                <label class="col-md-2 col-form-label">Nilai Sewa</label>
                <div class="col-md-4">
                    <input type="number" <?php echo $disabled; ?> class="form-control" name="nilai_sewa" value="<?php echo $nilai_sewa; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Nama Penyewa</label>
                <div class="col-md-4">
                    <input type="text" <?php echo $disabled; ?> class="form-control" name="nama_sewa" value="<?php echo $nama_sewa; ?>">
                </div>
                <label class="col-md-2 col-form-label">Alamat Penyewa</label>
                <div class="col-md-4">
                    <input type="text" <?php echo $disabled; ?> class="form-control" name="alamat_sewa" value="<?php echo $alamat_sewa; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Waktu Awal Sewa</label>
                <div class="col-md-4">
                    <input type="date" <?php echo $disabled; ?> class="form-control" name="waktu_sewa_awal" value="<?php echo $waktu_sewa_awal; ?>">
                </div>
                <label class="col-md-2 col-form-label">Waktu Akhir Sewa</label>
                <div class="col-md-4">
                    <input type="date" <?php echo $disabled; ?> class="form-control" name="waktu_sewa_akhir" value="<?php echo $waktu_sewa_akhir; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Keterangan Penggunaan Aset yang Disewakan</label>
                <div class="col-md-10">
                    <textarea <?php echo $disabled; ?> class="form-control" name="ket_penggunaan_aset"><?php echo $ket_penggunaan_aset; ?></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Aset Perlu Tindak Lanjut</label>
                <div class="col-md-10">
                    <label><input type="checkbox" <?php echo $disabled.' '.$checked_tindak_lanjut; ?> name="aset_perlu_tindak_lanjut" value="1"> Ya / Tidak</label>
                    <textarea <?php echo $disabled; ?> class="form-control" name="ket_aset_perlu_tindak_lanjut"><?php echo $aset_perlu_tindak_lanjut; ?></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Status informasi aset</label>
                <div class="col-md-10">
                    <label><input type="radio" <?php echo $disabled.' '.$checked_private; ?> name="status_informasi" value="1"> Privasi / rahasia</label>
                    <label style="margin-left: 15px;"><input type="radio" <?php echo $disabled.' '.$checked_publish; ?> name="status_informasi" value="2"> Informasi untuk masyarakat umum</label>
                </div>
            </div>
        <?php if(!empty($allow_edit_post) && empty($params['key']['edit'])): ?>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Aksi</label>
                <div class="col-md-10">
                    <a target="_blank" href="<?php echo $link_edit; ?>" class="btn btn-primary">Edit Post</a>
                </div>
            </div>
        <?php elseif(!empty($allow_edit_post) && !empty($params['key']['edit'])): ?>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Aksi</label>
                <div class="col-md-10">
                    <a target="_blank" onclick="simpan_aset(); return false;" href="#" class="btn btn-primary">Simpan</a> <a style="margin-left: 10px;" href="<?php echo $link_post; ?>" class="btn btn-danger">Kembali</a>
                </div>
            </div>
        <?php endif; ?>
        </form>
    </div>
</div>
<script type="text/javascript">
<?php if(!empty($allow_edit_post) && !empty($params['key']['edit'])): ?>
    function simpan_aset(){
        if(confirm("Apakah anda yakin untuk menimpan data ini. Data lama akan diupdate sesuai perubahan terbaru!")){
            jQuery('#wrap-loading').show();
            jQuery.ajax({
                url: ajax.url,
                type: "post",
                data: {
                    "action": "simpan_aset",
                    "api_key": "<?php echo $api_key; ?>",
                    "id_post": "<?php echo $post->ID; ?>",
                    "sejarah": tinyMCE.get('sejarah').getContent(),
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
                    "aset_perlu_tindak_lanjut": jQuery('input[name="aset_perlu_tindak_lanjut"]:checked').val(),
                    "ket_aset_perlu_tindak_lanjut": jQuery('textarea[name="ket_aset_perlu_tindak_lanjut"]').val(),
                    "status_informasi": jQuery('input[name="status_informasi"]:checked').val(),
                    "ket_penggunaan_aset": jQuery('textarea[name="ket_penggunaan_aset"]').val(),
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
        }
    }
<?php endif; ?>
</script>