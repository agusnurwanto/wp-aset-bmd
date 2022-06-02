<?php
$kd_lokasi_unit = '12.'.$this->functions->CekNull($Kd_Prov).'.'.$this->functions->CekNull($Kd_Kab_Kota).'.'.$this->functions->CekNull($Kd_Bidang).'.'.$this->functions->CekNull($Kd_Unit).'.'.$this->functions->CekNull($Kd_Sub);
$kd_lokasi_upb = '.'.$this->functions->CekNull($Kd_UPB).'.'.$this->functions->CekNull($Kd_Kecamatan).'.'.$this->functions->CekNull($Kd_Desa);
$link_detail_unit = $this->get_link_daftar_aset(
    array('get' => 
        array(
            'kd_lokasi' => $kd_lokasi_unit, 
            'nama_skpd' => $params['nama_skpd'], 
            'daftar_aset' => 1
        )
    )
);
    $link_detail = $this->get_link_daftar_aset(array(
        'get' => array(
            'nama_skpd' => $params['nama_skpd'].' '.$alamat,
            'kd_lokasi' => $params['kd_lokasi'],
            'jenis_aset' => $params['jenis_aset']
        )
    ));

?>
<style type="text/css">
    .warning {
        background: #f1a4a4;
    }
    .hide, nav.post-navigation, header.entry-header {
        display: none;
    }
</style>
<div class="cetak">
    <div style="padding: 10px;">
        <h2 class="text-center">Data Barang Milik Daerah<br><a href="<?php echo $link_detail_unit; ?>"><?php echo $kd_lokasi_unit; ?></a><?php echo $kd_lokasi_upb.'<br>'; ?><a href="<?php echo $link_detail; ?>"><?php echo $params['nama_skpd'].' '.$alamat; ?></a><br><?php echo $nama_jenis_aset; ?> ( <?php echo $aset[0]->Nm_Aset5; ?> )<br><?php echo $params['kd_barang'].' '.$params['kd_register']; ?><br><?php echo $nama_pemda; ?><br>Tahun <?php echo $tahun_anggaran; ?></h2>
        <form>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Kode UPB</label>
                <div class="col-md-4">
                    <input type="text" disabled class="form-control" name="" value="<?php echo $params['kd_lokasi']; ?>">
                </div>
                <label class="col-md-2 col-form-label">Unit Pengelola Barang</label>
                <div class="col-md-4">
                    <input type="text" disabled class="form-control" name="" value="<?php echo $params['nama_skpd']; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-md-2 col-form-label">Kecamatan</label>
                <div class="col-md-4">
                    <input type="text" disabled class="form-control" name="" value="<?php echo $params['kecamatan']; ?>">
                </div>
                <label class="col-md-2 col-form-label">Desa / Kelurahan</label>
                <div class="col-md-4">
                    <input type="text" disabled class="form-control" name="" value="<?php echo $params['desa']; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Kode Barang</label>
                <div class="col-md-4">
                    <input type="text" disabled class="form-control" name="" value="<?php echo $params['kd_barang']; ?>">
                </div>
                <label class="col-md-2 col-form-label">Nomor Register</label>
                <div class="col-md-4">
                    <input type="text" disabled class="form-control" name="" value="<?php echo $params['kd_register']; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Nama Aset</label>
                <div class="col-md-10">
                    <input type="text" disabled class="form-control" name="" value="<?php echo $aset[0]->Nm_Aset5; ?>">
                </div>
            </div>