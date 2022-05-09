<?php
$body = '';
$total_nilai = 0;
$nama_jenis_aset_all = array();
$nama_skpd = '';
$datasets = array();
if(!empty($params['jenis_aset'])){
    $data_jenis = $this->get_nama_jenis_aset(array('jenis_aset' => $params['jenis_aset']));
    $nama_jenis_aset = $data_jenis['nama'];
    $params['nama_aset'] = $nama_jenis_aset;
    $table_simda = $data_jenis['table_simda'];
    if(empty($nama_jenis_aset)){
        die('Jenis Aset tidak ditemukan!');
    }else{
        $nama_jenis_aset_all[] = $nama_jenis_aset;
        $skpd = $this->get_total_aset_upb($table_simda, $params);
    }
    $datasets[] = array(
        'label' => $nama_jenis_aset,
        'data' => array(),
        'backgroundColor' => [
            $data_jenis['color']
        ]
    );
}else if(!empty($params['kd_lokasi'])){
    $nama_skpd = '<br>'.$params['kd_lokasi'].' '.$params['nama_skpd'];
    $skpd = array();
    $params['jenis_aset'] = 'tanah';
    $data_jenis = $this->get_nama_jenis_aset(array('jenis_aset' => $params['jenis_aset']));
    $nama_jenis_aset = $data_jenis['nama'];
    $params['nama_aset'] = $nama_jenis_aset;
    $table_simda = $data_jenis['table_simda'];
    if(!empty($nama_jenis_aset)){
        $nama_jenis_aset_all[] = $nama_jenis_aset;
        $skpd = array_merge($skpd, $this->get_total_aset_upb($table_simda, $params));
    }
    $datasets[] = array(
        'label' => $nama_jenis_aset,
        'data' => array(),
        'backgroundColor' => [
            $data_jenis['color']
        ]
    );

    $params['jenis_aset'] = 'mesin';
    $data_jenis = $this->get_nama_jenis_aset(array('jenis_aset' => $params['jenis_aset']));
    $nama_jenis_aset = $data_jenis['nama'];
    $params['nama_aset'] = $nama_jenis_aset;
    $table_simda = $data_jenis['table_simda'];
    if(!empty($nama_jenis_aset)){
        $nama_jenis_aset_all[] = $nama_jenis_aset;
        $skpd = array_merge($skpd, $this->get_total_aset_upb($table_simda, $params));
    }
    $datasets[] = array(
        'label' => $nama_jenis_aset,
        'data' => array(),
        'backgroundColor' => [
            $data_jenis['color']
        ]
    );
    
    $params['jenis_aset'] = 'bangunan';
    $data_jenis = $this->get_nama_jenis_aset(array('jenis_aset' => $params['jenis_aset']));
    $nama_jenis_aset = $data_jenis['nama'];
    $params['nama_aset'] = $nama_jenis_aset;
    $table_simda = $data_jenis['table_simda'];
    if(!empty($nama_jenis_aset)){
        $nama_jenis_aset_all[] = $nama_jenis_aset;
        $skpd = array_merge($skpd, $this->get_total_aset_upb($table_simda, $params));
    }
    $datasets[] = array(
        'label' => $nama_jenis_aset,
        'data' => array(),
        'backgroundColor' => [
            $data_jenis['color']
        ]
    );
    
    $params['jenis_aset'] = 'jalan';
    $data_jenis = $this->get_nama_jenis_aset(array('jenis_aset' => $params['jenis_aset']));
    $nama_jenis_aset = $data_jenis['nama'];
    $params['nama_aset'] = $nama_jenis_aset;
    $table_simda = $data_jenis['table_simda'];
    if(!empty($nama_jenis_aset)){
        $nama_jenis_aset_all[] = $nama_jenis_aset;
        $skpd = array_merge($skpd, $this->get_total_aset_upb($table_simda, $params));
    }
    $datasets[] = array(
        'label' => $nama_jenis_aset,
        'data' => array(),
        'backgroundColor' => [
            $data_jenis['color']
        ]
    );
    
    $params['jenis_aset'] = 'aset_tetap';
    $data_jenis = $this->get_nama_jenis_aset(array('jenis_aset' => $params['jenis_aset']));
    $nama_jenis_aset = $data_jenis['nama'];
    $params['nama_aset'] = $nama_jenis_aset;
    $table_simda = $data_jenis['table_simda'];
    if(!empty($nama_jenis_aset)){
        $nama_jenis_aset_all[] = $nama_jenis_aset;
        $skpd = array_merge($skpd, $this->get_total_aset_upb($table_simda, $params));
    }
    $datasets[] = array(
        'label' => $nama_jenis_aset,
        'data' => array(),
        'backgroundColor' => [
            $data_jenis['color']
        ]
    );
    
    $params['jenis_aset'] = 'bangunan_dalam_pengerjaan';
    $data_jenis = $this->get_nama_jenis_aset(array('jenis_aset' => $params['jenis_aset']));
    $nama_jenis_aset = $data_jenis['nama'];
    $params['nama_aset'] = $nama_jenis_aset;
    $table_simda = $data_jenis['table_simda'];
    if(!empty($nama_jenis_aset)){
        $nama_jenis_aset_all[] = $nama_jenis_aset;
        $skpd = array_merge($skpd, $this->get_total_aset_upb($table_simda, $params));
    }
    $datasets[] = array(
        'label' => $nama_jenis_aset,
        'data' => array(),
        'backgroundColor' => [
            $data_jenis['color']
        ]
    );
    
}else if(
    empty($params['jenis_aset'])
    && empty($params['kd_lokasi'])
){
    die('Jenis Aset atau Kode lokasi tidak boleh kosong!');
}

