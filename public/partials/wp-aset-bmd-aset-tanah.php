<?php
global $wpdb;
$nama_pemda = get_option('_crb_bmd_nama_pemda');
$tahun_anggaran = get_option('_crb_bmd_tahun_anggaran');
$api_key = get_option( '_crb_apikey_simda_bmd' );
$body = '';
$warna_map = get_option('_crb_warna_tanah');
$ikon_map  = get_option('_crb_icon_tanah');
$api_googlemap = get_option( '_crb_google_api' );
$api_googlemap = "https://maps.googleapis.com/maps/api/js?key=$api_googlemap&callback=initMap&libraries=places";

$where = 'AND a.Sertifikat_Nomor is null';
$title_sertifikat = 'Belum';
$thead_sertifikat = '';
if(!empty($_GET) && !empty($_GET['sertifikat'])){
    $where = 'AND a.Sertifikat_Nomor is not null';
    if($_GET['sertifikat'] == 1){
        $title_sertifikat = 'Sudah';
        $thead_sertifikat = '<th class="text-center">Nomor Sertifikat</th>';
    }
}

$sql = '
    select 
        a.*,
        r.Nm_Aset5,
        d.Nm_UPB,
        e.Nm_Kecamatan,
        f.Nm_Desa
    from Ta_KIB_A a
    INNER JOIN Ta_Fn_KIB_A c ON c.IDPemda = a.IDPemda
    LEFT JOIN ref_upb d ON d.Kd_Prov = a.Kd_Prov
        AND d.Kd_Kab_Kota = a.Kd_Kab_Kota
        AND d.Kd_Bidang = a.Kd_Bidang
        AND d.Kd_Unit = a.Kd_Unit
        AND d.Kd_Sub = a.Kd_Sub
        AND d.Kd_UPB = a.Kd_UPB
        AND (d.Kd_Kecamatan = a.Kd_Kecamatan OR d.Kd_Kecamatan is null)
        AND (d.Kd_Desa = a.Kd_Desa OR d.Kd_Desa is null)
    LEFT JOIN ref_kecamatan e on e.Kd_Prov=a.Kd_Prov
        AND e.Kd_Kab_Kota = a.Kd_Kab_Kota
        AND e.Kd_Kecamatan = a.Kd_Kecamatan
    LEFT JOIN ref_desa f on f.Kd_Prov=a.Kd_Prov
        AND f.Kd_Kab_Kota = a.Kd_Kab_Kota
        AND f.Kd_Kecamatan = a.Kd_Kecamatan
        AND f.Kd_Desa = a.Kd_Desa
    LEFT JOIN Ref_Rek5_108 r on r.kd_aset=a.Kd_Aset8 
        and r.kd_aset0=a.Kd_Aset80 
        and r.kd_aset1=a.Kd_Aset81 
        and r.kd_aset2=a.Kd_Aset82 
        and r.kd_aset3=a.Kd_Aset83 
        and r.kd_aset4=a.Kd_Aset84 
        and r.kd_aset5=a.Kd_Aset85
    where a.Kd_Hapus= 0 
        AND a.Kd_Data != 3 
        AND a.Kd_KA= 1
    '.$where;

