<?php
global $post;

$current_post = $post;
$nama_pemda = get_option('_crb_bmd_nama_pemda');
$tahun_anggaran = get_option('_crb_bmd_tahun_anggaran');
$api_key = get_option( '_crb_apikey_simda_bmd' );
$body = '';

$args = array(
    'posts_per_page' => -1,
    'post_status' => 'any',
    'meta_query' => array(
       array(
           'key' => 'meta_judul_temuan_bpk',
           'value' => array(''),
           'compare' => 'NOT IN',
       )
   )
);

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
                    $alert = 'alert("Berhasil hapus data temuan BPK!");';
                }
            }
        }
    }
}

$no=1;
$query = new WP_Query($args);
foreach($query->posts as $post){
    $post_id = $post->ID;
    $status_neraca = get_post_meta($post_id, 'meta_status_neraca', true);
    $jenis_aset = get_post_meta($post_id, 'meta_pilih_jenis_aset', true);
    $judul_temuan_bpk = get_post_meta($post_id, 'meta_judul_temuan_bpk', true);
    $option_judul_temuan_bpk = $this->get_opsi_jenis_temuan($judul_temuan_bpk);
    $tanggal_temuan_bpk = get_post_meta($post_id, 'meta_tanggal_temuan_bpk', true);
    $keterangan_temuan_bpk = get_post_meta($post_id, 'meta_keterangan_temuan_bpk', true);
    $lampiran_temuan_bpk = get_post_meta($post_id, 'meta_lampiran_temuan_bpk', true);
    $pilih_opd_temuan_bpk = get_post_meta($post_id, 'meta_pilih_opd_temuan_bpk', true);
    $nama_opd_temuan_bpk = get_post_meta($post_id, 'meta_nama_opd_temuan_bpk', true);
    $kode_barang_temuan = get_post_meta($post_id, 'meta_kode_barang_temuan', true);
    $nm_aset = get_post_meta($post_id, 'meta_nama_barang_temuan', true);
    $post_id_aset = get_post_meta($post_id, 'meta_post_id_aset', true);
    $url_aset = '#';
    if(!empty($post_id_aset)){
        $post_aset = get_post($post_id_aset);
        $post_aset->custom_url = array(
            array(
                'key' =>'detail',
                'value' => 1
            )
        );
        $url_aset = $this->functions->get_link_post($post_aset);
    }

    if($status_neraca == '1'){
        $status_neraca = 'SIMDA BMD';
    }else if($status_neraca == '2'){
        $status_neraca = 'Belum Masuk Neraca';
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
            ),
            array(
                'key' =>'skip',
                'value' => 1
            )
        );
        $link_edit = $this->functions->get_link_post($post);
        $current_post->custom_url = array(
            array(
                'key' =>'delete',
                'value' => $post_id
            )
        );
        $link_delete = $this->functions->get_link_post($current_post);
        $tombol_edit = '<a href="'.$link_edit.'" class="btn btn-success"><i class="dashicons dashicons-edit"></i></a> <a onclick="return confirm(\'Apakah anda yakin untuk menghapus aset ini?\');" href="'.$link_delete.'" class="btn btn-danger"><i class="dashicons dashicons-trash"></i></a>';
    }
    // $params = '';
    $body .= '
        <tr>
            <td class="text-center">'.$status_neraca.'</td>
            <td class="text-center">'.$jenis_aset.'</td>
            <td>'.$judul_temuan_bpk.'</td>
            <td class="text-center"><a href="'.$url_aset.'">'.$kode_barang_temuan.'<br>'.$nm_aset.'</a></td>
            <td>'.$keterangan_temuan_bpk.'</td>
            <td class="text-center">'.$tanggal_temuan_bpk.'</td>
            <td>'.$lampiran_temuan_bpk.'</td>
            <td class="text-center">'.$pilih_opd_temuan_bpk.'<br>'.$nama_opd_temuan_bpk.'</td>
            <td class="text-center"><a href="'.$link_detail.'" class="btn btn-primary"><i class="dashicons dashicons-search"></i></a> '.$tombol_edit.'</td>
        </tr>
    ';
}

$tombol_tambah = '';
$pilihan_aset = array();
if(is_user_logged_in()){
    $user_id = get_current_user_id();
    if($this->functions->user_has_role($user_id, 'administrator')){
        $judul_form_input = 'Tambah Data Temuan BPK';
        $link = $this->functions->generatePage(array(
            'nama_page' => $judul_form_input,
            'content' => '[tambah_data_temuan_bpk]',
            'post_status' => 'private',
            'show_header' => 1,
        ));

        $tombol_tambah = '<a type="button" class="btn btn-primary" href="'.$link['url'].'" target="_blank" style="margin-bottom: 20px;">Tambah Temuan BPK</a>';
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
        <h2 class="text-center">Data Temuan BPK<br>( Badan Pemeriksa Keuangan )<br><?php echo $nama_pemda; ?><br>Tahun <?php echo $tahun_anggaran; ?></h2>
        <?php echo $tombol_tambah; ?>
        <table class="table table-bordered" id="data_temuan_bpk">
            <thead>
                <tr>
                    <th class="text-center">Status Aset</th>
                    <th class="text-center">Jenis Aset</th>
                    <th class="text-center">Judul Temuan</th>
                    <th class="text-center">Kode Barang</th>
                    <th class="text-center">Keterangan</th>
                    <th class="text-center">Tanggal Temuan</th>
                    <th class="text-center">Lampiran</th>
                    <th class="text-center">OPD yang menindaklanjuti</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody id="data_body">
                <?php echo $body; ?>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
<?php echo $alert; ?>
jQuery(document).on('ready', function(){
    jQuery('#data_temuan_bpk').dataTable({
        columnDefs: [
            { "width": "10px", "targets": 0 },
            { "width": "200px", "targets": 2 }
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