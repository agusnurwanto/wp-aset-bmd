<?php
global $wpdb;
$nama_pemda = get_option('_crb_bmd_nama_pemda');
$tahun_anggaran = get_option('_crb_bmd_tahun_anggaran');
$api_key = get_option( '_crb_apikey_simda_bmd' );
$body = '';

$args = array(
   'meta_key' => 'meta_aset_perlu_tindak_lanjut',
   'meta_query' => array(
       array(
           'key' => 'meta_aset_perlu_tindak_lanjut',
           'value' => '1',
           'compare' => '=',
       )
   )
);
$query = new WP_Query($args);
$no = 0;
$data_aset = array();
foreach($query->posts as $post){
    $nilai_aset = get_post_meta($post->ID, 'meta_nilai_aset', true);
    $nama_aset = get_post_meta($post->ID, 'meta_nama_aset', true);
    $alamat_aset = get_post_meta($post->ID, 'meta_alamat_aset', true);
    $params = shortcode_parse_atts(str_replace('[detail_aset', '', str_replace(']', '', $post->post_content)));
    $kd_lokasi = explode('.', $params['kd_lokasi']);
    $Kd_Prov = (int) $kd_lokasi[1];
    $Kd_Kab_Kota = (int) $kd_lokasi[2];
    $Kd_Bidang = (int) $kd_lokasi[3];
    $Kd_Unit = (int) $kd_lokasi[4];
    $Kd_Sub = (int) $kd_lokasi[5];
    $Kd_UPB = (int) $kd_lokasi[6];
    $Kd_Kecamatan = (int) $kd_lokasi[7];
    $Kd_Desa = (int) $kd_lokasi[8];

    $kd_barang = explode('.', $params['kd_barang']);
    $Kd_Aset8 = (int) $kd_barang[0];
    $Kd_Aset80 = (int) $kd_barang[1];
    $Kd_Aset81 = (int) $kd_barang[2];
    $Kd_Aset82 = (int) $kd_barang[3];
    $Kd_Aset83 = (int) $kd_barang[4];
    $Kd_Aset84 = (int) $kd_barang[5];
    $Kd_Aset85 = (int) $kd_barang[6];
    $No_Reg8 = (int) $params['kd_register'];

    $sql = "
        SELECT 
            u.Nm_UPB, 
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
        where u.Kd_Prov = $Kd_Prov
        AND u.Kd_Kab_Kota = $Kd_Kab_Kota 
        AND u.Kd_Bidang = $Kd_Bidang 
        AND u.Kd_Unit = $Kd_Unit 
        AND u.Kd_Sub = $Kd_Sub 
        AND u.Kd_UPB = $Kd_UPB
        AND (
            u.Kd_Kecamatan = $Kd_Kecamatan
            OR u.Kd_Kecamatan is null
        ) 
        AND (
            u.Kd_Desa = $Kd_Desa
            OR u.Kd_Desa is null
        )
    ";
    $nama_skpd = $this->functions->CurlSimda(array(
        'query' => $sql,
        'no_debug' => 0
    ));
    $params['nama_skpd'] = $nama_skpd[0]->Nm_UPB;
    if(!empty($Kd_Kecamatan)){
        $sql = "
            SELECT 
                k.Nm_Kecamatan
            from Ref_Kecamatan k 
            where k.Kd_Prov = $Kd_Prov
            AND k.Kd_Kab_Kota = $Kd_Kab_Kota 
            AND k.Kd_Kecamatan = $Kd_Kecamatan
        ";
        $kecamatan = $this->functions->CurlSimda(array(
            'query' => $sql,
            'no_debug' => 0
        ));
        $params['kecamatan'] = $kecamatan[0]->Nm_Kecamatan;
    }else{
        $params['kecamatan'] = '';
    }
    if(!empty($Kd_Kecamatan) && !empty($Kd_Desa)){
        $sql = "
            SELECT 
                d.Nm_Desa
            from Ref_Desa d 
            where d.Kd_Prov = $Kd_Prov
            AND d.Kd_Kab_Kota = $Kd_Kab_Kota 
            AND d.Kd_Kecamatan = $Kd_Kecamatan
            AND d.Kd_Desa = $Kd_Desa
        ";
        $desa = $this->functions->CurlSimda(array(
            'query' => $sql,
            'no_debug' => 0
        ));
        $params['desa'] = $desa[0]->Nm_Desa;
    }else{
        $params['kecamatan'] = '';
        $params['desa'] = '';
    }
    $data_jenis = $this->get_nama_jenis_aset(array('jenis_aset' => $params['jenis_aset']));
    $nama_jenis_aset = $data_jenis['nama'];
    $table_simda = $data_jenis['table_simda'];

    $warna_map = '';
    $ikon_map = '';
    if ($params['jenis_aset'] == 'tanah') {
        $warna_map = get_option('_crb_warna_tanah');
        $ikon_map  = get_option('_crb_icon_tanah');
    }

    if ($params['jenis_aset'] == 'bangunan') {
        $warna_map = get_option('_crb_warna_gedung');
        $ikon_map  = get_option('_crb_icon_gedung');
    }

    if ($params['jenis_aset'] == 'jalan') {
        $warna_map = get_option('_crb_warna_jalan');
        $ikon_map  = get_option('_crb_icon_jalan');
    }
    $koordinatX = get_post_meta($post->ID, 'latitude', true);
    if(empty($koordinatX)){
        $koordinatX = '0';
    }
    $koordinatY = get_post_meta($post->ID, 'longitude', true);
    if(empty($koordinatY)){
        $koordinatY = '0';
    }

    $alamat = array();
    if(!empty($params['kecamatan'])){
        $alamat[] = 'Kec. '.$params['kecamatan'];
    }
    if(!empty($params['desa'])){
        $alamat[] = 'Desa/Kel. '.$params['desa'];
    }
    if(!empty($alamat)){
        $alamat = '('.implode(', ', $alamat).')';
    }else{
        $alamat = '';
    }

    $where = '';
    if(!empty($Kd_Kecamatan)){
        $where .= $wpdb->prepare(' AND a.Kd_Kecamatan=%d', $Kd_Kecamatan);
    }
    if(!empty($Kd_Desa)){
        $where .= $wpdb->prepare(' AND a.Kd_Desa=%d', $Kd_Desa);
    }

    $sql = $wpdb->prepare('
        select 
            a.*,
            b.Harga as harga_asli,
            r.Nm_Aset5
        from '.$data_jenis['table_simda'].' a
        INNER JOIN '.$data_jenis['table_simda_harga'].' b ON b.IDPemda = a.IDPemda 
        LEFT JOIN Ref_Rek5_108 r on r.kd_aset=a.Kd_Aset8 
            and r.kd_aset0=a.Kd_Aset80 
            and r.kd_aset1=a.Kd_Aset81 
            and r.kd_aset2=a.Kd_Aset82 
            and r.kd_aset3=a.Kd_Aset83 
            and r.kd_aset4=a.Kd_Aset84 
            and r.kd_aset5=a.Kd_Aset85
        where a.Kd_Prov=%d
            AND a.Kd_Kab_Kota=%d 
            AND a.Kd_Bidang=%d 
            AND a.Kd_Unit=%d 
            AND a.Kd_Sub=%d 
            AND a.Kd_UPB=%d
            AND a.No_Reg8=%d
            '.$where.'
        ', $Kd_Prov, $Kd_Kab_Kota, $Kd_Bidang, $Kd_Unit, $Kd_Sub, $Kd_UPB, $No_Reg8);
    $aset = $this->functions->CurlSimda(array(
        'query' => $sql 
    ));
    $nilai_aset = $aset[0]->harga_asli;
    $no++;
    $kd_register = $this->functions->CekNull($aset[0]->No_Reg8, 6);
    $kd_lokasi = '12.'.$this->functions->CekNull($aset[0]->Kd_Prov).'.'.$this->functions->CekNull($aset[0]->Kd_Kab_Kota).'.'.$this->functions->CekNull($aset[0]->Kd_Bidang).'.'.$this->functions->CekNull($aset[0]->Kd_Unit).'.'.$this->functions->CekNull($aset[0]->Kd_Sub).'.'.$this->functions->CekNull($aset[0]->Kd_UPB).'.'.$this->functions->CekNull($aset[0]->Kd_Kecamatan).'.'.$this->functions->CekNull($aset[0]->Kd_Desa);
    $kd_barang = $aset[0]->Kd_Aset8.'.'.$aset[0]->Kd_Aset80.'.'.$this->functions->CekNull($aset[0]->Kd_Aset81).'.'.$this->functions->CekNull($aset[0]->Kd_Aset82).'.'.$this->functions->CekNull($aset[0]->Kd_Aset83).'.'.$this->functions->CekNull($aset[0]->Kd_Aset84).'.'.$this->functions->CekNull($aset[0]->Kd_Aset85, 3);
    $link = $this->functions->generatePage(array(
        'nama_page' => $params['jenis_aset'].' '.$kd_lokasi.' '.$kd_barang.' '.$kd_register,
        'content' => '[detail_aset kd_lokasi="'.$kd_lokasi.'" kd_barang="'.$kd_barang.'" kd_register="'.$kd_register.'" jenis_aset="'.$params['jenis_aset'].'"]',
        'post_status' => 'private',
        'post_type' => 'post',
        'show_header' => 1,
        'no_key' => 1
    ));
    $keterangan = array($aset[0]->Keterangan);
    if($params['jenis_aset'] == 'mesin'){
        $keterangan = array();
        if(!empty($aset[0]->Nomor_Polisi)){
            $keterangan[] = $aset[0]->Nomor_Polisi;
        }
        if(!empty($aset[0]->Merk)){
            $keterangan[] = $aset[0]->Merk;
        }
        if(!empty($aset[0]->Type)){
            $keterangan[] = $aset[0]->Type;
        }
        if(!empty($aset[0]->CC)){
            $keterangan[] = $aset[0]->CC;
        }
        if(!empty($aset[0]->Keterangan)){
            $keterangan[] = $aset[0]->Keterangan;
        }
    }
    $polygon = get_post_meta($post->ID, 'polygon', true);
    $keterangan_tindak_lanjut = get_post_meta($post->ID, 'meta_keterangan_aset_perlu_tindak_lanjut', true);

    $body .= '
        <tr>
            <td class="text-center">'.$params['kd_barang'].'.'.$params['kd_register'].'</td>
            <td>'.$aset[0]->Nm_Aset5.'</td>
            <td>'.implode(' | ', $keterangan).'</td>
            <td>'.$keterangan_tindak_lanjut.'</td>
            <td class="text-right" data-sort="'.$nilai_aset.'">'.number_format($nilai_aset,2,",",".").'</td>
            <td class="text-center"><a target="_blank" href="'.$link['url'].'" class="btn btn-primary">Detail</a></td>
        </tr>
    ';

    if(empty($polygon)){
        continue;
    }
    $data_aset[] = array(
        'aset' => $aset[0],
        'lng' => $koordinatX,
        'ltd' => $koordinatY,
        'polygon' => $polygon,
        'nilai_aset' => number_format($nilai_aset,2,",","."),
        'nama_aset' => $nama_aset,
        'alamat_aset' => $alamat_aset,
        'nama_skpd' => $params['nama_skpd'].' '.$alamat,
        'kd_barang' => $params['kd_barang'],
        'kd_lokasi' => $params['kd_lokasi'],
        'warna_map' => $warna_map,
        'ikon_map'  => $ikon_map,
    );
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
        <h2 class="text-center">Data Aset Yang Perlu Tindak Lanjut<br><?php echo $nama_pemda; ?><br>Tahun <?php echo $tahun_anggaran; ?></h2>
        <table class="table table-bordered" id="data_aset_aset">
            <thead>
                <tr>
                    <th class="text-center">Kode Barang</th>
                    <th class="text-center">Nama Aset</th>
                    <th class="text-center">Keterangan Aset</th>
                    <th class="text-center">Keterangan Tidak Lanjut</th>
                    <th class="text-center">Nilai Aset (Rp)</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody id="data_body">
                <?php echo $body; ?>
            </tbody>
            <tfoot>
                <th colspan="4" class="text-center">Total Nilai</th>
                <th class="text-right" id="total_aset">0</th>
                <th></th>
            <tfoot>
        </table>
    </div>
</div>
<script type="text/javascript">

jQuery(document).on('ready', function(){
    jQuery('#data_aset_aset').dataTable({
        columnDefs: [
            { "width": "300px", "targets": 2 },
            { "width": "300px", "targets": 3 }
        ],
        lengthMenu: [[20, 50, 100, -1], [20, 50, 100, "All"]],
        footerCallback: function ( row, data, start, end, display ) {
            var api = this.api();
            var total_page = api.column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return a + to_number(b);
                }, 0 );
            jQuery('#total_aset').text(formatRupiah(total_page));
        }
    });
});

</script>