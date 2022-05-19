<?php
$nama_pemda = get_option('_crb_bmd_nama_pemda');
$tahun_anggaran = get_option('_crb_bmd_tahun_anggaran');
$api_key = get_option( '_crb_apikey_simda_bmd' );
$skpd_all = array();
$body = '';
$tanah = $this->functions->CurlSimda(array(
    'query' => "
        select 
            sum(B.Luas_M2) as jml, 
            COUNT(B.Harga) as jml_bidang, 
            sum(C.Harga) as harga 
        from ta_kib_a B
        INNER JOIN Ta_Fn_KIB_A C ON C.IDPemda = B.IDPemda
        where B.Kd_Hapus = '0'
            AND B.Kd_Data != '3' 
            AND B.Kd_KA= '1'",
    'no_debug' => 0
));
$mesin = $this->functions->CurlSimda(array(
    'query' => "
        select 
            COUNT(B.Harga) as jml, 
            sum(C.Harga) as harga 
        from ta_kib_b B
        INNER JOIN Ta_Fn_KIB_B C ON C.IDPemda = B.IDPemda 
        where B.Kd_Hapus= '0' 
            AND B.Kd_Data != '3' 
            AND B.Kd_KA= '1'",
    'no_debug' => 0
));
$gedung = $this->functions->CurlSimda(array(
    'query' => "
        select 
            COUNT(B.Harga) as jml, 
            sum(C.Harga) as harga 
        from ta_kib_c B
        INNER JOIN Ta_Fn_KIB_C C ON C.IDPemda = B.IDPemda 
        where B.Kd_Hapus= '0' 
            AND B.Kd_Data != '3' 
            AND B.Kd_KA= '1'",
    'no_debug' => 0
));
$jalan = $this->functions->CurlSimda(array(
    'query' => "
        select 
            sum(B.Panjang) as jml, 
            sum(C.Harga) as harga 
        from ta_kib_d B
        INNER JOIN Ta_Fn_KIB_D C ON C.IDPemda = B.IDPemda 
        where B.Kd_Hapus= '0' 
            AND B.Kd_Data != '3' 
            AND B.Kd_KA= '1'",
    'no_debug' => 0
));
$tetap_lainnya = $this->functions->CurlSimda(array(
    'query' => "
        select 
            COUNT(B.Harga) as jml, 
            sum(C.Harga) as harga 
        from ta_kib_e B
        INNER JOIN Ta_Fn_KIB_E C ON C.IDPemda = B.IDPemda 
        where B.Kd_Hapus= '0' 
            AND B.Kd_Data != '3' 
            AND B.Kd_KA= '1'",
    'no_debug' => 0
));
$gedung_pengerjaan = $this->functions->CurlSimda(array(
    'query' => "
        select 
            COUNT(B.Harga) as jml, 
            sum(C.Harga) as harga 
        from Ta_KIB_A B
        INNER JOIN Ta_Fn_KIB_F C ON C.IDPemda = B.IDPemda 
        where B.Kd_Hapus= '0' 
            AND B.Kd_Data != '3' 
            AND B.Kd_KA= '1'",
    'no_debug' => 0
));

$chart_jenis_aset = array(
    'label' => array(
        'Tanah', 
        'Peralatan dan Mesin', 
        'Gedung dan Bangunan', 
        'Jalan, Jaringan dan Irigrasi', 
        'Aset Tetap Lainya', 
        'Kontruksi Dalam Pengerjaan'
    ),
    'data' => array(
        empty($tanah[0]->harga) ? 0 : $tanah[0]->harga,
        empty($mesin[0]->harga) ? 0 : $mesin[0]->harga,
        empty($gedung[0]->harga) ? 0 : $gedung[0]->harga,
        empty($jalan[0]->harga) ? 0 : $jalan[0]->harga,
        empty($tetap_lainnya[0]->harga) ? 0 : $tetap_lainnya[0]->harga,
        empty($gedung_pengerjaan[0]->harga) ? 0 : $gedung_pengerjaan[0]->harga,
    ),
    'color' => array(
        'rgba(255, 99, 132, 1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)'
    )
);

