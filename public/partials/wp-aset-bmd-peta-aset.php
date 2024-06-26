<?php
global $wpdb;

$nama_pemda = get_option('_crb_bmd_nama_pemda');
$tahun_anggaran = get_option('_crb_bmd_tahun_anggaran');
$api_key = get_option( '_crb_apikey_simda_bmd' );
$body_skpd = '';
$data_aset = array();
$total_nilai = 0;
$api_googlemap = get_option( '_crb_google_api' );
$api_googlemap = "https://maps.googleapis.com/maps/api/js?key=$api_googlemap&callback=initMap&libraries=places";
$lat_default = 0;
$lng_default = 0;
if(empty($lat_default) || empty($lng_default)){
    $center_map_default = get_option('_crb_google_map_center');
    if(!empty($center_map_default)){
        $center_map_default = explode(',', $center_map_default);
        $lat_default = $center_map_default[0];
        $lng_default = $center_map_default[1];
    }
}

$nama_jenis_aset = array();
$args = array(
    'posts_per_page' => -1,
    'post_status' => 'any',
    'meta_query' => array(
        array(
           'key' => 'polygon',
           'value' => array(''),
           'compare' => 'NOT IN',
        )
   )
);
$total_nilai_sewa = 0;
$query = new WP_Query($args);

$jenis_aset_all = array();
$where_query = array();
$where_query_upb = array();
foreach($query->posts as $post){
    $params = shortcode_parse_atts(str_replace('[detail_aset', '', str_replace(']', '', $post->post_content)));
    $jenis_aset_all[$params['jenis_aset']] = $params['jenis_aset'];
    
    $kd_lokasi = explode('.', $params['kd_lokasi']);
    $Kd_Prov = (int) $kd_lokasi[1];
    $Kd_Kab_Kota = (int) $kd_lokasi[2];
    $Kd_Bidang = (int) $kd_lokasi[3];
    $Kd_Unit = (int) $kd_lokasi[4];
    $Kd_Sub = (int) $kd_lokasi[5];
    $Kd_UPB = (int) $kd_lokasi[6];
    $Kd_Kecamatan = (int) $kd_lokasi[7];
    $Kd_Desa = (int) $kd_lokasi[8];

    $where_query_upb[$params['kd_lokasi']] = "(
        u.Kd_Prov=".$Kd_Prov."
        AND u.Kd_Kab_Kota=".$Kd_Kab_Kota." 
        AND u.Kd_Bidang=".$Kd_Bidang." 
        AND u.Kd_Unit=".$Kd_Unit." 
        AND u.Kd_Sub=".$Kd_Sub." 
        AND u.Kd_UPB=".$Kd_UPB."
    )";

    $kd_barang = explode('.', $params['kd_barang']);
    $Kd_Aset8= (int) $kd_barang[0];
    $Kd_Aset80= (int) $kd_barang[1];
    $Kd_Aset81= (int) $kd_barang[2];
    $Kd_Aset82= (int) $kd_barang[3];
    $Kd_Aset83= (int) $kd_barang[4];
    $Kd_Aset84= (int) $kd_barang[5];
    $Kd_Aset85= (int) $kd_barang[6];
    $No_Reg8 = (int) $params['kd_register'];

    if(empty($where_query[$params['jenis_aset']])){
        $where_query[$params['jenis_aset']] = array();
    }

    $where = '';
    if(!empty($Kd_Kecamatan)){
        $where .= ' AND a.Kd_Kecamatan='.$Kd_Kecamatan;
    }
    if(!empty($Kd_Desa)){
        $where .= ' AND a.Kd_Desa='.$Kd_Desa;
    }
    $where_query[$params['jenis_aset']][] = '(
        a.Kd_Prov='.$Kd_Prov.'
        AND a.Kd_Kab_Kota='.$Kd_Kab_Kota.' 
        AND a.Kd_Bidang='.$Kd_Bidang.' 
        AND a.Kd_Unit='.$Kd_Unit.' 
        AND a.Kd_Sub='.$Kd_Sub.' 
        AND a.Kd_UPB='.$Kd_UPB.'
        AND a.Kd_Aset8='.$Kd_Aset8.'
        AND a.Kd_Aset80='.$Kd_Aset80.'
        AND a.Kd_Aset81='.$Kd_Aset81.'
        AND a.Kd_Aset82='.$Kd_Aset82.'
        AND a.Kd_Aset83='.$Kd_Aset83.'
        AND a.Kd_Aset84='.$Kd_Aset84.'
        AND a.Kd_Aset85='.$Kd_Aset85.'
        AND a.No_Reg8='.$No_Reg8.'
        AND a.Kd_Hapus=0
        AND a.Kd_Data!=3
        AND a.Kd_KA=1
        '.$where.')';
}

