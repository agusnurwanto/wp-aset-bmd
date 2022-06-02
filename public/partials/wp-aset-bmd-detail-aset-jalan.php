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
                    <textarea <?php echo $disabled; ?> class="form-control" name="keterangan_kondisi_aset" placeholder="Keterangan Kondisi Aset Jalan"><?php echo $keterangan_kondisi_aset; ?></textarea>
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
                    console.log(data);
                    console.log(e);
                    return alert(data.message);
                }
            });
        })
    }
<?php endif; ?>

<?php if(!empty($allow_edit_post) && !empty($params['key']['edit'])): ?>
    function cari_alamat() {
        var alamat = jQuery('#cari-alamat-input').val();
        geocoder = new google.maps.Geocoder();
        geocoder.geocode( { 'address': alamat}, function(results, status) {
            if (status == 'OK') {
                console.log('results', results);
                map.setCenter(results[0].geometry.location);
            } else {
                alert('Geocode was not successful for the following reason: ' + status);
            }
        });
    }

    jQuery(document).ready(function(){
        var search = ''
            +'<div class="input-group" style="margin-bottom: 5px; display: block;">'
                +'<div class="input-group-prepend">'
                    +'<input class="form-control" id="cari-alamat-input" type="text" placeholder="Kotak pencarian alamat">'
                    +'<button class="btn btn-success" id="cari-alamat" type="button"><i class="dashicons dashicons-search"></i></button>'
                +'</div>'
            +'</div>';
        jQuery("#map-canvas").before(search);
        jQuery("#cari-alamat").on('click', function(){
            cari_alamat();
        });
        jQuery("#cari-alamat-input").on('keyup', function (e) {
            if (e.key === 'Enter' || e.keyCode === 13) {
                cari_alamat();
            }
        });
    });
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
    var warna_map;
    var ikon_map;
    
    function initMap() {
        // Lokasi Center Map
        var lokasi_aset = new google.maps.LatLng(<?php echo $lat_default; ?>, <?php echo $lng_default; ?>);
        // Setting Map
        var mapOptions = {  
            zoom: 18,
            center: lokasi_aset,
            mapTypeId: google.maps.MapTypeId.HYBRID
        };
        // Membuat Map
        map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);

        // Define the LatLng coordinates for the shape.
        var Coords1 = <?php echo $polygon; ?>;
        
        // Variabel Informasi Data
        nama_aset      = '<?php echo $aset[0]->Nm_Aset5; ?>';
        kode_aset      = '<?php echo $params['kd_barang']; ?>';
        status_aset    = '<?php if(!empty($aset[0]->Sertifikat_Nomor)){ echo 'Bersertipikat'; }else{ echo 'Belum sertifikat'; } ?>';
        luas           = '<?php echo number_format($aset[0]->Luas,2,",","."); ?>';
        alamat         = '<?php echo $aset[0]->Lokasi; ?>';
        keterangan     = '<?php echo $aset[0]->Keterangan; ?>';
        warna_map      = '<?php echo $warna_map; ?>';
        ikon_map       = '<?php echo $ikon_map; ?>';

        // Menampilkan Marker
        window.evm = new google.maps.Marker({
            position: lokasi_aset,
            map: map,
            icon: ikon_map,
        <?php if(!empty($allow_edit_post) && !empty($params['key']['edit'])): ?>
            draggable: true,
        <?php endif; ?>
            title: 'Lokasi Aset'
        });

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
        window.evp = new google.maps.Polyline({
            path: Coords1,
            geodesic: true,
            strokeColor: warna_map,
            strokeOpacity: 3,
            strokeWeight: 6,
            fillColor: warna_map,
            fillOpacity: 3,
        <?php if(!empty($allow_edit_post) && !empty($params['key']['edit'])): ?>
            editable: true,
            draggable: true,
        <?php endif; ?>
            html: contentString
        });

        evp.setMap(map);
        infoWindow = new google.maps.InfoWindow({
            content: contentString
        });
        google.maps.event.addListener(evp, 'click', function(event) {
            infoWindow.setPosition(event.latLng);
            infoWindow.open(map);
        });
        google.maps.event.addListener(evm, 'click', function(event) {
            infoWindow.setPosition(event.latLng);
            infoWindow.open(map);
        });

    <?php if(!empty($allow_edit_post) && !empty($params['key']['edit'])): ?>
        google.maps.event.addListener(evm, 'mouseup', function(event) {
            jQuery('input[name="latitude"]').val(event.latLng.lat());
            jQuery('input[name="longitude"]').val(event.latLng.lng());
        });
        google.maps.event.addListener(evp, 'mouseup', function(event) {
            jQuery('textarea[name="polygon"]').val(JSON.stringify(event.getPath().getArray()));
        });

        window.drawingManager = new google.maps.drawing.DrawingManager({
            drawingControl: true,
            drawingControlOptions: {
                position: google.maps.ControlPosition.TOP_CENTER,
                drawingModes: [
                    google.maps.drawing.OverlayType.MARKER,
                    google.maps.drawing.OverlayType.POLYLINE
                ],
            },
            markerOptions: {
                icon: ikon_map,
                draggable: true
            },
            polylineOptions: {
                geodesic: true,
                strokeColor: warna_map,
                strokeOpacity: 3,
                strokeWeight: 6,
                fillColor: warna_map,
                fillOpacity: 3,
                editable: true,
                draggable: true,
                zIndex: 1
            }
        });
        drawingManager.setMap(map);

        google.maps.event.addListener(drawingManager, 'overlaycomplete', function(event_draw) {
            if(event_draw.type == 'marker'){
                evm.setMap(null);
                evm = event_draw.overlay;
                google.maps.event.addListener(evm, 'mouseup', function(event) {
                    jQuery('input[name="latitude"]').val(event.latLng.lat());
                    jQuery('input[name="longitude"]').val(event.latLng.lng());
                });
                google.maps.event.addListener(evm, 'click', function(event) {
                    infoWindow.setPosition(event.latLng);
                    infoWindow.open(map);
                });
                jQuery('input[name="latitude"]').val(evm.position.lat());
                jQuery('input[name="longitude"]').val(evm.position.lng());
            }else if(event_draw.type == 'polyline'){
                evp.setMap(null);
                evp = event_draw.overlay;
                google.maps.event.addListener(evp, 'mouseup', function(event) {
                    jQuery('textarea[name="polygon"]').val(JSON.stringify(evp.getPath().getArray()));
                });
                google.maps.event.addListener(evp, 'click', function(event) {
                    infoWindow.setPosition(event.latLng);
                    infoWindow.open(map);
                });
                jQuery('textarea[name="polygon"]').val(JSON.stringify(evp.getPath().getArray()));
            }
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
                    }
                } else {
                    alert('Geocode was not successful for the following reason: ' + status);
                }
            });
        }
    <?php endif; ?>
    }
</script>