$aset = $this->functions->CurlSimda(array(
    'query' => $sql 
));
$no = 0;
$total_nilai = 0;
foreach($aset as $k => $val){
    $kd_lokasi = '12.'.$this->functions->CekNull($val->Kd_Prov).'.'.$this->functions->CekNull($val->Kd_Kab_Kota).'.'.$this->functions->CekNull($val->Kd_Bidang).'.'.$this->functions->CekNull($val->Kd_Unit).'.'.$this->functions->CekNull($val->Kd_Sub).'.'.$this->functions->CekNull($val->Kd_UPB).'.'.$this->functions->CekNull($val->Kd_Kecamatan).'.'.$this->functions->CekNull($val->Kd_Desa);
    $kd_barang = $val->Kd_Aset8.'.'.$val->Kd_Aset80.'.'.$this->functions->CekNull($val->Kd_Aset81).'.'.$this->functions->CekNull($val->Kd_Aset82).'.'.$this->functions->CekNull($val->Kd_Aset83).'.'.$this->functions->CekNull($val->Kd_Aset84).'.'.$this->functions->CekNull($val->Kd_Aset85, 3);
    $kd_register = $this->functions->CekNull($val->No_Reg8, 6);
    $link = $this->functions->generatePage(array(
        'nama_page' => 'tanah '.$kd_lokasi.' '.$kd_barang.' '.$kd_register,
        'content' => '[detail_aset kd_lokasi="'.$kd_lokasi.'" kd_barang="'.$kd_barang.'" kd_register="'.$kd_register.'" jenis_aset="tanah"]',
        'post_status' => 'private',
        'post_type' => 'post',
        'show_header' => 1,
        'no_key' => 1
    ));
    $koordinatX = get_post_meta($link['id'], 'latitude', true);
    if(empty($koordinatX)){
        $koordinatX = '0';
    }
    $koordinatY = get_post_meta($link['id'], 'longitude', true);
    if(empty($koordinatY)){
        $koordinatY = '0';
    }
    $polygon = get_post_meta($link['id'], 'polygon', true);
    if(empty($polygon)){
        $polygon = '[]';
    }
    $alamat = array();
    if(!empty($val->Nm_Kecamatan)){
        $alamat[] = 'Kec. '.$val->Nm_Kecamatan;
    }
    if(!empty($val->Nm_Desa)){
        $alamat[] = 'Desa/Kel. '.$val->Nm_Desa;
    }
    if(!empty($alamat)){
        $alamat = '('.implode(', ', $alamat).')';
    }else{
        $alamat = '';
    }
    $keterangan = array($val->Keterangan);
    $tanggal_sertifikat = substr($val->Sertifikat_Tanggal,0,10);
    $tanggal_sertifikat = $val->Sertifikat_Tanggal == '' ? '-' : date("d-m-Y", strtotime($tanggal_sertifikat));
    $column_sertifikat = '';
    if($title_sertifikat == 'Sudah'){
        $column_sertifikat = '<td style="width:110px;text-align:center;">'.$val->Sertifikat_Nomor.' ('.$tanggal_sertifikat.')</td>';
    }
    $body .= '
        <tr>
            <td class="text-center">'.$kd_barang.'.'.$kd_register.'</td>
            <td>'.$val->Nm_Aset5.'</td>
            <td>'.$val->Nm_UPB.' '.$alamat.'</td>
            <td>'.$val->Alamat.'</td>
            '.$column_sertifikat.'
            <td>'.implode(' | ', $keterangan).'</td>
            <td class="text-right" data-sort="'.$val->Harga.'">'.number_format($val->Harga,2,",",".").'</td>
            <td class="text-center"><a target="_blank" href="'.$link['url'].'" class="btn btn-primary">Detail</a><br><a style="margin-top: 5px;" onclick="setCenter(\''.$koordinatX.'\',\''.$koordinatY.'\');" href="#" class="btn btn-danger">Map</a></td>
        </tr>
    ';
    $data_aset[] = array(
        'aset' => $aset[0],
        'nama_aset' => $val->Nm_Aset5,
        'lng' => $koordinatX,
        'ltd' => $koordinatY,
        'polygon' => $polygon,
        'nilai' => number_format($val->Harga,2,",","."),
        'nama_skpd' => $val->Nm_UPB.' '.$alamat,
        'kd_barang' => $kd_barang.'.'.$kd_register,
        'kd_lokasi' => $kd_lokasi,
        'warna_map' => $warna_map,
        'ikon_map'  => $ikon_map,
        'unit_pengelola_barang' => $val->Nm_UPB,
        'lokasi' => $val->Alamat,
        'hak' => $val->Hak_Tanah,
        'sertifikat_nomor' => $val->Sertifikat_Nomor,
        'asal_usul' => $val->Asal_usul,
        'luas' => $val->Luas_M2,
        'penggunaan' => $val->Penggunaan

    );
    $total_nilai++;
}
if(!empty($_GET) && !empty($_GET['sertifikat'])){
    update_option('_crb_jumlah_tanah_sertifikat', $total_nilai);
}else{
    update_option('_crb_jumlah_tanah_belum_sertifikat', $total_nilai);
}
?>
<style type="text/css">
    .warning {
        background: #f1a4a4;
    }
    .hide {
        display: none;
    }
</style>
<div class="cetak">
    <div style="padding: 10px;">
        <h2 class="text-center">Data Aset Tanah Yang <?php echo $title_sertifikat ?> Bersertifikat<br><?php echo $nama_pemda; ?><br>Tahun <?php echo $tahun_anggaran; ?></h2>
        <div style="height:600px; width: 100%; margin-bottom: 15px;" id="map-canvas"></div>
        <table class="table table-bordered" id="data_aset_sewa">
            <thead>
                <tr>
                    <th class="text-center">Kode Barang</th>
                    <th class="text-center">Nama Aset</th>
                    <th class="text-center">Unit Pengelola Barang</th>
                    <th class="text-center">Lokasi</th>
                    <?php echo $thead_sertifikat; ?>
                    <th class="text-center">Keterangan</th>
                    <th class="text-center">Nilai Aset (Rp)</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody id="data_body">
                <?php echo $body; ?>
            </tbody>
            <tfoot>
                <th colspan="6" class="text-center">Total Nilai</th>
                <th class="text-right" id="total_aset">0</th>
                <th></th>
            <tfoot>
        </table>
    </div>
