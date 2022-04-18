<?php
$nama_pemda = get_option('_crb_bmd_nama_pemda');
$tahun_anggaran = get_option('_crb_bmd_tahun_anggaran');
$api_key = get_option( '_crb_apikey_simda_bmd' );

$limit = '';
if(
    !empty($_GET)
    && !empty($_GET['limit'])
    && is_numeric($_GET['limit'])
){
    $limit = 'top '.$_GET['limit'];
}
$body_skpd = '';
$skpd = $this->functions->CurlSimda(array(
    'query' => '
        select '.$limit.' 
            u.Kd_Prov, 
            u.Kd_Kab_Kota, 
            u.Kd_Bidang, 
            u.Kd_Unit, 
            n.Nm_Unit
        from ref_upb u
        LEFT JOIN Ref_Unit n ON n.Kd_Prov=u.Kd_Prov
            AND n.Kd_Kab_Kota=u.Kd_Kab_Kota
            AND n.Kd_Bidang=u.Kd_Bidang
            AND n.Kd_Unit=u.Kd_Unit
        '
));
$jml = 10;
$skpd_all = array();
$skpd_sementara = array();
$no=0;
$cek_skpd = array();
foreach($skpd as $k => $val){
    $kd_lokasi = '12.'.$this->functions->CekNull($val->Kd_Prov).'.'.$this->functions->CekNull($val->Kd_Kab_Kota).'.'.$this->functions->CekNull($val->Kd_Bidang).'.'.$this->functions->CekNull($val->Kd_Unit);
    if(empty($cek_skpd[$kd_lokasi])){
        $cek_skpd[$kd_lokasi] = $kd_lokasi;
    }else{
        continue;
    }
    $no++;
    $val->kd_lokasi = $kd_lokasi;
    $skpd_sementara[] = $val;
    if($no%$jml == 0){
        $skpd_all[] = $skpd_sementara;
        $skpd_sementara = array();
    }
    $body_skpd .= '
        <tr>
            <td class="text-center">'.$no.'</td>
            <td class="text-center">'.$kd_lokasi.'</td>
            <td>'.$val->Nm_Unit.'</td>
            <td class="text-right harga_total" data-kd_lokasi="'.$kd_lokasi.'">Menunggu... </td>
            <td class="text-center"><a target="_blank" href="'.$this->get_link_daftar_aset(array('get' => array('kd_lokasi' => $kd_lokasi, 'nama_skpd' => $val->Nm_Unit, 'daftar_aset' => 1))).'" class="btn btn-primary">Detail</a></td>
        </tr>
    ';
}
if(!empty($skpd_sementara)){
    $skpd_all[] = $skpd_sementara;
}
$total_nilai_skpd = 0;

$body = '';
$tanah = $this->functions->CurlSimda(array(
    'query' => 'select sum(Luas_M2) as jml, COUNT(*) as jml_bidang, sum(Harga) as harga from ta_kib_a',
    'no_debug' => 1
));
$mesin = $this->functions->CurlSimda(array(
    'query' => 'select COUNT(*) as jml, sum(Harga) as harga from ta_kib_b',
    'no_debug' => 1
));
$gedung = $this->functions->CurlSimda(array(
    'query' => 'select COUNT(*) as jml, sum(Harga) as harga from ta_kib_c',
    'no_debug' => 1
));
$jalan = $this->functions->CurlSimda(array(
    'query' => 'select sum(Panjang) as jml, sum(Harga) as harga from ta_kib_d',
    'no_debug' => 1
));
$tetap_lainnya = $this->functions->CurlSimda(array(
    'query' => 'select COUNT(*) as jml, sum(Harga) as harga from ta_kib_e',
    'no_debug' => 1
));
$gedung_pengerjaan = $this->functions->CurlSimda(array(
    'query' => 'select COUNT(*) as jml, sum(Harga) as harga from ta_kib_f',
    'no_debug' => 1
));

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
        <h2 class="text-center">Data Barang Milik Daerah Per Jenis Aset<br><?php echo $nama_pemda; ?><br>Tahun <?php echo $tahun_anggaran; ?></h2>
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
        <h2 class="text-center">Data Barang Milik Daerah Per SKPD<br><?php echo $nama_pemda; ?><br>Tahun <?php echo $tahun_anggaran; ?></h2>
        <table class="table table-bordered" id="table-aset-skpd">
            <thead id="data_header">
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Kode Unit</th>
                    <th class="text-center">Nama Unit</th>
                    <th class="text-center">Nilai (Rupiah)</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody id="data_body">
                <?php echo $body_skpd; ?>
            </tbody>
            <tfoot>
                <th colspan="3" class="text-center">Total Nilai</th>
                <th class="text-right" id="total_all_skpd">Menunggu... </th>
                <th></th>
            <tfoot>
        </table>
    </div>
</div>
<script type="text/javascript">
var skpd = <?php echo json_encode($skpd_all); ?>;
var row_skpd = {};
jQuery(document).on('ready', function() {
    jQuery('#table-aset-skpd tbody tr').map(function(i, b){
        var tr = jQuery(b);
        var kd_lokasi = tr.find('td.harga_total').attr('data-kd_lokasi');
        row_skpd[kd_lokasi] = i;
    });
    var tableRender = jQuery('#table-aset-skpd').dataTable({
        lengthMenu: [[20, 50, 100, -1], [20, 50, 100, "All"]],
        footerCallback: function ( row, data, start, end, display ) {
            var api = this.api();
            var cek_menunggu = false;
            var text_menunggu = 'Menunggu...';
            var total_page = api.column( 3, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    if(b == text_menunggu){
                        cek_menunggu = text_menunggu;
                        return a;
                    }else{
                        return a + to_number(b);
                    }
                }, 0 );
            if(cek_menunggu){
                total_page = cek_menunggu;
            }else{
                total_page = formatRupiah(total_page);
            }
            jQuery('#total_all_skpd').text(total_page);
        }
    });
    var total_all = 0;
    var last = skpd.length-1;
    skpd.reduce(function(sequence, nextData){
        return sequence.then(function(current_data){
            return new Promise(function(resolve_reduce, reject_reduce){
                var sendData2 = current_data.map(function(opd, i){
                    // console.log('Get pagu SKPD', opd);
                    return new Promise(function(resolve2, reject2){
                        jQuery.ajax({
                            url: ajax.url,
                            type: "POST",
                            data: {
                                action: 'get_total_skpd',
                                api_key: '<?php echo $api_key; ?>',
                                data: opd
                            },
                            dataType: 'json',
                            success: function(ret){
                                tableRender.api().cell({row: row_skpd[ret.data.kd_lokasi], column:3}).data(ret.data.total).draw()
                                total_all += +ret.data.total_asli;
                                resolve2();
                            }
                        });
                    });
                });
                Promise.all(sendData2)
                .then(function(all_data){
                    resolve_reduce(nextData);
                });
            })
            .catch(function(e){
                console.log(e);
                return Promise.resolve(nextData);
            });
        })
        .catch(function(e){
            console.log(e);
            return Promise.resolve(nextData);
        });
    }, Promise.resolve(skpd[last]))
    .then(function(data_last){
        console.log('Berhasil! total=', total_all);
        var total_page = tableRender.api().column( 3, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
                return a + to_number(b);
            }, 0 );
        jQuery('#total_all_skpd').text(formatRupiah(total_page));
    });
});
</script>