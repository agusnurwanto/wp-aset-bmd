<?php
	$meta_keterangan = '';
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
        <h2 class="text-center">Tambah Data Temuan BPK</h2>
        <form>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Judul</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="judul">
                </div>
                <label for="inputEmail3" class="col-md-2 col-form-label">Tanggal Temuan</label>
                <div class="col-md-4">
                    <input type="date" class="form-control" name="" value="">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Keterangan</label>
                <div class="col-md-10">
                    <?php 
                    wp_editor($meta_keterangan,'keterangan',array('textarea_name' => 'keterangan', 'textarea_rows' => 20)); 
                    ?>
                </div>
            </div>
            
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Lampiran</label>
                <div class="col-md-4">
                    <input type="file" name="lampiran" value="">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">OPD yang menindaklanjuti</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="" value="">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Aksi</label>
                <div class="col-md-10">
                    <a onclick="simpan_aset(); return false;" href="#" class="btn btn-primary">Simpan</a> <a style="margin-left: 10px;" href="<?php echo $aset_belum_masuk_neraca['url']; ?>" class="btn btn-danger">Kembali</a>
                </div>
            </div>
       	</form>
    </div>
</div>