$sql = "
    SELECT 
        u.Nm_UPB, 
        u.Kd_Prov,
        u.Kd_Kab_Kota,
        u.Kd_Bidang,
        u.Kd_Unit,
        u.Kd_Sub,
        u.Kd_UPB,
        s.Nm_Sub_Unit
    from ref_upb u
    INNER JOIN ref_sub_unit s ON u.Kd_Prov=s.Kd_Prov
        AND u.Kd_Kab_Kota = s.Kd_Kab_Kota 
        AND u.Kd_Bidang = s.Kd_Bidang 
        AND u.Kd_Unit = s.Kd_Unit 
        AND u.Kd_Sub = s.Kd_Sub 
    where ".implode(' OR ', $where_query_upb)."
";
$nama_skpd_db = $this->functions->CurlSimda(array(
    'query' => $sql,
    'no_debug' => 0
));
$nama_skpd = array();
foreach($nama_skpd_db as $val){
    $kode_lok = $this->functions->CekNull($val->Kd_Prov).'.'.$this->functions->CekNull($val->Kd_Kab_Kota).'.'.$this->functions->CekNull($val->Kd_Bidang).'.'.$this->functions->CekNull($val->Kd_Unit).'.'.$this->functions->CekNull($val->Kd_Sub).'.'.$this->functions->CekNull($val->Kd_UPB);
    $nama_skpd[$kode_lok] = $val;
}

foreach($jenis_aset_all as $jenis_aset){
    $data_jenis = $this->get_nama_jenis_aset(array('jenis_aset' => $jenis_aset));
    $nama_jenis_aset[$data_jenis['nama']] = $data_jenis['nama'];

    $sql = '
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
        where '.implode(' OR ', $where_query[$jenis_aset]);
    $aset_all = $this->functions->CurlSimda(array(
        'query' => $sql 
    ));
    if(empty($aset_all)){
	   continue;
    }

    foreach($aset_all as $aset){
        $kd_register = $this->functions->CekNull($aset->No_Reg8, 6);
        $kd_lokasi_asli = $this->functions->CekNull($aset->Kd_Prov).'.'.$this->functions->CekNull($aset->Kd_Kab_Kota).'.'.$this->functions->CekNull($aset->Kd_Bidang).'.'.$this->functions->CekNull($aset->Kd_Unit).'.'.$this->functions->CekNull($aset->Kd_Sub).'.'.$this->functions->CekNull($aset->Kd_UPB);
        $kd_lokasi = '12.'.$kd_lokasi_asli.'.'.$this->functions->CekNull($aset->Kd_Kecamatan).'.'.$this->functions->CekNull($aset->Kd_Desa);
        $kd_barang = $aset->Kd_Aset8.'.'.$aset->Kd_Aset80.'.'.$this->functions->CekNull($aset->Kd_Aset81).'.'.$this->functions->CekNull($aset->Kd_Aset82).'.'.$this->functions->CekNull($aset->Kd_Aset83).'.'.$this->functions->CekNull($aset->Kd_Aset84).'.'.$this->functions->CekNull($aset->Kd_Aset85, 3);
        $link = $this->functions->generatePage(array(
            'nama_page' => $jenis_aset.' '.$kd_lokasi.' '.$kd_barang.' '.$kd_register,
            'content' => '[detail_aset kd_lokasi="'.$kd_lokasi.'" kd_barang="'.$kd_barang.'" kd_register="'.$kd_register.'" jenis_aset="'.$jenis_aset.'"]',
            'post_status' => 'private',
            'post_type' => 'post',
            'show_header' => 1,
            'no_key' => 1
        ));

        $tanggal_sertifikat = '';
        $no_sertifikat = '';
        if(!empty($aset->Sertifikat_Tanggal)){
            $tanggal_sertifikat = substr($aset->Sertifikat_Tanggal,0,10);
        }
        if(!empty($aset->Sertifikat_Nomor)){
            $no_sertifikat = $aset->Sertifikat_Nomor;
        }

        $keterangan = array($this->filter_string($aset->Keterangan));
        $warna_map = '';
        $ikon_map = '';

        if ($data_jenis['jenis'] == 'tanah') {
            // $warna_map = get_option('_crb_warna_tanah');
            // $ikon_map  = get_option('_crb_icon_tanah');

            $warna_map = get_option('_crb_warna_tanah_blm_bersertifikat');
            $ikon_map  = get_option('_crb_icon_tanah_blm_bersertifikat');

            if (!empty($tanggal_sertifikat) && !empty($no_sertifikat)) {
                $warna_map = get_option('_crb_warna_tanah_sdh_bersertifikat');
                $ikon_map  = get_option('_crb_icon_tanah_sdh_bersertifikat');
            }
        }
        if ($data_jenis['jenis'] == 'bangunan') {
            $warna_map = get_option('_crb_warna_gedung');
            $ikon_map  = get_option('_crb_icon_gedung');
        }
        if ($data_jenis['jenis'] == 'jalan') {
            $warna_map = get_option('_crb_warna_jalan');
            $ikon_map  = get_option('_crb_icon_jalan');
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
            // continue;
            $polygon = '[]';
        }

        $map_center = '';
        if(!empty($warna_map)){
            $map_center = ' <a style="margin-bottom: 5px;" onclick="setCenter(\''.$koordinatX.'\',\''.$koordinatY.'\');" href="#" class="btn btn-danger">Map</a>';
        }
        $nama_gabungan = $nama_skpd[$kd_lokasi_asli]->Nm_Sub_Unit.' | '.$nama_skpd[$kd_lokasi_asli]->Nm_UPB;
        if(strpos($nama_skpd[$kd_lokasi_asli]->Nm_UPB, $nama_skpd[$kd_lokasi_asli]->Nm_Sub_Unit) !== false){
            $nama_gabungan = $nama_skpd[$kd_lokasi_asli]->Nm_UPB;
        }
        $body_skpd .= '
            <tr>
                <td class="text-center">'.$data_jenis['nama'].'</td>
                <td>'.$nama_gabungan.'</td>
                <td class="text-center">'.$kd_barang.'.'.$kd_register.'</td>
                <td>'.$aset->Nm_Aset5.'</td>
                <td>'.implode(' | ', $keterangan).'</td>
                <td class="text-right" data-sort="'.$aset->harga_asli.'">'.number_format($aset->harga_asli,2,",",".").'</td>
                <td class="text-center"><a style="margin-bottom: 5px;" target="_blank" href="'.$link['url'].'" class="btn btn-primary">Detail</a>'.$map_center.'</td>
            </tr>
        ';

        $data_aset[] = array(
            'jenis' => $data_jenis['jenis'],
            'zIndex' => $data_jenis['zIndex'],
            'aset' => $aset,
            'lng' => $koordinatX,
            'ltd' => $koordinatY,
            'polygon' => $polygon,
            'nilai' => number_format($aset->harga_asli,2,",","."),
            'nama_aset' => $aset->Nm_Aset5,
            'keterangan' => implode(' | ', $keterangan),
            'nama_skpd' => $nama_gabungan,
            'kd_barang' => $kd_barang,
            'kd_lokasi' => $kd_lokasi,
            'warna_map' => $warna_map,
            'ikon_map'  => $ikon_map,
        );
    }
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
        <h2 class="text-center">Peta Sebaran Data Barang Milik Daerah<br><?php echo implode(', ', $nama_jenis_aset); ?><br><?php echo $nama_pemda; ?><br>Tahun <?php echo $tahun_anggaran; ?></h2>
        <div style="height:600px; width: 100%; margin-bottom: 15px;" id="map-canvas"></div>
        <table class="table table-bordered" id="table-aset-skpd">
            <thead id="data_header">
                <tr>
                    <th class="text-center">Jenis Aset</th>
                    <th class="text-center">Nama UPB</th>
                    <th class="text-center">Kode Barang</th>
                    <th class="text-center">Nama Aset</th>
                    <th class="text-center">Keterangan</th>
                    <th class="text-center">Nilai (Rupiah)</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody id="data_body">
                <?php echo $body_skpd; ?>
            </tbody>
            <tfoot>
                <th colspan="5" class="text-center">Total Nilai</th>
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
            { "width": "300px", "targets": 4 }
        ],
        order: [[ 5, "desc" ]],
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
var infoWindow = {};

