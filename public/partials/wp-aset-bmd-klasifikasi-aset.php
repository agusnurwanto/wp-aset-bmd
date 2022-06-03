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

$nama_jenis_aset = array();
$datasets_awal = array();
$all_jenis = array('mesin', 'bangunan', 'jalan', 'aset_tetap');
$color = array('red', 'green', 'blue', 'orange', 'purple', 'pink');
$args = array(
    'posts_per_page' => -1,
    'post_status' => 'any',
    'meta_query' => array(
       array(
           'key' => 'meta_kondisi_aset_simata',
           'value' => array(''),
           'compare' => 'NOT IN'
       )
   )
);
$total_nilai_sewa = 0;
$query = new WP_Query($args);
$data_aset = array();
foreach($query->posts as $post){
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

    $where = '';
    if(!empty($Kd_Kecamatan)){
        $where .= $wpdb->prepare(' AND a.Kd_Kecamatan=%d', $Kd_Kecamatan);
    }
    if(!empty($Kd_Desa)){
        $where .= $wpdb->prepare(' AND a.Kd_Desa=%d', $Kd_Desa);
    }

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
    $nama_jenis_aset[$data_jenis['nama']] = $data_jenis['nama'];

    $sql = $wpdb->prepare('
        select 
            a.*,
            u.Nm_Unit, 
            b.Harga as harga_asli
        from '.$data_jenis['table_simda'].' a
        LEFT JOIN '.$data_jenis['table_simda_harga'].' b ON a.IDPemda = b.IDPemda
        LEFT JOIN Ref_Unit u ON u.Kd_Prov=a.Kd_Prov
            AND u.Kd_Kab_Kota=a.Kd_Kab_Kota
            AND u.Kd_Bidang=a.Kd_Bidang
            AND u.Kd_Unit=a.Kd_Unit
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
            AND a.Kd_Hapus=0
            AND a.Kd_Data!=3
            AND a.Kd_KA=1
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
    $kd_register = $this->functions->CekNull($aset[0]->No_Reg8, 6);
    $kd_lokasi = '12.'.$this->functions->CekNull($aset[0]->Kd_Prov).'.'.$this->functions->CekNull($aset[0]->Kd_Kab_Kota).'.'.$this->functions->CekNull($aset[0]->Kd_Bidang).'.'.$this->functions->CekNull($aset[0]->Kd_Unit);

    $kondisi = get_post_meta($post->ID, 'meta_kondisi_aset_simata', true);
    $dt_kondisi = $this->get_kondisi($kondisi);
    $key = $kd_lokasi.$kondisi;
    if(empty($data_aset[$key])){
        $data_aset[$key] = $aset[0];
        $data_aset[$key]->total_nilai = 0;
        $data_aset[$key]->uraian_kondisi = $dt_kondisi['uraian'];
        $data_aset[$key]->kode_kondisi = $kondisi;
        $data_aset[$key]->kd_lokasi = $kd_lokasi;
        $data_aset[$key]->color = $dt_kondisi['color'];
    }
    $data_aset[$key]->total_nilai += $aset[0]->harga_asli;
}

foreach($data_aset as $i => $val){
    $datasets_awal[$val->uraian_kondisi] = array(
        'label' => $val->uraian_kondisi,
        'data' => array(),
        'backgroundColor' => [
            $val->color
        ]
    );
    $body_skpd .= '
        <tr>
            <td class="text-center">'.$val->uraian_kondisi.'</td>
            <td class="text-center">'.$val->kd_lokasi.'</td>
            <td>'.$val->Nm_Unit.'</td>
            <td class="text-right harga_total" data-kd_lokasi="'.$val->kd_lokasi.'" data-order="'.$val->total_nilai.'">'.number_format($val->total_nilai,2,",",".").'</td>
            <td class="text-center"><a href="'.$this->get_link_daftar_aset(array('get' => array('kd_lokasi' => $val->kd_lokasi, 'nama_skpd' => $val->Nm_Unit, 'daftar_aset' => 1, 'kondisi_simata' => $val->kode_kondisi))).'" class="btn btn-primary">Detail</a></td>
        </tr>
    ';
}

$datasets = array();
foreach($datasets_awal as $val){
    $datasets[] = $val;
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
        <h2 class="text-center">Klasifikasi Kondisi Barang Milik Daerah<br><?php echo implode(', ', $nama_jenis_aset); ?><br><?php echo $nama_pemda; ?><br>Tahun <?php echo $tahun_anggaran; ?></h2>
        <div style="width: 100%; max-width: 1500px; max-height: 1000px; margin: auto; margin-bottom: 25px;">
            <canvas id="chart"></canvas>
        </div>
        <section id="data_per_skpd">
            <table class="table table-bordered" id="table-aset-skpd">
                <thead id="data_header">
                    <tr>
                        <th class="text-center">Kondisi</th>
                        <th class="text-center">Kode Unit</th>
                        <th class="text-center">Nama Unit</th>
                        <th class="text-center">Nilai (Rupiah)</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php echo $body_skpd; ?>
                </tbody>
                <tfoot>
                    <th colspan="3" class="text-center">Total Nilai</th>
                    <th class="text-right" id="total_all_skpd">Menunggu...</th>
                    <th></th>
                <tfoot>
            </table>
        </section>
    </div>
</div>
<script type="text/javascript">

jQuery(document).on('ready', function(){
    jQuery('#table-aset-skpd').dataTable({
        columnDefs: [
            { "width": "200px", "targets": 2 }
        ],
        order: [[ 1, "asc" ]],
        lengthMenu: [[20, 50, 100, -1], [20, 50, 100, "All"]],
        footerCallback: function ( row, data, start, end, display ) {
            var api = this.api();
            var total_page = api.column( 3, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return a + to_number(b);
                }, 0 );
            jQuery('#total_all_skpd').text(formatRupiah(total_page));
            if(pieChart2){
                var labels = [];
                var datasets = {};
                pieChart2.data.datasets.map(function(b, i){
                    pieChart2.data.datasets[i].data = [];
                    datasets[pieChart2.data.datasets[i].label] = i;
                });
                api.rows( {page:'current'} ).data().map(function(b, i){
                    labels.push(b[2].substring(0, 50));
                    pieChart2.data.datasets[datasets[b[0].trim()]].data[i] = to_number(b[3].display);
                });
                if(labels.length >= 1){
                    pieChart2.data.labels = labels;
                    pieChart2.update();
                }
            }
        }
    });
});


window.pieChart2 = new Chart(document.getElementById('chart'), {
    type: 'bar',
    data: {
        labels: [],
        datasets: <?php echo json_encode($datasets); ?>
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
                labels: {
                    font: {
                        size: 16
                    }
                }
            },
            tooltip: {
                bodyFont: {
                    size: 16
                },
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                boxPadding: 5
            },
        }
    }
});
</script>