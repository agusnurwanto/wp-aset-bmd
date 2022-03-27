<?php
$body = '';
$total_nilai = 0;
$data_jenis = $this->get_nama_jenis_aset(array('jenis_aset' => $params['jenis_aset']));
$nama_jenis_aset = $data_jenis['nama'];
$table_simda = $data_jenis['table_simda'];
if(empty($nama_jenis_aset)){
    die('Jenis Aset tidak ditemukan!');
}

$select_custom = '';
if($table_simda == 'Ta_KIB_A'){
    $select_custom = 'sum(a.Luas_M2) as luas, ';
}

$body_skpd = '';
$skpd = $this->functions->CurlSimda(array(
    'query' => '
        select 
            '.$select_custom.'
            a.Kd_Prov, 
            a.Kd_Kab_Kota, 
            a.Kd_Bidang, 
            a.Kd_Unit, 
            a.Kd_Sub, 
            a.Kd_UPB, 
            a.Kd_Kecamatan, 
            a.Kd_Desa, 
            COUNT(a.Harga) as jml, 
            sum(a.Harga) as harga,
            u.Nm_UPB,
            k.Nm_Kecamatan,
            d.Nm_Desa
        from '.$data_jenis['table_simda'].' a
        LEFT JOIN ref_upb u ON a.Kd_Prov=u.Kd_Prov
            AND a.Kd_Kab_Kota = u.Kd_Kab_Kota 
            AND a.Kd_Bidang = u.Kd_Bidang 
            AND a.Kd_Unit = u.Kd_Unit 
            AND a.Kd_Sub = u.Kd_Sub 
            AND a.Kd_UPB = u.Kd_UPB 
        LEFT JOIN Ref_Kecamatan k ON k.Kd_Prov=a.Kd_Prov
            AND k.Kd_Kab_Kota = a.Kd_Kab_Kota 
            AND k.Kd_Kecamatan = a.Kd_Kecamatan
        LEFT JOIN Ref_Desa d ON d.Kd_Prov=a.Kd_Prov
            AND d.Kd_Kab_Kota = a.Kd_Kab_Kota 
            AND d.Kd_Kecamatan = a.Kd_Kecamatan
            AND d.Kd_Desa = a.Kd_Desa
        group by a.Kd_Prov, 
            a.Kd_Kab_Kota, 
            a.Kd_Bidang, 
            a.Kd_Unit, 
            a.Kd_Sub, 
            a.Kd_UPB, 
            a.Kd_Kecamatan, 
            a.Kd_Desa,
            u.Nm_UPB,
            k.Nm_Kecamatan,
            d.Nm_Desa'
));
$jml = 50;
$skpd_all = array();
$skpd_sementara = array();
$no=0;
foreach($skpd as $k => $val){
    $no++;
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
    if($table_simda == 'Ta_KIB_A'){
        $jumlah = number_format($val->jml,2,",",".").'<br>'.number_format($val->luas,2,",",".");
        $satuan = 'Bidang Tanah<br>Meter Persegi';
    }else if($table_simda == 'Ta_KIB_B'){
        $satuan = 'Pcs';
    }else if($table_simda == 'Ta_KIB_C'){
        $satuan = 'Gedung';
    }else if($table_simda == 'Ta_KIB_D'){
        $satuan = 'Meter (Panjang)';
    }else if($table_simda == 'Ta_KIB_E'){
        $satuan = 'Pcs';
    }else if($table_simda == 'Ta_KIB_F'){
        $satuan = 'Gedung';
    }
    $link_detail = $this->get_link_daftar_aset(array(
        'get' => array(
            'nama_skpd' => $val->Nm_UPB.' '.$alamat,
            'kd_lokasi' => $kd_lokasi,
            'jenis_aset' => $params['jenis_aset']
        )
    ));
    $body_skpd .= '
        <tr>
            <td class="text-center">'.$no.'</td>
            <td class="text-center">'.$kd_lokasi.'</td>
            <td>'.$val->Nm_UPB.' '.$alamat.'</td>
            <td class="text-right">'.$jumlah.'</td>
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
        <h2 class="text-center">Data Aset Barang Milik Daerah Per SKPD<br><?php echo $nama_jenis_aset; ?><br><?php echo $nama_pemda; ?><br>Tahun <?php echo $tahun_anggaran; ?></h2>
        <table class="table table-bordered" id="table-aset-skpd">
            <thead id="data_header">
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Kode Lokasi</th>
                    <th class="text-center">Nama SKPD</th>
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