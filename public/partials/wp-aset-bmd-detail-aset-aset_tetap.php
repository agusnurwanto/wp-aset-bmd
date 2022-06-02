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
                    <input type="text" disabled class="form-control" name="" value="<?php echo number_format($aset[0]->harga_asli,2,",","."); ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Keterangan</label>
                <div class="col-md-10">
                    <textarea disabled class="form-control" name=""><?php echo $aset[0]->Keterangan; ?></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Kondisi Aset</label>
                <div class="col-md-4">
                    <select class="form-control" <?php echo $disabled; ?> name="kondisi_aset_simata" id="kondisi_aset_simata" >
                        <?php echo $this->get_kondisi($kondisi_aset_simata, 1); ?>
                    </select>
                </div>
                <label class="col-md-2 col-form-label">Kondisi Aset SIMDA BMD</label>
                <div class="col-md-4">
                    <select class="form-control" disabled name="kondisi_aset_simda" id="kondisi_aset_simda" >
                        <option value="<?php echo $kondisi_simda ?>"><?php echo $kondisi_simda; ?></option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Keterangan Kondisi Aset</label>
                <div class="col-md-10">
                    <textarea <?php echo $disabled; ?> class="form-control" name="keterangan_kondisi_aset" placeholder="Keterangan Kondisi Aset Tetap Lainya"><?php echo $keterangan_kondisi_aset; ?></textarea>
                </div>
            </div>
            <?php require_once plugin_dir_path(dirname(__FILE__)) . 'partials/wp-aset-bmd-detail-footer.php'; ?>
        </form>
    </div>
</div>
<script type="text/javascript">
<?php if(!empty($allow_edit_post) && !empty($params['key']['edit'])): ?>
    function simpan_aset(){
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
                    "mutasi_aset": jQuery('input[name="mutasi_aset"]:checked').val(),
                    "ket_mutasi_aset": jQuery('textarea[name="ket_mutasi_aset"]').val(),
                    "status_informasi": jQuery('input[name="status_informasi"]:checked').val(),
                    "ket_penggunaan_aset": jQuery('textarea[name="ket_penggunaan_aset"]').val(),
                    "kondisi_aset_simata": res.kondisi,
                    "keterangan_kondisi_aset": res.ket_kondisi,
                    "ket_potensi_penggunaan": jQuery('textarea[name="ket_potensi_penggunaan"]').val(),

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
<?php endif; ?>
</script>