<?php
	$nama_pemda = get_option('_crb_bmd_nama_pemda');
	$tahun_anggaran = get_option('_crb_bmd_tahun_anggaran');
	$api_key = get_option( '_crb_apikey_simda_bmd' );
	$data_jenis = $this->get_nama_jenis_aset(array('jenis_aset' => $params['key']['jenis_aset']));
	$api_googlemap = get_option( '_crb_google_api' );
	$api_googlemap = "https://maps.googleapis.com/maps/api/js?key=$api_googlemap&callback=initMap&libraries=places";
	$warna_map = get_option('_crb_warna_tanah');
	$ikon_map  = get_option('_crb_icon_tanah');
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
		$list_upb .= '<option value="'.$kd_upb.'">'.$kd_upb.'-'.$nama_upb.$alamat.'</option>';
	}
	$_POST['api_key'] = $api_key;
	$_POST['tipe'] = 'rek_0';
	$_POST['selected'] = '1.3';
	$rek_0_ret = $this->get_rek_barang(true);
	$rek_0 = $rek_0_ret['html'];
	$_POST['tipe'] = 'rek_1';
	$_POST['selected'] = '1.3.1';
	$rek_1_ret = $this->get_rek_barang(true);
	$rek_1 = $rek_1_ret['html'];
	$_POST['tipe'] = 'rek_2';
	$_POST['selected'] = '1.3.1.1';
	$rek_2_ret = $this->get_rek_barang(true);
	$rek_2 = $rek_2_ret['html'];
	$_POST['tipe'] = 'rek_3';
	$_POST['selected'] = '1.3.1.1';
	$rek_3_ret = $this->get_rek_barang(true);
	$rek_3 = $rek_3_ret['html'];
	$rek_4 = '<option value="">Pilih Rekening Aset 4</option>';
	$rek_5 = '<option value="">Pilih Rekening Aset 5</option>';
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
        <h2 class="text-center">Tambah Data Barang Milik Daerah<br><?php echo $data_jenis['nama']; ?></h2>
        <form>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Pilih Unit Pengelola Barang</label>
                <div class="col-md-10">
                    <select class="form-control select2" id="pilih_upb"><?php echo $list_upb; ?></select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Kode UPB</label>
                <div class="col-md-4">
                    <input type="text" disabled class="form-control" name="kode_upb" value="">
                </div>
                <label class="col-md-2 col-form-label">Nama Unit Pengelola Barang</label>
                <div class="col-md-4">
                    <input type="text" disabled class="form-control" name="nama_upb" value="">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-md-2 col-form-label">Kecamatan</label>
                <div class="col-md-4">
                    <input type="text" disabled class="form-control" name="kecamatan" value="">
                </div>
                <label class="col-md-2 col-form-label">Desa / Kelurahan</label>
                <div class="col-md-4">
                    <input type="text" disabled class="form-control" name="desa" value="">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4">
                    <select class="form-control select2 rek_aset" id="rek_0"><?php echo $rek_0; ?></select>
                </div>
                <div class="col-md-4">
                    <select class="form-control select2 rek_aset" id="rek_1"><?php echo $rek_1; ?></select>
                </div>
                <div class="col-md-4">
                    <select class="form-control select2 rek_aset" id="rek_2"><?php echo $rek_2; ?></select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4">
                    <select class="form-control select2 rek_aset" id="rek_3"><?php echo $rek_3; ?></select>
                </div>
                <div class="col-md-4">
                    <select class="form-control select2 rek_aset" id="rek_4"><?php echo $rek_4; ?></select>
                </div>
                <div class="col-md-4">
                    <select class="form-control select2 rek_aset" id="rek_5"><?php echo $rek_5; ?></select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Kode Barang</label>
                <div class="col-md-4">
                    <input type="text" disabled class="form-control" name="kd_barang" value="">
                </div>
                <label class="col-md-2 col-form-label">Nomor Register</label>
                <div class="col-md-4">
                    <input type="text" disabled class="form-control" name="kd_register" value="" placeholder="Akan diisi otomatis oleh sistem!">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Nama Aset</label>
                <div class="col-md-10">
                    <input type="text" disabled class="form-control" name="nama_aset" value="">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Penggunaan</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="penggunaan" value="">
                </div>
                <label class="col-md-2 col-form-label">Luas (M2)</label>
                <div class="col-md-4">
                    <input type="text"  class="form-control" name="luas" value="">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Letak / Alamat</label>
                <div class="col-md-10">
                    <input type="text"  class="form-control" name="alamat" value="">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Tahun Pengadaan</label>
                <div class="col-md-4">
                    <input type="date"  class="form-control" name="tgl_pengadaan" value="">
                </div>
                <label class="col-md-2 col-form-label">Hak</label>
                <div class="col-md-4">
                    <input type="text"  class="form-control" name="hak" value="">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Tanggal Sertifikat</label>
                <div class="col-md-4">
                    <input type="date"  class="form-control" name="tgl_sertifikat" value="">
                </div>
                <label class="col-md-2 col-form-label">Nomor Sertifikat</label>
                <div class="col-md-4">
                    <input type="number"  class="form-control" name="nomor_sertifikat" value="">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Asal Usul</label>
                <div class="col-md-4">
                    <input type="text"  class="form-control" name="asal_usul" value="">
                </div>
                <label class="col-md-2 col-form-label">Harga (Rp)</label>
                <div class="col-md-4">
                    <input type="text"  class="form-control" name="harga" value="">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Keterangan</label>
                <div class="col-md-10">
                    <textarea  class="form-control" name="keterangan"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Koordinat Latitude</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="latitude" value="" placeholder="-7.7524434396470605">
                </div>
                <label class="col-md-2 col-form-label">Koordinat Longitude</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="longitude" value="" placeholder="111.51809306769144">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Polygon / Shape</label>
                <div class="col-md-10">
                    <textarea class="form-control" name="polygon" placeholder="[{lat: -7.751975, lng: 111.517829},{lat: -7.752092, lng: 111.518424},{lat: -7.752815, lng: 111.518344},{lat: -7.752661, lng: 111.5177}]"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2">Map</label>
                <div class="col-md-10">
                	<div style="height:600px; width: 100%;" id="map-canvas"></div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Sejarah</label>
                <div class="col-md-10">
                    <textarea class="form-control" name="sejarah"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Kronologi</label>
                <div class="col-md-10">
                <?php 
                    wp_editor('','kronologi',array('textarea_name' => 'kronologi', 'textarea_rows' => 20));
                ?>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Foto</label>
                <div class="col-md-10">
                <?php 
                    wp_editor('','foto',array('textarea_name' => 'foto', 'textarea_rows' => 10));
                ?>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Video</label>
                <div class="col-md-10">
                <?php 
                    wp_editor('','video',array('textarea_name' => 'video', 'textarea_rows' => 10));
                ?>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Disewakan / Tidak</label>
                <div class="col-md-4">
                    <label><input type="radio" name="disewakan" value="1"> Disewakan</label>
                    <label style="margin-left: 15px;"><input type="radio" name="disewakan" value="2"> Tidak Disewakan</label>
                </div>
                <label class="col-md-2 col-form-label">Nilai Sewa</label>
                <div class="col-md-4">
                    <input type="number" class="form-control" name="nilai_sewa" value="">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Keterangan Potensi Penggunaan</label>
                <div class="col-md-10">
                    <textarea class="form-control" name="ket_potensi_penggunaan"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Nama Penyewa</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="nama_sewa" value="">
                </div>
                <label class="col-md-2 col-form-label">Alamat Penyewa</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="alamat_sewa" value="">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Waktu Awal Sewa</label>
                <div class="col-md-4">
                    <input type="date" class="form-control" name="waktu_sewa_awal" value="">
                </div>
                <label class="col-md-2 col-form-label">Waktu Akhir Sewa</label>
                <div class="col-md-4">
                    <input type="date" class="form-control" name="waktu_sewa_akhir" value="">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Keterangan Penggunaan Aset yang Disewakan</label>
                <div class="col-md-10">
                    <textarea class="form-control" name="ket_penggunaan_aset"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Aset Perlu Tindak Lanjut</label>
                <div class="col-md-10">
                    <label><input type="checkbox" name="aset_perlu_tindak_lanjut" value="1"> Ya / Tidak</label>
                    <textarea class="form-control" name="ket_aset_perlu_tindak_lanjut"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Status informasi aset</label>
                <div class="col-md-10">
                    <label><input type="radio" name="status_informasi" value="1"> Privasi / rahasia</label>
                    <label style="margin-left: 15px;"><input type="radio" name="status_informasi" value="2"> Informasi untuk masyarakat umum</label>
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
<script type="text/javascript" src="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/js/select2.min.js"></script>
<script async defer src="<?php echo $api_googlemap ?>&libraries=drawing"></script>
<script type="text/javascript">
	window.upb = <?php echo json_encode($new_upbs); ?>;
	jQuery(document).ready(function(){
		jQuery('.select2').select2();
		jQuery('#pilih_upb').on('change', function(){
			var kd_upb = jQuery(this).val();
			jQuery('input[name="kode_upb"]').val(upb[kd_upb].kd_upb);
			jQuery('input[name="nama_upb"]').val(upb[kd_upb].Nm_UPB);
			jQuery('input[name="kecamatan"]').val(upb[kd_upb].Nm_Kecamatan);
			jQuery('input[name="desa"]').val(upb[kd_upb].Nm_Desa);
		});
		jQuery('.rek_aset').on('change', function(){
			var id = jQuery(this).attr('id');
			var kd_barang = jQuery(this).val();
			var val = jQuery(this).find('option:selected').text().split(' ');
			var nama_aset = '';
			if(id == 'rek_5'){
				val.shift();
				nama_aset = val.join(' ');
				jQuery('input[name="kd_barang"]').val(kd_barang);
				jQuery('input[name="nama_aset"]').val(nama_aset);
				return;
			}
			var val_id_rek = +(id.split('rek_')[1]) + 1;
            jQuery('#wrap-loading').show();
            jQuery.ajax({
                url: ajax.url,
                type: "post",
                data: {
                    "action": "get_rek_barang",
                    "api_key": "<?php echo $api_key; ?>",
                    "tipe": 'rek_'+val_id_rek,
                    "selected": kd_barang+'.xx'
                },
                dataType: "json",
                success: function(data){
                	if(data.status == 'error'){
                		return alert(data.message);
                	}
                    jQuery('#wrap-loading').hide();
					if(id == 'rek_0'){
						jQuery('#rek_1').html(data.html);
						jQuery('#rek_2').html('<option value="">Pilih Rekening Aset 2</option>');
						jQuery('#rek_3').html('<option value="">Pilih Rekening Aset 3</option>');
						jQuery('#rek_4').html('<option value="">Pilih Rekening Aset 4</option>');
						jQuery('#rek_5').html('<option value="">Pilih Rekening Aset 5</option>');
					}else if(id == 'rek_1'){
						jQuery('#rek_2').html(data.html);
						jQuery('#rek_3').html('<option value="">Pilih Rekening Aset 3</option>');
						jQuery('#rek_4').html('<option value="">Pilih Rekening Aset 4</option>');
						jQuery('#rek_5').html('<option value="">Pilih Rekening Aset 5</option>');
					}else if(id == 'rek_2'){
						jQuery('#rek_3').html(data.html);
						jQuery('#rek_4').html('<option value="">Pilih Rekening Aset 4</option>');
						jQuery('#rek_5').html('<option value="">Pilih Rekening Aset 5</option>');
					}else if(id == 'rek_3'){
						jQuery('#rek_4').html(data.html);
						jQuery('#rek_5').html('<option value="">Pilih Rekening Aset 5</option>');
					}else if(id == 'rek_4'){
						jQuery('#rek_5').html(data.html);
					}
					jQuery('input[name="kd_barang"]').val(kd_barang);
					jQuery('input[name="nama_aset"]').val(nama_aset);
                },
                error: function(e) {
                    console.log(e);
                    return alert('Error, harap hubungi admin!');
                }
            });
		});
	});

	function simpan_aset(){
        if(confirm("Apakah anda yakin untuk menyimpan data ini. Data lama akan diupdate sesuai perubahan terbaru!")){
            jQuery('#wrap-loading').show();
            jQuery.ajax({
                url: ajax.url,
                type: "post",
                data: {
                    "action": "simpan_aset_belum_masuk_neraca",
                    "api_key": "<?php echo $api_key; ?>",
                    "jenis_aset": "<?php echo $data_jenis['jenis']; ?>",
                    "kd_upb": jQuery('#pilih_upb').val(),
                    "kd_barang": jQuery('input[name="kd_barang"]').val(),
                    "penggunaan": jQuery('input[name="penggunaan"]').val(),
                    "luas": jQuery('input[name="luas"]').val(),
                    "alamat": jQuery('input[name="alamat"]').val(),
                    "tgl_pengadaan": jQuery('input[name="tgl_pengadaan"]').val(),
                    "hak": jQuery('input[name="hak"]').val(),
                    "tgl_sertifikat": jQuery('input[name="tgl_sertifikat"]').val(),
                    "nomor_sertifikat": jQuery('input[name="nomor_sertifikat"]').val(),
                    "asal_usul": jQuery('input[name="asal_usul"]').val(),
                    "harga": jQuery('input[name="harga"]').val(),
                    "keterangan": jQuery('textarea[name="keterangan"]').val(),
                    "sejarah": jQuery('textarea[name="sejarah"]').val(),
                    "kronologi": tinyMCE.get('kronologi').getContent(),
                    "foto": tinyMCE.get('foto').getContent(),
                    "video": tinyMCE.get('video').getContent(),
                    "latitude": jQuery('input[name="latitude"]').val(),
                    "longitude": jQuery('input[name="longitude"]').val(),
                    "polygon": jQuery('textarea[name="polygon"]').val(),
                    "disewakan": jQuery('input[name="disewakan"]:checked').val(),
                    "nilai_sewa": jQuery('input[name="nilai_sewa"]').val(),
                    "nama_sewa": jQuery('input[name="nama_sewa"]').val(),
                    "alamat_sewa": jQuery('input[name="alamat_sewa"]').val(),
                    "waktu_sewa_awal": jQuery('input[name="waktu_sewa_awal"]').val(),
                    "waktu_sewa_akhir": jQuery('input[name="waktu_sewa_akhir"]').val(),
                    "status_informasi": jQuery('input[name="status_informasi"]:checked').val(),
                    "aset_perlu_tindak_lanjut": jQuery('input[name="aset_perlu_tindak_lanjut"]:checked').val(),
                    "ket_aset_perlu_tindak_lanjut": jQuery('textarea[name="ket_aset_perlu_tindak_lanjut"]').val(),
                    "ket_penggunaan_aset": jQuery('textarea[name="ket_penggunaan_aset"]').val(),
                    "ket_potensi_penggunaan": jQuery('textarea[name="ket_potensi_penggunaan"]').val(),

                },
                dataType: "json",
                success: function(data){
                    jQuery('#wrap-loading').hide();
                    return alert(data.message);
                },
                error: function(e) {
                    console.log(e);
                }
            });
        }
    }

    var map;
    var nama_aset;
    var kode_aset;
    var status_aset;
    var luas;
    var alamat;
    var hak_tanah;
    var tgl_sertifikat;
    var no_sertipikat;
    var penggunaan;
    var keterangan;
    var warna_map = "<?php echo $warna_map; ?>";
    var ikon_map = "<?php echo $ikon_map; ?>";
    
    function initMap() {
    	var lokasi_aset = new google.maps.LatLng(0, 0);
        // Setting Map
        var mapOptions = {
            zoom: 18,
            center: lokasi_aset,
            mapTypeId: google.maps.MapTypeId.HYBRID
        };
        // Membuat Map
        map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);

        window.drawingManager = new google.maps.drawing.DrawingManager({
            drawingControl: true,
            drawingControlOptions: {
                position: google.maps.ControlPosition.TOP_CENTER,
                drawingModes: [
                    google.maps.drawing.OverlayType.MARKER,
                    google.maps.drawing.OverlayType.POLYGON
                ],
            },
            markerOptions: {
                icon: ikon_map,
                draggable: true
            },
            polygonOptions: {
                strokeColor: warna_map,
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: warna_map,
                fillOpacity: 0.45,
                editable: true,
                draggable: true,
                zIndex: 1
            }
        });
        drawingManager.setMap(map);

        google.maps.event.addListener(drawingManager, 'overlaycomplete', function(event_draw) {
            if(event_draw.type == 'marker'){
            	if(typeof evm != 'undefined'){
               		evm.setMap(null);
               	}
                window.evm = event_draw.overlay;
                google.maps.event.addListener(evm, 'mouseup', function(event) {
                    jQuery('input[name="latitude"]').val(event.latLng.lat());
                    jQuery('input[name="longitude"]').val(event.latLng.lng());
                });
                jQuery('input[name="latitude"]').val(evm.position.lat());
                jQuery('input[name="longitude"]').val(evm.position.lng());
            }else if(event_draw.type == 'polygon'){
            	if(typeof evp != 'undefined'){
                	evp.setMap(null);
                }
                window.evp = event_draw.overlay;
                google.maps.event.addListener(evp, 'mouseup', function(event) {
                    jQuery('textarea[name="polygon"]').val(JSON.stringify(evp.getPath().getArray()));
                });
                jQuery('textarea[name="polygon"]').val(JSON.stringify(evp.getPath().getArray()));
            }
        });

        geocoder = new google.maps.Geocoder();
        geocoder.geocode( { 'address': '<?php echo $nama_pemda; ?>'}, function(results, status) {
            if (status == 'OK') {
                map.setCenter(results[0].geometry.location);
            } else {
                alert('Geocode was not successful for the following reason: ' + status);
            }
        });
    }
</script>