$body .= '
    <tr>
        <td class="text-center" rowspan="2">1</td>
        <td rowspan="2">Tanah</td>
        <td class="text-right">'.number_format($tanah[0]->jml,2,",",".").'</td>
        <td class="text-center">Meter Persegi</td>
        <td class="text-right" rowspan="2">'.number_format($tanah[0]->harga,2,",",".").'</td>
        <td class="text-center" rowspan="2"><a target="_blank" href="'.$this->get_link_daftar_aset(array('get' => array('daftar_aset' => 1, 'jenis_aset' => 'tanah'))).'" class="btn btn-primary">Detail</a></td>
    </tr>
    <tr>
        <td class="text-right">'.number_format($tanah[0]->jml_bidang,2,",",".").'</td>
        <td class="text-center">Bidang Tanah</td>
    </tr>
    <tr>
        <td class="text-center">2</td>
        <td>Peralatan dan Mesin</td>
        <td class="text-right">'.number_format($mesin[0]->jml,2,",",".").'</td>
        <td class="text-center">Pcs</td>
        <td class="text-right">'.number_format($mesin[0]->harga,2,",",".").'</td>
        <td class="text-center"><a target="_blank" href="'.$this->get_link_daftar_aset(array('get' => array('daftar_aset' => 1, 'jenis_aset' => 'mesin'))).'" class="btn btn-primary">Detail</a></td>
    </tr>
    <tr>
        <td class="text-center">3</td>
        <td>Gedung dan Bangunan</td>
        <td class="text-right">'.number_format($gedung[0]->jml,2,",",".").'</td>
        <td class="text-center">Gedung</td>
        <td class="text-right">'.number_format($gedung[0]->harga,2,",",".").'</td>
        <td class="text-center"><a target="_blank" href="'.$this->get_link_daftar_aset(array('get' => array('daftar_aset' => 1, 'jenis_aset' => 'bangunan'))).'" class="btn btn-primary">Detail</a></td>
    </tr>
    <tr>
        <td class="text-center">4</td>
        <td>Jalan, Jaringan dan Irigrasi</td>
        <td class="text-right">'.number_format($jalan[0]->jml,2,",",".").'</td>
        <td class="text-center">Meter (Panjang)</td>
        <td class="text-right">'.number_format($jalan[0]->harga,2,",",".").'</td>
        <td class="text-center"><a target="_blank" href="'.$this->get_link_daftar_aset(array('get' => array('daftar_aset' => 1, 'jenis_aset' => 'jalan'))).'" class="btn btn-primary">Detail</a></td>
    </tr>
    <tr>
        <td class="text-center">5</td>
        <td>Aset Tetap Lainnya</td>
        <td class="text-right">'.number_format($tetap_lainnya[0]->jml,2,",",".").'</td>
        <td class="text-center">Pcs</td>
        <td class="text-right">'.number_format($tetap_lainnya[0]->harga,2,",",".").'</td>
        <td class="text-center"><a target="_blank" href="'.$this->get_link_daftar_aset(array('get' => array('daftar_aset' => 1, 'jenis_aset' => 'aset_tetap'))).'" class="btn btn-primary">Detail</a></td>
    </tr>
    <tr>
        <td class="text-center">6</td>
        <td>Kontruksi Dalam Pengerjaan</td>
        <td class="text-right">'.number_format($gedung_pengerjaan[0]->jml,2,",",".").'</td>
        <td class="text-center">Gedung</td>
        <td class="text-right">'.number_format($gedung_pengerjaan[0]->harga,2,",",".").'</td>
        <td class="text-center"><a target="_blank" href="'.$this->get_link_daftar_aset(array('get' => array('daftar_aset' => 1, 'jenis_aset' => 'bangunan_dalam_pengerjaan'))).'" class="btn btn-primary">Detail</a></td>
    </tr>