function initMap() {
    var lokasi_aset = new google.maps.LatLng(<?php echo $lat_default; ?>, <?php echo $lng_default; ?>);
    var mapOptions = {
        zoom: 13,
        center: lokasi_aset,
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
            icon: aset.ikon_map,
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
            '<td valign="top" height="25">Kode UPB</td><td width="2%" valign="top"><center>:</center></td><td width="65%" valign="top">' + aset.kd_lokasi + '</td>' +
            '</tr>' +
            '<tr>' +
            '<td valign="top" height="25">UPB</td><td width="2%" valign="top"><center>:</center></td><td width="65%" valign="top">' + aset.nama_skpd + '</td>' +
            '</tr>' +
            '<tr>' +
            '<td valign="top" height="25">Kode Aset</td><td width="2%" valign="top"><center>:</center></td><td width="65%" valign="top">' + kode_aset + '</td>' +
            '</tr>' +
            '<tr>' +
                '<td width="33%" valign="top" height="25">Nama Aset</td><td valign="top"><center>:</center></td><td valign="top"><b>' + nama_aset + '</b></td>' +
            '</tr>' +
            '<tr>' +
            '<td valign="top" height="25">Nilai</td><td width="2%" valign="top"><center>:</center></td><td width="65%" valign="top">Rp ' + aset.nilai + '</td>' +
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
                map: map,
                path: Coords1,
                geodesic: true,
                strokeColor: aset.warna_map,
                strokeOpacity: 3,
                strokeWeight: 6,
                fillColor: aset.warna_map,
                fillOpacity: 3,
                zIndex: aset.zIndex
            });
        }else{
            var bentuk_bidang1 = new google.maps.Polygon({
                map: map,
                paths: Coords1,
                strokeColor: aset.warna_map,
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: aset.warna_map,
                fillOpacity: 0.45,
                zIndex: aset.zIndex
            });
        }

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
}
</script>
