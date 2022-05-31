<?php
$aset_tidak_ditemukan = '<label class="col-form-label" style="color: red">Nama Aset Tidak Ditemukan!</label>';
$sql = "
    SELECT 
        u.*, 
        k.Nm_Kecamatan,
        d.Nm_Desa
    from ref_upb u
    LEFT JOIN Ref_Kecamatan k ON k.Kd_Prov=u.Kd_Prov
        AND k.Kd_Kab_Kota = u.Kd_Kab_Kota 
        AND k.Kd_Kecamatan = u.Kd_Kecamatan
    LEFT JOIN Ref_Desa d ON d.Kd_Prov=u.Kd_Prov
        AND d.Kd_Kab_Kota = u.Kd_Kab_Kota 
        AND d.Kd_Kecamatan = u.Kd_Kecamatan
        AND d.Kd_Desa = u.Kd_Desa
";
$upbs = $this->functions->CurlSimda(array(
    'query' => $sql,
    'no_debug' => 0
));
$pilih_jenis_aset = '<option value="">Pilih Jenis Aset</option>';
if (!empty($jenis_aset) && $jenis_aset != '' ) {
    $pilih_jenis_aset = '<option value="">'.$jenis_aset.'</option>';
}

$list_upb = '<option value="">Pilih UPB</option>';

