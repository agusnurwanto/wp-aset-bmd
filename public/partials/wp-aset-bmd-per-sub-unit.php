<?php
$nama_pemda = get_option('_crb_bmd_nama_pemda');
$tahun_anggaran = get_option('_crb_bmd_tahun_anggaran');
$api_key = get_option( '_crb_apikey_simda_bmd' );
$_POST['api_key'] = $api_key;
$limit = '';
if(
    !empty($_GET['limit'])
    && is_numeric($_GET['limit'])
){
    $limit = 'top '.$_GET['limit'];
}
$body_skpd = '';
$filter_sub_unit = $this->functions->get_option_multiselect('_crb_sub_unit_pilihan');
$skpd = $this->functions->CurlSimda(array(
    'query' => '
        select '.$limit.' 
            u.Kd_Prov, 
            u.Kd_Kab_Kota, 
            u.Kd_Bidang, 
            u.Kd_Unit, 
            u.Kd_Sub, 
            b.Nm_Bidang, 
            n.Nm_Unit, 
            s.Nm_Sub_Unit
        from ref_upb u
        LEFT JOIN ref_bidang b ON b.Kd_Bidang=u.Kd_Bidang
        LEFT JOIN Ref_Unit n ON n.Kd_Prov=u.Kd_Prov
            AND n.Kd_Kab_Kota=u.Kd_Kab_Kota
            AND n.Kd_Bidang=u.Kd_Bidang
            AND n.Kd_Unit=u.Kd_Unit
        INNER JOIN ref_sub_unit s ON u.Kd_Prov=s.Kd_Prov
            AND u.Kd_Kab_Kota = s.Kd_Kab_Kota 
            AND u.Kd_Bidang = s.Kd_Bidang 
            AND u.Kd_Unit = s.Kd_Unit 
            AND u.Kd_Sub = s.Kd_Sub
        '
));
$no=0;
$cek_skpd = array();
$all_skpd = array();
$all_bidang = array();
foreach($skpd as $k => $val){
    $kd_bidang = '12.'.$this->functions->CekNull($val->Kd_Prov).'.'.$this->functions->CekNull($val->Kd_Kab_Kota).'.'.$this->functions->CekNull($val->Kd_Bidang);
    $kd_lokasi = $kd_bidang.'.'.$this->functions->CekNull($val->Kd_Unit).'.'.$this->functions->CekNull($val->Kd_Sub);
    if(empty($cek_skpd[$kd_lokasi])){
        $cek_skpd[$kd_lokasi] = $kd_lokasi;
    }else{
        continue;
    }

    // filter untuk menampilkan sub unit skpd yang terpilih saja
    if(empty($filter_sub_unit[$kd_lokasi])){
        continue;
    }
    $no++;
    $val->kd_lokasi = $kd_lokasi;
    $_POST['data'] = (array) $val;
    $total = $this->get_total_skpd(true);
    if(empty($total['data']['total_asli'])){
        continue;
    }
    $body_skpd .= '
        <tr>
            <td class="text-center">'.$kd_lokasi.'</td>
            <td>'.$val->Nm_Sub_Unit.'</td>
            <td class="text-right harga_total" data-kd_lokasi="'.$kd_lokasi.'" data-order="'.$total['data']['total_asli'].'">'.$total['data']['total'].'</td>
            <td class="text-center"><a target="_blank" href="'.$this->get_link_daftar_aset(array('get' => array('kd_lokasi' => $kd_lokasi, 'nama_skpd' => $val->Nm_Sub_Unit, 'daftar_aset' => 1))).'" class="btn btn-primary">Detail</a></td>
        </tr>
    ';
    $all_skpd[$kd_lokasi] = array(
    	'nama' => $val->Nm_Sub_Unit,
    	'total' => $total['data']['total_asli']
    );
    if(empty($all_bidang[$kd_bidang])){
    	$all_bidang[$kd_bidang] = array(
    		'nama' => $val->Nm_Bidang,
    		'total' => 0
    	);
    }
    $all_bidang[$kd_bidang]['total'] += $total['data']['total_asli'];
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
		<h2 class="text-center">Data Barang Milik Daerah Per Sub Unit SKPD<br><?php echo $nama_pemda; ?><br>Tahun <?php echo $tahun_anggaran; ?></h2>
        <div class="container counting-inner">
            <div class="row counting-box title-row">
                <div class="col-md-12 text-center animated" data-animation="fadeInBottom"
                    data-animation-delay="200">
                    <div style="width: 100%; max-width: 1500px; max-height: 1000px; margin: auto; margin-bottom: 25px;">
                        <canvas id="chart_per_unit"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <section id="data_per_skpd">
            <table class="table table-bordered" id="table-aset-skpd">
                <thead id="data_header">
                    <tr>
                        <th class="text-center">Kode Sub Unit</th>
                        <th class="text-center">Nama Sub Unit</th>
                        <th class="text-center">Nilai (Rupiah)</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php echo $body_skpd; ?>
                </tbody>
                <tfoot>
                    <th colspan="2" class="text-center">Total Nilai</th>
                    <th class="text-right" id="total_all_skpd">Menunggu...</th>
                    <th></th>
                <tfoot>
            </table>
        </section>
    </div>
</div>
<script type="text/javascript" src="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/js/scripts.js"></script>
<script type="text/javascript">
	var text_menunggu = 'Menunggu...';
    jQuery(document).on('ready', function() {
        window.tableRender = jQuery('#table-aset-skpd').dataTable({
            lengthMenu: [[20, 50, 100, -1], [20, 50, 100, "All"]],
            footerCallback: function ( row, data, start, end, display ) {
                var api = this.api();
                var total_page = api.column( 2, { page: 'current'} )
                    .data()
                    .reduce( function (a, b) {
                        return a + to_number(b);
                    }, 0 );
                jQuery('#total_all_skpd').text(formatRupiah(total_page));
                if(pieChart2){
                    var new_data = [];
                    var labels = [];
                    api.rows( {page:'current'} ).data().map(function(b, i){
                        labels.push(b[1].substring(0, 50));
                        new_data.push(to_number(b[2].display));
                    });
                    if(new_data.length == labels.length){
                        pieChart2.data.labels = labels;
                        pieChart2.data.datasets[0].data = new_data;
                        pieChart2.update();
                    }
                }
            }
    	});
    });
</script>