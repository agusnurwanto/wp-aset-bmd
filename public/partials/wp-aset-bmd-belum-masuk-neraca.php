<?php
global $wpdb;
global $post;

$current_post = $post;
$nama_pemda = get_option('_crb_bmd_nama_pemda');
$tahun_anggaran = get_option('_crb_bmd_tahun_anggaran');
$api_key = get_option( '_crb_apikey_simda_bmd' );
$body = '';
$alert = '';

$allow_edit = false;
if(is_user_logged_in()){
    $user_id = get_current_user_id();
    if($this->functions->user_has_role($user_id, 'administrator')){
        $allow_edit = true;
        if(!empty($_GET) && !empty($_GET['key'])){
            $params['key'] = $this->functions->decode_key($_GET['key']);
            if(!empty($params['key']['delete'])){
                $post_id_delete = $params['key']['delete'];
                $meta_all = get_post_meta($post_id_delete);
                foreach($meta_all as $key => $val)  {
                    delete_post_meta($post_id_delete, $key);
                }
                $ret = wp_delete_post($post_id_delete, true);
                if(!empty($ret)){
                    $alert = 'alert("Berhasil hapus data aset belum masuk neraca!");';
                }
            }
        }
    }
}

$args = array(
    'posts_per_page' => -1,
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
    $kd_upb = get_post_meta($post->ID, 'abm_kd_upb', true);
    $abm_nama_upb = get_post_meta($post->ID, 'abm_nama_upb', true);
    $jenis_aset = get_post_meta($post->ID, 'abm_jenis_aset', true);
    $abm_kd_barang = get_post_meta($post->ID, 'abm_kd_barang', true);
    $abm_kd_register = get_post_meta($post->ID, 'abm_kd_register', true);
    $nilai_aset = get_post_meta($post->ID, 'abm_harga', true);
    if(empty($nilai_aset)){
        $nilai_aset = 0;
    }
    $alamat_aset = get_post_meta($post->ID, 'abm_alamat', true);
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
    $data_jenis = $this->get_nama_jenis_aset(array('jenis_aset' => $jenis_aset));
    $nama_aset = get_post_meta($post->ID, 'abm_nama_aset', true);
    $column_lokasi = get_post_meta($post->ID, 'abm_alamat', true);

    $warna_map = '';
    $ikon_map = '';
    if ($jenis_aset == 'tanah') {
        $warna_map = get_option('_crb_warna_tanah');
        $ikon_map  = get_option('_crb_icon_tanah');
    }

    if ($jenis_aset == 'bangunan') {
        $warna_map = get_option('_crb_warna_gedung');
        $ikon_map  = get_option('_crb_icon_gedung');
    }

    if ($jenis_aset == 'jalan') {
        $warna_map = get_option('_crb_warna_jalan');
        $ikon_map  = get_option('_crb_icon_jalan');
    }

    $post->custom_url = array(
        array(
            'key' =>'detail',
            'value' => 1
        )
    );
    $link_detail = $this->functions->get_link_post($post);

    $tombol_edit = '';
    if($allow_edit){
        $post->custom_url = array(
            array(
                'key' =>'edit',
                'value' => 1
            )
        );
        $link_edit = $this->functions->get_link_post($post);
        $current_post->custom_url = array(
            array(
                'key' =>'delete',
                'value' => $post->ID
            )
        );
        $link_delete = $this->functions->get_link_post($current_post);
        $tombol_edit = '<a href="'.$link_edit.'" class="btn btn-success"><i class="dashicons dashicons-edit"></i></a> <a onclick="return confirm(\'Apakah anda yakin untuk menghapus aset ini?\');" href="'.$link_delete.'" class="btn btn-danger"><i class="dashicons dashicons-trash"></i></a>';
    }

    $body .= '
        <tr>
            <td class="text-center">'.$kd_upb.'<br>'.$abm_nama_upb.'</td>
            <td class="text-center">'.$data_jenis['nama'].'</td>
            <td class="text-center">'.$abm_kd_barang.'.'.$abm_kd_register.'</td>
            <td>'.$nama_aset.'</td>
            <td>'.$column_lokasi.'</td>
            <td>'.$keterangan.'</td>
            <td class="text-right" data-sort="'.$nilai_aset.'">'.number_format($nilai_aset,2,",",".").'</td>
            <td class="text-center"><a href="'.$link_detail.'" class="btn btn-primary"><i class="dashicons dashicons-search"></i></a> '.$tombol_edit.'</td>
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
        'nama_skpd' => $abm_nama_upb,
        'kd_barang' => $abm_kd_barang,
        'kd_lokasi' => $kd_upb,
        'warna_map' => $warna_map,
        'ikon_map'  => $ikon_map,
    );
}

$tombol_tambah = '';
$pilihan_aset = array();
if($allow_edit){
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
<?php echo $alert; ?>
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