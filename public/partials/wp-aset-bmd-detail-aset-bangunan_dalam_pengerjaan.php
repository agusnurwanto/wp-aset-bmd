            <div class="form-group row">
                <label class="col-md-2 col-form-label">Status Tanah</label>
                <div class="col-md-4">
                    <input type="text" disabled class="form-control" name="" value="<?php echo $aset[0]->Status_Tanah; ?>">
                </div>
                <label class="col-md-2 col-form-label">Bertingkat / Tidak</label>
                <div class="col-md-4">
                    <input type="text" disabled class="form-control" name="" value="<?php echo $aset[0]->Bertingkat_Tidak; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Lokasi</label>
                <div class="col-md-10">
                    <input type="text" disabled class="form-control" name="<?php echo $aset[0]->Lokasi; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Tanggal Perolehan</label>
                <div class="col-md-4">
                    <input type="text" disabled class="form-control" name="" value="<?php echo $aset[0]->Tgl_Perolehan; ?>">
                </div>
                <label class="col-md-2 col-form-label">Luas Lantai</label>
                <div class="col-md-4">
                    <input type="text" disabled class="form-control" name="" value="<?php echo number_format($aset[0]->Luas_Lantai,2,",","."); ?>">
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
                    <textarea <?php echo $disabled; ?> class="form-control" name="keterangan_kondisi_aset" placeholder="Keterangan Kondisi Aset Bangunan Dalam Pengerjaan"><?php echo $keterangan_kondisi_aset; ?></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Koordinat Latitude</label>
                <div class="col-md-4">
                    <input type="text" <?php echo $disabled; ?> class="form-control" name="latitude" value="<?php echo $koordinatX; ?>" placeholder="-7.7524434396470605">
                </div>
                <label class="col-md-2 col-form-label">Koordinat Longitude</label>
                <div class="col-md-4">
                    <input type="text" <?php echo $disabled; ?> class="form-control" name="longitude" value="<?php echo $koordinatY; ?>" placeholder="111.51809306769144">
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
                <div class="col-md-10"><div style="height:600px; width: 100%;" id="map-canvas"></div></div>
            </div>
            <?php require_once plugin_dir_path(dirname(__FILE__)) . 'partials/wp-aset-bmd-detail-footer.php'; ?>
        </form>
    </div>
</div>
<script async defer src="<?php echo $api_googlemap ?>"></script>
<script>
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
                    "aset_perlu_tindak_lanjut": jQuery('input[name="aset_perlu_tindak_lanjut"]:checked').val(),
                    "ket_aset_perlu_tindak_lanjut": jQuery('textarea[name="ket_aset_perlu_tindak_lanjut"]').val(),
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

    // Variabel Informasi Data
    window.nama_aset      = '<?php echo $aset[0]->Nm_Aset5; ?>';
    window.kode_aset      = '<?php echo $params['kd_barang']; ?>';
    window.status_aset    = '<?php if(!empty($aset[0]->Sertifikat_Nomor)){ echo 'Bersertipikat'; }else{ echo 'Belum sertifikat'; } ?>';
    window.luas           = '<?php echo number_format($aset[0]->Luas_Lantai,2,",","."); ?>';
    window.alamat         = '<?php echo $aset[0]->Lokasi; ?>';
    window.bertingkat      = '<?php echo $aset[0]->Bertingkat_Tidak; ?>';
    window.keterangan     = '<?php echo $aset[0]->Keterangan; ?>';
    window.warna_map      = '<?php echo $warna_map; ?>';
    window.ikon_map       = '<?php echo $ikon_map; ?>';
    window.cari_lokasi_aset = '<?php echo $nama_pemda.' '.$params['nama_skpd'].' '.$aset[0]->Lokasi.' '.$aset[0]->Keterangan; ?>';

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
        '<tr>' +
        '<td valign="top" height="25">Bertingkat / Tidak</td><td valign="top"><center>:</center></td><td valign="top">' + bertingkat + '</td>' +
        '</tr>' +
        '<tr>' +
        '<td valign="top" height="25">Keterangan</td><td valign="top"><center>:</center></td><td valign="top">' + keterangan + '</td>' +
        '</tr>' +
        '</table>';
</script>
<?php include plugin_dir_path(dirname(__FILE__)) . 'partials/wp-aset-bmd-maps.php'; ?>