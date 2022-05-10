<?php

$body = '';
$total_nilai = 0;
$data_jenis = $this->get_nama_jenis_aset(array('jenis_aset' => $params['jenis_aset']));
$nama_jenis_aset = $data_jenis['nama'];
$table_simda = $data_jenis['table_simda'];
$api_googlemap = get_option( '_crb_google_api' );
$api_googlemap = "https://maps.googleapis.com/maps/api/js?key=$api_googlemap&callback=initMap&libraries=places";

if(empty($nama_jenis_aset)){
    die('Jenis Aset tidak ditemukan!');
}

$kd_lokasi_unit = '12.'.$this->functions->CekNull($Kd_Prov).'.'.$this->functions->CekNull($Kd_Kab_Kota).'.'.$this->functions->CekNull($Kd_Bidang).'.'.$this->functions->CekNull($Kd_Unit);
$kd_lokasi_upb = '.'.$this->functions->CekNull($Kd_Sub).'.'.$this->functions->CekNull($Kd_UPB).'.'.$this->functions->CekNull($Kd_Kecamatan).'.'.$this->functions->CekNull($Kd_Desa);
$link_detail_unit = $this->get_link_daftar_aset(
    array('get' => 
        array(
            'kd_lokasi' => $kd_lokasi_unit, 
            'nama_skpd' => $params['nama_skpd'], 
            'daftar_aset' => 1
        )
    )
);

$where = '';
if(!empty($Kd_Kecamatan)){
    $where .= $wpdb->prepare(' AND a.Kd_Kecamatan=%d', $Kd_Kecamatan);
}else{
    $where .= ' AND a.Kd_Kecamatan is null';
}
if(!empty($Kd_Desa)){
    $where .= $wpdb->prepare(' AND a.Kd_Desa=%d', $Kd_Desa);
}else{
    $where .= ' AND a.Kd_Desa is null';
}

