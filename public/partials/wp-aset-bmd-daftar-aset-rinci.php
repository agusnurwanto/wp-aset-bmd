<?php
$body = '';
$total_nilai = 0;
$data_jenis = $this->get_nama_jenis_aset(array('jenis_aset' => $params['jenis_aset']));
$nama_jenis_aset = $data_jenis['nama'];
$table_simda = $data_jenis['table_simda'];

if(empty($nama_jenis_aset)){
    die('Jenis Aset tidak ditemukan!');
}

$where = '';
if(!empty($Kd_Kecamatan)){
    $where .= $wpdb->prepare(' AND a.Kd_Kecamatan=%d', $Kd_Kecamatan);
}
if(!empty($Kd_Desa)){
    $where .= $wpdb->prepare(' AND a.Kd_Desa=%d', $Kd_Desa);
}

$body_skpd = '';
$sql = $wpdb->prepare('
    select 
        a.*
    from '.$data_jenis['table_simda'].' a
    where a.Kd_Prov=%d
        AND a.Kd_Kab_Kota=%d 
        AND a.Kd_Bidang=%d 
        AND a.Kd_Unit=%d 
        AND a.Kd_Sub=%d 
        AND a.Kd_UPB=%d
        '.$where.'
    ', $Kd_Prov, $Kd_Kab_Kota, $Kd_Bidang, $Kd_Unit, $Kd_Sub, $Kd_UPB);
$aset = $this->functions->CurlSimda(array(
    'query' => $sql 
));
$no=0;
foreach($aset as $k => $val){
    $no++;
    $total_nilai += $val->Harga;
    $kd_lokasi = '12.'.$this->functions->CekNull($val->Kd_Prov).'.'.$this->functions->CekNull($val->Kd_Kab_Kota).'.'.$this->functions->CekNull($val->Kd_Bidang).'.'.$this->functions->CekNull($val->Kd_Unit).'.'.$this->functions->CekNull($val->Kd_Sub).'.'.$this->functions->CekNull($val->Kd_UPB).'.'.$this->functions->CekNull($val->Kd_Kecamatan).'.'.$this->functions->CekNull($val->Kd_Desa);
    $kd_barang = $val->Kd_Aset8.'.'.$val->Kd_Aset80.'.'.$this->functions->CekNull($val->Kd_Aset81).'.'.$this->functions->CekNull($val->Kd_Aset82).'.'.$this->functions->CekNull($val->Kd_Aset83).'.'.$this->functions->CekNull($val->Kd_Aset84).'.'.$this->functions->CekNull($val->Kd_Aset85, 3);
    $kd_register = $this->functions->CekNull($val->No_Reg8, 6);
    $link_detail = $this->get_link_daftar_aset(array(
        'get' => array(
            'nama_skpd' => $params['nama_skpd'],
            'kd_barang' => $kd_barang,
            'kd_register' => $kd_register,
            'kd_lokasi' => $kd_lokasi,
            'jenis_aset' => $params['jenis_aset']
        )
    ));
    $link = $this->functions->generatePage(array(
        'nama_page' => $params['jenis_aset'].' '.$kd_lokasi.' '.$kd_barang.' '.$kd_register,
        'content' => '[detail_aset kd_lokasi="'.$kd_lokasi.'" kd_barang="'.$kd_barang.'" kd_register="'.$kd_register.'" jenis_aset="'.$params['jenis_aset'].'"]',
        'post_status' => 'private',
        'post_type' => 'post',
        'no_key' => true
    ));
    $body_skpd .= '
        <tr>
            <td class="text-center">'.$no.'</td>
            <td class="text-center">'.$kd_barang.'</td>
            <td>'.$kd_register.'</td>
            <td class="text-right">'.$val->Keterangan.'</td>
            <td class="text-center">'.$val->Penggunaan.'</td>
            <td class="text-right" data-sort="'.$val->Harga.'">'.number_format($val->Harga,2,",",".").'</td>
            <td class="text-center"><a target="_blank" href="'.$link['url'].'" class="btn btn-primary">Detail</a></td>
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
        <h2 class="text-center">Data Aset Barang Milik Daerah<br><?php echo $params['nama_skpd']; ?><br><?php echo $nama_jenis_aset; ?><br><?php echo $nama_pemda; ?><br>Tahun <?php echo $tahun_anggaran; ?></h2>
        <table class="table table-bordered" id="table-aset-skpd">
            <thead id="data_header">
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Kode Barang</th>
                    <th class="text-center">Register</th>
                    <th class="text-center">Keterangan</th>
                    <th class="text-center">Penggunaan</th>
                    <th class="text-center">Nilai (Rupiah)</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody id="data_body">
                <?php echo $body_skpd; ?>
            </tbody>
            <tfoot>
                <th colspan="5" class="text-center">Total Nilai</th>
                <th class="text-right" id="total_all_skpd"><?php echo number_format($total_nilai,2,",","."); ?></th>
                <th></th>
            <tfoot>
        </table>
    </div>
</div>
<script type="text/javascript">
jQuery(document).on('ready', function(){
    jQuery('#table-aset-skpd').dataTable({
        columnDefs: [
            { "width": "100px", "targets": 4 }
        ],
        lengthMenu: [[20, 50, 100, -1], [20, 50, 100, "All"]],
        footerCallback: function ( row, data, start, end, display ) {
            var api = this.api();
            var total_page = api.column( 5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return a + to_number(b);
                }, 0 );
            jQuery('#total_all_skpd').text(formatRupiah(total_page));
        }
    });
});
</script>