<div class="form-group row">
    <label class="col-md-2 col-form-label">Sejarah</label>
    <div class="col-md-10">
        <textarea <?php echo $disabled; ?> class="form-control" name="sejarah" rows="10"><?php echo $meta_sejarah; ?></textarea>
    </div>
</div>
<div class="form-group row">
    <label class="col-md-2 col-form-label">Dokumen Kronologi</label>
    <div class="col-md-10">
    <?php 
        if(!empty($params['key']['edit'])){
            wp_editor($meta_kronologi,'kronologi',array('textarea_name' => 'kronologi', 'textarea_rows' => 20)); 
        }else{
            echo do_shortcode($meta_kronologi);
        }
    ?>
    </div>
</div>
<div class="form-group row">
    <label class="col-md-2 col-form-label">Foto Aset</label>
    <div class="col-md-10">
    <?php 
        if(!empty($params['key']['edit'])){
            wp_editor($meta_foto,'foto',array('textarea_name' => 'foto', 'textarea_rows' => 10)); 
        }else{
            echo do_shortcode($meta_foto);
        }
    ?>
    </div>
</div>
<div class="form-group row">
    <label class="col-md-2 col-form-label">Video Aset</label>
    <div class="col-md-10">
    <?php 
        if(!empty($params['key']['edit'])){
            wp_editor($meta_video,'video',array('textarea_name' => 'video', 'textarea_rows' => 10)); 
        }else{
            echo do_shortcode($meta_video);
        }
    ?>
    </div>
</div>
<div class="form-group row">
    <label class="col-md-2 col-form-label">Disewakan / Tidak</label>
    <div class="col-md-4">
        <label style="margin-left: 15px;"><input type="radio" <?php echo $disabled.' '.$checked_sewa; ?> name="disewakan" value="1"> Telah Disewakan</label>
        <label style="margin-left: 15px;"><input type="radio" <?php echo $disabled.' '.$checked_tidak_sewa; ?> name="disewakan" value="2"> Tidak Disewakan</label>
        <label style="margin-left: 15px;"><input type="radio" <?php echo $disabled.' '.$potensi_disewakan; ?> name="disewakan" value="3"> Potensi Akan Disewakan</label>
    </div>
    <label class="col-md-2 col-form-label">Nilai Sewa</label>
    <div class="col-md-4">
        <input type="number" <?php echo $disabled; ?> class="form-control" name="nilai_sewa" value="<?php echo $nilai_sewa; ?>">
    </div>
</div>
<div class="form-group row">
    <label class="col-md-2 col-form-label">Keterangan Potensi Penggunaan</label>
    <div class="col-md-10">
        <textarea <?php echo $disabled; ?> class="form-control" name="ket_potensi_penggunaan"><?php echo $ket_potensi_penggunaan; ?></textarea>
    </div>
</div>
<div class="form-group row">
    <label class="col-md-2 col-form-label">Nama Penyewa</label>
    <div class="col-md-4">
        <input type="text" <?php echo $disabled; ?> class="form-control" name="nama_sewa" value="<?php echo $nama_sewa; ?>">
    </div>
    <label class="col-md-2 col-form-label">Alamat Penyewa</label>
    <div class="col-md-4">
        <input type="text" <?php echo $disabled; ?> class="form-control" name="alamat_sewa" value="<?php echo $alamat_sewa; ?>">
    </div>
</div>
<div class="form-group row">
    <label class="col-md-2 col-form-label">Waktu Awal Sewa</label>
    <div class="col-md-4">
        <input type="date" <?php echo $disabled; ?> class="form-control" name="waktu_sewa_awal" value="<?php echo $waktu_sewa_awal; ?>">
    </div>
    <label class="col-md-2 col-form-label">Waktu Akhir Sewa</label>
    <div class="col-md-4">
        <input type="date" <?php echo $disabled; ?> class="form-control" name="waktu_sewa_akhir" value="<?php echo $waktu_sewa_akhir; ?>">
    </div>
</div>
<div class="form-group row">
    <label class="col-md-2 col-form-label">Keterangan Penggunaan Aset yang Disewakan</label>
    <div class="col-md-10">
        <textarea <?php echo $disabled; ?> class="form-control" name="ket_penggunaan_aset"><?php echo $ket_penggunaan_aset; ?></textarea>
    </div>
</div>
<div class="form-group row">
    <label class="col-md-2 col-form-label">Aset Perlu Tindak Lanjut</label>
    <div class="col-md-10">
        <label><input type="checkbox" <?php echo $disabled.' '.$checked_tindak_lanjut; ?> name="aset_perlu_tindak_lanjut" value="1"> Ya / Tidak</label>
        <textarea <?php echo $disabled; ?> class="form-control" name="ket_aset_perlu_tindak_lanjut"><?php echo $aset_perlu_tindak_lanjut; ?></textarea>
    </div>
</div>
<div class="form-group row">
    <label class="col-md-2 col-form-label">Aset Perlu Mutasi</label>
    <div class="col-md-10">
        <label><input type="checkbox" <?php echo $disabled.' '.$checked_mutasi_aset; ?> name="mutasi_aset" value="1"> Ya / Tidak</label>
        <textarea <?php echo $disabled; ?> class="form-control" name="ket_mutasi_aset"><?php echo $ket_mutasi_aset; ?></textarea>
    </div>
</div>
<div class="form-group row">
    <label class="col-md-2 col-form-label">Status informasi aset</label>
    <div class="col-md-10">
        <label><input type="radio" <?php echo $disabled.' '.$checked_private; ?> name="status_informasi" value="1"> Privasi / rahasia</label>
        <label style="margin-left: 15px;"><input type="radio" <?php echo $disabled.' '.$checked_publish; ?> name="status_informasi" value="2"> Informasi untuk masyarakat umum</label>
    </div>
</div>
<?php if(!empty($allow_edit_post) && empty($params['key']['edit'])): ?>
<div class="form-group row">
    <label class="col-md-2 col-form-label">Aksi</label>
    <div class="col-md-10">
        <a href="<?php echo $link_edit; ?>" class="btn btn-primary">Edit Post</a>
    </div>
</div>
<?php elseif(!empty($allow_edit_post) && !empty($params['key']['edit'])): ?>
<div class="form-group row">
    <label class="col-md-2 col-form-label">Aksi</label>
    <div class="col-md-10">
        <a onclick="simpan_aset(); return false;" href="#" class="btn btn-primary">Simpan</a> <a style="margin-left: 10px;" href="<?php echo $link_post; ?>" class="btn btn-danger">Kembali</a>
    </div>
</div>
<?php endif; ?>