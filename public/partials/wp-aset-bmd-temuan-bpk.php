<?php
global $wpdb;
$nama_pemda = get_option('_crb_bmd_nama_pemda');
$tahun_anggaran = get_option('_crb_bmd_tahun_anggaran');
$api_key = get_option( '_crb_apikey_simda_bmd' );
$body = '';

$args = array(
   'meta_query' => array(
       array(
           'key' => 'meta_data_temuan_bpk',
           'value' => array(''),
           'compare' => 'NOT IN',
       )
   )
);

$query = new WP_Query($args);

$data_aset = array();

foreach($query->posts as $post){
    $post_id = $post->ID;

    $judul = get_post_meta($post_id, 'meta_judul_temuan_bpk', true);
    $tanggal_temuan_bpk = get_post_meta($post_id, 'meta_tanggal_temuan_bpk', true);
    $keterangan_temuan_bpk = get_post_meta($post_id, 'meta_keterangan_temuan_bpk', true);
    $lampiran_temuan_bpk = get_post_meta($post_id, 'meta_lampiran_temuan_bpk', true);
    $pilih_opd_temuan_bpk = get_post_meta($post_id, 'meta_pilih_opd_temuan_bpk', true);

    $link = $this->functions->generatePage(array(
        'nama_page' => $judul,
        'content' => '[tambah_data_temuan_bpk]',
        'post_status' => 'private',
        'show_header' => 1,
    ));

    $tombol_details = '<a type="button" class="btn btn-primary" href="'.$link['url'].'" target="_blank" style="margin-bottom: 20px;">Details</a>';

    // $params = '';
    $body .= '
        <tr>
            <td class="text-center">'.$judul.'</td>
            <td class="text-center">'.$keterangan_temuan_bpk.'</td>
            <td>'.$tanggal_temuan_bpk.'</td>
            <td>'.$lampiran_temuan_bpk.'</td>
            <td>'.$pilih_opd_temuan_bpk.'</td>
            <td>'.$tombol_details.'</td>
        </tr>
    ';
}

$tombol_tambah = '';
$pilihan_aset = array();
if(is_user_logged_in()){
    $user_id = get_current_user_id();
    if($this->functions->user_has_role($user_id, 'administrator')){
        $custom_url = array();
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
                    <th class="text-center">Jenis Temuan</th>
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