$new_upbs = array();
foreach($upbs as $i => $val){
    $nama_upb = $val->Nm_UPB;

    $alamat = array();
    if(!empty($val->Nm_Kecamatan)){
        $alamat[] = 'Kec. '.$val->Nm_Kecamatan;
    }
    if(!empty($val->Nm_Desa)){
        $alamat[] = 'Desa/Kel. '.$val->Nm_Desa;
    }
    if(!empty($alamat)){
        $alamat = ' ('.implode(', ', $alamat).')';
    }else{
        $alamat = '';
    }

    $kd_upb = '12.'.$this->functions->CekNull($val->Kd_Prov).'.'.$this->functions->CekNull($val->Kd_Kab_Kota).'.'.$this->functions->CekNull($val->Kd_Bidang).'.'.$this->functions->CekNull($val->Kd_Unit).'.'.$this->functions->CekNull($val->Kd_Sub).'.'.$this->functions->CekNull($val->Kd_UPB).'.'.$this->functions->CekNull($val->Kd_Kecamatan).'.'.$this->functions->CekNull($val->Kd_Desa);
    $upbs[$i]->kd_upb = $kd_upb;
    $new_upbs[$kd_upb] = $upbs[$i];
    $selected = '';
    if ($pilih_opd_temuan_bpk == $kd_upb) {
        $selected .= 'selected';
    }
    $list_upb .= '<option value="'.$kd_upb.'" '.$selected.'>'.$kd_upb.'-'.$nama_upb.$alamat.'</option>';
}


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
                <label class="col-md-2 col-form-label">OPD yang menindaklanjuti</label>
                <div class="col-md-10">
                    <select class="form-control" name="pilih_opd_temuan_bpk" <?php echo $disabled; ?>>
                        <?php echo $list_upb; ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label" >Status Aset</label>
                <div class="col-md-4" >
                    <label style="margin-left: 15px;"><input type="radio" <?php echo $disabled.' '.$checked_sudah_neraca; ?> name="status_neraca" value="1"> SIMDA BMD </label>
                    <label style="margin-left: 15px;"><input type="radio" <?php echo $disabled.' '.$checked_belum_neraca; ?> name="status_neraca" value="2"> Belum masuk neraca </label>
                </div>
                <label class="col-md-2 col-form-label">Jenis Aset</label>
                <div class="col-md-4">
                    <select class="form-control" id="pilih_jenis_aset" <?php echo $disabled; ?>>
                        <?php echo $pilih_jenis_aset; ?>
                        <option value="tanah">Tanah</option>
                        <option value="bangunan">Bangunan</option>
                        <option value="mesin">Mesin</option>
                        <option value="jalan">Jalan</option>
                        <option value="aset_tetap">Aset Tetap</option>
                        <option value="bangunan_dalam_pengerjaan">Bangunan Dalam Pengerjaan</option>
                    </select>
                </div>
                
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Kode Barang</label>
                <div class="col-md-4">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="kode_barang_temuan" value="<?php echo $kode_barang_temuan; ?>" <?php echo $disabled; ?>/>
                        <div class="input-group-prepend">
                            <button class="btn btn-success" id="cari-aset" type="button">Cari Aset</button>
                        </div>
                    </div>
                </div>
                <label class="col-md-2 col-form-label">Nama Aset</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="post_id_aset" value="" disabled style="display: none;" />
                    <span id="link_nama_aset"><?php echo $aset_tidak_ditemukan; ?></span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Jenis Temuan BPK</label>
                <div class="col-md-4">
                    <select class="form-control" name="judul_temuan_bpk" <?php echo $disabled; ?>>
                        <?php echo $option_judul_temuan_bpk; ?>
                    </select>
                </div>
                <label for="inputEmail3" class="col-md-2 col-form-label">Tanggal Temuan</label>
                <div class="col-md-4">
                    <input type="date" class="form-control" name="tanggal_temuan_bpk" value="<?php echo $tanggal_temuan_bpk; ?>" <?php echo $disabled; ?>>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Keterangan</label>
                <div class="col-md-10">
                    <textarea class="form-control" name="keterangan_temuan_bpk" placeholder="Keterangan Data Temuan BPK" <?php echo $disabled; ?>><?php echo $keterangan_temuan_bpk; ?></textarea>
                </div>
            </div>
            
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Lampiran</label>
                <div class="col-md-10">
                <?php 
                    if(empty($disabled)){
                        wp_editor($lampiran_temuan_bpk,'lampiran_temuan_bpk',array('textarea_name' => 'lampiran_temuan_bpk', 'textarea_rows' => 20)); 
                    }else{
                        echo $lampiran_temuan_bpk;
                    }
                ?>
                </div>
            </div>
        <?php if(empty($disabled) && !empty($allow_edit_post)): ?>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Aksi</label>
                <div class="col-md-10">
                    <a onclick="simpan_temuan_bpk(); return false;" href="#" class="btn btn-primary">Simpan</a> <a style="margin-left: 10px;" href="<?php echo $data_temuan_bpk['url']; ?>" class="btn btn-danger">Kembali</a>
                </div>
            </div>
        <?php elseif(!empty($disabled) && !empty($allow_edit_post)): ?>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Aksi</label>
                <div class="col-md-10">
                    <a href="<?php echo $link_edit; ?>" class="btn btn-primary">Edit Post</a> <a onclick="return confirm('Apakah anda yakin untuk menghapus aset ini?');" href="<?php echo $link_delete; ?>" class="btn btn-danger">Delete Post</a>
                </div>
            </div>
        <?php endif; ?>
       	</form>
    </div>
</div>

