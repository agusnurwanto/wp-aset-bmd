<?php
$body = '';
$total_nilai = 0;
$data_jenis = $this->get_nama_jenis_aset(array('jenis_aset' => $params['jenis_aset']));
$nama_jenis_aset = $data_jenis['nama'];
$table_simda = $data_jenis['table_simda'];

if(empty($nama_jenis_aset)){
    die('Jenis Aset tidak ditemukan!');
}

$where = '';
if(!empty($Kd_Kecamatan)){
    $where .= $wpdb->prepare(' AND a.Kd_Kecamatan=%d', $Kd_Kecamatan);
}
if(!empty($Kd_Desa)){
    $where .= $wpdb->prepare(' AND a.Kd_Desa=%d', $Kd_Desa);
}

$body_skpd = '';
$sql = $wpdb->prepare('
    select 
        a.*
    from '.$data_jenis['table_simda'].' a
    where a.Kd_Prov=%d
        AND a.Kd_Kab_Kota=%d 
        AND a.Kd_Bidang=%d 
        AND a.Kd_Unit=%d 
        AND a.Kd_Sub=%d 
        AND a.Kd_UPB=%d
        '.$where.'
    ', $Kd_Prov, $Kd_Kab_Kota, $Kd_Bidang, $Kd_Unit, $Kd_Sub, $Kd_UPB);
$aset = $this->functions->CurlSimda(array(
    'query' => $sql 
));
$koordinatX = '-7.7524434396470605';
$koordinatY = '111.51809306769144';
$polygon = '[{lat: -7.751975, lng: 111.517829},{lat: -7.752092, lng: 111.518424},{lat: -7.752815, lng: 111.518344},{lat: -7.752661, lng: 111.5177}]';
$link_edit = get_edit_post_link($post->ID);
$edit_post = $this->cek_edit_post(array(
    'Kd_Prov' => $Kd_Prov,
    'Kd_Kab_Kota' => $Kd_Kab_Kota,
    'Kd_Bidang' => $Kd_Bidang,
    'Kd_Unit' => $Kd_Unit,
    'Kd_Sub' => $Kd_Sub,
    'Kd_UPB' => $Kd_UPB,
    'Kd_Kecamatan' => $Kd_Kecamatan,
    'Kd_Desa' => $Kd_Desa
));
?>
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
        <h2 class="text-center">Data Aset Barang Milik Daerah<br><?php echo $params['kd_lokasi'].' '.$params['nama_skpd']; ?><br><?php echo $nama_jenis_aset; ?><br><?php echo $params['kd_barang'].' '.$params['kd_register']; ?><br><?php echo $nama_pemda; ?><br>Tahun <?php echo $tahun_anggaran; ?></h2>
        <form>
            <div class="form-group row">
                <label for="inputEmail3" class="col-md-2 col-form-label">Kode Lokasi</label>
                <div class="col-md-4">
                    <input type="text" disabled class="form-control" name="" value="<?php echo $params['kd_lokasi']; ?>">
                </div>
                <label class="col-md-2 col-form-label">Nama Lokasi</label>
                <div class="col-md-4">
                    <input type="text" disabled class="form-control" name="" value="<?php echo $params['nama_skpd']; ?>">
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
                <label class="col-md-2 col-form-label">Penggunaan</label>
                <div class="col-md-4">
                    <input type="text" disabled class="form-control" name="" value="<?php echo $aset[0]->Penggunaan; ?>">
                </div>
                <label class="col-md-2 col-form-label">Luas (M2)</label>
                <div class="col-md-4">
                    <input type="text" disabled class="form-control" name="" value="<?php echo number_format($aset[0]->Luas_M2,2,",","."); ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Letak / Alamat</label>
                <div class="col-md-10">
                    <input type="text" disabled class="form-control" name="<?php echo $aset[0]->Alamat; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Tahun Pengadaan</label>
                <div class="col-md-4">
                    <input type="text" disabled class="form-control" name="" value="<?php echo $aset[0]->Tgl_Perolehan; ?>">
                </div>
                <label class="col-md-2 col-form-label">Hak</label>
                <div class="col-md-4">
                    <input type="text" disabled class="form-control" name="" value="<?php echo $aset[0]->Hak_Tanah; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Tanggal Sertifikat</label>
                <div class="col-md-4">
                    <input type="text" disabled class="form-control" name="" value="<?php echo $aset[0]->Sertifikat_Tanggal; ?>">
                </div>
                <label class="col-md-2 col-form-label">Nomor Sertifikat</label>
                <div class="col-md-4">
                    <input type="text" disabled class="form-control" name="" value="<?php echo $aset[0]->Sertifikat_Nomor; ?>">
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
                    <input type="text" disabled class="form-control" name="" value="<?php echo $koordinatX; ?>" placeholder="-7.7524434396470605">
                </div>
                <label class="col-md-2 col-form-label">Koordinat Longitude</label>
                <div class="col-md-4">
                    <input type="text" disabled class="form-control" name="" value="<?php echo $koordinatY; ?>" placeholder="111.51809306769144">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Polygon / Shape</label>
                <div class="col-md-10">
                    <textarea disabled class="form-control" name=""><?php echo $polygon; ?></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2">Map</label>
                <div class="col-md-10"><div style="height:600px; width: 100%;" id="map-canvas"></div></div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Foto</label>
                <div class="col-md-10">
                    <input type="text" disabled class="form-control" name="">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Video</label>
                <div class="col-md-10">
                    <input type="text" disabled class="form-control" name="">
                </div>
            </div>
            <?php if(!empty($edit_post)): ?>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Aksi</label>
                <div class="col-md-10">
                    <a target="_blank" href="<?php echo $link_edit; ?>" class="btn btn-primary">Edit Post</a>
                </div>
            </div>
        <?php endif; ?>
        </form>
    </div>
</div>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBrDSUIMFDIleLOFUUXf1wFVum9ae3lJ0&callback=initMap&libraries=places"></script>
<script>
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
            title: 'Lokasi Aset',
            // icon: baseUrl + 'assets/images/marker-icon/kib-a.png'
        });

        // Define the LatLng coordinates for the shape.
        var Coords1 = <?php echo $polygon; ?>;
        
        // Variabel Informasi Data
        nama_aset      = 'Perkebunan Lain-lain';
        kode_aset      = '01.01.03.01.19';
        status_aset    = 'Bersertipikat';
        luas           = '104.73';
        alamat         = 'Kel.Bangunsari Kec.Dolopo';
        hak_tanah      = 'Hak Pakai';
        tgl_sertipikat = '31 Agustus 2005';
        no_sertipikat  = '11';
        penggunaan     = 'Kebun Bibit';
        keterangan     = 'Balai Benih Pertanian Dolopo';

        // Menampilkan Informasi Data
        var contentString = '<b>' + nama_aset + '</b><br>' +
            '<table width="100%" border="0">' +
            '<tr>' +
            '<td width="33%" valign="top" height="25">Kode Aset</td><td width="2%" valign="top"><center>:</center></td><td width="65%" valign="top">' + kode_aset + '</td>' +
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
        var bentuk_bidang1 = new google.maps.Polygon({
            paths: Coords1,
            strokeColor: '#00cc00',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#00cc00',
            fillOpacity: 0.45,
            html: contentString
        });

        bentuk_bidang1.setMap(map);
        infoWindow = new google.maps.InfoWindow;
        google.maps.event.addListener(bentuk_bidang1, 'click', function(event) {
            infoWindow.setContent(this.html);
            infoWindow.setPosition(event.latLng);
            infoWindow.open(map);
        });
                }
</script>