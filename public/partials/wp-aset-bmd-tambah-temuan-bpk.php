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
        <h2 class="text-center">Tambah Data Temuan BPK<br>( Badan Pemeriksa Keuangan )</h2>
        <form>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Judul</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="judul_temuan_bpk">
                </div>
                <label for="inputEmail3" class="col-md-2 col-form-label">Tanggal Temuan</label>
                <div class="col-md-4">
                    <input type="date" class="form-control" name="tanggal_temuan_bpk" value="">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Keterangan</label>
                <div class="col-md-4">
                    <textarea>

                    </textarea>
                </div>
                <label class="col-md-2 col-form-label">OPD yang menindaklanjuti</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="opd_temuan_bpk" value="">
                </div>
            </div>
            
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Lampiran</label>
                <div class="col-md-10">
                    <?php 
                        wp_editor($meta_keterangan,'keterangan',array('textarea_name' => 'keterangan_temuan_bpk', 'textarea_rows' => 20)); 
                    ?>
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

<script>
    function simpan_aset(){
        cek_simpan()
        .then(function(res){
            jQuery('#wrap-loading').show();
            jQuery.ajax({
                url: ajax.url,
                type: "post",
                data: {
                    "action": "simpan_aset",
                    "api_key": "<?php echo $api_key; ?>",
                    "id_post": "<?php echo $post->ID; ?>",
                    "judul_temuan_bpk": jQuery('input[name="judul_temuan_bpk"]').val(),

                },
                dataType: "json",
                success: function(data){
                    jQuery('#wrap-loading').hide();
                    return alert(data.message);
                },
                error: function(e) {
                    console.log(e);
                    return alert(data.message);
                }
            });
        });
    }
</script>