<?php
global $wpdb;
$nama_pemda = get_option('_crb_bmd_nama_pemda');
$tahun_anggaran = get_option('_crb_bmd_tahun_anggaran');
$api_key = get_option( '_crb_apikey_simda_bmd' );
$body = '';

$args = array(
   'meta_key' => 'meta_temuan_bpk',
   'meta_query' => array(
       array(
           'key' => 'meta_temuan_bpk',
           'value' => '1',
           'compare' => '=',
       )
   )
);
$query = new WP_Query($args);
$no = 0;
$data_aset = array();
foreach($query->posts as $post){
    $nilai_aset = get_post_meta($post->ID, 'meta_nilai_aset', true);
    $nama_aset = get_post_meta($post->ID, 'meta_nama_aset', true);
    $alamat_aset = get_post_meta($post->ID, 'meta_alamat_aset', true);
    $koordinatX = get_post_meta($post->ID, 'latitude', true);
    if(empty($koordinatX)){
        $koordinatX = '0';
    }
    $koordinatY = get_post_meta($post->ID, 'longitude', true);
    if(empty($koordinatY)){
        $koordinatY = '0';
    }
    $keterangan = get_post_meta($post->ID, 'keterangan_aset', true);;
    $polygon = get_post_meta($post->ID, 'polygon', true);
    $keterangan_tindak_lanjut = get_post_meta($post->ID, 'meta_keterangan_aset_perlu_tindak_lanjut', true);
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

    $data_jenis = $this->get_nama_jenis_aset(array('jenis_aset' => $params['jenis_aset']));

    $warna_map = '';
    $ikon_map = '';
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

    $link = $this->functions->generatePage(array(
        'nama_page' => $params['jenis_aset'].' '.$params['kd_lokasi'].' '.$params['kd_barang'].' '.$params['kd_register'],
        'content' => '[detail_aset kd_lokasi="'.$params['kd_lokasi'].'" kd_barang="'.$params['kd_barang'].'" kd_register="'.$params['kd_register'].'" jenis_aset="'.$params['jenis_aset'].'"]',
        'post_status' => 'private',
        'post_type' => 'post',
        'show_header' => 1,
        'no_key' => 1
    ));
    $column_lokasi = '';

    $body .= '
        <tr>
            <td class="text-center">'.$data_jenis['nama'].'</td>
            <td class="text-center">'.$params['kd_barang'].'.'.$params['kd_register'].'</td>
            <td>'.$nama_aset.'</td>
            <td>'.$column_lokasi.'</td>
            <td>'.implode(' | ', $keterangan).'</td>
            <td>'.$keterangan_tindak_lanjut.'</td>
            <td class="text-right" data-sort="'.$nilai_aset.'">'.number_format($nilai_aset,2,",",".").'</td>
            <td class="text-center"><a href="'.$link['url'].'" class="btn btn-primary">Detail</a></td>
        </tr>
    ';

    if(empty($polygon)){
        continue;
    }
    $data_aset[] = array(
        'aset' => array(),
        'lng' => $koordinatX,
        'ltd' => $koordinatY,
        'polygon' => $polygon,
        'nilai_aset' => number_format($nilai_aset,2,",","."),
        'nama_aset' => $nama_aset,
        'alamat_aset' => $alamat_aset,
        'nama_skpd' => $params['nama_skpd'].' '.$alamat,
        'kd_barang' => $params['kd_barang'],
        'kd_lokasi' => $params['kd_lokasi'],
        'warna_map' => $warna_map,
        'ikon_map'  => $ikon_map,
    );
}

$tombol_tambah = '';
$pilihan_aset = array();
if(is_user_logged_in()){
    $user_id = get_current_user_id();
    if($this->functions->user_has_role($user_id, 'administrator')){
        $judul_form_input = 'Tambah Aset Belum Masuk Neraca';
        $link = $this->functions->generatePage(array(
            'nama_page' => 'Tambah Temuan BPK',
            'content' => '[tambah_temuan_bpk]',
            'post_status' => 'private',
            'show_header' => 1
        ));
        $tombol_tambah = '<button class="btn btn-primary" href="'.$link['url'].'" style="margin-bottom: 20px;">Tambah Temuan BPK</button>';
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
    .form-group li {
        list-style: none;
        display: inline-block;
        margin-left: 10px;
        margin-bottom: 10px;
    }
</style>
<div class="cetak">
    <div style="padding: 10px;">
        <h2 class="text-center">Data Temuan BPK<br><?php echo $nama_pemda; ?><br>Tahun <?php echo $tahun_anggaran; ?></h2>
        <?php echo $tombol_tambah; ?>
        <table class="table table-bordered" id="data_temuan_bpk">
            <thead>
                <tr>
                    <th class="text-center">Judul</th>
                    <th class="text-center">Keterangan</th>
                    <th class="text-center">Tanggal Temuan</th>
                    <th class="text-center">Lampiran</th>
                    <th class="text-center">OPD yang menindaklanjuti</th>
                </tr>
            </thead>
            <tbody id="data_body">
                <?php echo $body; ?>
            </tbody>
            <tfoot>
                <th ></th>
            <tfoot>
        </table>
    </div>
</div>
<script type="text/javascript">

jQuery(document).on('ready', function(){
    jQuery('#data_temuan_bpk').dataTable({
        columnDefs: [
            { "width": "200px", "targets": 3 },
            { "width": "200px", "targets": 4 }
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
</script>