<script>
    function simpan_temuan_bpk(){
		var judul_temuan_bpk = jQuery('input[name="judul_temuan_bpk"]').val();
		if(judul_temuan_bpk == ''){
			return alert("Judul Temuan tidak boleh kosong!");
		}
		var opd = jQuery('select[name="pilih_opd_temuan_bpk"]').val();
		if(opd == ''){
			return alert("OPD tidak boleh kosong!");
		}
        var post_id_aset = jQuery('input[name="post_id_aset"]').val();
        if(post_id_aset == ''){
            return alert("Nama aset tidak boleh kosong!");
        }
		var keterangan_temuan_bpk = jQuery('textarea[name="keterangan_temuan_bpk"]').val();
		if(keterangan_temuan_bpk == ''){
			return alert("Keterangan aset tidak boleh kosong!");
		}
        if(confirm("Apakah anda yakin untuk menyimpan data ini?")){
            jQuery('#wrap-loading').show();
            var upb = jQuery('select[name="pilih_opd_temuan_bpk"] option:selected').text().split(' ');
            upb.shift();
            var data_post = {
                "action": "simpan_temuan_bpk",
                "api_key": "<?php echo $api_key; ?>",
                "post_id_aset": post_id_aset,
                "status_neraca": jQuery('input[name="status_neraca"]:checked').val(),
                "pilih_jenis_aset": jQuery( "#pilih_jenis_aset option:selected" ).text(),
                "judul_temuan_bpk": jQuery('select[name="judul_temuan_bpk"]').val(),
                "pilih_opd_temuan_bpk": jQuery('select[name="pilih_opd_temuan_bpk"]').val(),
                "nama_upb": upb.join(' '),
                "tanggal_temuan_bpk": jQuery('input[name="tanggal_temuan_bpk"]').val(),
                "tanggal_temuan_bpk": jQuery('input[name="tanggal_temuan_bpk"]').val(),
                "keterangan_temuan_bpk": jQuery('textarea[name="keterangan_temuan_bpk"]').val(),
                "lampiran_temuan_bpk": tinyMCE.get('lampiran_temuan_bpk').getContent(),
                "kode_barang_temuan": jQuery('input[name="kode_barang_temuan"]').val(),

            };
        <?php 
            if(!empty($allow_edit_post)){
                echo "data_post.id_post = ".$post->ID.';';
            }
        ?>
            jQuery.ajax({
                url: ajax.url,
                type: "post",
                data: data_post,
                dataType: "json",
                success: function(data){
                    jQuery('#wrap-loading').hide();
                    alert(data.message);
                <?php 
                    if(empty($allow_edit_post)){
                        echo "window.location.href='".$data_temuan_bpk['url']."';";
                    }
                ?>
                },
                error: function(e) {
                    console.log(e);
                }
            });
        }
    }

    jQuery('#cari-aset').on('click', function(){
        var kd_upb = jQuery('select[name="pilih_opd_temuan_bpk"]').val();
        if(kd_upb == ''){
            return alert('Kode UPB tidak boleh kosong!');
        }
        var status_aset = jQuery('input[name="status_neraca"]:checked').val();
        if(status_aset == ''){
            return alert('Status aset tidak boleh kosong!');
        }
        var jenis_aset = jQuery('#pilih_jenis_aset').val();
        if(jenis_aset == ''){
            return alert('Jenis aset tidak boleh kosong!');
        }
        var kd_barang = jQuery('input[name="kode_barang_temuan"]').val();
        if(kd_barang.split('.').length < 8){
            jQuery('input[name="post_id_aset"]').val('');
            jQuery('#link_nama_aset').html('<?php echo $aset_tidak_ditemukan; ?>');
            return alert('Format kode barang harus diisi full dengan termasuk kode register!');
        }

        jQuery('#wrap-loading').show();
        jQuery.ajax({
            url: ajax.url,
            type: "post",
            data: {
                action: 'get_data_barang',
                api_key: "<?php echo $api_key; ?>",
                kd_upb: kd_upb,
                status_aset: status_aset,
                jenis_aset: jenis_aset,
                kd_barang: kd_barang
            },
            dataType: "json",
            success: function(data){
                jQuery('#wrap-loading').hide();
                if(data.status == 'success'){
                    jQuery('input[name="post_id_aset"]').val(data.post_id);
                    jQuery('#link_nama_aset').html('<a target="_blank" href="'+data.url+'" class="btn btn-outline-primary">'+data.nm_aset+'</a>');
                }else{
                    jQuery('input[name="post_id_aset"]').val('');
                    jQuery('#link_nama_aset').html('<?php echo $aset_tidak_ditemukan; ?>');
                    alert(data.message);
                }
            },
            error: function(e) {
                console.log(e);
            }
        });
    });
</script>