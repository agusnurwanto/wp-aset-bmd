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
$datasets = array();
$all_jenis = array('mesin', 'bangunan', 'jalan', 'aset_tetap');
$args = array(
   'meta_query' => array(
       array(
           'key' => 'meta_kondisi_aset_simata',
           'value' => $params['kondisi_simata'],
           'compare' => '='
       )
   )
);
$total_nilai_sewa = 0;
$query = new WP_Query($args);
$data_aset = array();
$dt_kondisi = $this->get_kondisi($params['kondisi_simata']);
foreach($query->posts as $post){
    $params_post = shortcode_parse_atts(str_replace('[detail_aset', '', str_replace(']', '', $post->post_content)));
    $kd_lokasi = explode('.', $params_post['kd_lokasi']);
    $Kd_Prov = (int) $kd_lokasi[1];
    $Kd_Kab_Kota = (int) $kd_lokasi[2];
    $Kd_Bidang = (int) $kd_lokasi[3];
    $Kd_Unit = (int) $kd_lokasi[4];
    $kd_lokasi_unit = '12.'.$this->functions->CekNull($Kd_Prov).'.'.$this->functions->CekNull($Kd_Kab_Kota).'.'.$this->functions->CekNull($Kd_Bidang).'.'.$this->functions->CekNull($Kd_Unit);
    $kondisi = get_post_meta($post->ID, 'meta_kondisi_aset_simata', true);

    // filter untuk menampilkan hanya aset yang sesuai unitnya
    if(
        $kd_lokasi_unit != $params['kd_lokasi']
        || $kondisi != $params['kondisi_simata']
    ){
        continue;
    }

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

    $kd_barang = explode('.', $params_post['kd_barang']);
    $Kd_Aset8 = (int) $kd_barang[0];
    $Kd_Aset80 = (int) $kd_barang[1];
    $Kd_Aset81 = (int) $kd_barang[2];
    $Kd_Aset82 = (int) $kd_barang[3];
    $Kd_Aset83 = (int) $kd_barang[4];
    $Kd_Aset84 = (int) $kd_barang[5];
    $Kd_Aset85 = (int) $kd_barang[6];
    $No_Reg8 = (int) $params_post['kd_register'];

    $data_jenis = $this->get_nama_jenis_aset(array('jenis_aset' => $params_post['jenis_aset']));
    $nama_jenis_aset[$data_jenis['nama']] = $data_jenis['nama'];

    $sql = $wpdb->prepare('
        select 
            a.*,
            un.Nm_Unit,
            s.Nm_Sub_Unit,
            u.Nm_UPB, 
            k.Nm_Kecamatan,
            d.Nm_Desa,
            b.Harga as harga_asli
        from '.$data_jenis['table_simda'].' a
        LEFT JOIN '.$data_jenis['table_simda_harga'].' b ON a.IDPemda = b.IDPemda
        INNER JOIN ref_unit un ON a.Kd_Prov = un.Kd_Prov
            AND a.Kd_Kab_Kota = un.Kd_Kab_Kota 
            AND a.Kd_Bidang = un.Kd_Bidang 
            AND a.Kd_Unit = un.Kd_Unit 
        INNER JOIN ref_sub_unit s ON a.Kd_Prov=s.Kd_Prov
            AND a.Kd_Kab_Kota = s.Kd_Kab_Kota 
            AND a.Kd_Bidang = s.Kd_Bidang 
            AND a.Kd_Unit = s.Kd_Unit 
            AND a.Kd_Sub = s.Kd_Sub 
        LEFT JOIN ref_upb u ON u.Kd_Prov=a.Kd_Prov
            AND u.Kd_Kab_Kota=a.Kd_Kab_Kota
            AND u.Kd_Bidang=a.Kd_Bidang
            AND u.Kd_Unit=a.Kd_Unit
            AND u.Kd_Sub = a.Kd_Sub 
            AND u.Kd_UPB = a.Kd_UPB 
            AND ( u.Kd_Kecamatan = a.Kd_Kecamatan OR u.Kd_Kecamatan is null ) 
            AND ( u.Kd_Desa = a.Kd_Desa OR u.Kd_Desa is null )
        LEFT JOIN Ref_Kecamatan k ON k.Kd_Prov=a.Kd_Prov
            AND k.Kd_Kab_Kota = a.Kd_Kab_Kota 
            AND ( k.Kd_Kecamatan = a.Kd_Kecamatan OR k.Kd_Kecamatan is null )
        LEFT JOIN Ref_Desa d ON d.Kd_Prov=a.Kd_Prov
            AND d.Kd_Kab_Kota = a.Kd_Kab_Kota 
            AND ( d.Kd_Kecamatan = a.Kd_Kecamatan OR d.Kd_Kecamatan is null )
            AND ( d.Kd_Desa = a.Kd_Desa OR d.Kd_Desa is null )
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
    $kd_lokasi = $kd_lokasi_unit.'.'.$this->functions->CekNull($aset[0]->Kd_Sub).'.'.$this->functions->CekNull($aset[0]->Kd_UPB).'.'.$this->functions->CekNull($aset[0]->Kd_Kecamatan).'.'.$this->functions->CekNull($aset[0]->Kd_Desa);

    $key = $kd_lokasi.$kondisi.$data_jenis['nama'];
    if(empty($data_aset[$key])){
        $data_aset[$key] = $aset[0];
        $data_aset[$key]->total_nilai = 0;
        $data_aset[$key]->jml_aset = 0;
        $data_aset[$key]->uraian_kondisi = $dt_kondisi['uraian'];
        $data_aset[$key]->kode_kondisi = $kondisi;
        $data_aset[$key]->kd_lokasi = $kd_lokasi;
        $data_aset[$key]->color = $dt_kondisi['color'];
        $data_aset[$key]->jenis = $data_jenis['jenis'];
        $data_aset[$key]->nama_jenis = $data_jenis['nama'];
        $data_aset[$key]->color_jenis = $data_jenis['color'];
        $data_aset[$key]->satuan_jenis = $data_jenis['satuan'];
    }
    $data_aset[$key]->total_nilai += $aset[0]->harga_asli;
    $data_aset[$key]->jml_aset++;
}

$nama_unit = '';

foreach($data_aset as $i => $val){
    $alamat = array();
    if(!empty($val->Nm_Kecamatan)){
        $alamat[] = 'Kec. '.$val->Nm_Kecamatan;
    }
    if(!empty($val->Nm_Desa)){
        $alamat[] = 'Desa/Kel. '.$val->Nm_Desa;
    }
    if(!empty($alamat)){
        $alamat = ' ('.implode(', ', $alamat).')';
    }else{
        $alamat = '';
    }

    $nama_unit = $val->Nm_Unit;
    $nama_skpd = $val->Nm_UPB.$alamat;
    $nama_gabungan = $val->Nm_Sub_Unit.' | '.$nama_skpd;
    if(strpos($nama_skpd, $val->Nm_Sub_Unit) !== false){
        $nama_gabungan = $nama_skpd;
    }
    $datasets[] = array(
        'label' => substr($val->nama_jenis.' '.$nama_gabungan, 0, 50),
        'data' => array(),
        'backgroundColor' => [
            $val->color_jenis
        ]
    );
    $body_skpd .= '
        <tr>
            <td class="text-center">'.$val->uraian_kondisi.'</td>
            <td class="text-center">'.$val->nama_jenis.'</td>
            <td class="text-center">'.$val->kd_lokasi.'</td>
            <td>'.$nama_gabungan.'</td>
            <td class="text-center">'.number_format($val->jml_aset,0,",",".").'</td>
            <td class="text-center">'.$val->satuan_jenis.'</td>
            <td class="text-right harga_total" data-kd_lokasi="'.$val->kd_lokasi.'" data-order="'.$val->harga_asli.'">'.number_format($val->harga_asli,2,",",".").'</td>
            <td class="text-center"><a href="'.$this->get_link_daftar_aset(array('get' => array('kd_lokasi' => $val->kd_lokasi, 'nama_skpd' => $nama_skpd, 'kondisi_simata' => $val->kode_kondisi, 'jenis_aset' => $val->jenis))).'" class="btn btn-primary">Detail</a></td>
        </tr>
    ';
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
        <h2 class="text-center">Data Barang Milik Daerah Per UPB SKPD<br><?php echo $nama_unit; ?><br><?php echo implode(', ', $nama_jenis_aset); ?><br><?php echo $dt_kondisi['uraian']; ?><br><?php echo $nama_pemda; ?><br>Tahun <?php echo $tahun_anggaran; ?></h2>
        <div style="width: 100%; max-width: 1500px; max-height: 1000px; margin: auto; margin-bottom: 25px;">
            <canvas id="chart"></canvas>
        </div>
        <section id="data_per_skpd">
            <table class="table table-bordered" id="table-aset-skpd">
                <thead id="data_header">
                    <tr>
                        <th class="text-center">Kondisi</th>
                        <th class="text-center">Jenis Aset</th>
                        <th class="text-center">Kode UPB</th>
                        <th class="text-center">Nama UPB</th>
                        <th class="text-center">Volume</th>
                        <th class="text-center">Satuan</th>
                        <th class="text-center">Nilai (Rupiah)</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php echo $body_skpd; ?>
                </tbody>
                <tfoot>
                    <th colspan="6" class="text-center">Total Nilai</th>
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
            { "width": "200px", "targets": 3 }
        ],
        order: [[ 1, "asc" ]],
        lengthMenu: [[20, 50, 100, -1], [20, 50, 100, "All"]],
        footerCallback: function ( row, data, start, end, display ) {
            var api = this.api();
            var total_page = api.column( 6, { page: 'current'} )
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
                    var key = (b[1]+' '+b[3]).substring(0, 50);
                    labels.push(key);
                    pieChart2.data.datasets[datasets[key]].data[i] = to_number(b[6].display);
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