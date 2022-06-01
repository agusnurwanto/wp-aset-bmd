<script async defer src="<?php echo $api_googlemap ?>"></script>
<script type="text/javascript">
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
        window.map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);

        // Define the LatLng coordinates for the shape.
        var Coords1 = <?php echo $polygon; ?>;

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