</div>
<script async defer src="<?php echo $api_googlemap ?>"></script>
<script type="text/javascript">
function setCenter(lng, ltd){
    var lokasi_aset = new google.maps.LatLng(lng, ltd);
    map.setCenter(lokasi_aset);
    map.setZoom(18);
    jQuery([document.documentElement, document.body]).animate({
        scrollTop: jQuery("#map-canvas").offset().top
    }, 500);
}
jQuery(document).on('ready', function(){
    jQuery('#data_aset_sewa').dataTable({
        columnDefs: [
            { "width": "300px", "targets": 3 }
        ],
        lengthMenu: [[20, 50, 100, -1], [20, 50, 100, "All"]],
        footerCallback: function ( row, data, start, end, display ) {
            var api = this.api();
            var total_page = api.column( 6, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return a + to_number(b);
                }, 0 );
            jQuery('#total_aset').text(formatRupiah(total_page));
        }
    });
});

window.data_aset = <?php echo json_encode($data_aset); ?>;
var map;
var nama_aset;
var kode_aset;
var status_aset;
var luas;
var alamat;
var hak_tanah;
var tgl_sertipikat;
var sertifikat_nomor;
var penggunaan;
var keterangan;
var warna_map;
var ikon_map;
var unit_pengelola_barang;
var lokasi;
var asal_usul;
var nilai_aset;
var infoWindow = {};

function initMap() {
    geocoder = new google.maps.Geocoder();
    geocoder.geocode( { 'address': '<?php echo $nama_pemda; ?>'}, function(results, status) {
        var mapOptions = {
            zoom: 13,
            center: results[0].geometry.location,
            mapTypeId: google.maps.MapTypeId.HYBRID
        };
        // Membuat Map
        window.map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
        data_aset.map(function(aset, i){
            console.log('aset', aset);
            var lokasi_aset = new google.maps.LatLng(aset.lng, aset.ltd);
            // Menampilkan Marker
            var marker1 = new google.maps.Marker({
                position: lokasi_aset,
                map,
                icon: ikon_map,
                title: 'Lokasi Aset'
            });
            
            // Variabel Informasi Data
            nama_aset               = aset.nama_aset;
            kode_aset               = aset.kd_barang;
            keterangan              = aset.aset.Keterangan;
            unit_pengelola_barang   = aset.unit_pengelola_barang;
            lokasi                  = aset.lokasi;
            sertifikat_nomor        = aset.sertifikat_nomor;
            nilai_aset              = aset.nilai;
            penggunaan              = aset.penggunaan;
            hak_tanah               = aset.hak;
            asal_usul               = aset.asal_usul;
            luas                    = aset.luas;

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
                '<td valign="top" height="25">Unit Pengelola Barang</td><td valign="top"><center>:</center></td><td valign="top">' + unit_pengelola_barang + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td valign="top" height="25">Lokasi</td><td valign="top"><center>:</center></td><td valign="top">' + lokasi + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td valign="top" height="25">Nomor Sertifikat</td><td valign="top"><center>:</center></td><td valign="top">' + sertifikat_nomor + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td valign="top" height="25">Keterangan</td><td valign="top"><center>:</center></td><td valign="top">' + keterangan + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td valign="top" height="25">Nilai Aset</td><td width="2%" valign="top"><center>:</center></td><td width="65%" valign="top">Rp ' + nilai_aset + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td valign="top" height="25">Penggunaan</td><td valign="top"><center>:</center></td><td valign="top">' + penggunaan + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td valign="top" height="25">Hak</td><td valign="top"><center>:</center></td><td valign="top">' + hak_tanah + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td valign="top" height="25">Asal usul</td><td valign="top"><center>:</center></td><td valign="top">' + asal_usul + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td valign="top" height="25">Luas</td><td valign="top"><center>:</center></td><td valign="top">' + luas + ' M<sup>2</sup></td>' +
                '</tr>' +
                '</table>';

            // Define the LatLng coordinates for the shape.
            var Coords1 = JSON.parse(aset.polygon);

            // Membuat Shape
            var bentuk_bidang1 = new google.maps.Polygon({
                paths: Coords1,
                strokeColor: warna_map,
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: warna_map,
                fillOpacity: 0.45,
                html: contentString
            });

            bentuk_bidang1.setMap(map);
            infoWindow[i] = new google.maps.InfoWindow({
                content: contentString
            });
            google.maps.event.addListener(bentuk_bidang1, 'click', function(event) {
                infoWindow[i].setPosition(event.latLng);
                infoWindow[i].open(map);
            });
            google.maps.event.addListener(marker1, 'click', function(event) {
                infoWindow[i].setPosition(event.latLng);
                infoWindow[i].open(map);
            });
        });
    });
}
</script>