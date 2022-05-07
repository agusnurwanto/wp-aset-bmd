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
$no=0;
$nama_jenis_aset = array();
$filter_sub_unit = $this->functions->get_option_multiselect('_crb_sub_unit_pilihan');
$all_jenis = array('tanah', 'bangunan', 'jalan');
foreach($all_jenis as $jenis){
    $where_prov = array();
    $where_kab_kota = array();
    $where_bidang = array();
    $where_unit = array();
    $where_sub = array();
    foreach($filter_sub_unit as $sub){
        $kd = explode('.', $sub);
        $where_prov[$kd[1]] = (int) $kd[1];
        $where_kab_kota[$kd[2]] = (int) $kd[2];
        $where_bidang[$kd[3]] = (int) $kd[3];
        $where_unit[$kd[4]] = (int) $kd[4];
        $where_sub[$kd[5]] = (int) $kd[5];
    }
    $where_all = '';
    if(!empty($where_sub)){
        $where_all = '
            AND (
                a.Kd_Prov IN ('.implode(',', $where_prov).')
                AND a.Kd_Kab_Kota IN ('.implode(',', $where_kab_kota).')
                AND a.Kd_Bidang IN ('.implode(',', $where_bidang).')
                AND a.Kd_Unit IN ('.implode(',', $where_unit).')
                AND a.Kd_Sub IN ('.implode(',', $where_sub).')
            )
        ';
    }
    $data_jenis = $this->get_nama_jenis_aset(array('jenis_aset' => $jenis));
    $nama_jenis_aset[] = $data_jenis['nama'];
    $table_simda = $data_jenis['table_simda'];

    $limit = '';
    // $limit = 'TOP 100';
    $sql = '
        select '.$limit.'
            a.*,
            b.Harga as harga_asli,
            r.Nm_Aset5,
            u.Nm_UPB,
            k.Nm_Kecamatan,
            d.Nm_Desa,
            s.Nm_Sub_Unit
        from '.$data_jenis['table_simda'].' a
        LEFT JOIN '.$data_jenis['table_simda_harga'].' b ON a.IDPemda = b.IDPemda 
        INNER JOIN ref_sub_unit s ON a.Kd_Prov=s.Kd_Prov
            AND a.Kd_Kab_Kota = s.Kd_Kab_Kota 
            AND a.Kd_Bidang = s.Kd_Bidang 
            AND a.Kd_Unit = s.Kd_Unit 
            AND a.Kd_Sub = s.Kd_Sub 
        LEFT JOIN Ref_UPB u on u.Kd_Prov = a.Kd_Prov 
            and u.Kd_Kab_Kota = a.Kd_Kab_Kota
            and u.Kd_Bidang = a.Kd_Bidang
            and u.Kd_Unit = a.Kd_Unit
            and u.Kd_Sub = a.Kd_Sub
            and u.Kd_UPB = a.Kd_UPB 
        LEFT JOIN Ref_Kecamatan k ON k.Kd_Prov=a.Kd_Prov
            AND k.Kd_Kab_Kota = a.Kd_Kab_Kota 
            AND k.Kd_Kecamatan = a.Kd_Kecamatan
        LEFT JOIN Ref_Desa d ON d.Kd_Prov=a.Kd_Prov
            AND d.Kd_Kab_Kota = a.Kd_Kab_Kota 
            AND d.Kd_Kecamatan = a.Kd_Kecamatan
            AND d.Kd_Desa = a.Kd_Desa
        LEFT JOIN Ref_Rek5_108 r on r.kd_aset=a.Kd_Aset8 
            and r.kd_aset0=a.Kd_Aset80 
            and r.kd_aset1=a.Kd_Aset81 
            and r.kd_aset2=a.Kd_Aset82 
            and r.kd_aset3=a.Kd_Aset83 
            and r.kd_aset4=a.Kd_Aset84 
            and r.kd_aset5=a.Kd_Aset85
        where 
            a.Kd_Hapus= \'0\' 
            AND a.Kd_Data != \'3\' 
            AND a.Kd_KA= \'1\'
            AND b.Harga > 0
        '.$where_all;
    $aset = $this->functions->CurlSimda(array(
        'query' => $sql 
    ));
    foreach($aset as $k => $val){
        $no++;
        $total_nilai += $val->harga_asli;
        $kd_lokasi = '12.'.$this->functions->CekNull($val->Kd_Prov).'.'.$this->functions->CekNull($val->Kd_Kab_Kota).'.'.$this->functions->CekNull($val->Kd_Bidang).'.'.$this->functions->CekNull($val->Kd_Unit).'.'.$this->functions->CekNull($val->Kd_Sub).'.'.$this->functions->CekNull($val->Kd_UPB).'.'.$this->functions->CekNull($val->Kd_Kecamatan).'.'.$this->functions->CekNull($val->Kd_Desa);
        $kd_barang = $val->Kd_Aset8.'.'.$val->Kd_Aset80.'.'.$this->functions->CekNull($val->Kd_Aset81).'.'.$this->functions->CekNull($val->Kd_Aset82).'.'.$this->functions->CekNull($val->Kd_Aset83).'.'.$this->functions->CekNull($val->Kd_Aset84).'.'.$this->functions->CekNull($val->Kd_Aset85, 3);
        $kd_register = $this->functions->CekNull($val->No_Reg8, 6);
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
        $nama_skpd = $val->Nm_UPB.' '.$alamat;
        $link_detail = $this->get_link_daftar_aset(array(
            'get' => array(
                'nama_skpd' => $nama_skpd,
                'kd_barang' => $kd_barang,
                'kd_register' => $kd_register,
                'kd_lokasi' => $kd_lokasi,
                'jenis_aset' => $data_jenis['jenis']
            )
        ));
        $link = $this->functions->generatePage(array(
            'nama_page' => $data_jenis['jenis'].' '.$kd_lokasi.' '.$kd_barang.' '.$kd_register,
            'content' => '[detail_aset kd_lokasi="'.$kd_lokasi.'" kd_barang="'.$kd_barang.'" kd_register="'.$kd_register.'" jenis_aset="'.$data_jenis['jenis'].'"]',
            'post_status' => 'private',
            'post_type' => 'post',
            'show_header' => 1,
            'no_key' => 1
        ));
        $keterangan = array($val->Keterangan);
        if($data_jenis['jenis'] == 'mesin'){
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
        if ($data_jenis['jenis'] == 'tanah') {
            $warna_map = get_option('_crb_warna_tanah');
            $ikon_map  = get_option('_crb_icon_tanah');
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
        $nama_gabungan = $val->Nm_Sub_Unit.' | '.$nama_skpd;
        if(strpos($nama_skpd, $val->Nm_Sub_Unit) !== false){
            $nama_gabungan = $nama_skpd;
        }
        $body_skpd .= '
            <tr>
                <td>'.$data_jenis['nama'].'</td>
                <td>'.$nama_gabungan.'</td>
                <td class="text-center">'.$kd_barang.'.'.$kd_register.'</td>
                <td>'.$val->Nm_Aset5.'</td>
                <td>'.implode(' | ', $keterangan).'</td>
                <td class="text-right" data-sort="'.$val->harga_asli.'">'.number_format($val->harga_asli,2,",",".").'</td>
                <td class="text-center"><a style="margin-bottom: 5px;" target="_blank" href="'.$link['url'].'" class="btn btn-primary">Detail</a>'.$map_center.'</td>
            </tr>
        ';

        $data_aset[] = array(
            'jenis' => $data_jenis['jenis'],
            'aset' => $val,
            'lng' => $koordinatX,
            'ltd' => $koordinatY,
            'polygon' => $polygon,
            'nilai' => number_format($val->harga_asli,2,",","."),
            'nama_aset' => $val->Nm_Aset5,
            'keterangan' => implode(' | ', $keterangan),
            'nama_skpd' => $nama_skpd,
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