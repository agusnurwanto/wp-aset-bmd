<?php 
$args = array(
    'number'=> '',
    'status'=> 'approve'
);
$body = '';
foreach (get_comments($args) as $comment) {
    $tgl = $comment->comment_date;
    $data_post = get_post($comment->comment_post_ID);
    $url = get_permalink($data_post->ID);
    $detail = '<a href="'.$url.'" target="_blank" class="btn btn-primary"><i class="dashicons dashicons-search"></i></a>';
    $email = $comment->comment_author_email;
    $parts = explode('@', $email);
    $email = substr($parts[0], 0, -10).'xxxxxxxxxx@'.$parts[1];
    $body .= '
        <tr>
            <td class="text-center">'.$tgl.'</td>
            <td class="text-center">'.$email.'</td>
            <td class="text-center">'.$comment->comment_author.'</td>
            <td>'.$comment->comment_content.'</td>
            <td class="text-center">'.$detail.'</td>
        </tr>
    ';
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
        <h2 class="text-center">Tanggapan Publik</h2>
        <table class="table table-bordered" id="data_aset_sewa">
            <thead>
                <tr>
                    <th class="text-center">Tanggal</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">Tanggapan</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody id="data_body">
                <?php echo $body; ?>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
jQuery(document).on('ready', function(){
    jQuery('#data_aset_sewa').dataTable({
        columnDefs: [
            { "width": "110px", "targets": 0 },
            { "width": "150px", "targets": 1 },
            { "width": "150px", "targets": 2 },
            { "width": "35px", "targets": 4 }
        ],
        lengthMenu: [[20, 50, 100, -1], [20, 50, 100, "All"]]
    });
});
</script>