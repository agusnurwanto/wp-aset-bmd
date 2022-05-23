<?php
global $wpdb;
$nama_pemda = get_option('_crb_bmd_nama_pemda');
$tahun_anggaran = get_option('_crb_bmd_tahun_anggaran');
$api_key = get_option( '_crb_apikey_simda_bmd' );
$body = '';
$api_googlemap = get_option( '_crb_google_api' );
$api_googlemap = "https://maps.googleapis.com/maps/api/js?key=$api_googlemap&callback=initMap&libraries=places";

$args = array(
   'meta_query' => array(
       array(
           'key' => 'meta_disewakan',
           'value' => '3',
           'compare' => '=',
       )
   )
);
$total_nilai_sewa = 0;
$query = new WP_Query($args);
$no = 0;
$data_aset = array();
$now = date('Y-m-d');
foreach($query->posts as $post){
    $waktu_sewa_akhir = get_post_meta($post->ID, 'meta_waktu_sewa_akhir', true);
    $date1 = strtotime($waktu_sewa_akhir);
    $date2 = strtotime($now);
    $interval = $date1 - $date2;
    // cek jika masa sewa belum habis
    // if($interval >= 0){ continue; }

    $nilai_sewa = get_post_meta($post->ID, 'meta_nilai_sewa', true);
    $params = shortcode_parse_atts(str_replace('[detail_aset', '', str_replace(']', '', $post->post_content)));
    $kd_lokasi = explode('.', $params['kd_lokasi']);
    $Kd_Prov = (int) $kd_lokasi[1];
    $Kd_Kab_Kota = (int) $kd_lokasi[2];
    $Kd_Bidang = (int) $kd_lokasi[3];
    $Kd_Unit = (int) $kd_lokasi[4];
    $Kd_Sub = (int) $kd_lokasi[5];
    $Kd_UPB = (int) $kd_lokasi[6];
    $Kd_Kecamatan = (int) $kd_lokasi[7];
    $Kd_Desa = (int) $kd_lokasi[8];

    $kd_barang = explode('.', $params['kd_barang']);
    $Kd_Aset8 = (int) $kd_barang[0];
    $Kd_Aset80 = (int) $kd_barang[1];
    $Kd_Aset81 = (int) $kd_barang[2];
    $Kd_Aset82 = (int) $kd_barang[3];
    $Kd_Aset83 = (int) $kd_barang[4];
    $Kd_Aset84 = (int) $kd_barang[5];
    $Kd_Aset85 = (int) $kd_barang[6];
    $No_Reg8 = (int) $params['kd_register'];

    $sql = "
        SELECT 
            u.Nm_UPB, 
            k.Nm_Kecamatan,
            d.Nm_Desa
        from ref_upb u
        LEFT JOIN Ref_Kecamatan k ON k.Kd_Prov=u.Kd_Prov
            AND k.Kd_Kab_Kota = u.Kd_Kab_Kota 
            AND k.Kd_Kecamatan = u.Kd_Kecamatan
        LEFT JOIN Ref_Desa d ON d.Kd_Prov=u.Kd_Prov
            AND d.Kd_Kab_Kota = u.Kd_Kab_Kota 
            AND d.Kd_Kecamatan = u.Kd_Kecamatan
            AND d.Kd_Desa = u.Kd_Desa
        where u.Kd_Prov = $Kd_Prov
        AND u.Kd_Kab_Kota = $Kd_Kab_Kota 
        AND u.Kd_Bidang = $Kd_Bidang 
        AND u.Kd_Unit = $Kd_Unit 
        AND u.Kd_Sub = $Kd_Sub 
        AND u.Kd_UPB = $Kd_UPB
        AND (
            u.Kd_Kecamatan = $Kd_Kecamatan
            OR u.Kd_Kecamatan is null
        ) 
        AND (
            u.Kd_Desa = $Kd_Desa
            OR u.Kd_Desa is null
        )
    ";
    $nama_skpd = $this->functions->CurlSimda(array(
        'query' => $sql,
        'no_debug' => 0
    ));
    $params['nama_skpd'] = $nama_skpd[0]->Nm_UPB;
    if(!empty($Kd_Kecamatan)){
        $sql = "
            SELECT 
                k.Nm_Kecamatan
            from Ref_Kecamatan k 
            where k.Kd_Prov = $Kd_Prov
            AND k.Kd_Kab_Kota = $Kd_Kab_Kota 
            AND k.Kd_Kecamatan = $Kd_Kecamatan
        ";
        $kecamatan = $this->functions->CurlSimda(array(
            'query' => $sql,
            'no_debug' => 0
        ));
        $params['kecamatan'] = $kecamatan[0]->Nm_Kecamatan;
    }else{
        $params['kecamatan'] = '';
    }
    if(!empty($Kd_Kecamatan) && !empty($Kd_Desa)){
        $sql = "
            SELECT 
                d.Nm_Desa
            from Ref_Desa d 
            where d.Kd_Prov = $Kd_Prov
            AND d.Kd_Kab_Kota = $Kd_Kab_Kota 
            AND d.Kd_Kecamatan = $Kd_Kecamatan
            AND d.Kd_Desa = $Kd_Desa
        ";
        $desa = $this->functions->CurlSimda(array(
            'query' => $sql,
            'no_debug' => 0
        ));
        $params['desa'] = $desa[0]->Nm_Desa;
    }else{
        $params['kecamatan'] = '';
        $params['desa'] = '';
    }
    $data_jenis = $this->get_nama_jenis_aset(array('jenis_aset' => $params['jenis_aset']));
    $nama_jenis_aset = $data_jenis['nama'];
    $table_simda = $data_jenis['table_simda'];
    if ($params['jenis_aset'] == 'tanah') {
        $warna_map = get_option('_crb_warna_tanah');
        $ikon_map  = get_option('_crb_icon_tanah');
    }

    if ($params['jenis_aset'] == 'bangunan') {
        $warna_map = get_option('_crb_warna_gedung');
        $ikon_map  = get_option('_crb_icon_gedung');
    }

    if ($params['jenis_aset'] == 'jalan') {
        $warna_map = get_option('_crb_warna_jalan');
        $ikon_map  = get_option('_crb_icon_jalan');
    }


    $koordinatX = get_post_meta($post->ID, 'latitude', true);
    if(empty($koordinatX)){
        $koordinatX = '0';
    }
    $koordinatY = get_post_meta($post->ID, 'longitude', true);
    if(empty($koordinatY)){
        $koordinatY = '0';
    }
    $polygon = get_post_meta($post->ID, 'polygon', true);
    if(empty($polygon)){
        $polygon = '[]';
    }
    $ket_potensi_penggunaan = get_post_meta($post->ID, 'meta_ket_potensi_penggunaan', true);

    $alamat = array();
    if(!empty($params['kecamatan'])){
        $alamat[] = 'Kec. '.$params['kecamatan'];
    }
    if(!empty($params['desa'])){
        $alamat[] = 'Desa/Kel. '.$params['desa'];
    }
    if(!empty($alamat)){
        $alamat = '('.implode(', ', $alamat).')';
    }else{
        $alamat = '';
    }

    $where = '';
    if(!empty($Kd_Kecamatan)){
        $where .= $wpdb->prepare(' AND a.Kd_Kecamatan=%d', $Kd_Kecamatan);
    }
    if(!empty($Kd_Desa)){
        $where .= $wpdb->prepare(' AND a.Kd_Desa=%d', $Kd_Desa);
    }

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
            AND a.Kd_Aset8=%d
            AND a.Kd_Aset80=%d
            AND a.Kd_Aset81=%d
            AND a.Kd_Aset82=%d
            AND a.Kd_Aset83=%d
            AND a.Kd_Aset84=%d
            AND a.Kd_Aset85=%d
            AND a.No_Reg8=%d
            '.$where.'
        ',
        $Kd_Prov,
        $Kd_Kab_Kota,
        $Kd_Bidang,
        $Kd_Unit,
        $Kd_Sub,
        $Kd_UPB,
        $Kd_Aset8,
        $Kd_Aset80,
        $Kd_Aset81,
        $Kd_Aset82,
        $Kd_Aset83,
        $Kd_Aset84,
        $Kd_Aset85,
        $No_Reg8
    );
    $aset = $this->functions->CurlSimda(array(
        'query' => $sql 
    ));
    $no++;
    $kd_register = $this->functions->CekNull($aset[0]->No_Reg8, 6);
    $kd_lokasi = '12.'.$this->functions->CekNull($aset[0]->Kd_Prov).'.'.$this->functions->CekNull($aset[0]->Kd_Kab_Kota).'.'.$this->functions->CekNull($aset[0]->Kd_Bidang).'.'.$this->functions->CekNull($aset[0]->Kd_Unit).'.'.$this->functions->CekNull($aset[0]->Kd_Sub).'.'.$this->functions->CekNull($aset[0]->Kd_UPB).'.'.$this->functions->CekNull($aset[0]->Kd_Kecamatan).'.'.$this->functions->CekNull($aset[0]->Kd_Desa);
    $kd_barang = $aset[0]->Kd_Aset8.'.'.$aset[0]->Kd_Aset80.'.'.$this->functions->CekNull($aset[0]->Kd_Aset81).'.'.$this->functions->CekNull($aset[0]->Kd_Aset82).'.'.$this->functions->CekNull($aset[0]->Kd_Aset83).'.'.$this->functions->CekNull($aset[0]->Kd_Aset84).'.'.$this->functions->CekNull($aset[0]->Kd_Aset85, 3);
    $link = $this->functions->generatePage(array(
        'nama_page' => $params['jenis_aset'].' '.$kd_lokasi.' '.$kd_barang.' '.$kd_register,
        'content' => '[detail_aset kd_lokasi="'.$kd_lokasi.'" kd_barang="'.$kd_barang.'" kd_register="'.$kd_register.'" jenis_aset="'.$params['jenis_aset'].'"]',
        'post_status' => 'private',
        'post_type' => 'post',
        'show_header' => 1,
        'no_key' => 1
    ));
    $keterangan = array($aset[0]->Keterangan);
    if($params['jenis_aset'] == 'mesin'){
        $keterangan = array();
        if(!empty($aset[0]->Nomor_Polisi)){
            $keterangan[] = $aset[0]->Nomor_Polisi;
        }
        if(!empty($aset[0]->Merk)){
            $keterangan[] = $aset[0]->Merk;
        }
        if(!empty($aset[0]->Type)){
            $keterangan[] = $aset[0]->Type;
        }
        if(!empty($aset[0]->CC)){
            $keterangan[] = $aset[0]->CC;
        }
        if(!empty($aset[0]->Keterangan)){
            $keterangan[] = $aset[0]->Keterangan;
        }
    }
    $body .= '
        <tr>
            <td class="text-center">'.$params['kd_barang'].'.'.$params['kd_register'].'<br>'.$aset[0]->Nm_Aset5.'</td>
            <td>'.$params['nama_skpd'].' '.$alamat.'</td>
            <td>'.implode(' | ', $keterangan).'</td>
            <td>'.$ket_potensi_penggunaan.'</td>
            <td class="text-right" data-sort="'.$aset[0]->harga_asli.'">'.number_format($aset[0]->harga_asli,2,",",".").'</td>
            <td class="text-right" data-sort="'.$nilai_sewa.'">'.number_format($nilai_sewa,2,",",".").'</td>
            <td class="text-center"><a href="'.$link['url'].'" class="btn btn-primary">Detail</a> <a onclick="setCenter(\''.$koordinatX.'\',\''.$koordinatY.'\');" href="#" class="btn btn-danger">Map</a></td>
        </tr>
    ';
    $total_nilai_sewa++;
    $data_aset[] = array(
        'jenis' => $data_jenis['jenis'],
        'aset' => $aset[0],
        'lng' => $koordinatX,
        'ltd' => $koordinatY,
        'polygon' => $polygon,
        'nilai_sewa' => number_format($nilai_sewa,2,",","."),
        'nama_skpd' => $params['nama_skpd'].' '.$alamat,
        'kd_barang' => $params['kd_barang'],
        'kd_lokasi' => $params['kd_lokasi'],
        'warna_map' => $warna_map,
        'ikon_map'  => $ikon_map,
    );
}
update_option('_crb_total_potensi_aset', $total_nilai_sewa);
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
        <h2 class="text-center">Potensi Data Barang Milik Daerah Yang Disewakan<br><?php echo $nama_pemda; ?><br>Tahun <?php echo $tahun_anggaran; ?></h2>
        <div style="height:600px; width: 100%; margin-bottom: 15px;" id="map-canvas"></div>
        <table class="table table-bordered" id="data_aset_sewa">
            <thead>
                <tr>
                    <th class="text-center">Kode Barang &<br>Nama Aset</th>
                    <th class="text-center">UPB</th>
                    <th class="text-center">Keterangan Aset</th>
                    <th class="text-center">Potensi Penggunaan</th>
                    <th class="text-center">Nilai Aset (Rp)</th>
                    <th class="text-center">Nilai Sewa (Rp)</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody id="data_body">
                <?php echo $body; ?>
            </tbody>
            <tfoot>
                <th colspan="4" class="text-center">Total Nilai</th>
                <th class="text-right" id="total_aset">0</th>
                <th class="text-right" id="total_sewa">0</th>
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
            { "width": "200px", "targets": 2 },
            { "width": "200px", "targets": 3 }
        ],
        lengthMenu: [[20, 50, 100, -1], [20, 50, 100, "All"]],
        footerCallback: function ( row, data, start, end, display ) {
            var api = this.api();
            var total_page = api.column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return a + to_number(b);
                }, 0 );
            jQuery('#total_aset').text(formatRupiah(total_page));
            var total_sewa = api.column( 5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return a + to_number(b);
                }, 0 );
            jQuery('#total_sewa').text(formatRupiah(total_sewa));
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
                    map: map,
                    path: Coords1,
                    geodesic: true,
                    strokeColor: aset.warna_map,
                    strokeOpacity: 3,
                    strokeWeight: 6,
                    fillColor: aset.warna_map,
                    fillOpacity: 3
                });
            }else{
                var bentuk_bidang1 = new google.maps.Polygon({
                    map: map,
                    paths: Coords1,
                    strokeColor: aset.warna_map,
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: aset.warna_map,
                    fillOpacity: 0.45
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
    });
}
</script>