<style>
    .main-div{
        padding: 1rem 5rem 1rem;
    }
    h2.title-page{
        text-align: center;
        margin: 0 0 2rem 0;
    }
</style>
<div class="main-div">
    <h2 class="title-page">Dokumentasi WP ASET BMD</h2>
    <div>
        <p>WP ASET BMD adalah aplikasi yang dikembangkan untuk menampilkan data aset pemerintah kabupaten terkait secara daring. Badan Pengelola Keuangan dan Aset Daerah Kabupaten terkait (BPKAD) selaku dinas yang menangani data aset, saat ini menggunakan aplikasi Sistem Informasi Manajemen Daerah Barang Milik Daerah (SIMDA BMD) berbasis desktop untuk perekaman data aset. Aplikasi WP ASET BMD terintegrasi dengan data aset di SIMDA BMD dan dilengkapi dengan data meta lain seperti lokasi koordinat google map, foto aset, sejarah aset dan lain sebagainya.</p>
        <h3>Ruang Lingkup Penggunaan WP ASET BMD</h3>
        <div>
            <p><strong>WP ASET BMD </strong>adalah aplikasi yang dikembangkan untuk menampilkan data aset pemerintah kabupaten&nbsp;terkait secara daring. Badan Pengelola Keuangan dan Aset Daerah Kabupaten terkait (BPKAD) selaku dinas yang menangani data aset, saat ini menggunakan aplikasi<strong> Sistem Informasi Manajemen Daerah Barang Milik Daerah (SIMDA BMD)</strong> berbasis desktop&nbsp;untuk&nbsp;perekaman data aset. Aplikasi WP ASET BMD <strong>terintegrasi</strong> dengan data aset di SIMDA BMD dan dilengkapi dengan data meta lain seperti lokasi koordinat google map, foto aset, sejarah aset dan lain sebagainya.</p>
            <h2>Ruang Lingkup Penggunaan WP ASET BMD</h2>
            <ul><li>Ruang Lingkup Penggunaan WP ASET BMD  ini di bagi menjadi 3 jenis pengguna yaitu:<ol><li><strong>Reguler User</strong>  (Masyarakat Umum) Bertugas dan mempunyai wewenang dalam hal:<ul><li>melihat data aset dari WP ASET BMD</li><li>Melakukan penyewaan aset</li></ul></li><li><strong>Executive User</strong>  (Pengguna SKPD) Bertugas dan mempunyai wewenang dalam hal:<ul><li>dapat menambahkan data aset sewa</li><li>dapat menambahkan data kelengkapan aset seperti foto dan lain lain</li></ul></li><li><strong>Administator</strong> Bertugas dan mempunyai wewenang dalam hal:<ul><li>Pengelolaan data referensi </li><li>Pengelolaan user dan hak akses</li></ul></li></ol></li></ul>
            <h2>Pengenalan WP ASET BMD</h2>
            <h3>1. Halaman Homepage WP ASET BMD</h3>
            <div>
                <figure class="aligncenter">
                    <img loading="lazy" src="<?php echo BMD_PLUGIN_URL.'public/images/dokumentasi/1.homepage.png'?>" alt="" width="910" height="416">
                    <figcaption>Tampilan menu WP ASET BMD untuk user umum yang belum masuk ke dalam aplikasi</figcaption>
                </figure>
            </div>
            <ul>
                <li>Penjelasan menu untuk user yang belum masuk ke sistem :
                    <ul>
                        <li><strong>Nama Situs dan Tagline WP ASET BMD</strong> : Menampilkan nama aplikasi dan pintasan menuju halaman utama.</li>
                        <li><strong>Login </strong>: Menu ini akan muncul untuk user yang belum login. Pintasan menuju ke halaman masuk bagi admin dan user perangkat daerah.</li>
                        <li><strong>Petunuk penggunaan</strong> : Halaman petunjuk penggunaan aplikasi.</li>
                        <li><strong>Dokumentasi</strong> : Halaman dokumentasi WP ASET BMD.</li>
                    </ul>
                </li>
            </ul>
            <div>
                <figure class="aligncenter ">
                    <img loading="lazy" width="1024" height="333" src="<?php echo BMD_PLUGIN_URL.'public/images/dokumentasi/2.menu-page-2.png'?>" alt="">
                    <figcaption>Tampilan menu WP ASET BMD saat user sudah masuk ke aplikasi</figcaption>
                </figure>
            </div>
            <ul>
                <li>Penjelasan menu aplikasi ketika user sudah masuk ke sistem :
                    <ul>
                        <li><strong>Logout </strong>: Menu ini akan muncul untuk user yang sudah login. Pintasan untuk keluar dari sistem.</li>
                        <li><strong>User </strong>: Pintasan menuju halaman dasboard user perangkat daerah.</li>
                    </ul>
                </li>
            </ul>
            <h3>2. Halaman Aset Perjenis</h3>
            <div>
                <figure class="aligncenter ">
                    <img loading="lazy" width="1024" height="469" src="<?php echo BMD_PLUGIN_URL.'public/images/dokumentasi/3.per-jenis-aset.png'?>" alt="">
                        <figcaption>Halaman utama, tampilan total aset per jenis aset</figcaption>
                </figure>
            </div>
            <ul>
                <li>Penjelasan kolom tabel data aset per jenis aset :
                    <ul>
                        <li><strong>Jenis Aset</strong> : Beberapa Jenis aset yang di miliki tiap daerah.</li>
                        <li><strong>Jumlah Aset</strong> : Jumlah keseluruhan isi aset.</li>
                        <li><strong>Satuan</strong> : Jenis barang dalam bentuk satuan.</li>
                        <li><strong>Nilai Total Satuan Harga</strong> : Nilai harga dari keseluruhan aset.</li>
                        <li><strong>Aksi</strong> : Berisi tombol Detail untuk pintasan menuju halaman data aset per Unit Pengelola Barang (UPB) sesuai jenis aset yang dipilih.</li>
                    </ul>
                </li>
            </ul>
            <div>
                <figure class="aligncenter ">
                    <img loading="lazy" width="1024" height="469" src="<?php echo BMD_PLUGIN_URL.'public/images/dokumentasi/4.per-jenis-skpd.png'?>" alt="">
                        <figcaption>Halman utama, tabel total nilai aset per perangkat daerah</figcaption>
                </figure>
            </div>
            <ul>
                <li>Penjelasan kolom tabel data aset per jenis aset :
                    <ul>
                        <li><strong>No </strong>: Nomor urut untuk mempermudah identifikasi.</li>
                        <li><strong>Kode Unit</strong>:&nbsp;Kode unit perangkat daerah.</li>
                        <li><strong>Nama Unit</strong> : Nama unit kerja perangkat daerah.</li>
                        <li><strong>Nilai Unit</strong> : Nilai harga dari keseluruhan aset pada unit kerja yang bersangkutan dengan satuan rupiah. Total nilai akan ditampilkan secara bertahap untuk meringankan beban server karena harus meload banyak data.</li>
                        <li><strong>Aksi </strong>: Berisi tombol Detail untuk pintasan menuju halaman data aset per Unit Pengelola Barang (UPB).</li>
                    </ul>
                </li>
            </ul>
            <h3>3. Halaman Detail Total Aset Per Unit Pengelola Barang</h3>
            <div>
                <figure class="aligncenter ">
                    <img loading="lazy" width="1024" height="469" src="<?php echo BMD_PLUGIN_URL.'public/images/dokumentasi/5.halaman-per-jenis-upb.png'?>" alt="">
                    <figcaption>Halaman total aset per unit pengelola barang (UPB)</figcaption>
                </figure>
            </div>
            <ul style="font-size:16px">
                <li>Penjelasan kolom tabel total nilai aset per UPB :
                    <ul>
                        <li><strong>Jenis Aset</strong> : Keterangan jenis aset</li>
                        <li><strong>Kode Lokasi</strong> : kode lokasi adalah kode UPB atau biasa di sebut Unit Pengelola Barang</li>
                        <li><strong>Nama Sub Unit</strong> : Nama sub unit biasanya di dalam satu sub unit bisa berisi beberapa UPB</li>
                        <li><strong>Nama UPB</strong> : Nama unit pengelola barang dari UPB biasa berisi pengajuan pengusulan pengurus barang dari setiap instansi</li>
                        <li><strong>Jumlah</strong> : Jumlah satuan dari setiap unit yang di butuhkan</li>
                        <li><strong>Nilai Rupiah/Harga</strong> : Total nilai aset dari UPB</li>
                        <li><strong>Aksi </strong>: Berisi tombol Detail untuk pintasan menuju halaman daftar aset yang dimiliki oleh unit pengelola barang (UPB).</li>
                    </ul>
                </li>
            </ul>
            <h3>4. Halaman Daftar Aset Per UPB</h3>
            <div>
                <figure class="aligncenter ">
                    <img loading="lazy" width="1024" height="469" src="<?php echo BMD_PLUGIN_URL.'public/images/dokumentasi/6.halaman-aset-per-jenis-upb.png'?>" alt="">
                    <figcaption>Halaman daftar aset per UPB</figcaption>
                </figure>
            </div>
            <ul>
                <li>Penjelasan kolom pada tabel data aset per UPB :
                    <ul>
                        <li><strong>Kode barang</strong> : Kode barang sesuai Permendagri nomor 108 tahun 2016</li>
                        <li><strong>Register</strong> : Nomor register aset sesuai data di SIMDA BMD</li>
                        <li><strong>Nama Aset</strong> : Nama aset sesuai Permendagri nomor 108 tahun 2016</li>
                        <li><strong>Keterangan aset</strong> : Keterangan aset yang di miliki.</li>
                        <li><strong>Nilai Rupiah/Harga</strong> : Nilai harga satuan aset.</li>
                        <li><strong>Aksi</strong> : Berisi tombol Detail untuk pintasan menuju halaman informasi detail aset.</li>
                    </ul>
                </li>
            </ul>
            <h3>5. Halaman Informasi Detail Aset</h3>
            <div>
                <figure class="aligncenter  ">
                    <img loading="lazy" src="<?php echo BMD_PLUGIN_URL.'public/images/dokumentasi/1.SIMATA-–-Sistem-Informasi-Manajemen-Data-Aset-768x351.png'?>" alt="" width="731" height="1143">
                </figure>
                </div>
            <h3>6. Halaman Sewa Aset </h3>
            <div>
                <figure class="aligncenter ">
                    <img loading="lazy" width="1024" height="932" src="<?php echo BMD_PLUGIN_URL.'public/images/dokumentasi/8.halaman-aset-disewakan.png'?>" alt="">
                </figure>
            </div>
            <ul>
                <li>Penjelasan kolom table aset yang disewakan :
                    <ul>
                        <li><strong>No </strong>: Nomor urut untuk mempermudah identifikasi</li>
                        <li><strong>Kode Barang </strong>: Kode barang sesuai Permendagri nomor 108 tahun 2016</li>
                        <li><strong>Register </strong> :Nomor register aset sewa sesuai data di SIMDA BMD</li>
                        <li><strong>Keterangan </strong>:Keterangan aset sewa yang di miliki.</li>
                        <li><strong>Nilai Aset</strong> : Nilai harga aset.</li>
                        <li><strong>Nilai Sewa</strong> : Nilai harga sewa.</li>
                        <li><strong>Tombol Maps</strong> : otomatis mengarahkan ke lokasi tempat penyewaan aset</li>
                        <li><strong>Tombol Detail </strong>: Detail halaman sewa berisi informasi lengkap aset sewa seperti kode lokasi, kode barang, nama aset dan lain lain.</li>
                    </ul>
                </li>
            </ul>
            <h3>7.&nbsp;Halaman Login Wp Aset BMD</h3>
            <div>
                <figure class="aligncenter">
                    <img loading="lazy" width="1024" height="932" src="<?php echo BMD_PLUGIN_URL.'public/images/dokumentasi/halaman-login.png'?>" alt="">
                </figure>
            </div>
            <ul>
                <li>Penjelasan halaman Login WP ASET BMD: 
                    <ul>
                        <li><strong>Username </strong>: Berisi email yang sudah di konfirmasi oleh admin</li>
                        <li><strong>Password</strong> : Berisi beberapa kombinasi angka dan huruf</li>
                    </ul>
                </li>
            </ul>
            <h3>8. Halaman Edit Detail Aset dan Sewa Aset </h3>
            <div>
                <figure class="aligncenter  ">
                    <img loading="lazy" src="<?php echo BMD_PLUGIN_URL.'public/images/dokumentasi/1.SIMATA-–-Sistem-Informasi-Manajemen-Data-Aset-768x351.png'?>" alt="" width="583" height="1415">
                </figure>
            </div>
            <ul>
                <li>Penjelasan informasi data meta yang bisa diedit :
                    <ul>
                        <li><strong>Maps</strong> : Lokasi aset berdasarkan koordinat google maps.</li>
                        <li><strong>Sejarah</strong> : Sejarah dari aset mulai diperoleh sampai kondisi saat ini.</li>
                        <li><strong>Photo</strong> : Foto aset dokumentasi.</li>
                        <li><strong>Video</strong> : Video dokumentasi aset agar mempermudah melihat kondisi aset.</li>
                        <li><strong>Disewakan / Tidak</strong> : Aset yang disewakan akan muncul pada halaman sewa aset.</li>
                        <li><strong>Status Informasi Aset</strong> : Nilai awal status aset adalah privasi atau rahasia. Untuk melihat aset yang rahasia user harus masuk ke aplikasi. Jika status aset dibuat sebagai informasi untuk masyarakat umum maka semua user bisa melihat informasi detail tentang aset.</li>
                    </ul>
                </li>
            </ul>
            <h3>9. Halaman Setting WP ASET BMD</h3>
            <div>
                <figure class="aligncenter ">
                    <img loading="lazy" width="702" height="1024" src="<?php echo BMD_PLUGIN_URL.'public/images/dokumentasi/1.SIMATA-–-Sistem-Informasi-Manajemen-Data-Aset-768x351.png'?>" alt="">
                    <figcaption>Halaman setting WP ASET BMD oleh user administrator</figcaption>
                </figure>
            </div>
            <ul>
                <li>Halaman setting bisa dikses pada dashboard user administrator di menu <strong>Aset BMD</strong>.</li>
                <li>Penjelasan informasi halaman setting :
                    <ul>
                        <li>Status koneksi ke database SIMDA BMD. Berwarna hijau menandakan sudah tekoneksi dan warna merah menandakan berlum terkoneksi.</li>
                        <li><strong>URL API SIMDA</strong> : adalah url untuk koneksi ke API database SIMDA BMD menggunakan <a href="https://github.com/agusnurwanto/SIMDA-API-PHP">https://github.com/agusnurwanto/SIMDA-API-PHP</a></li>
                        <li><strong>APIKEY SIMDA</strong> : adalah kode kunci pengaman koneksi antara WP ASET BMD dengan SIMDA API PHP</li>
                        <li><strong>Database SIMDA</strong> : nama database SQL Server yang digunakan oleh SIMDA BMD</li>
                        <li><strong>Nama Pemerintah Daerah</strong> sampai <strong>Jabatan Kepala Umum</strong> : berisi data umum yang diambil dari database SIMDA BMD. Data bisa disesuaikan jika jika diperlukan.</li>
                        <li><strong>Tombol Generate User</strong> : berfungsi untuk membuat user unit, sub unit dan UPB secara otomatis menggunakan data dari SIMDA BMD.</li>
                        <li><strong>Upload File Excel</strong> sampai <strong>Import Excel Custom Username Sub Unit</strong> : berfungsi untuk membuat user sub unit dengan custom username.</li>
                    </ul>
                </li></ul>
            <h2>Mengenal beberapa tampilan fitur di halaman setting Beranda</h2>
            <h3>10. Tampilan Halaman Setting Background WP ASET BMD</h3>
            <div>
                <figure class="aligncenter ">
                    <img loading="lazy" width="1024" height="909" src="<?php echo BMD_PLUGIN_URL.'public/images/dokumentasi/1.SIMATA-–-Sistem-Informasi-Manajemen-Data-Aset-768x351.png'?>" alt="">
                    <figcaption>Tampilan halaman setting background simata</figcaption>
                </figure>
            </div>
                <ul>
                    <li>Penjelasan informasi halaman setting <strong>Background</strong> :
                        <ul>
                            <li><strong>Background Header</strong> berfungsi untuk mengganti/memasang tampilan latar belakang header utama </li>
                            <li><strong>Background Fitur</strong> berfungsi untuk mengganti/memasang tampilan latar belakang fitur </li>
                            <li><strong>Background Pertinjau</strong> berfungsi untuk mengganti/memasang tampilan latar belakang pertinjau</li><li><strong>Background Video</strong> berfungsi untuk mengganti/memasang tampilan latar belakang video</li>
                        </ul>
                    </li>
                </ul>
                <h3>11. Tampilan Halaman Setting Logo &amp; Menu WP ASET BMD</h3>
            <div>
                <figure class="aligncenter ">
                    <img loading="lazy" width="1024" height="518" src="<?php echo BMD_PLUGIN_URL.'public/images/dokumentasi/1.SIMATA-–-Sistem-Informasi-Manajemen-Data-Aset-768x351.png'?>" alt="">
                    <figcaption>Tampilan Halaman setting Logo &amp; Menu WP ASET BMD</figcaption>
                </figure>
            </div>
            <ul>
                <li>Penjelasan informasi halaman setting <strong>Logo &amp; Menu</strong> :
                    <ul>
                        <li><strong>Gambar Logo</strong> berfungsi untuk memasang logo utama di pojok kiri atas di tampilan beranda WP ASET BMD</li>
                        <li><strong>Gambar Loading</strong> berfungsi untuk menampilkan gambar atau logo pada saat halaman sedang melakukan loading</li>
                        <li><strong>Menu Kanan</strong> berisi beberapa baris code untuk menampilkan beberapa menu utama di pojok kanan atas</li>
                    </ul>
                </li>
            </ul>
            <div>
                <figure class="aligncenter size-full">
                    <img loading="lazy" width="687" height="59" src="<?php echo BMD_PLUGIN_URL.'public/images/dokumentasi/1.SIMATA-–-Sistem-Informasi-Manajemen-Data-Aset-768x351.png'?>" alt="">
                    <figcaption>Tampilan menu kanan atas</figcaption>
                </figure>
            </div>
            <h3>12. Tampilan Halaman Setting Header Utama WP ASET BMD</h3>
            <div>
                <figure class="aligncenter ">
                    <img loading="lazy" width="1024" height="607" src="<?php echo BMD_PLUGIN_URL.'public/images/dokumentasi/1.SIMATA-–-Sistem-Informasi-Manajemen-Data-Aset-768x351.png'?>" alt="">
                    <figcaption>Tampilan Halaman setting Header Utama WP ASET BMD</figcaption>
                </figure>
            </div>
            <ul>
                <li>Penjelasan informasi halaman setting <strong>Header Utama</strong> :
                    <ul>
                        <li><strong>Judul</strong> berisi barisan code untuk menampilkan judul pada bagian header utama</li>
                        <li><strong>Text</strong> berisi tentang pengenalan WP ASET BMD </li>
                        <li><strong>Tombol</strong> menmpilkan tombol untuk mengarah halaman dokumentasi WP ASET BMD dan halaman masuk </li>
                        <li><strong>Gambar</strong> berisi tampilan gambar WP ASET BMD jika di gunakan di handphone atau di desktop  </li>
                    </ul>
                </li>
            </ul>
            <h3>13. Tampilan Halaman Setting Testimoni WP ASET BMD</h3>
            <div>
                <figure class="aligncenter ">
                    <img loading="lazy" width="1024" height="976" src="<?php echo BMD_PLUGIN_URL.'public/images/dokumentasi/1.SIMATA-–-Sistem-Informasi-Manajemen-Data-Aset-768x351.png'?>" alt="">
                    <figcaption>Tampilan Halaman setting Testimoni WP ASET BMD</figcaption>
                </figure>
            </div>
            <ul>
                <li>Penjelasan informasi halaman setting <strong>Testimoni</strong> :
                    <ul>
                        <li><strong>Gambar</strong> untuk menampilkan foto testimoni</li>
                        <li><strong>Nama</strong> Nama Testimoni beserta jabatannya</li>
                        <li><strong>Pesan</strong> berisi pesan setelah menggunakan WP ASET BMD</li>
                    </ul>
                </li>
            </ul>
            <h3>14. Tampilan Halaman Setting Fitur WP ASET BMD</h3>
            <div>
                <figure class="aligncenter ">
                    <img loading="lazy" width="1024" height="507" src="<?php echo BMD_PLUGIN_URL.'public/images/dokumentasi/1.SIMATA-–-Sistem-Informasi-Manajemen-Data-Aset-768x351.png'?>" alt="">
                <figcaption>Tampilan Halaman setting Fitur WP ASET BMD</figcaption></figure></div>
                <ul>
                    <li>Penjelasan informasi halaman setting <strong>Fitur</strong> :
                        <ul>
                            <li><strong>Judul</strong> menampilkan judul dari fitur WP ASET BMD</li>
                            <li><strong>Gambar</strong> gambar tampilan dari beberapa keunggulan SIAMATA</li>
                            <li><strong>Icon</strong> sebagai identitas atau lambang pada judul beberapa fitur</li>
                            <li><strong>Pesan</strong> berisi deskripsi dari setiap fitur fitur</li>
                        </ul>
                    </li>
                </ul>
                <h3>15. Tampilan Halaman Setting Pertinjau WP ASET BMD</h3>
            <div>
                <figure class="aligncenter ">
                    <img loading="lazy" width="1024" height="648" src="https://simata.madiunkab.go.id/wp-content/uploads/2022/04/screencapture-simata-madiunkab-go-id-wp-admin-admin-php-2022-04-26-02_00_44-1024x648.png" alt="" class="wp-image-11341" srcset="https://simata.madiunkab.go.id/wp-content/uploads/2022/04/screencapture-simata-madiunkab-go-id-wp-admin-admin-php-2022-04-26-02_00_44-1024x648.png 1024w, https://simata.madiunkab.go.id/wp-content/uploads/2022/04/screencapture-simata-madiunkab-go-id-wp-admin-admin-php-2022-04-26-02_00_44-300x190.png 300w, https://simata.madiunkab.go.id/wp-content/uploads/2022/04/screencapture-simata-madiunkab-go-id-wp-admin-admin-php-2022-04-26-02_00_44-768x486.png 768w, https://simata.madiunkab.go.id/wp-content/uploads/2022/04/screencapture-simata-madiunkab-go-id-wp-admin-admin-php-2022-04-26-02_00_44.png 1358w" sizes="(max-width: 1024px) 100vw, 1024px">
                    <figcaption>Tampilan Halaman setting Pertinjau WP ASET BMD</figcaption>
                </figure>
            </div>
            <ul>
                <li>Penjelasan informasi halaman setting <strong>Pertinjau</strong> :
                    <ul>
                        <li><strong>Judul</strong> menampilkan judul utama dari pertinjau WP ASET BMD</li>
                        <li><strong>Gambar</strong> gambar screanshot dari beberapa tampilan WP ASET BMD </li>
                    </ul>
                </li>
            </ul>
            <h3>16. Tampilan Halaman Setting Video WP ASET BMD</h3>
            <div>
                <figure class="aligncenter ">
                    <img loading="lazy" width="1024" height="504" src="https://simata.madiunkab.go.id/wp-content/uploads/2022/04/screencapture-simata-madiunkab-go-id-wp-admin-admin-php-2022-04-26-02_01_05-1024x504.png" alt="" class="wp-image-11345" srcset="https://simata.madiunkab.go.id/wp-content/uploads/2022/04/screencapture-simata-madiunkab-go-id-wp-admin-admin-php-2022-04-26-02_01_05-1024x504.png 1024w, https://simata.madiunkab.go.id/wp-content/uploads/2022/04/screencapture-simata-madiunkab-go-id-wp-admin-admin-php-2022-04-26-02_01_05-300x148.png 300w, https://simata.madiunkab.go.id/wp-content/uploads/2022/04/screencapture-simata-madiunkab-go-id-wp-admin-admin-php-2022-04-26-02_01_05-768x378.png 768w, https://simata.madiunkab.go.id/wp-content/uploads/2022/04/screencapture-simata-madiunkab-go-id-wp-admin-admin-php-2022-04-26-02_01_05.png 1358w" sizes="(max-width: 1024px) 100vw, 1024px">
                    <figcaption>Tampilan Halaman setting Video WP ASET BMD</figcaption>
                </figure>
            </div>
            <ul>
                <li>Penjelasan informasi halaman setting <strong>video</strong> :
                    <ul>
                        <li><strong>Judul</strong> menampilkan judul utama dari video demo WP ASET BMD</li>
                        <li><strong>Url Video</strong> Menampilkan video demo dokumentasi dari WP ASET BMD bersumber dari youtube resmi WP ASET BMD</li>
                        <li><strong>Auto Play Video</strong> di berikan pilihan jika mengakses website simata akan auto play video dokumentasi WP ASET BMD atau dilakukan secara manual untuk pemutaran dokumentasi WP ASET BMD</li>
                    </ul>
                </li>
            </ul>
            <h3>17. Tampilan Halaman Setting Monitoring Data WP ASET BMD</h3>
            <div>
                <figure class="aligncenter ">
                    <img loading="lazy" width="1024" height="701" src="https://simata.madiunkab.go.id/wp-content/uploads/2022/04/screencapture-simata-madiunkab-go-id-wp-admin-admin-php-2022-04-26-02_01_21-1024x701.png" alt="" class="wp-image-11347" srcset="https://simata.madiunkab.go.id/wp-content/uploads/2022/04/screencapture-simata-madiunkab-go-id-wp-admin-admin-php-2022-04-26-02_01_21-1024x701.png 1024w, https://simata.madiunkab.go.id/wp-content/uploads/2022/04/screencapture-simata-madiunkab-go-id-wp-admin-admin-php-2022-04-26-02_01_21-300x205.png 300w, https://simata.madiunkab.go.id/wp-content/uploads/2022/04/screencapture-simata-madiunkab-go-id-wp-admin-admin-php-2022-04-26-02_01_21-768x525.png 768w, https://simata.madiunkab.go.id/wp-content/uploads/2022/04/screencapture-simata-madiunkab-go-id-wp-admin-admin-php-2022-04-26-02_01_21.png 1358w" sizes="(max-width: 1024px) 100vw, 1024px">
                    <figcaption>Tampilan Halaman setting Monitoring Data WP ASET BMD</figcaption>
                    </figure></div>
            <ul>
                <li>Penjelasan informasi halaman setting <strong>Monitoring Data</strong> :
                    <ul>
                        <li><strong>Judul</strong> menampilkan judul utama dari Monitoring Data </li>
                        <li><strong>Total Nilai Aset Pemerintah Daerah</strong> total nilai harga dari seluruh aset milik daerah</li>
                        <li><strong>Data Total Aset Perjenis Aset</strong> nilai total aset dari keseluruhan harga dari jenis aset </li>
                        <li><strong>Data Total Aset Perbidang Urusan</strong> nilai data total aset dari keseluruhan nilai perbidang mulai dari data total bidang kesehatan,bidang pendidikan atau pun yang lainnya</li>
                        <li><strong>Data Total Aset Per unit SKPD</strong> data total aset dari keseluruhan nilai per unit SKPD </li>
                        <li><strong>Jumlah Sub Unit</strong> Jumlah keseluruhan unit </li>
                    </ul>
                </li>
            </ul>
            <h3>18. Tampilan Halaman Setting Sewa Aset WP ASET BMD</h3>
            <div>
                <figure class="aligncenter ">
                    <img loading="lazy" width="1024" height="504" src="https://simata.madiunkab.go.id/wp-content/uploads/2022/04/screencapture-simata-madiunkab-go-id-wp-admin-admin-php-2022-04-26-02_01_39-1024x504.png" alt="" class="wp-image-11351" srcset="https://simata.madiunkab.go.id/wp-content/uploads/2022/04/screencapture-simata-madiunkab-go-id-wp-admin-admin-php-2022-04-26-02_01_39-1024x504.png 1024w, https://simata.madiunkab.go.id/wp-content/uploads/2022/04/screencapture-simata-madiunkab-go-id-wp-admin-admin-php-2022-04-26-02_01_39-300x148.png 300w, https://simata.madiunkab.go.id/wp-content/uploads/2022/04/screencapture-simata-madiunkab-go-id-wp-admin-admin-php-2022-04-26-02_01_39-768x378.png 768w, https://simata.madiunkab.go.id/wp-content/uploads/2022/04/screencapture-simata-madiunkab-go-id-wp-admin-admin-php-2022-04-26-02_01_39.png 1358w" sizes="(max-width: 1024px) 100vw, 1024px">
                    <figcaption>Tampilan Halaman setting Sewa Aset WP ASET BMD</figcaption>
                </figure>
            </div>
            <ul>
                <li>Penjelasan informasi halaman setting <strong>Sewa Aset</strong> :
                    <ul>
                        <li><strong>Judul</strong> menampilkan judul utama dari Sewa Aset </li>
                        <li><strong>Total Nilai Potensi Aset Yang Disewakan</strong> total nilai aset yang berpotensi di sewakan</li>
                        <li><strong>Jumlah Aset Disewakan</strong> tampilan jumlah aset yang telah di sewakan </li>
                        <li><strong>Jumlah Aset Tanah Yang Belum Bersertifikat</strong> tampilan jumlah keseluruhan aset tanah yang belum terkonfirmasi bersertifikat</li>
                    </ul>
                </li>
            </ul>
            <h2>tampilan fitur baru di halaman Beranda</h2>
            <h3>19. Tampilan Halaman Setting Logo WP ASET BMD</h3>
            <div>
                <figure class="aligncenter ">
                    <img loading="lazy" width="1024" height="765" src="https://simata.madiunkab.go.id/wp-content/uploads/2022/05/logo-1-1024x765.png" alt="" class="wp-image-14286" srcset="https://simata.madiunkab.go.id/wp-content/uploads/2022/05/logo-1-1024x765.png 1024w, https://simata.madiunkab.go.id/wp-content/uploads/2022/05/logo-1-300x224.png 300w, https://simata.madiunkab.go.id/wp-content/uploads/2022/05/logo-1-768x574.png 768w, https://simata.madiunkab.go.id/wp-content/uploads/2022/05/logo-1.png 1207w" sizes="(max-width: 1024px) 100vw, 1024px">
                    <figcaption>Tampilan Halaman Edit Logo</figcaption>
                </figure>
            </div>
            <ul>
                <li>Penjelasan informasi halaman setting <strong>Logo</strong> :
                    <ul>
                        <li><strong>Gamabr Logo</strong> untuk mengganti atau menubah tampilan logo </li>
                        <li><strong>Video Loading</strong> tampilan video loading sebelum masuk ke halaman menu utama</li>
                        <li><strong>Lama Loading</strong> untuk mengatur durasi video loading simata </li>
                        <li><strong>Backround Beranda</strong> untuk mengubah tampilan latar belakang beranda simata</li>
                        <li><strong>Save Changes</strong> menyimpan tampilan setting yang sudah di edit</li>
                    </ul>
                </li>
            </ul>
            <h3>20. Tampilan Halaman Icon &amp; menu</h3>
            <div>
                <figure class="aligncenter ">
                    <img src="https://simata.madiunkab.go.id/wp-content/uploads/2022/05/menu-1024x532.png" alt="" class="wp-image-14287">
                <figcaption>Tampilan Halaman i<em>con &amp; Menu</em></figcaption>
                </figure>
            </div>
            <ul>
                <li>Penjelasan informasi halaman setting <strong>Icon &amp; Menu</strong> :
                    <ul>
                        <li><strong>Gambar Menu 1</strong> untuk mengganti logo icon menu yang berisi 12 icon menu </li>
                        <li><strong>Text Menu</strong> text judul icon menu</li>
                        <li><strong>URL Menu</strong> url untuk mengarahkan pengguna untuk menuju ke halaman menu yang pengguna pilih </li>
                        <li><strong>Keterangan Menu</strong> keterangan penjelas untuk fungsi icon di setiap menu</li>
                    </ul>
                </li>
            </ul>
            <div>
                <figure class="aligncenter ">
                    <img src="https://simata.madiunkab.go.id/wp-content/uploads/2022/05/icon-menu-1024x307.png" alt="" class="wp-image-14291">
                <figcaption>Gambar Icon Menu SImata</figcaption>
                </figure>
            </div>
            <h3>21. Tampilan Halaman Sub Unit</h3>
            <div>
                <figure class="aligncenter ">
                    <img loading="lazy" width="1024" height="464" src="https://simata.madiunkab.go.id/wp-content/uploads/2022/05/sub-unit-1024x464.png" alt="" class="wp-image-14290" srcset="https://simata.madiunkab.go.id/wp-content/uploads/2022/05/sub-unit-1024x464.png 1024w, https://simata.madiunkab.go.id/wp-content/uploads/2022/05/sub-unit-300x136.png 300w, https://simata.madiunkab.go.id/wp-content/uploads/2022/05/sub-unit-768x348.png 768w, https://simata.madiunkab.go.id/wp-content/uploads/2022/05/sub-unit-1536x696.png 1536w, https://simata.madiunkab.go.id/wp-content/uploads/2022/05/sub-unit.png 1991w" sizes="(max-width: 1024px) 100vw, 1024px">
                <figcaption>tampilan halaman Sub unit</figcaption>
            </figure>
        </div>
            <ul>
                <li>Penjelasan informasi halaman setting <strong>Sub Unit</strong>:
                    <ul>
                        <li><strong>Sub Menu Pilihan</strong> Sub unit yang akan ditampilkan saat masuk ke halaman total aset per SKPD.</li>
                    </ul>
                </li>
            </ul>
            <h4>Sumber Referensi</h4>
            <ol>
                <li>Dokumentasi SIMDA v2.7.0&nbsp;<a href="https://drive.google.com/file/d/1oFRFHHYixmeWJugFxK4AYDDFlYX3ClKU/view?usp=sharing">file PDF</a></li>
                <li>Artikel tentang sistem informasi pengelolaan data aset berbasis web <a href="https://drive.google.com/file/d/1M1Ru9mNwbsfKcqqHtiIBq5KtatV9Njmf/view?usp=sharing"> file PDF</a></li>
            </ol>
            <p></p>
        </div>
    </div>
</div>