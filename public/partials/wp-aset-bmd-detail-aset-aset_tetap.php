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
        <h2 class="text-center">Data Aset Barang Milik Daerah<br><?php echo $params['kd_lokasi'].'<br>'.$params['nama_skpd'].' '.$alamat; ?><br><?php echo $nama_jenis_aset; ?> ( <?php echo $aset[0]->Nm_Aset5; ?> )<br><?php echo $params['kd_barang'].' '.$params['kd_register']; ?><br><?php echo $nama_pemda; ?><br>Tahun <?php echo $tahun_anggaran; ?></h2>
        <form>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Kode Lokasi</label>
                <div class="col-md-4">
                    <input type="text" disabled class="form-control" name="" value="<?php echo $params['kd_lokasi']; ?>">
                </div>
                <label class="col-md-2 col-form-label">Nama Lokasi</label>
                <div class="col-md-4">
                    <input type="text" disabled class="form-control" name="" value="<?php echo $params['nama_skpd']; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-md-2 col-form-label">Kecamatan</label>
                <div class="col-md-4">
                    <input type="text" disabled class="form-control" name="" value="<?php echo $params['kecamatan']; ?>">
                </div>
                <label class="col-md-2 col-form-label">Desa / Kelurahan</label>
                <div class="col-md-4">
                    <input type="text" disabled class="form-control" name="" value="<?php echo $params['desa']; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Kode Barang</label>
                <div class="col-md-4">
                    <input type="text" disabled class="form-control" name="" value="<?php echo $params['kd_barang']; ?>">
                </div>
                <label class="col-md-2 col-form-label">Nomor Register</label>
                <div class="col-md-4">
                    <input type="text" disabled class="form-control" name="" value="<?php echo $params['kd_register']; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Nama Aset</label>
                <div class="col-md-10">
                    <input type="text" disabled class="form-control" name="" value="<?php echo $aset[0]->Nm_Aset5; ?>">
                </div>
            </div>
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
                    "polygon": jQuery('textarea[name="polygon"]').val()
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