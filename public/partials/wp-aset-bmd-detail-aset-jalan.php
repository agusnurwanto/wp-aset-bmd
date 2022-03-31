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
                <label class="col-md-2 col-form-label">Lokasi</label>
                <div class="col-md-10">
                    <input type="text" disabled class="form-control" name="<?php echo $aset[0]->Lokasi; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Konstruksi</label>
                <div class="col-md-4">
                    <input type="text" disabled class="form-control" name="" value="<?php echo $aset[0]->Konstruksi; ?>">
                </div>
                <label class="col-md-2 col-form-label">Luas (M2)</label>
                <div class="col-md-4">
                    <input type="text" disabled class="form-control" name="" value="<?php echo number_format($aset[0]->Luas,2,",","."); ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Panjang</label>
                <div class="col-md-4">
                    <input type="text" disabled class="form-control" name="" value="<?php echo $aset[0]->Panjang; ?>">
                </div>
                <label class="col-md-2 col-form-label">Lebar</label>
                <div class="col-md-4">
                    <input type="text" disabled class="form-control" name="" value="<?php echo $aset[0]->Lebar; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Tanggal Perolehan</label>
                <div class="col-md-4">
                    <input type="text" disabled class="form-control" name="" value="<?php echo $aset[0]->Tgl_Perolehan; ?>">
                </div>
                <label class="col-md-2 col-form-label">Status Tanah</label>
                <div class="col-md-4">
                    <input type="text" disabled class="form-control" name="" value="<?php echo $aset[0]->Status_Tanah; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Dokumen Tanggal</label>
                <div class="col-md-4">
                    <input type="text" disabled class="form-control" name="" value="<?php echo $aset[0]->Dokumen_Tanggal; ?>">
                </div>
                <label class="col-md-2 col-form-label">Dokumen Nomor</label>
                <div class="col-md-4">
                    <input type="text" disabled class="form-control" name="" value="<?php echo $aset[0]->Dokumen_Nomor; ?>">
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
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBrDSUIMFDIleLOFUUXf1wFVum9ae3lJ0&callback=initMap&libraries=places"></script>
<script>
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

    var map;
    var nama_aset;
    var kode_aset;
    var status_aset;
    var luas;
    var alamat;
    var hak_tanah;
    var tgl_sertipikat;
    var no_sertipikat;
    var penggunaan;
    var keterangan;
    
    function initMap() {
        // Lokasi Center Map
        var lokasi_aset = new google.maps.LatLng(<?php echo $koordinatX; ?>, <?php echo $koordinatY; ?>);
        // Setting Map
        var mapOptions = {
            zoom: 18,
            center: lokasi_aset,
            mapTypeId: google.maps.MapTypeId.HYBRID
        };
        // Membuat Map
        map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);

        // Menampilkan Marker
        var marker1 = new google.maps.Marker({
            position: lokasi_aset,
            map: map,
        <?php if(!empty($allow_edit_post) && !empty($params['key']['edit'])): ?>
            draggable: true,
        <?php endif; ?>
            title: 'Lokasi Aset',
            // icon: baseUrl + 'assets/images/marker-icon/kib-a.png'
        });

        // Define the LatLng coordinates for the shape.
        var Coords1 = <?php echo $polygon; ?>;
        
        // Variabel Informasi Data
        nama_aset      = '<?php echo $aset[0]->Nm_Aset5; ?>';
        kode_aset      = '<?php echo $params['kd_barang']; ?>';
        status_aset    = '<?php if(!empty($aset[0]->Sertifikat_Nomor)){ echo 'Bersertipikat'; }else{ echo 'Belum sertifikat'; } ?>';
        luas           = '<?php echo number_format($aset[0]->Luas,2,",","."); ?>';
        alamat         = '<?php echo $aset[0]->Lokasi; ?>';
        keterangan     = '<?php echo $aset[0]->Keterangan; ?>';

        // Menampilkan Informasi Data
        var contentString = '<br>' +
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
            '<td valign="top" height="25">Keterangan</td><td valign="top"><center>:</center></td><td valign="top">' + keterangan + '</td>' +
            '</tr>' +
            '</table>';

        // Membuat Shape
        var bentuk_bidang1 = new google.maps.Polygon({
            paths: Coords1,
            strokeColor: '#00cc00',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#00cc00',
            fillOpacity: 0.45,
        <?php if(!empty($allow_edit_post) && !empty($params['key']['edit'])): ?>
            editable: true,
            draggable: true,
        <?php endif; ?>
            html: contentString
        });

        bentuk_bidang1.setMap(map);
        infoWindow = new google.maps.InfoWindow({
            content: contentString
        });
        google.maps.event.addListener(bentuk_bidang1, 'click', function(event) {
            infoWindow.setPosition(event.latLng);
            infoWindow.open(map);
        });
        google.maps.event.addListener(marker1, 'click', function(event) {
            infoWindow.setPosition(event.latLng);
            infoWindow.open(map);
        });

    <?php if(!empty($allow_edit_post) && !empty($params['key']['edit'])): ?>
        google.maps.event.addListener(marker1, 'mouseup', function(event) {
            jQuery('input[name="latitude"]').val(event.latLng.lat());
            jQuery('input[name="longitude"]').val(event.latLng.lng());
        });
        google.maps.event.addListener(bentuk_bidang1, 'mouseup', function(event) {
            jQuery('textarea[name="polygon"]').val(JSON.stringify(bentuk_bidang1.getPath().getArray()));
        });

        // cek jika koordinat kosong maka lokasi center di setting ke alamat pemda
        if(
            <?php echo $koordinatX; ?> == 0 
            || <?php echo $koordinatY; ?> == 0
            || '<?php echo $polygon; ?>' == '[]'
        ){
            geocoder = new google.maps.Geocoder();
            geocoder.geocode( { 'address': '<?php echo $nama_pemda.' '.$params['nama_skpd'].' '.$alamat.' '.$aset[0]->Keterangan; ?>'}, function(results, status) {
                if (status == 'OK') {
                    if(
                        <?php echo $koordinatX; ?> == 0 
                        || <?php echo $koordinatY; ?> == 0
                    ){
                        // ganti center map
                        map.setCenter(results[0].geometry.location);
                        // ganti center maker
                        marker1.setPosition(results[0].geometry.location);
                        // ganti value latitude
                        jQuery('input[name="latitude"]').val(results[0].geometry.location.lat());
                        // ganti value longitude
                        jQuery('input[name="longitude"]').val(results[0].geometry.location.lng());
                    }
                    if('<?php echo $polygon; ?>' == '[]'){
                        // ganti value dari polygon
                        bentuk_bidang1.setPath([
                            {
                                lat: results[0].geometry.location.lat()-0.0004, 
                                lng: results[0].geometry.location.lng()-0.0004
                            },
                            {
                                lat: results[0].geometry.location.lat()-0.0004, 
                                lng: results[0].geometry.location.lng()+0.0004
                            },
                            {
                                lat: results[0].geometry.location.lat()+0.0004, 
                                lng: results[0].geometry.location.lng()+0.0004
                            },
                            {
                                lat: results[0].geometry.location.lat()+0.0004, 
                                lng: results[0].geometry.location.lng()-0.0004
                            }
                        ]);
                        jQuery('textarea[name="polygon"]').val(JSON.stringify(bentuk_bidang1.getPath().getArray()));
                    }
                } else {
                    alert('Geocode was not successful for the following reason: ' + status);
                }
            });
        }
    <?php endif; ?>
    }
</script>