$body_skpd = '';
$sql = $wpdb->prepare('
    select 
        a.*,
        b.Harga as harga_asli,
        r.Nm_Aset5
    from '.$data_jenis['table_simda'].' a
    LEFT JOIN '.$data_jenis['table_simda_harga'].' b ON a.IDPemda = b.IDPemda
    LEFT JOIN Ref_Rek5_108 r on r.kd_aset=a.Kd_Aset8 
        and r.kd_aset0=a.Kd_Aset80 
        and r.kd_aset1=a.Kd_Aset81 
        and r.kd_aset2=a.Kd_Aset82 
        and r.kd_aset3=a.Kd_Aset83 
        and r.kd_aset4=a.Kd_Aset84 
        and r.kd_aset5=a.Kd_Aset85
    where a.Kd_Prov=%d
        AND a.Kd_Kab_Kota=%d 
        AND a.Kd_Bidang=%d 
        AND a.Kd_Unit=%d 
        AND a.Kd_Sub=%d 
        AND a.Kd_UPB=%d
        AND a.Kd_Hapus= \'0\' 
        AND a.Kd_Data != \'3\' 
        AND a.Kd_KA= \'1\'
        AND b.Harga > 0
        '.$where.'
    ', $Kd_Prov, $Kd_Kab_Kota, $Kd_Bidang, $Kd_Unit, $Kd_Sub, $Kd_UPB);
$aset = $this->functions->CurlSimda(array(
    'query' => $sql 
));
$no=0;
$show_map = false;
foreach($aset as $k => $val){
    $no++;
    $total_nilai += $val->harga_asli;
    $kd_lokasi = '12.'.$this->functions->CekNull($val->Kd_Prov).'.'.$this->functions->CekNull($val->Kd_Kab_Kota).'.'.$this->functions->CekNull($val->Kd_Bidang).'.'.$this->functions->CekNull($val->Kd_Unit).'.'.$this->functions->CekNull($val->Kd_Sub).'.'.$this->functions->CekNull($val->Kd_UPB).'.'.$this->functions->CekNull($val->Kd_Kecamatan).'.'.$this->functions->CekNull($val->Kd_Desa);
    $kd_barang = $val->Kd_Aset8.'.'.$val->Kd_Aset80.'.'.$this->functions->CekNull($val->Kd_Aset81).'.'.$this->functions->CekNull($val->Kd_Aset82).'.'.$this->functions->CekNull($val->Kd_Aset83).'.'.$this->functions->CekNull($val->Kd_Aset84).'.'.$this->functions->CekNull($val->Kd_Aset85, 3);
    $kd_register = $this->functions->CekNull($val->No_Reg8, 6);
    $link_detail = $this->get_link_daftar_aset(array(
        'get' => array(
            'nama_skpd' => $params['nama_skpd'],
            'kd_barang' => $kd_barang,
            'kd_register' => $kd_register,
            'kd_lokasi' => $kd_lokasi,
            'jenis_aset' => $params['jenis_aset']
        )
    ));
    $link = $this->functions->generatePage(array(
        'nama_page' => $params['jenis_aset'].' '.$kd_lokasi.' '.$kd_barang.' '.$kd_register,
        'content' => '[detail_aset kd_lokasi="'.$kd_lokasi.'" kd_barang="'.$kd_barang.'" kd_register="'.$kd_register.'" jenis_aset="'.$params['jenis_aset'].'"]',
        'post_status' => 'private',
        'post_type' => 'post',
        'show_header' => 1,
        'no_key' => 1
    ));
    $keterangan = array($val->Keterangan);
    if($params['jenis_aset'] == 'mesin'){
        $keterangan = array();
        if(!empty($val->Nomor_Polisi)){
            $keterangan[] = $val->Nomor_Polisi;
        }
        if(!empty($val->Merk)){
            $keterangan[] = $val->Merk;
        }
        if(!empty($val->Type)){
            $keterangan[] = $val->Type;
        }
        if(!empty($val->CC)){
            $keterangan[] = $val->CC;
        }
        if(!empty($val->Keterangan)){
            $keterangan[] = $val->Keterangan;
        }
    }

    $warna_map = '';
    $ikon_map = '';

    if ($params['jenis_aset'] == 'tanah') {
        $warna_map = get_option('_crb_warna_tanah');
        $ikon_map  = get_option('_crb_icon_tanah');
        $show_map = true;
    }

    if ($params['jenis_aset'] == 'bangunan') {
        $warna_map = get_option('_crb_warna_gedung');
        $ikon_map  = get_option('_crb_icon_gedung');
        $show_map = true;
    }

    if ($params['jenis_aset'] == 'jalan') {
        $warna_map = get_option('_crb_warna_jalan');
        $ikon_map  = get_option('_crb_icon_jalan');
        $show_map = true;
    }
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
    $kondisi_aset = get_post_meta($link['id'], 'meta_kondisi_aset', true);
    if(empty($kondisi_aset)){
        $kondisi_aset = '-';
    }
    
    $keterangan_kondisi_aset = get_post_meta($link['id'], 'meta_keterangan_kondisi_aset', true);
    if(empty($keterangan_kondisi_aset)){
        $keterangan_kondisi_aset = '-';
    }

    $map_center = '';
    if(!empty($warna_map)){
        $map_center = ' <a style="margin-bottom: 5px;" onclick="setCenter(\''.$koordinatX.'\',\''.$koordinatY.'\');" href="#" class="btn btn-danger">Map</a>';
    }
    $body_skpd .= '
        <tr>
            <td class="text-center">'.$no.'</td>
            <td class="text-center">'.$kd_barang.'</td>
            <td class="text-center">'.$kd_register.'</td>
            <td>'.$val->Nm_Aset5.'</td>
            <td>'.$kondisi_aset.'</td>
            <td>'.$keterangan_kondisi_aset.'</td>
            <td>'.implode(' | ', $keterangan).'</td>
            <td class="text-right" data-sort="'.$val->harga_asli.'">'.number_format($val->harga_asli,2,",",".").'</td>
            <td class="text-center"><a style="margin-bottom: 5px;" target="_blank" href="'.$link['url'].'" class="btn btn-primary">Detail</a>'.$map_center.'</td>
        </tr>
    ';

    $data_aset[] = array(
        'jenis' => $params['jenis_aset'],
        'aset' => $val,
        'lng' => $koordinatX,
        'ltd' => $koordinatY,
        'polygon' => $polygon,
        'nilai' => number_format($val->harga_asli,2,",","."),
        'nama_aset' => $val->Nm_Aset5,
        'keterangan' => implode(' | ', $keterangan),
        'nama_skpd' => $params['nama_skpd'],
        'kd_barang' => $kd_barang,
        'kd_lokasi' => $params['kd_lokasi'],
        'warna_map' => $warna_map,
        'ikon_map'  => $ikon_map,
    );
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
        <h2 class="text-center">Data Barang Milik Daerah<br><a href="<?php echo $link_detail_unit; ?>" target="_blank"><?php echo $kd_lokasi_unit; ?></a><?php echo $kd_lokasi_upb.'<br>'; ?><?php echo $params['nama_skpd']; ?><br><?php echo $nama_jenis_aset; ?><br><?php echo $nama_pemda; ?><br>Tahun <?php echo $tahun_anggaran; ?></h2>
    <?php
        if($show_map){
            echo '<div style="height:600px; width: 100%; margin-bottom: 15px;" id="map-canvas"></div>';
        }
    ?>
        <table class="table table-bordered" id="table-aset-skpd">
            <thead id="data_header">
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Kode Barang</th>
                    <th class="text-center">Register</th>
                    <th class="text-center">Nama Aset</th>
                    <th class="text-center">Kondisi</th>
                    <th class="text-center">Keterangan Kondisi Aset</th>
                    <th class="text-center">Keterangan</th>
                    <th class="text-center">Nilai (Rupiah)</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody id="data_body">
                <?php echo $body_skpd; ?>
            </tbody>
            <tfoot>
                <th colspan="7" class="text-center">Total Nilai</th>
                <th class="text-right" id="total_all_skpd"><?php echo number_format($total_nilai,2,",","."); ?></th>
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
    jQuery('#table-aset-skpd').dataTable({
        columnDefs: [
            { "width": "500px", "targets": 4 }
        ],
        lengthMenu: [[20, 50, 100, -1], [20, 50, 100, "All"]],
        footerCallback: function ( row, data, start, end, display ) {
            var api = this.api();
            var total_page = api.column( 5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return a + to_number(b);
                }, 0 );
            jQuery('#total_all_skpd').text(formatRupiah(total_page));
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
var no_sertipikat;
var penggunaan;
var keterangan;
var warna_map;
var ikon_map;

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
                map: map,
                icon: ikon_map,
                title: 'Lokasi Aset'
            });
            
            // Variabel Informasi Data
            nama_aset      = aset.aset.Nm_Aset5;
            kode_aset      = aset.kd_barang;
            keterangan     = aset.aset.Keterangan;

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
                '<td valign="top" height="25">Nilai Sewa</td><td width="2%" valign="top"><center>:</center></td><td width="65%" valign="top">Rp ' + aset.nilai_sewa + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td valign="top" height="25">Keterangan</td><td valign="top"><center>:</center></td><td valign="top">' + keterangan + '</td>' +
                '</tr>' +
                '</table>';

            // Define the LatLng coordinates for the shape.
            var Coords1 = JSON.parse(aset.polygon);

            // Membuat Shape
            if(aset.jenis == 'jalan'){
                var bentuk_bidang1 = new google.maps.Polyline({
                    paths: Coords1,
                    strokeColor: warna_map,
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: warna_map,
                    fillOpacity: 0.45,
                    html: contentString
                });
            }else{
                var bentuk_bidang1 = new google.maps.Polygon({
                    paths: Coords1,
                    strokeColor: warna_map,
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: warna_map,
                    fillOpacity: 0.45,
                    html: contentString
                });
            }

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
        });
    });
}


</script>