<?php
$nama_pemda = get_option('_crb_bmd_nama_pemda');
$tahun_anggaran = get_option('_crb_bmd_tahun_anggaran');
$body = '';
$tanah = $this->simda->CurlSimda(array(
    'query' => 'select sum(Luas_M2) as jml, sum(Harga) as harga from ta_kib_a',
    'no_debug' => 1
));
$mesin = $this->simda->CurlSimda(array(
    'query' => 'select COUNT(*) as jml, sum(Harga) as harga from ta_kib_b',
    'no_debug' => 1
));
$gedung = $this->simda->CurlSimda(array(
    'query' => 'select COUNT(*) as jml, sum(Harga) as harga from ta_kib_c',
    'no_debug' => 1
));
$jalan = $this->simda->CurlSimda(array(
    'query' => 'select sum(Panjang) as jml, sum(Harga) as harga from ta_kib_d',
    'no_debug' => 1
));
$tetap_lainnya = $this->simda->CurlSimda(array(
    'query' => 'select COUNT(*) as jml, sum(Harga) as harga from ta_kib_e',
    'no_debug' => 1
));
$gedung_pengerjaan = $this->simda->CurlSimda(array(
    'query' => 'select COUNT(*) as jml, sum(Harga) as harga from ta_kib_f',
    'no_debug' => 1
));

$body .= '
<tr>
    <td class="text-center">1</td>
    <td>Aset Tanah</td>
    <td class="text-right">'.number_format($tanah[0]->jml,0,",",".").'</td>
    <td class="text-center">Meter Persegi</td>
    <td class="text-right">'.number_format($tanah[0]->harga,0,",",".").'</td>
<tr>
<tr>
    <td class="text-center">2</td>
    <td>Aset Mesin</td>
    <td class="text-right">'.number_format($mesin[0]->jml,0,",",".").'</td>
    <td class="text-center">Pcs</td>
    <td class="text-right">'.number_format($mesin[0]->harga,0,",",".").'</td>
<tr>
<tr>
    <td class="text-center">3</td>
    <td>Aset Bangunan</td>
    <td class="text-right">'.number_format($gedung[0]->jml,0,",",".").'</td>
    <td class="text-center">Gedung</td>
    <td class="text-right">'.number_format($gedung[0]->harga,0,",",".").'</td>
<tr>
<tr>
    <td class="text-center">4</td>
    <td>Aset Jalan Irigrasi</td>
    <td class="text-right">'.number_format($jalan[0]->jml,0,",",".").'</td>
    <td class="text-center">Meter</td>
    <td class="text-right">'.number_format($jalan[0]->harga,0,",",".").'</td>
<tr>
<tr>
    <td class="text-center">5</td>
    <td>Aset Tetap seperti buku, tanaman, hewan</td>
    <td class="text-right">'.number_format($tetap_lainnya[0]->jml,0,",",".").'</td>
    <td class="text-center">Pcs</td>
    <td class="text-right">'.number_format($tetap_lainnya[0]->harga,0,",",".").'</td>
<tr>
<tr>
    <td class="text-center">6</td>
    <td>Aset Kontruksi Dalam Pengerjaan</td>
    <td class="text-right">'.number_format($gedung_pengerjaan[0]->jml,0,",",".").'</td>
    <td class="text-center">Gedung</td>
    <td class="text-right">'.number_format($gedung_pengerjaan[0]->harga,0,",",".").'</td>
<tr>
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
        <h2 class="text-center">Data Aset Barang Milik Daerah<br><?php echo $nama_pemda; ?><br>Tahun <?php echo $tahun_anggaran; ?></h2>
        <table class="table table-bordered">
            <thead id="data_header">
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Jenis Aset</th>
                    <th class="text-center">Jumlah</th>
                    <th class="text-center">Satuan</th>
                    <th class="text-center">Nilai (Rupiah)</th>
                </tr>
            </thead>
            <tbody id="data_body">
                <?php echo $body; ?>
            </tbody>
            <tfoot>
                <th colspan="4" class="text-center">Total Nilai</th>
                <th class="text-right"><?php echo number_format($total_nilai,0,",","."); ?></th>
            <tfoot>
        </table>
    </div>
</div>