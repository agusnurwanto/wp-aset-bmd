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
$datasets_awal = array();
// $filter_sub_unit = $this->functions->get_option_multiselect('_crb_sub_unit_pilihan');
$all_jenis = array('mesin', 'bangunan', 'jalan', 'aset_tetap');
foreach($all_jenis as $jenis){
    $where_prov = array();
    $where_kab_kota = array();
    $where_bidang = array();
    $where_unit = array();
    $where_sub = array();
    // foreach($filter_sub_unit as $sub){
    //     $kd = explode('.', $sub);
    //     $where_prov[$kd[1]] = (int) $kd[1];
    //     $where_kab_kota[$kd[2]] = (int) $kd[2];
    //     $where_bidang[$kd[3]] = (int) $kd[3];
    //     $where_unit[$kd[4]] = (int) $kd[4];
    //     $where_sub[$kd[5]] = (int) $kd[5];
    // }
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

    $sql = '
        select
            a.Kd_Prov, 
            a.Kd_Kab_Kota, 
            a.Kd_Bidang, 
            a.Kd_Unit, 
            n.Nm_Bidang, 
            u.Nm_Unit, 
            sum(b.Harga) as harga_asli,
            i.Uraian as uraian_kondisi,
            a.Kondisi
        from '.$data_jenis['table_simda'].' a
        LEFT JOIN ref_bidang n ON n.Kd_Bidang=a.Kd_Bidang
        INNER JOIN Ref_Kondisi i ON i.Kd_Kondisi=a.Kondisi
        LEFT JOIN Ref_Unit u ON u.Kd_Prov=a.Kd_Prov
            AND u.Kd_Kab_Kota=a.Kd_Kab_Kota
            AND u.Kd_Bidang=a.Kd_Bidang
            AND u.Kd_Unit=a.Kd_Unit
        LEFT JOIN '.$data_jenis['table_simda_harga'].' b ON a.IDPemda = b.IDPemda 
        where 
            a.Kd_Hapus= \'0\' 
            AND a.Kd_Data != \'3\' 
            AND a.Kd_KA= \'1\'
            AND b.Harga > 0
            '.$where_all.'
        group by a.Kd_Prov, a.Kd_Kab_Kota, a.Kd_Bidang, n.Nm_Bidang, a.Kd_Unit, u.Nm_Unit, i.Uraian, a.Kondisi
        ';
    $aset = $this->functions->CurlSimda(array(
        'query' => $sql 
    ));
    foreach($aset as $k => $val){
        $no++;
        $total_nilai += $val->harga_asli;
        $kd_lokasi = '12.'.$this->functions->CekNull($val->Kd_Prov).'.'.$this->functions->CekNull($val->Kd_Kab_Kota).'.'.$this->functions->CekNull($val->Kd_Bidang).'.'.$this->functions->CekNull($val->Kd_Unit);
        $key = $kd_lokasi.$val->Kondisi;
        $dt_kondisi = $this->get_kondisi($val->Kondisi);
        if(empty($data_aset[$key])){
            $data_aset[$key] = $val;
            $data_aset[$key]->total_nilai = 0;
            $data_aset[$key]->kd_lokasi = $kd_lokasi;
            $data_aset[$key]->color = $dt_kondisi['color'];
        }
        $data_aset[$key]->total_nilai += $val->harga_asli;
    }
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
            <td class="text-right harga_total" data-kd_lokasi="'.$val->kd_lokasi.'" data-order="'.$val->harga_asli.'">'.number_format($val->harga_asli,2,",",".").'</td>
            <td class="text-center"><a target="_blank" href="'.$this->get_link_daftar_aset(array('get' => array('kd_lokasi' => $val->kd_lokasi, 'nama_skpd' => $val->Nm_Unit, 'daftar_aset' => 1, 'kondisi' => $val->Kondisi))).'" class="btn btn-primary">Detail</a></td>
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
    type: 'line',
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