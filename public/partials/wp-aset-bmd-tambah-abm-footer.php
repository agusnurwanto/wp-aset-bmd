            <div class="form-group row">
                <label class="col-md-2 col-form-label">Sejarah</label>
                <div class="col-md-10">
                    <textarea <?php echo $disabled; ?> rows="10" class="form-control" name="sejarah"><?php echo $abm_meta_sejarah; ?></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Dokumen Kronologi</label>
                <div class="col-md-10">
                <?php 
                    if(empty($disabled)){
                        wp_editor($abm_meta_kronologi,'kronologi',array('textarea_name' => 'kronologi', 'textarea_rows' => 10));
                    }else{
                        echo do_shortcode($abm_meta_kronologi);
                    }
                ?>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Foto</label>
                <div class="col-md-10">
                <?php 
                    if(empty($disabled)){
                        wp_editor($abm_meta_foto,'foto',array('textarea_name' => 'foto', 'textarea_rows' => 10));
                    }else{
                        echo do_shortcode($abm_meta_foto);
                    }
                ?>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Video</label>
                <div class="col-md-10">
                <?php 
                    if(empty($disabled)){
                        wp_editor($abm_meta_video,'video',array('textarea_name' => 'video', 'textarea_rows' => 10));
                    }else{
                        echo do_shortcode($abm_meta_video);
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
                    <input <?php echo $disabled; ?> type="number" class="form-control" name="nilai_sewa" value="<?php echo $abm_meta_nilai_sewa; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Keterangan Potensi Penggunaan</label>
                <div class="col-md-10">
                    <textarea <?php echo $disabled; ?> class="form-control" name="ket_potensi_penggunaan"><?php echo $abm_meta_ket_potensi_penggunaan; ?></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Nama Penyewa</label>
                <div class="col-md-4">
                    <input <?php echo $disabled; ?> type="text" class="form-control" name="nama_sewa" value="<?php echo $abm_meta_nama_sewa; ?>">
                </div>
                <label class="col-md-2 col-form-label">Alamat Penyewa</label>
                <div class="col-md-4">
                    <input <?php echo $disabled; ?> type="text" class="form-control" name="alamat_sewa" value="<?php echo $abm_meta_alamat_sewa; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Waktu Awal Sewa</label>
                <div class="col-md-4">
                    <input <?php echo $disabled; ?> type="date" class="form-control" name="waktu_sewa_awal" value="<?php echo $abm_meta_waktu_sewa_awal; ?>">
                </div>
                <label class="col-md-2 col-form-label">Waktu Akhir Sewa</label>
                <div class="col-md-4">
                    <input <?php echo $disabled; ?> type="date" class="form-control" name="waktu_sewa_akhir" value="<?php echo $abm_meta_waktu_sewa_akhir; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Keterangan Penggunaan Aset yang Disewakan</label>
                <div class="col-md-10">
                    <textarea <?php echo $disabled; ?> class="form-control" name="ket_penggunaan_aset"><?php echo $abm_meta_ket_penggunaan_aset; ?></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Aset Perlu Tindak Lanjut</label>
                <div class="col-md-10">
                    <label><input type="checkbox" <?php echo $disabled.' '.$checked_tindak_lanjut; ?> name="aset_perlu_tindak_lanjut" value="1"> Ya / Tidak</label>
                    <textarea <?php echo $disabled; ?> class="form-control" name="ket_aset_perlu_tindak_lanjut"><?php echo $abm_meta_keterangan_aset_perlu_tindak_lanjut; ?></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Aset Perlu Mutasi</label>
                <div class="col-md-10">
                    <label><input type="checkbox" <?php echo $disabled.' '. $checked_mutasi_aset ?>  name="mutasi_aset" value="1"> Ya / Tidak</label>
                    <textarea <?php echo $disabled; ?> class="form-control" name="ket_mutasi_aset"><?php echo $abm_meta_ket_mutasi_aset; ?></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Status informasi aset</label>
                <div class="col-md-10">
                    <label><input type="radio" <?php echo $disabled.' '.$checked_private; ?> name="status_informasi" value="1"> Privasi / rahasia</label>
                    <label style="margin-left: 15px;"><input type="radio" <?php echo $disabled.' '.$checked_publish; ?> name="status_informasi" value="2"> Informasi untuk masyarakat umum</label>
                </div>
            </div>
        <?php if(empty($disabled)): ?>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Aksi</label>
                <div class="col-md-10">
                    <a onclick="simpan_aset(); return false;" href="#" class="btn btn-primary">Simpan</a>
                    <a href="<?php echo $aset_belum_masuk_neraca['url']; ?>" class="btn btn-success">Kembali</a>
                </div>
            </div>
        <?php elseif(!empty($disabled) && !empty($allow_edit_post)): ?>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Aksi</label>
                <div class="col-md-10">
                    <a href="<?php echo $aset_belum_masuk_neraca['url']; ?>" class="btn btn-success">Kembali</a>
                    <a href="<?php echo $link_edit; ?>" class="btn btn-primary">Edit Post</a>
                    <a onclick="return confirm('Apakah anda yakin untuk menghapus aset ini?');" href="<?php echo $link_delete; ?>" class="btn btn-danger">Delete Post</a>
                </div>
            </div>
        <?php else: ?>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Aksi</label>
                <div class="col-md-10">
                    <a href="<?php echo $aset_belum_masuk_neraca['url']; ?>" class="btn btn-success">Kembali</a>
                </div>
            </div>
        <?php endif; ?>
       	</form>
    </div>
</div>