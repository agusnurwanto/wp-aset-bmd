<script async defer src="<?php echo $api_googlemap ?>"></script>
<script type="text/javascript">
<?php if(!empty($allow_edit_post) && !empty($params['key']['edit'])): ?>
    jQuery(document).ready(function(){
        var search = ''
            +'<div class="input-group" style="margin-bottom: 5px;">'
                +'<div class="input-group-prepend">'
                    +'<input class="form-control" id="cari-alamat-input" type="text" placeholder="Kotak pencarian alamat">'
                    +'<button class="btn btn-success" id="cari-alamat" type="button">Cari</button>'
                +'</div>'
            +'</div>';
        jQuery("#map-canvas").before(search);
        jQuery("#cari-alamat").on('click', function(){
            alert('Fitur cari alamat masih dalam pengembangan!');
            var alamat = jQuery('#cari-alamat-input').val();
            geocoder = new google.maps.Geocoder();
            geocoder.geocode( { 'address': alamat}, function(results, status) {
                if (status == 'OK') {
                    console.log('results', results);
                    // map.setCenter(results[0].geometry.location);
                } else {
                    alert('Geocode was not successful for the following reason: ' + status);
                }
            });
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
        luas           = '<?php echo number_format($aset[0]->Luas_M2,2,",","."); ?>';
        alamat         = '<?php echo trim($aset[0]->Alamat); ?>';
        hak_tanah      = '<?php echo $aset[0]->Hak_Tanah; ?>';
        tgl_sertipikat = '<?php echo $aset[0]->Sertifikat_Tanggal; ?>';
        no_sertipikat  = '<?php echo $aset[0]->Sertifikat_Nomor; ?>';
        penggunaan     = '<?php echo $aset[0]->Penggunaan; ?>';
        keterangan     = '<?php echo $aset[0]->Keterangan; ?>';
        warna_map      = '<?php echo $warna_map; ?>';
        ikon_map       = '<?php echo $ikon_map; ?>';

        // Menampilkan Marker
        window.evm = new google.maps.Marker({
            position: lokasi_aset,
            map,
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

        // Membuat Shape
        window.evp = new google.maps.Polygon({
            paths: Coords1,
            strokeColor: warna_map,
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: warna_map,
            fillOpacity: 0.45,
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
            jQuery('textarea[name="polygon"]').val(JSON.stringify(evp.getPath().getArray()));
        });

        window.drawingManager = new google.maps.drawing.DrawingManager({
            drawingControl: true,
            drawingControlOptions: {
                position: google.maps.ControlPosition.TOP_CENTER,
                drawingModes: [
                    google.maps.drawing.OverlayType.MARKER,
                    google.maps.drawing.OverlayType.POLYGON
                ],
            },
            markerOptions: {
                icon: ikon_map,
                draggable: true
            },
            polygonOptions: {
                strokeColor: warna_map,
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: warna_map,
                fillOpacity: 0.45,
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
            }else if(event_draw.type == 'polygon'){
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