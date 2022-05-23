<?php
global $wpdb;
$nama_pemda = get_option('_crb_bmd_nama_pemda');
$tahun_anggaran = get_option('_crb_bmd_tahun_anggaran');
$api_key = get_option( '_crb_apikey_simda_bmd' );
$body = '';

$args = array(
   'meta_query' => array(
       array(
           'key' => 'abm_kd_register',
           'value' => array(''),
           'compare' => 'NOT IN',
       )
   )
);
$query = new WP_Query($args);
$no = 0;
$data_aset = array();
foreach($query->posts as $post){
    $abm_kd_barang = get_post_meta($post->ID, 'abm_kd_barang', true);
    $abm_kd_register = get_post_meta($post->ID, 'abm_kd_register', true);
    $nilai_aset = get_post_meta($post->ID, 'abm_harga', true);
    if(empty($nilai_aset)){
        $nilai_aset = 0;
    }
    $alamat_aset = get_post_meta($post->ID, 'abm_alamat', true);
    $kd_upb = get_post_meta($post->ID, 'abm_kd_upb', true);
    $alamat_aset = get_post_meta($post->ID, 'abm_alamat', true);
    $koordinatX = get_post_meta($post->ID, 'abm_latitude', true);
    if(empty($koordinatX)){
        $koordinatX = '0';
    }
    $koordinatY = get_post_meta($post->ID, 'abm_longitude', true);
    if(empty($koordinatY)){
        $koordinatY = '0';
    }
    $keterangan = get_post_meta($post->ID, 'abm_keterangan', true);
    $polygon = get_post_meta($post->ID, 'abm_polygon', true);
    $keterangan_tindak_lanjut = get_post_meta($post->ID, 'abm_meta_keterangan_aset_perlu_tindak_lanjut', true);
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
    $nama_aset = get_post_meta($post->ID, 'abm_nama_aset', true);
    $nama_upb = get_post_meta($post->ID, 'abm_nama_upb', true);
    $column_lokasi = get_post_meta($post->ID, 'abm_alamat', true);

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

    $link = $this->functions->generatePage(array(
        'nama_page' => $params['jenis_aset'].' '.$params['kd_lokasi'].' '.$params['kd_barang'].' '.$params['kd_register'],
        'content' => '[detail_aset kd_lokasi="'.$params['kd_lokasi'].'" kd_barang="'.$params['kd_barang'].'" kd_register="'.$params['kd_register'].'" jenis_aset="'.$params['jenis_aset'].'"]',
        'post_status' => 'private',
        'post_type' => 'post',
        'show_header' => 1,
        'no_key' => 1
    ));

    $body .= '
        <tr>
            <td class="text-center">'.$kd_upb.'<br>'.$nama_upb.'</td>
            <td class="text-center">'.$data_jenis['nama'].'</td>
            <td class="text-center">'.$abm_kd_barang.'.'.$abm_kd_register.'</td>
            <td>'.$nama_aset.'</td>
            <td>'.$column_lokasi.'</td>
            <td>'.$keterangan.'</td>
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
        $tombol_tambah = '<button class="btn btn-primary" onclick="jQuery(\'#mod-aset\').modal(\'show\')" style="margin-bottom: 20px;">Tambah Aset Belum Masuk Neraca</button>';
        $judul_form_input = 'Tambah Aset Belum Masuk Neraca';
        $data_jenis = $this->get_nama_jenis_aset(array('jenis_aset' => 'tanah'));
        $custom_url = array();
        $custom_url[] = array('key' => 'jenis_aset', 'value' => $data_jenis['jenis']);
        $link = $this->functions->generatePage(array(
            'nama_page' => $judul_form_input,
            'content' => '[tambah_aset_belum_masuk_neraca]',
            'post_status' => 'private',
            'custom_url' => $custom_url,
            'show_header' => 1
        ));
        $pilihan_aset[] = '<li><a href="'.$link['url'].'" class="btn btn-success">'.$data_jenis['nama'].'</a></li>';
        $data_jenis = $this->get_nama_jenis_aset(array('jenis_aset' => 'mesin'));
        $custom_url = array();
        $custom_url[] = array('key' => 'jenis_aset', 'value' => $data_jenis['jenis']);
        $link = $this->functions->generatePage(array(
            'nama_page' => $judul_form_input,
            'content' => '[tambah_aset_belum_masuk_neraca]',
            'post_status' => 'private',
            'custom_url' => $custom_url,
            'show_header' => 1
        ));
        $pilihan_aset[] = '<li><a href="'.$link['url'].'" class="btn btn-success">'.$data_jenis['nama'].'</a></li>';
        $data_jenis = $this->get_nama_jenis_aset(array('jenis_aset' => 'bangunan'));
        $custom_url = array();
        $custom_url[] = array('key' => 'jenis_aset', 'value' => $data_jenis['jenis']);
        $link = $this->functions->generatePage(array(
            'nama_page' => $judul_form_input,
            'content' => '[tambah_aset_belum_masuk_neraca]',
            'post_status' => 'private',
            'custom_url' => $custom_url,
            'show_header' => 1
        ));
        $pilihan_aset[] = '<li><a href="'.$link['url'].'" class="btn btn-success">'.$data_jenis['nama'].'</a></li>';
        $data_jenis = $this->get_nama_jenis_aset(array('jenis_aset' => 'jalan'));
        $custom_url = array();
        $custom_url[] = array('key' => 'jenis_aset', 'value' => $data_jenis['jenis']);
        $link = $this->functions->generatePage(array(
            'nama_page' => $judul_form_input,
            'content' => '[tambah_aset_belum_masuk_neraca]',
            'post_status' => 'private',
            'custom_url' => $custom_url,
            'show_header' => 1
        ));
        $pilihan_aset[] = '<li><a href="'.$link['url'].'" class="btn btn-success">'.$data_jenis['nama'].'</a></li>';
        $data_jenis = $this->get_nama_jenis_aset(array('jenis_aset' => 'aset_tetap'));
        $custom_url = array();
        $custom_url[] = array('key' => 'jenis_aset', 'value' => $data_jenis['jenis']);
        $link = $this->functions->generatePage(array(
            'nama_page' => $judul_form_input,
            'content' => '[tambah_aset_belum_masuk_neraca]',
            'post_status' => 'private',
            'custom_url' => $custom_url,
            'show_header' => 1
        ));
        $pilihan_aset[] = '<li><a href="'.$link['url'].'" class="btn btn-success">'.$data_jenis['nama'].'</a></li>';
        $data_jenis = $this->get_nama_jenis_aset(array('jenis_aset' => 'bangunan_dalam_pengerjaan'));
        $custom_url = array();
        $custom_url[] = array('key' => 'jenis_aset', 'value' => $data_jenis['jenis']);
        $link = $this->functions->generatePage(array(
            'nama_page' => $judul_form_input,
            'content' => '[tambah_aset_belum_masuk_neraca]',
            'post_status' => 'private',
            'custom_url' => $custom_url,
            'show_header' => 1
        ));
        $pilihan_aset[] = '<li><a href="'.$link['url'].'" class="btn btn-success">'.$data_jenis['nama'].'</a></li>';
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
<div class="modal fade" id="mod-aset" role="dialog" data-backdrop="static" aria-hidden="true">'
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bgpanel-theme">
                <h4 style="margin: 0;" class="modal-title" id="">Pilih Jenis Aset</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span><i class="dashicons dashicons-dismiss"></i></span></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <ul><?php echo implode('', $pilihan_aset); ?></ul>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="components-button btn btn-success hide" id="set-mapping">Simpan</button>
                <button type="button" class="components-button btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<div class="cetak">
    <div style="padding: 10px;">
        <h2 class="text-center">Data Aset Yang Belum Masuk Neraca<br><?php echo $nama_pemda; ?><br>Tahun <?php echo $tahun_anggaran; ?></h2>
        <?php echo $tombol_tambah; ?>
        <table class="table table-bordered" id="data_aset_aset">
            <thead>
                <tr>
                    <th class="text-center">UPB</th>
                    <th class="text-center">Jenis Aset</th>
                    <th class="text-center">Kode Barang</th>
                    <th class="text-center">Nama Aset</th>
                    <th class="text-center">Lokasi</th>
                    <th class="text-center">Keterangan Aset</th>
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
<script type="text/javascript">

jQuery(document).on('ready', function(){
    jQuery('#data_aset_aset').dataTable({
        columnDefs: [
            { "width": "200px", "targets": 5 }
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