$body_skpd = '';
$jml = 50;
$skpd_all = array();
$skpd_sementara = array();
$no=0;
foreach($skpd as $k => $val){
    $no++;
    if($val->harga <= 0){
        continue;
    }
    $total_nilai += $val->harga;
    $kd_lokasi = '12.'.$this->functions->CekNull($val->Kd_Prov).'.'.$this->functions->CekNull($val->Kd_Kab_Kota).'.'.$this->functions->CekNull($val->Kd_Bidang).'.'.$this->functions->CekNull($val->Kd_Unit).'.'.$this->functions->CekNull($val->Kd_Sub).'.'.$this->functions->CekNull($val->Kd_UPB).'.'.$this->functions->CekNull($val->Kd_Kecamatan).'.'.$this->functions->CekNull($val->Kd_Desa);
    $val->kd_lokasi = $kd_lokasi;
    $skpd_sementara[] = $val;
    if($no%$jml == 0){
        $skpd_all[] = $skpd_sementara;
        $skpd_sementara = array();
    }
    $alamat = array();
    if(!empty($val->Nm_Kecamatan)){
        $alamat[] = 'Kec. '.$val->Nm_Kecamatan;
    }
    if(!empty($val->Nm_Desa)){
        $alamat[] = 'Desa/Kel. '.$val->Nm_Desa;
    }
    if(!empty($alamat)){
        $alamat = '('.implode(', ', $alamat).')';
    }else{
        $alamat = '';
    }
    $jumlah = number_format($val->jml,2,",",".");
    if($val->table_simda == 'Ta_KIB_A'){
        $jumlah = number_format($val->jml,2,",",".").'<br>'.number_format($val->luas,2,",",".");
        $satuan = 'Bidang Tanah<br>Meter Persegi';
    }else if($val->table_simda == 'Ta_KIB_B'){
        $satuan = 'Pcs';
    }else if($val->table_simda == 'Ta_KIB_C'){
        $satuan = 'Gedung';
    }else if($val->table_simda == 'Ta_KIB_D'){
        $satuan = 'Meter (Panjang)';
    }else if($val->table_simda == 'Ta_KIB_E'){
        $satuan = 'Pcs';
    }else if($val->table_simda == 'Ta_KIB_F'){
        $satuan = 'Gedung';
    }
    $link_detail = $this->get_link_daftar_aset(array(
        'get' => array(
            'nama_skpd' => $val->Nm_UPB.' '.$alamat,
            'kd_lokasi' => $kd_lokasi,
            'jenis_aset' => $val->jenis_aset
        )
    ));
    $body_skpd .= '
        <tr>
            <td class="text-center">'.$val->nama_aset.'</td>
            <td class="text-center">'.$kd_lokasi.'</td>
            <td>'.$val->Nm_Sub_Unit.'</td>
            <td>'.$val->Nm_UPB.' '.$alamat.'</td>
            <td class="text-right" data-sort="'.$val->jml.'">'.$jumlah.'</td>
            <td class="text-center">'.$satuan.'</td>
            <td class="text-right" data-kd_lokasi="'.$kd_lokasi.'" data-sort="'.$val->harga.'">'.number_format($val->harga,2,",",".").'</td>
            <td class="text-center"><a target="_blank" href="'.$link_detail.'" class="btn btn-primary">Detail</a></td>
        </tr>
    ';
}
if(!empty($skpd_sementara)){
    $skpd_all[] = $skpd_sementara;
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
        <h2 class="text-center">Data Barang Milik Daerah Per UPB SKPD<?php echo $nama_skpd; ?><br><?php echo implode(', ', $nama_jenis_aset_all); ?><br><?php echo $nama_pemda; ?><br>Tahun <?php echo $tahun_anggaran; ?></h2>
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
        <table class="table table-bordered" id="table-aset-skpd">
            <thead id="data_header">
                <tr>
                    <th class="text-center">Jenis Aset</th>
                    <th class="text-center">Kode Lokasi</th>
                    <th class="text-center">Nama Sub Unit</th>
                    <th class="text-center">Nama UPB</th>
                    <th class="text-center">Jumlah</th>
                    <th class="text-center">Satuan</th>
                    <th class="text-center">Nilai (Rupiah)</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody id="data_body">
                <?php echo $body_skpd; ?>
            </tbody>
            <tfoot>
                <th colspan="6" class="text-center">Total Nilai</th>
                <th class="text-right" id="total_all_skpd"><?php echo number_format($total_nilai,2,",","."); ?></th>
                <th></th>
            <tfoot>
        </table>
    </div>
</div>
<script type="text/javascript">
var data_skpd = [];
var new_data = [];
var labels = [];
data_skpd.map(function(b, i){
    if(i < 30){ return; }
    var data = {};
    for(var n in b){
        labels.push(n.substring(0, 50));
        new_data.push(b[n]);
    }
});
// console.log('new_data', new_data);
window.pieChart2 = new Chart(document.getElementById('chart_per_unit'), {
    type: 'line',
    data: {
        labels: labels,
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
        },
        animation: {
            onProgress: function() {
                const ctx = this.ctx;
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                let dataSum = 0;
                if(this._sortedMetasets.length > 0 && this._sortedMetasets[0].data.length > 0) {
                    const dataset = this._sortedMetasets[0].data[0].$context.dataset;
                    dataSum = dataset.data.reduce((p, c) => p + c, 0);
                }
                if(dataSum <= 0) return;

                this._sortedMetasets.forEach(meta => {
                    meta.data.forEach(metaData => {
                        const dataset = metaData.$context.dataset;
                        const datasetIndex = metaData.$context.dataIndex;
                        const value = dataset.data[datasetIndex];
                        const percent = (Math.round(value / dataSum * 1000) / 10) + '%';
                        const mid_radius = metaData.innerRadius + (metaData.outerRadius - metaData.innerRadius) * 0.7;
                        const start_angle = metaData.startAngle;
                        const end_angle = metaData.endAngle;
                        if(start_angle === end_angle) return; // hidden
                        const mid_angle = start_angle + (end_angle - start_angle) / 2;

                        const x = mid_radius * Math.cos(mid_angle);
                        const y = mid_radius * Math.sin(mid_angle);

                        ctx.fillStyle = '#fff';
                        ctx.fillText(formatRupiah(value), metaData.x + x, metaData.y + y);
                        ctx.fillText(percent, metaData.x + x, metaData.y + y + 20);
                    });
                });
            }
        }
    }
});
jQuery(document).on('ready', function(){
    jQuery('#table-aset-skpd').dataTable({
        columnDefs: [
            { "width": "110px", "targets": 0 },
            { "width": "50px", "targets": 5 },
            { "width": "130px", "targets": 6 }
        ],
        order: [[ 6, "desc" ]],
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
                pieChart2.data.datasets[0].data = [];
                pieChart2.data.datasets[1].data = [];
                pieChart2.data.datasets[2].data = [];
                pieChart2.data.datasets[3].data = [];
                pieChart2.data.datasets[4].data = [];
                pieChart2.data.datasets[5].data = [];
                api.rows( {page:'current'} ).data().map(function(b, i){
                    labels.push(b[3].substring(0, 50));
                    if(b[0] == 'Tanah'){
                        pieChart2.data.datasets[0].data[i] = to_number(b[6].display);
                    }else if(b[0].trim() == 'Peralatan dan Mesin'){
                        pieChart2.data.datasets[1].data[i] = to_number(b[6].display);
                    }else if(b[0].trim() == 'Gedung dan Bangunan'){
                        pieChart2.data.datasets[2].data[i] = to_number(b[6].display);
                    }else if(b[0].trim() == 'Jalan, Jaringan dan Irigrasi'){
                        pieChart2.data.datasets[3].data[i] = to_number(b[6].display);
                    }else if(b[0].trim() == 'Aset Tetap Lainnya'){
                        pieChart2.data.datasets[4].data[i] = to_number(b[6].display);
                    }else if(b[0].trim() == 'Kontruksi Dalam Pengerjaan'){
                        pieChart2.data.datasets[5].data[i] = to_number(b[6].display);
                    }
                });
                if(labels.length >= 1){
                    pieChart2.data.labels = labels;
                    pieChart2.update();
                }
            }
        }
    });
});
</script>