';
$total_nilai = $tanah[0]->harga+$mesin[0]->harga+$gedung[0]->harga+$jalan[0]->harga+$tetap_lainnya[0]->harga+$gedung_pengerjaan[0]->harga;
update_option('_crb_total_nilai', $total_nilai);
update_option('_crb_total_per_jenis', json_encode(array(
    array(
        'nama' => 'Tanah',
        'total' => $tanah[0]->harga
    ),
    array(
        'nama' => 'Peralatan dan Mesin',
        'total' => $mesin[0]->harga
    ),
    array(
        'nama' => 'Gedung dan Bangunan',
        'total' => $gedung[0]->harga
    ),
    array(
        'nama' => 'Jalan, Jaringan dan Irigrasi',
        'total' => $jalan[0]->harga
    ),
    array(
        'nama' => 'Aset Tetap Lainnya',
        'total' => $tetap_lainnya[0]->harga
    ),
    array(
        'nama' => 'Kontruksi Dalam Pengerjaan',
        'total' => $gedung_pengerjaan[0]->harga
    )
)));
?>
<div class="modal fade" id="mod-aset" role="dialog" data-backdrop="static" aria-hidden="true">'
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bgpanel-theme">
                <h4 style="margin: 0;" class="modal-title" id="">Modal Aset</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span><i class="dashicons dashicons-dismiss"></i></span></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group" id="wrap-realisasi">
                        <label class="control-label" style="display: block;">tes</label>
                        <input type="number" style="width: 100%;" id="tes"/>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="components-button btn btn-success" id="set-mapping">Simpan</button>
                <button type="button" class="components-button btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
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
        <h2 class="text-center">Total Nilai Barang Milik Daerah<br><?php echo $nama_pemda; ?><br>Tahun <?php echo $tahun_anggaran; ?><br>Rp <?php echo number_format($total_nilai,2,",","."); ?></h2>
        <h2 class="text-center">Data Barang Milik Daerah Per Jenis Aset</h2>
        <div class="container counting-inner">
            <div class="row counting-box title-row" style="margin-bottom: 55px;">
                <div class="col-md-12 text-center animated" data-animation="fadeInBottom"
                    data-animation-delay="200">
                    <div style="width: 100%; max-width: 800px; max-height: 800px; margin: auto; margin-bottom: 20px;">
                        <canvas id="chart_per_jenis_aset"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <table class="table table-bordered">
            <thead id="data_header">
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Jenis Aset</th>
                    <th class="text-center">Jumlah</th>
                    <th class="text-center">Satuan</th>
                    <th class="text-center">Nilai (Rupiah)</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody id="data_body">
                <?php echo $body; ?>
            </tbody>
            <tfoot>
                <th colspan="4" class="text-center">Total Nilai</th>
                <th class="text-right"><?php echo number_format($total_nilai,2,",","."); ?></th>
                <th></th>
            <tfoot>
        </table>
        <h2 class="text-center">Data Barang Milik Daerah Per Unit SKPD<br><?php echo $nama_pemda; ?><br>Tahun <?php echo $tahun_anggaran; ?></h2>
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
                        <th class="text-center">Kode Unit</th>
                        <th class="text-center">Nama Unit</th>
                        <th class="text-center">Nilai (Rupiah)</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="4" class="text-center">Menunggu...</td>
                    </tr>
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
<script type="text/javascript" src="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/js/loadingoverlay.min.js"></script>
<script type="text/javascript">
    window.total_per_bidang = <?php echo get_option('_crb_total_per_skpd'); ?>;
    setTimeout(function(){
        if(pieChart2){
            var new_data = [];
            var labels = [];
            for(var i in total_per_bidang){
                labels.push(total_per_bidang[i].nama.substring(0, 50));
                new_data.push(to_number(total_per_bidang[i].total));
            };
            if(new_data.length == labels.length){
                pieChart2.data.labels = labels;
                pieChart2.data.datasets[0].data = new_data;
                pieChart2.update();
            }
        }
    }, 1000);
    jQuery("#data_per_skpd").LoadingOverlay("show", {
        image : '<?php echo get_option('_crb_menu_logo_loading'); ?>', 
        imageAnimation : false,
        background : "rgba(255, 255, 255, 0.8)",
        progress    : true
    });
    var count     = 0;
    var interval  = setInterval(function(){
        count += 10;
        jQuery("#data_per_skpd").LoadingOverlay("progress", count);
    }, 5000);

    window.chart_jenis_aset = <?php echo json_encode($chart_jenis_aset); ?>;
    var text_menunggu = 'Menunggu...';
    jQuery(document).on('ready', function() {
        jQuery.ajax({
            url: ajax.url,
            type: "POST",
            data: {
                action: 'get_total_skpd_all',
                api_key: '<?php echo $api_key; ?>'
            },
            dataType: 'json',
            success: function(ret){
                if(ret.status == 'error'){
                    return alert(ret.message);
                }
                jQuery('#table-aset-skpd tbody').html(ret.html);
                jQuery("#data_per_skpd").LoadingOverlay("hide", true);
                clearInterval(interval);
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
            }
        });
    });
</script>
<script type="text/javascript" src="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/js/scripts.js"></script>