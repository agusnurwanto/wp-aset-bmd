<?php
$body = '';
$total_nilai = 0;
$data_jenis = $this->get_nama_jenis_aset(array('jenis_aset' => $params['jenis_aset']));
$nama_jenis_aset = $data_jenis['nama'];
$table_simda = $data_jenis['table_simda'];

if(empty($nama_jenis_aset)){
    die('Jenis Aset tidak ditemukan!');
}

$kd_lokasi_unit = '12.'.$this->functions->CekNull($Kd_Prov).'.'.$this->functions->CekNull($Kd_Kab_Kota).'.'.$this->functions->CekNull($Kd_Bidang).'.'.$this->functions->CekNull($Kd_Unit);
$kd_lokasi_upb = '.'.$this->functions->CekNull($Kd_Sub).'.'.$this->functions->CekNull($Kd_UPB).'.'.$this->functions->CekNull($Kd_Kecamatan).'.'.$this->functions->CekNull($Kd_Desa);
$link_detail_unit = $this->get_link_daftar_aset(
    array('get' => 
        array(
            'kd_lokasi' => $kd_lokasi_unit, 
            'nama_skpd' => $params['nama_skpd'], 
            'daftar_aset' => 1
        )
    )
);

$where = '';
if(!empty($Kd_Kecamatan)){
    $where .= $wpdb->prepare(' AND a.Kd_Kecamatan=%d', $Kd_Kecamatan);
}else{
    $where .= ' AND a.Kd_Kecamatan is null';
}
if(!empty($Kd_Desa)){
    $where .= $wpdb->prepare(' AND a.Kd_Desa=%d', $Kd_Desa);
}else{
    $where .= ' AND a.Kd_Desa is null';
}

$body_skpd = '';
$sql = $wpdb->prepare('
    select 
        a.*,
        r.Nm_Aset5
    from '.$data_jenis['table_simda'].' a
    LEFT JOIN Ref_Rek5_108 r on r.kd_aset=a.Kd_Aset8 
        and r.kd_aset0=a.Kd_Aset80 
        and r.kd_aset1=a.Kd_Aset81 
        and r.kd_aset2=a.Kd_Aset82 
        and r.kd_aset3=a.Kd_Aset83 
        and r.kd_aset4=a.Kd_Aset84 
        and r.kd_aset5=a.Kd_Aset85
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
        'show_header' => 1,
        'no_key' => 1
    ));
    $keterangan = array($val->Keterangan);
    if($params['jenis_aset'] == 'mesin'){
        $keterangan = array();
        if(!empty($val->Nomor_Polisi)){
            $keterangan[] = $val->Nomor_Polisi;
        }
        if(!empty($val->Merk)){
            $keterangan[] = $val->Merk;
        }
        if(!empty($val->Type)){
            $keterangan[] = $val->Type;
        }
        if(!empty($val->CC)){
            $keterangan[] = $val->CC;
        }
        if(!empty($val->Keterangan)){
            $keterangan[] = $val->Keterangan;
        }
    }
    $body_skpd .= '
        <tr>
            <td class="text-center">'.$no.'</td>
            <td class="text-center">'.$kd_barang.'</td>
            <td class="text-center">'.$kd_register.'</td>
            <td>'.$val->Nm_Aset5.'</td>
            <td>'.implode(' | ', $keterangan).'</td>
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
        <h2 class="text-center">Data Barang Milik Daerah<br><a href="<?php echo $link_detail_unit; ?>" target="_blank"><?php echo $kd_lokasi_unit; ?></a><?php echo $kd_lokasi_upb.'<br>'; ?><?php echo $params['nama_skpd']; ?><br><?php echo $nama_jenis_aset; ?><br><?php echo $nama_pemda; ?><br>Tahun <?php echo $tahun_anggaran; ?></h2>
        <table class="table table-bordered" id="table-aset-skpd">
            <thead id="data_header">
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Kode Barang</th>
                    <th class="text-center">Register</th>
                    <th class="text-center">Nama Aset</th>
                    <th class="text-center">Keterangan</th>
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
            { "width": "500px", "targets": 4 }
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