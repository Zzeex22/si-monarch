<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        @page { margin: 80px 50px 80px 50px; }
        body { font-family: "Times New Roman", Times, serif; font-size: 11pt; line-height: 1.5; color: #000; }
        footer { position: fixed; bottom: -50px; left: 0px; right: 0px; height: 30px; font-size: 11pt; }
        .page-number:after { content: counter(page); }
        .center { text-align: center; }
        .bold { font-weight: bold; }
        .justify { text-align: justify; }
        .page-break { page-break-after: always; }
        .cover-title { font-size: 14pt; font-weight: bold; text-align: center; margin-top: 150px; line-height: 2; }
        .cover-nomor { margin-top: 100px; width: 100%; font-weight: bold; }
        .cover-nomor td { padding: 5px; }
        .tabel-biasa { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .tabel-biasa td { vertical-align: top; padding: 2px 0; }
        .pasal-title { text-align: center; font-weight: bold; margin-top: 20px; margin-bottom: 10px; }
        ol { margin-top: 5px; margin-bottom: 5px; padding-left: 20px; }
        ol li { text-align: justify; margin-bottom: 5px; }
        ol.alpha-list { list-style-type: lower-alpha; }
        ol.roman-list { list-style-type: lower-roman; }
        .tabel-border { width: 100%; border-collapse: collapse; margin-top: 10px; margin-bottom: 10px; table-layout: fixed; }
        .tabel-border th, .tabel-border td { border: 1px solid black; padding: 6px; word-wrap: break-word; overflow-wrap: break-word; }
        .tabel-border th { text-align: center; font-weight: bold; }
    </style>
</head>
<body>
    <?php
        // 1. OTOMATIS TANGGAL HARI INI
        \Carbon\Carbon::setLocale('id');
        $tgl_dibuat_indo = \Carbon\Carbon::now()->translatedFormat('l, d F Y');

        // 2. OTOMATIS TERBILANG UNTUK DURASI HARI (Contoh: 30 jadi Tiga Puluh)
        if (!function_exists('terbilang_hari')) {
            function terbilang_hari($angka) {
                $angka = abs((int)$angka);
                $baca = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
                $terbilang = "";
                if ($angka < 12) {
                    $terbilang = " " . $baca[$angka];
                } else if ($angka < 20) {
                    $terbilang = terbilang_hari($angka - 10) . " Belas";
                } else if ($angka < 100) {
                    $terbilang = terbilang_hari($angka / 10) . " Puluh" . terbilang_hari($angka % 10);
                } else if ($angka < 200) {
                    $terbilang = " Seratus" . terbilang_hari($angka - 100);
                } else if ($angka < 1000) {
                    $terbilang = terbilang_hari($angka / 100) . " Ratus" . terbilang_hari($angka % 100);
                }
                return trim($terbilang);
            }
        }
        $waktu_hari_huruf = isset($waktu_hari) ? terbilang_hari($waktu_hari) : '';
    ?>

    <footer>
        <table width="100%" style="border-collapse: collapse;">
            <tr>
                <td width="33%" style="text-align: left;" class="bold">Paraf Pihak I</td>
                <td width="33%" style="text-align: center;" class="bold"><span class="page-number"></span></td>
                <td width="33%" style="text-align: right;" class="bold">Paraf Pihak II</td>
            </tr>
        </table>
    </footer>

    <div class="center" style="margin-top: 50px;">
        <?php
            $path = public_path('img/logo-ssm.jpg');
            if (file_exists($path)) {
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            } else {
                $base64 = ''; // Jaga-jaga kalau logo terhapus biar nggak error 500
            }
        ?>
        
        @if($base64)
        <div style="text-align: center; margin-bottom: 30px;">
            <img src="{{ $base64 }}" alt="Logo Sumber Sari Mulia" style="width: 250px; height: auto;">
        </div>
        @endif
    </div>
    
    <div class="cover-title">
        PERJANJIAN<br>ANTARA<br>{{ strtoupper($pt_pihak1) }}<br>DAN<br>{{ strtoupper($cv_pihak2) }}<br>TENTANG<br>{{ strtoupper($nama_pekerjaan) }}
    </div>
    
    <table class="cover-nomor">
        <tr>
            <td width="45%">NOMOR PIHAK PERTAMA</td><td width="5%">:</td><td width="50%">{{ $no_pihak1 }}</td>
        </tr>
        <tr>
            <td>NOMOR PIHAK KEDUA</td><td>:</td><td>{{ $no_pihak2 }}</td>
        </tr>
    </table>
    
    <div class="page-break"></div>

    <p class="justify">Pada hari ini {{ $tgl_dibuat_indo }}, yang bertanda tangan di bawah ini:</p>
    
    <table class="tabel-biasa">
        <tr>
            <td width="5%">1.</td>
            <td width="35%" class="bold">{{ strtoupper($pt_pihak1) }}</td>
            <td width="5%">:</td>
            <td width="55%" class="justify">Dalam hal ini diwakili oleh <strong>{{ $nama_pejabat1 }}</strong> selaku <strong>{{ $jabatan1 }}</strong>. Disebut <strong>PIHAK PERTAMA</strong>.</td>
        </tr>
        <tr><td colspan="4" style="height: 15px;"></td></tr>
        <tr>
            <td>2.</td>
            <td class="bold">{{ strtoupper($cv_pihak2) }}</td>
            <td>:</td>
            <td class="justify">Diwakili oleh <strong>{{ $nama_pejabat2 }}</strong>, sebagai <strong>{{ $jabatan2 }}</strong> berdasarkan {{ $akta_notaris }}, yang beralamat di {{ $alamat_pihak2 }}. Disebut <strong>PIHAK KEDUA</strong>.</td>
        </tr>
    </table>

    <div class="pasal-title">PASAL 2<br>RUANG LINGKUP PEKERJAAN</div>
    <ol>
        <li>Ruang lingkup pekerjaan dalam Kontrak ini meliputi:
            <table class="tabel-biasa" style="margin-top: 10px; margin-bottom: 10px;">
                <tr><td width="15%">PEKERJAAN</td><td width="3%">:</td><td class="bold">{{ strtoupper($nama_pekerjaan) }}</td></tr>
                <tr><td>LOKASI</td><td>:</td><td class="bold">{{ $lokasi_kerja }}</td></tr>
            </table>
            
            <table class="tabel-border">
                <thead>
                    <tr>
                        <th width="5%">No</th><th width="25%">Barang/Uraian</th><th width="50%">Spesifikasi</th><th width="10%">Kbt</th><th width="10%">Sat</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($uraian))
                        @for($i = 0; $i < count($uraian); $i++)
                        <tr>
                            <td class="center">{{ $i + 1 }}</td>
                            <td>{{ $uraian[$i] }}</td>
                            <td class="justify">{!! nl2br(e($spek[$i])) !!}</td>
                            <td class="center">{{ $qty[$i] }}</td>
                            <td class="center">{{ $satuan[$i] }}</td>
                        </tr>
                        @endfor
                    @endif
                </tbody>
            </table>
        </li>
    </ol>

    <div class="pasal-title">PASAL 3<br>WAKTU PELAKSANAAN, LOKASI PEKERJAAN, JANGKA WAKTU<br>DAN JENIS PERJANJIAN</div>
            <ol>
                <li>Waktu Pelaksanaan Pekerjaan adalah selama <strong>{{ $waktu_hari }} ({{ $waktu_hari_huruf }})</strong> hari kalender, yang terhitung sejak tanggal <strong>{{ \Carbon\Carbon::parse($tgl_mulai)->translatedFormat('d F Y') }}</strong>, dan akan berakhir pada tanggal <strong>{{ \Carbon\Carbon::parse($tgl_selesai)->translatedFormat('d F Y') }}</strong>.</li>
                <li>Lokasi Pelaksanaan Pekerjaan adalah di {{ $lokasi_kerja }}, atau di lokasi lain yang disepakati oleh PARA PIHAK sebelum pelaksanaan pekerjaan dimulai.</li>
                <li>Jenis perjanjian ini menggunakan jenis perjanjian yaitu Harga Satuan (Unit Price).</li>
                <li>Perjanjian ini akan berakhir apabila seluruh hak dan kewajiban PARA PIHAK yang tercantum dalam kontrak ini telah terpenuhi sesuai dengan ketentuan yang berlaku dalam kontrak ini.</li>
            </ol>

            <div class="pasal-title">PASAL 4<br>KEPATUHAN TERHADAP HUKUM DAN PERIZINAN</div>
            <ol>
                <li>PARA PIHAK wajib mematuhi seluruh peraturan dan ketentuan hukum yang berlaku dan berhubungan langsung dengan pelaksanaan Perjanjian ini, termasuk namun tidak terbatas pada hukum perpajakan, perizinan, ketenagakerjaan, lingkungan, keselamatan dan kesehatan kerja (K3), ketenagalistrikan (K2), perlindungan lingkungan, serta peraturan teknis lainnya yang berlaku untuk pekerjaan ini.</li>
                <li>PIHAK KEDUA wajib memperoleh, mempertahankan, dan memperbaharui semua izin yang diperlukan untuk pelaksanaan pekerjaan sesuai dengan hukum dan peraturan yang berlaku dan relevan dengan seluruh kegiatan yang akan dilaksanakan sesuai dengan perjanjian ini termasuk, namun tidak terbatas pada, izin usaha, izin lingkungan, izin teknis, izin tenaga kerja, serta izin lainnya yang relevan. Semua biaya yang terkait dengan perizinan tersebut menjadi tanggung jawab PIHAK KEDUA.</li>
                <li>Pelanggaran terhadap peraturan
                    <ol class="alpha-list">
                        <li>Dalam hal terjadinya pelanggaran terhadap peraturan atau perundang-undangan yang relevan dalam rangka pelaksanaan perjanian ini oleh PIHAK KEDUA, maka PIHAK KEDUA bertanggung jawab penuh atas segala akibat hukum, sanksi, denda, dan/atau biaya yang timbul akibat pelanggaran tersebut.</li>
                        <li>Dalam hal terjadinya pelanggaran terhadap peraturan oleh PIHAK KEDUA berakibat pada proses penyelesaian perjanjian ini dan dinyatakan wanprestasi sesuai dengan tata cara yang diatur pada pasal Ganti Rugi dan Wanprestasi.</li>
                    </ol>
                </li>
                <li>Dalam hal setelah penandatanganan Perjanjian ini terjadi perubahan dalam peraturan perundang-undangan, Peraturan Pemerintah, Keputusan Menteri, yang berpengaruh langsung pada perjanjian ini dan mengakibatkan kerugian atau tidak terpenuhinya kewajiban untuk memenuhi peraturan tersebut bagi salah satu pihak atau PARA PIHAK, maka PARA PIHAK wajib melakukan langkah-langkah untuk menyesuaikan Perjanjian ini.</li>
                <li>Dalam hal Hasil Penyesuaian menemui kepakatan PARA PIHAK maka kesepakatan tersebut akan dituangkan dalam Addendum/Amandemen dengan tata cara sesuai dengan ketentuan yang diatur dalam Pasal pada Perjanjian ini.</li>
            </ol>

            <div class="pasal-title">PASAL 5<br>HAK, KEWAJIBAN DAN LARANGAN</div>
            <p class="justify">Hak, Kewajiban dan Larangan PARA PIHAK yang di atur pada Pasal-Pasal dalam perjanjian ini tetap mengikat dan berlaku, dan diluar hal tersebut PARA PIHAK sepakat bahwa Hak, Kewajiban dan Larangan PARA PIHAK adalah sebagai berikut</p>
            <ol>
                <li>Hak PIHAK PERTAMA adalah sebagai berikut:
                    <ol class="alpha-list">
                        <li>Mengawasi pelaksanaan pekerjaan yang dilakukan oleh PIHAK KEDUA.</li>
                        <li>Meminta laporan periodik mengenai pelaksanaan pekerjaan dari PIHAK KEDUA.</li>
                        <li>Memberikan peringatan terkait keterlambatan pekerjaan.</li>
                        <li>Mengenakan sanksi dan denda atas keterlambatan pekerjaan.</li>
                        <li>Memberikan instruksi yang diperlukan sesuai dengan lingkup pekerjaan yang ditetapkan.</li>
                        <li>Melakukan perubahan perjanjian apabila ada alasan yang sah dan disetujui oleh PARA PIHAK.</li>
                    </ol>
                </li>
                <li>Kewajiban PIHAK PERTAMA adalah sebagai berikut:
                    <ol class="alpha-list">
                        <li>Menyediakan akses dan informasi yang diperlukan bagi PIHAK KEDUA untuk melaksanakan pekerjaan sesuai dengan ketentuan dalam Perjanjian.</li>
                        <li>Membayar nilai pekerjaan setelah pekerjaan selesai dilaksanakan dan sesuai dengan Berita Acara Pemeriksaan Pekerjaan serta Berita Acara Serah Terima Pekerjaan.</li>
                        <li>Membuat dan menandatangani Berita Acara Serah Terima Pekerjaan apabila pekerjaan telah selesai.</li>
                    </ol>
                </li>
                <li>Hak PIHAK KEDUA adalah sebagai berikut:
                    <ol class="alpha-list">
                        <li>Menerima pembayaran sesuai dengan hasil pekerjaan yang tercantum dalam Berita Acara Pemeriksaan Pekerjaan dan Berita Acara Serah Terima Pekerjaan yang disetujui PARA PIHAK.</li>
                        <li>Meminta klarifikasi kepada PIHAK PERTAMA jika dalam instruksi pekerjaan terdapat hal yang tidak sesuai dengan spesifikasi atau kontrak.</li>
                        <li>Mengajukan permohonan perubahan perjanjian dalam hal kondisi yang tidak dapat diprediksi atau jika terdapat kesulitan dalam pelaksanaan pekerjaan.</li>
                    </ol>
                </li>
                <li>Kewajiban PIHAK KEDUA adalah sebagai berikut:
                    <ol class="alpha-list">
                        <li>Melaksanakan dan menyelesaikan pekerjaan serta menyerahkan hasil pekerjaan sesuai dengan ruang lingkup dan jadwal pelaksanaan pekerjaan dan memberikan jaminan atas kualitas hasil pekerjaan, termasuk perbaikan atau penggantian atas cacat atau kerusakan yang timbul dalam jangka waktu yang ditentukan setelah pekerjaan selesai diserahkan.</li>
                        <li>Memberikan keterangan yang diperlukan untuk pemeriksaan pelaksanaan pekerjaan yang dilakukan PIHAK PERTAMA.</li>
                        <li>Melaksanakan Pekerjaan sesuai dengan hukum yang berlaku di Indonesia termasuk Memastikan bahwa semua izin yang diperlukan untuk pelaksanaan pekerjaan telah diperoleh dan memenuhi peraturan yang berlaku.</li>
                        <li>Menerapkan Keselamatan Ketenagalistrikan (K2) dan Keselamatan dan Kesehatan Kerja (K3) dan melindungi lingkungan dengan melakukan identifikasi, mengelola, dan mengurangi risiko yang terkait dengan pelaksanaan pekerjaan, serta mengambil tindakan pencegahan yang sesuai untuk memastikan keselamatan kerja, perlindungan lingkungan, dan kelancaran operasional.</li>
                        <li>Menyusun laporan kemajuan pekerjaan secara berkala dan memberikan informasi yang jelas mengenai status pelaksanaan pekerjaan kepada PIHAK PERTAMA.</li>
                        <li>Menepati segala petunjuk, perintah dan kewajiban yang diberikan oleh Direksi Pekerjaan / Pengawas Lapangan dalam melaksanakan pekerjaan.</li>
                        <li>Meminta persetujuan PIHAK PERTAMA dalam hal memobilisasi personel.</li>
                        <li>Menyerahkan rancangan, gambar-gambar, spesifikasi, desain dan dokumen lain kepada PIHAK PERTAMA setelah berakhirnya Perjanjian dan salinan dapat disimpan oleh PIHAK KEDUA.</li>
                        <li>Menyediakan peralatan dan bahan untuk kebutuhan pelaksanaan Pekerjaan sesuai dengan kesepakatan PARA PIHAK.</li>
                        <li>Menghormati waktu pelaksanaan dan memastikan penyelesaian pekerjaan sesuai dengan jadwal yang disepakati, serta melakukan upaya maksimal untuk menghindari keterlambatan.</li>
                        <li>Menunjuk personel di lokasi Pekerjaan, yang diberi wewenang penuh dan bertanggung jawab atas pelaksanaan Pekerjaan.</li>
                        <li>Menyediakan dokumentasi lengkap terkait pekerjaan, termasuk manual pemeliharaan, laporan hasil pekerjaan, dan dokumen lain yang relevan setelah pekerjaan selesai.</li>
                    </ol>
                </li>
                <li>Larangan PIHAK KEDUA adalah sebagai berikut:
                    <ol class="alpha-list">
                        <li>Dilarang menerima keuntungan untuk kepentingan pribadi dari komisi usaha (trade commission), rabat (discount), atau pembayaran pembayaran lain.</li>
                        <li>Dilarang untuk melaksanakan pekerjaan jasa maupun mengadakan barang yang tidak sesuai dengan Perjanjian.</li>
                        <li>Dilarang melakukan kegiatan yang menimbulkan pertentangan kepentingan.</li>
                        <li>Dilarang melakukan subkontrak kecuali atas persetujuan PIHAK PERTAMA.</li>
                    </ol>
                </li>
            </ol>

            <div class="pasal-title">PASAL 6<br>PENGGUNAAN SUBKONTRAKTOR ATAU PIHAK KETIGA</div>
            <ol>
                <li>Apabila dalam pelaksanaan pekerjaan PIHAK KEDUA akan melibatkan subkontraktor atau pihak ketiga, maka penggunaan subkontraktor atau pihak ketiga tersebut harus terlebih dahulu mendapatkan persetujuan tertulis dari PIHAK PERTAMA.</li>
                <li>Setiap penggunaan subkontraktor atau pihak ketiga yang disetujui harus mematuhi ketentuan dalam perjanjian ini serta standar yang ditetapkan oleh PIHAK PERTAMA.</li>
                <li>Prosedur Persetujuan
                    <ol class="alpha-list">
                        <li>PIHAK KEDUA wajib memberikan informasi lengkap mengenai subkontraktor atau pihak ketiga yang akan digunakan, termasuk identitas, keahlian, pengalaman, serta rincian pekerjaan yang akan dilaksanakan.</li>
                        <li>PIHAK PERTAMA berhak untuk menilai kelayakan subkontraktor atau pihak ketiga dan dapat menolak jika tidak memenuhi kriteria atau persyaratan yang ditetapkan dalam kontrak.</li>
                        <li>Persetujuan tertulis dari PIHAK PERTAMA harus diberikan sebelum subkontraktor atau pihak ketiga mulai melaksanakan pekerjaan terkait dengan kontrak ini.</li>
                    </ol>
                </li>
                <li>Tanggung Jawab PIHAK KEDUA
                    <ol class="alpha-list">
                        <li>PIHAK KEDUA tetap bertanggung jawab penuh atas kinerja, kualitas, dan kelancaran pekerjaan yang dilakukan oleh subkontraktor atau pihak ketiga, meskipun telah mendapatkan persetujuan dari PIHAK PERTAMA.</li>
                        <li>PIHAK KEDUA wajib memastikan bahwa subkontraktor atau pihak ketiga yang dilibatkan mematuhi semua ketentuan dalam perjanjian ini, serta mematuhi standar keselamatan, kualitas, dan peraturan yang berlaku.</li>
                    </ol>
                </li>
                <li>Tanggung Jawab Hukum
                    <ol class="alpha-list">
                        <li>PIHAK KEDUA bertanggung bertanggung sepenuhnya atas segala tindakan subkontraktor atau pihak ketiga yang melanggar hukum atau ketentuan yang berlaku selama pelaksanaan pekerjaan.</li>
                        <li>Jika subkontraktor atau pihak ketiga menyebabkan kerugian, kerusakan, atau pelanggaran, PIHAK KEDUA wajib mengganti kerugian yang ditimbulkan oleh tindakan tersebut.</li>
                    </ol>
                </li>
                <li>PIHAK PERTAMA berhak untuk mengawasi dan memeriksa pekerjaan yang dilakukan oleh subkontraktor atau pihak ketiga, dan PIHAK KEDUA wajib memberikan akses yang diperlukan untuk keperluan pengawasan tersebut.</li>
                <li>Jika PIHAK KEDUA melibatkan subkontraktor atau pihak ketiga dalam pelaksanaan pekerjaan, maka PIHAK KEDUA wajib mencantumkan ketentuan yang setara dengan ketentuan dalam perjanjian ini dalam perjanjian antara PIHAK KEDUA dan subkontraktor atau pihak ketiga tersebut, termasuk hak akses dan kewajiban pengawasan oleh PIHAK PERTAMA.</li>
            </ol>

            <div class="pasal-title">PASAL 7<br>SERVICE LEVEL AGREEMENT (SLA)</div>
            <ol>
                <li>Service Level Agreement (SLA)
                    <ol class="alpha-list">
                        <li>SLA berlaku khusus untuk jasa atau layanan yang diberikan oleh PIHAK KEDUA dalam rangka pelaksanaan Perjanjian ini. PIHAK KEDUA wajib untuk memberikan layanan sesuai dengan standar kinerja yang telah disepakati bersama, yang meliputi waktu penyelesaian, kualitas layanan, dan respons terhadap permintaan atau keluhan yang diajukan oleh PIHAK PERTAMA.</li>
                        <li>Layanan yang diberikan oleh PIHAK KEDUA harus memenuhi indikator kinerja yang terukur, yang dapat mencakup namun tidak terbatas pada hal-hal berikut:
                            <ol class="roman-list">
                                <li>Waktu Penyelesaian Layanan: Pekerjaan atau layanan yang dijanjikan harus diselesaikan dalam waktu yang telah ditentukan dalam jadwal proyek yang disepakati.</li>
                                <li>Kualitas Layanan: Semua layanan yang diberikan harus sesuai dengan standar kualitas yang telah disepakati dalam perjanjian ini.</li>
                                <li>Respon terhadap Keluhan: PIHAK KEDUA wajib memberikan respon terhadap setiap keluhan atau permintaan dari PIHAK PERTAMA dalam waktu yang disepakati PARA PIHAK setelah keluhan atau permintaan tersebut diterima.</li>
                            </ol>
                        </li>
                        <li>Apabila PIHAK KEDUA gagal untuk memenuhi standar yang tercantum dalam SLA, maka PIHAK KEDUA akan dikenakan denda oleh PIHAK PERTAMA sesuai dengan pelanggaran SLA nya.</li>
                    </ol>
                </li>
                <li>Penyelarasan Penggunaan SLA<br>
                    PARA PIHAK sepakat bahwa SLA berlaku untuk jasa atau layanan yang disediakan oleh PIHAK KEDUA, yang berhubungan dengan kinerja, waktu penyelesaian, dan kualitas layanan.
                </li>
            </ol>

            <div class="pasal-title">PASAL 9<br>PENGGUNA BARANG/ JASA DAN POLA PENGAWASAN</div>
            <ol>
                <li>Pengguna Barang/Jasa adalah {{ $pt_pihak1 }}.</li>
                <li>Dalam rangka pelaksanaan Pekerjaan tersebut dalam Perjanjian ini, PIHAK PERTAMA dibantu oleh Assistant Manager Pelaksanaan Pembelajaran sebagai Direksi Pekerjaan yang bertanggung jawab atas manajemen perjanjian dan pemantauan terhadap kinerja PIHAK KEDUA.</li>
                <li>Tugas Direksi Pekerjaan adalah:
                    <ol class="alpha-list">
                        <li>Melakukan Pengawasan dan Pembinaan terhadap pelaksanaan Perjanjian.</li>
                        <li>Memeriksa, mengarahkan dan mengawasi seluruh lingkup Pekerjaan yang dilaksanakan oleh PIHAK KEDUA.</li>
                        <li>Memastikan hasil pelaksanaan Pekerjaan yang dilakukan oleh PIHAK KEDUA sesuai dengan ketentuan ketentuan dalam Perjanjian ini.</li>
                        <li>Membuat dan menandatangani Berita Acara Penyelesaian Pekerjaan dan Berita Acara lainnya yang menjadi tanggung jawabnya.</li>
                        <li>Memastikan persyaratan permohonan pembayaran lengkap.</li>
                        <li>Memberikan penilaian kinerja PIHAK KEDUA secara berkala selama pelaksanaan Perjanjian ini sesuai dengan ketentuan yang berlaku di lingkungan PIHAK PERTAMA.</li>
                    </ol>
                </li>
                <li>Untuk mengawasi pelaksaaan Pekerjaan di lokasi tersebut, Direksi Pekerjaan dapat dibantu oleh Pengawas Pekerjaan dengan tugas-tugas sebagai berikut:
                    <ol class="alpha-list">
                        <li>Melakukan pemeriksaan mutu, memastikan mutu dan menerima Pekerjaan sesuai dengan Perjanjian dan dokumen pengadaan dan untuk mewakili Direksi Pekerjaan.</li>
                        <li>Memberikan pertanyaan dan/atau memeriksa/mengklarifikasi barang/jasa dan kelengkapannya dalam pelaksanaan Pekerjaan serta memastikan kelengkapan dokumen pendukungnya.</li>
                    </ol>
                </li>
                <li>Pengawas K3 adalah Team Leader Pelaksana K3L & KAM dengan tugas-tugas sebagai berikut:
                    <ol class="alpha-list">
                        <li>Memberikan izin masuk lokasi dan izin bekerja kepada PIHAK KEDUA sebelum mulai bekerja.</li>
                        <li>Memeriksa pemenuhan persyaratan K3 dan lingkungan yang harus dipenuhi oleh PIHAK KEDUA sebelum dan selama mereka bekerja.</li>
                        <li>Menghentikan sementara pekerjaan yang berlangsung, apabila pekerjaan dilapangan tidak memenuhi aspek K3 dalam bekerja.</li>
                        <li>Mengijinkan melanjutkan pekerjaan, apabila pekerjaan dilapangan telah memenuhi aspek K3 dalam bekerja.</li>
                    </ol>
                </li>
                <li>Dalam proses Penilaian Akhir Pelaksanaan Pekerjaan maka PIHAK PERTAMA dapat membentuk Tim Pemeriksa Barang / Jasa yang mempunyai tugas antara lain memeriksa kualitas dan kuantitas pekerjaan, mengarahkan dan menyetujui untuk serah terima pekerjaan PIHAK KEDUA yang diserahkan kepada PIHAK PERTAMA dan dituangkan dalam Berita Acara Pemeriksaan Pekerjaan.</li>
            </ol>

            <div class="pasal-title">PASAL 10<br>NILAI PEKERJAAN DAN PENGGUNAAN PRODUK DALAM NEGERI (TKDN)</div>
            <ol>
                <li>PIHAK PERTAMA dan PIHAK KEDUA sepakat bahwa Nilai Perjanjian untuk seluruh pekerjaan yang tercakup dalam Perjanjian ini adalah sebesar <strong>Rp {{ number_format($nilaiAsli, 0, ',', '.') }} ({{ $nilai_terbilang }})</strong>, yang sudah termasuk pajak-pajak yang berlaku, dengan perincian sebagaimana diatur dalam Daftar Kuantitas dan Harga / Bill of Quantity (BOQ) yang merupakan Lampiran Perjanjian ini.</li>
                <li>Nilai pekerjaan ini adalah hasil kesepakatan antara PIHAK PERTAMA dan PIHAK KEDUA, dan sudah mencakup semua biaya yang diperlukan, termasuk risiko, overhead, pajak, serta pembayaran wajib lainnya yang sesuai dengan ketentuan yang berlaku.</li>
                <li>Apabila pekerjaan konstruksi maka pemotongan PPh kepada PIHAK KEDUA akan dilakukan sesuai dengan Peraturan Pemerintah Republik Indonesia No. 9 Tahun 2022 tentang Perubahan Kedua atas Peraturan Pemerintah Nomor 51 Tahun 2008 tentang Pajak Penghasilan atas Penghasilan dari Usaha Jasa Konstruksi.</li>
                <li>Kenaikan Harga dan Risiko
                    <ol class="alpha-list">
                        <li>Apabila selama pelaksanaan pekerjaan terjadi kenaikan harga yang terkait dengan pekerjaan ini, maka segala risiko yang timbul akibat kenaikan harga tersebut menjadi tanggung jawab PIHAK KEDUA, kecuali jika terjadi perubahan peraturan dari Pemerintah Pusat atau Pemerintah Daerah yang mempengaruhi harga material atau jasa yang digunakan dalam pelaksanaan pekerjaan.</li>
                        <li>Dalam hal terjadi perubahan peraturan atau ketentuan pajak yang menyebabkan perubahan harga yang signifikan, PIHAK KEDUA berhak mengajukan revisi harga sesuai dengan perubahan tersebut, yang harus mendapatkan persetujuan tertulis dari PIHAK PERTAMA.</li>
                    </ol>
                </li>
                <li>Tanggung Jawab atas Pajak dan Pungutan Lainnya
                    <ol class="alpha-list">
                        <li>Apabila Pemerintah Pusat maupun Daerah memungut pajak atau pungutan lainnya yang berkaitan dengan pekerjaan ini selama pelaksanaan Perjanjian, maka seluruh pajak atau pungutan tersebut menjadi tanggung jawab PIHAK KEDUA dan akan menjadi beban PIHAK KEDUA sepenuhnya.</li>
                        <li>PIHAK KEDUA wajib untuk melakukan pembayaran atas pajak dan pungutan tersebut sesuai dengan ketentuan yang berlaku tanpa menuntut biaya tambahan kepada PIHAK PERTAMA.</li>
                    </ol>
                </li>
                <li>Kenaikan Harga Satuan Material dan Jasa
                    <ol class="alpha-list">
                        <li>PIHAK KEDUA tidak dapat mengajukan permohonan kenaikan harga pekerjaan dalam Perjanjian ini yang telah disepakati, sebagaimana diatur dalam ayat (1) Pasal ini, yang disebabkan oleh kenaikan harga satuan material dan/atau jasa di pasaran, kecuali jika ada persetujuan atau penetapan dari PIHAK PERTAMA dan/atau Pemerintah terkait dengan kenaikan harga tersebut.</li>
                        <li>Setiap kenaikan harga yang disetujui oleh PIHAK PERTAMA akan dituangkan dalam Addendum Perjanjian dan akan diatur secara rinci mengenai mekanisme penyesuaian harga yang berlaku.</li>
                    </ol>
                </li>
                <li>Penggunaan Produk Dalam Negeri
                    <ol class="alpha-list">
                        <li>PIHAK KEDUA berkomitmen untuk meningkatkan penggunaan Produk Dalam Negeri dalam pelaksanaan pekerjaan ini sesuai dengan ketentuan yang berlaku di Indonesia.</li>
                        <li>PIHAK KEDUA wajib memenuhi persentase Tingkat Kandungan Dalam Negeri (TKDN) minimal sebesar 70% untuk barang dan jasa yang digunakan dalam pekerjaan ini, serta memberikan bukti dokumentasi yang sah mengenai TKDN apabila diperlukan oleh PIHAK PERTAMA.</li>
                        <li>Dalam hal tidak tercapainya TKDN yang disepakati, PIHAK KEDUA wajib memberikan penjelasan tertulis kepada PIHAK PERTAMA mengenai alasan ketidakmampuan tersebut dan langkah-langkah yang akan diambil untuk mematuhi ketentuan TKDN yang berlaku.</li>
                        <li>Pengenaan sanksi ketidaktercapaian TKDN akan diatur pada sala lain dalam perjanjian ini.</li>
                    </ol>
                </li>
                <li>Penyesuaian Nilai Pekerjaan<br>
                    PIHAK PERTAMA berhak untuk meninjau dan menyesuaikan nilai pekerjaan jika terdapat perubahan dalam kebijakan pemerintah yang secara langsung mempengaruhi biaya yang terkait dengan pekerjaan ini. Dalam hal hasil tinjauan tersebut diperlukan penyesuaian harga maka penyesuaian tersebut akan disepakati bersama dalam bentuk Addendum/amandemen dengan tata cara sesuai dengan ketentuan yang diatur dalam Pasal pada Perjanjian ini.
                </li>
            </ol>

            <div class="pasal-title">PASAL 11<br>TATA CARA DAN SYARAT PEMBAYARAN</div>
            <ol>
                <li>PIHAK PERTAMA tidak memberikan uang muka.</li>
                <li>Pelaksanaan pembayaran pekerjaan dilakukan setelah pekerjaan selesai 100% (seratus persen) dan diterima dengan baik oleh Pengguna barang/Jasa.</li>
                <li>Pelaksanaan setelah pekerjaan fisik selesai 100% (seratus persen) dilakukan oleh PIHAK PERTAMA dimana PIHAK KEDUA menyerahkan Jaminan pemeliharaan kepada PIHAK PERTAMA sesuai dengan ketentuan pada perjanjian ini.</li>
                <li>Pembayaran kepada PIHAK KEDUA akan dilakukan oleh PIHAK PERTAMA setelah PIHAK KEDUA mengajukan Surat Permohonan Pembayaran yang telah dilengkapi dengan dokumen-dokumen sebagai berikut:
                    <ol class="alpha-list">
                        <li>Surat Garansi Pemeliharaan dari PIHAK KEDUA.</li>
                        <li>Surat Permohonan Pembayaran yang mencakup, antara lain: nama bank, nomor rekening, dan atas nama pemilik rekening sesuai dengan yang tercantum dalam kontrak ini.</li>
                        <li>Invoice rangkap 3 (tiga), 1 (satu) asli bermeterai cukup dan 2 (dua) Salinan sesuai dengan format yang ditentukan oleh PIHAK PERTAMA.</li>
                        <li>Kwitansi tagihan dengan format VIP (Vendor Invoicing Portal) rangkap 3 (tiga), 1 (satu) asli bermeterai cukup dan 2 (dua) Salinan sesuai dengan format yang ditentukan oleh PIHAK PERTAMA.</li>
                        <li>Faktur Pajak yang sah, bila PIHAK KEDUA terdaftar sebagai Pengusaha Kena Pajak (PKP).</li>
                        <li>Salinan NPWP (Nomor Pokok Wajib Pajak) milik PIHAK KEDUA.</li>
                        <li>Salinan SKPKP (Surat Pengukuhan Pengusaha Kena Pajak), bila PIHAK KEDUA terdaftar sebagai PKP, atau jika PIHAK KEDUA merupakan perusahaan berstatus Non-PKP, maka PIHAK KEDUA melampirkan dokumen pernyataan Non-PKP terkini, yang ditanda tangani oleh pimpinan perusahaan.</li>
                        <li>Salinan Surat Perjanjian yang ditandatangani oleh kedua pihak.</li>
                        <li>Berita Acara Pemeriksaan Pekerjaan (BAPP) yang ditandatangani oleh Direksi Pekerjaan dan Pelaksana Pekerjaan untuk setiap tahapan pembayaran, rangkap 2 (dua) bermaterai, dengan format yang disediakan oleh PIHAK PERTAMA.</li>
                        <li>Berita Acara Serah Terima Pekerjaan (BASTP) yang bermeterai, ditandatangani oleh Pengguna Barang/Jasa dan Pelaksana Pekerjaan untuk setiap tahapan pembayaran, rangkap 2 (dua), dengan format yang disediakan oleh PIHAK PERTAMA.</li>
                        <li>Berita Acara Pembayaran rangkap 2 (dua): (lembar 1 bermeterai di pihak 1, lembar 2 bermeterai di pihak 2), dengan format yang disediakan oleh PIHAK PERTAMA.</li>
                        <li>Laporan Pelaksanaan Pekerjaan yang ditandatangani oleh PIHAK KEDUA, mencakup kemajuan pekerjaan yang telah dilaksanakan (sesuai kebutuhan PIHAK PERTAMA).</li>
                    </ol>
                </li>
                <li>Pembayaran pekerjaan akan dilakukan oleh PIHAK PERTAMA melalui transfer ke rekening PIHAK KEDUA yang telah disepakati sebelumnya, sebagai berikut:<br>
                    Nama : <strong>{{ $cv_pihak2 }}</strong><br>
                    Nomor Rekening : <strong>{{ $no_rek }}</strong><br>
                    Bank : <strong>{{ $nama_bank }}</strong><br>
                    NPWP : <strong>{{ $npwp }}</strong>
                </li>
                <li>Pembayaran akan dilakukan setelah seluruh dokumen yang tercantum dalam ayat 4 diserahkan dan diterima oleh PIHAK PERTAMA dalam keadaan lengkap dan sesuai dengan ketentuan yang berlaku.</li>
                <li>Dalam hal terjadi kelebihan pembayaran sebagaimana dimaksud dalam Perjanjian ini, PIHAK KEDUA wajib mengembalikan kelebihan pembayaran tersebut kepada PIHAK PERTAMA dalam rentang waktu yang ditentukan oleh PIHAK PERTAMA.</li>
            </ol>

            <div class="pasal-title">PASAL 12<br>BEA MATERAI, PAJAK, DAN PUNGUTAN LAINNYA</div>
            <ol>
                <li>Bea Meterai<br>
                    Setiap dokumen yang dibuat dan ditandatangani berdasarkan Perjanjian ini yang diwajibkan untuk dibubuhi Meterai sesuai dengan ketentuan peraturan perundang-undangan yang berlaku di Indonesia, maka akan dikenakan Bea Meterai sesuai dengan tarif yang berlaku pada saat penerbitan dan/atau penandatanganan dokumen tersebut dan Bea Meterai tersebut menjadi tanggung jawab PIHAK KEDUA.
                </li>
                <li>Pajak<br>
                    Semua pajak yang timbul sehubungan dengan pelaksanaan Perjanjian ini, termasuk namun tidak terbatas pada PPN, PPh, dan pungutan lain yang diwajibkan oleh peraturan perundang-undangan yang berlaku di Indonesia, akan menjadi tanggung jawab PIHAK KEDUA, kecuali ditentukan lain dalam peraturan yang berlaku.<br>
                    Dalam hal PIHAK PERTAMA sesuai dengan kewenangannya melakukan pemungutan pajak terhadap PIHAK KEDUA, maka PIHAK KEDUA dapat meminta bukti pemotongan tersebut kepada PIHAK PERTAMA.
                </li>
                <li>Pungutan Lainnya<br>
                    Dalam hal terdapat pungutan atau biaya lainnya yang timbul sehubungan dengan pelaksanaan Perjanjian ini yang ditetapkan oleh pemerintah atau lembaga berwenang lainnya, maka seluruh pungutan dan biaya tersebut akan menjadi tanggung jawab sepenuhnya PIHAK KEDUA, kecuali disepakati lain oleh PARA PIHAK dalam Perjanjian ini.<br>
                    PIHAK KEDUA wajib memastikan bahwa seluruh kewajiban terkait pungutan tersebut dipenuhi sesuai dengan ketentuan peraturan yang berlaku.
                </li>
            </ol>

            <div class="pasal-title">PASAL 13<br>PEKERJAAN TAMBAH KURANG</div>
            <ol>
                <li>Kebutuhan Pekerjaan Tambah
                    <ol class="alpha-list">
                        <li>Pekerjaan tambah atau kurang adalah pekerjaan yang timbul selama pelaksanaan perjanjian ini yang bersifat mendesak, tidak dapat diprediksi pada awal pelaksanaan, dan memerlukan perubahan dalam ruang lingkup pekerjaan yang telah disepakati sebelumnya</li>
                        <li>PARA PIHAK berhak mengajukan permohonan usulan pekerjaan tambah atau kurang berdasarkan data lapangan yang valid atau kajian yang dapat dipertanggungjawabkan secara teknis dan finansial untuk menilai kelayakan pekerjaan tambah atau pengurangan tersebut. Permohonan ini harus disampaikan secara tertulis dan dilengkapi dengan justifikasi teknis dan estimasi biaya.</li>
                        <li>Setiap pekerjaan tambah atau kurang yang disepakati oleh PARA PIHAK harus dituangkan secara rinci dalam addendum atau amandemen perjanjian yang disetujui bersama dan ditandatangani oleh PARA PIHAK. Addendum atau amandemen tersebut menjadi bagian yang tidak terpisahkan dari perjanjian ini.</li>
                        <li>PIHAK KEDUA wajib melaksanakan semua pekerjaan tambahan sesuai dengan kualitas, standar, dan jadwal yang telah disepakati sebelumnya dalam kontrak ini, dan berhak untuk menerima pembayaran sesuai dengan perubahan yang disetujui oleh kedua belah pihak.</li>
                        <li>Pekerjaan tambahan yang dilaksanakan tanpa adanya persetujuan tertulis atau yang tidak disepakati dalam addendum atau amandemen perjanjian tidak akan dianggap sah. Dalam hal ini, PIHAK PERTAMA tidak berkewajiban untuk melakukan pembayaran atau penyesuaian terkait pekerjaan tersebut. Semua pekerjaan tambahan yang tidak disetujui akan menjadi tanggung jawab PIHAK KEDUA.</li>
                        <li>Bilamana terjadi perubahan yang mengakibatkan pengurangan volume dan/atau jenis pekerjaan dari perjanjian yang telah disepakati, maka pengurangan ini tidak dapat digunakan sebagai dasar tuntutan ganti rugi atau tuntutan atas hilangnya keuntungan PIHAK KEDUA.</li>
                        <li>PIHAK KEDUA wajib menerima hasil pengurangan volume dan nilai pekerjaan sesuai dengan pekerjaan kurang yang telah disepakati.</li>
                    </ol>
                </li>
            </ol>

            <div class="pasal-title">PASAL 14<br>ADDENDUM/AMANDEMEN PERJANJIAN</div>
            <ol>
                <li>Addendum atau amandemen perjanjian harus segera dibuat apabila terdapat penambahan atau perubahan terhadap perjanjian ini dan hanya dapat dilakukan berdasarkan kesepakatan bersama antara PARA PIHAK.</li>
                <li>Setiap perubahan yang dibuat dalam bentuk addendum atau amandemen akan menjadi bagian yang tidak terpisahkan dari perjanjian ini.</li>
                <li>Addendum atau amandemen perjanjian dapat dilakukan apabila terdapat kondisi-kondisi berikut:
                    <ol class="alpha-list">
                        <li>Perubahan volume, jenis, atau lingkup pekerjaan.</li>
                        <li>Perubahan spesifikasi teknis pekerjaan.</li>
                        <li>Perubahan harga perjanjian/kontrak.</li>
                        <li>Perubahan jadwal pelaksanaan pekerjaan sesuai dengan kebutuhan lapangan atau faktor lain yang mempengaruhi kelancaran pelaksanaan pekerjaan.</li>
                        <li>Perubahan ketentuan atau peraturan yang berlaku yang berdampak pada pelaksanaan perjanjian ini.</li>
                    </ol>
                </li>
                <li>Prosedur pembuatan addendum atau amandemen perjanjian dilakukan sebagai berikut:
                    <ol class="alpha-list">
                        <li>PIHAK PERTAMA memberikan perintah tertulis kepada PIHAK KEDUA untuk melaksanakan perubahan perjanjian, atau PIHAK KEDUA mengusulkan perubahan tersebut kepada PIHAK PERTAMA.</li>
                        <li>Surat perintah atau Usulan perubahan harus diajukan salah satu pihak kepada pihak lainnya dengan jangka waktu yang wajar sebelum diberlakukannya kesepakatan perubahan yang diusulkan, dan dilakukan sebelum berakhirnya pelaksanaan pekerjaan.</li>
                        <li>Atas usulan perubahan perjanjian tersebut, selanjutnya dilakukan pembahasan oleh PARA PIHAK dan dituangkan kedalam suatu dokumen yang disepakati PARA PIHAK sebagai dasar pembuatan addendum atau amandemen perjanjian yang disepakati oleh PARA PIHAK.</li>
                    </ol>
                </li>
                <li>Addendum / Amandemen kontrak hanya dapat dilakukan atas dasar kesepakatan bersama antara PIHAK PERTAMA dan PIHAK KEDUA dan tidak boleh bertentangan dengan ketentuan yang telah diatur dalam dokumen pengadaan ini.</li>
                <li>Addendum atau amandemen yang disepakati dan ditandatangani oleh PARA PIHAK menjadi bagian yang tidak terpisahkan dari perjanjian ini dan memiliki kekuatan hukum yang sama dengan perjanjian ini.</li>
            </ol>

            <div class="pasal-title">PASAL 15<br>JAMINAN, GARANSI, DAN MASA PEMELIHARAAN</div>
            <ol>
                <li>Jaminan
                    <ol class="alpha-list">
                        <li>Apabila dibutuhkan oleh PIHAK PERTAMA maka PIHAK KEDUA bersedia memberikan Jaminan Pelaksanaan dengan ketentuan yang berlaku.</li>
                        <li>Seluruh besaran dan jenis jaminan yang disebutkan dalam perjanjian ini akan disesuaikan dengan ketentuan yang berlaku.</li>
                        <li>Semua jaminan yang disebutkan dalam perjanjian ini harus diberikan dalam bentuk yang dapat diterima oleh PIHAK PERTAMA dan dikeluarkan oleh lembaga yang sah serta terdaftar di Indonesia.</li>
                        <li>Jaminan yang diberikan oleh PIHAK KEDUA harus tetap berlaku dan dapat dicairkan sesuai dengan ketentuan dalam perjanjian ini hingga seluruh kewajiban PIHAK KEDUA terhadap PIHAK PERTAMA terpenuhi sepenuhnya.</li>
                        <li>PIHAK PERTAMA berhak menuntut klaim terhadap jaminan jika PIHAK KEDUA tidak memenuhi kewajibannya sesuai dengan kontrak ini.</li>
                    </ol>
                </li>
                <li>Garansi Dan Masa Pemeliharaan
                    <ol class="alpha-list">
                        <li>PIHAK KEDUA memberikan garansi dan masa pemeliharaan terhadap kualitas hasil pekerjaan yang telah diselesaikan selama jangka waktu tertentu yang disepakati, dimulai dari tanggal penerimaan pekerjaan oleh PIHAK PERTAMA</li>
                        <li>Lingkup Garansi dan Masa Pemeliharaan mencakup pemeliharaan dan perbaikan pekerjaan yang rusak atau tidak sesuai dengan spesifikasi yang telah disepakati, tanpa biaya tambahan bagi PIHAK PERTAMA, apabila kerusakan terjadi dalam periode garansi yang disepakati.</li>
                        <li>Jangka waktu garansi dan masa pemeliharaan terhitung setelah penerimaan pekerjaan dan berlaku sesuai dengan kesepakatan antara PARA PIHAK yaitu 3 (tiga) bulan terhitung sejak serah terima pekerjaan.</li>
                        <li>Prosedur Klaim Garansi: Jika dalam masa garansi ditemukan kerusakan atau cacat pada pekerjaan, PIHAK PERTAMA dapat mengajukan klaim garansi secara tertulis kepada PIHAK KEDUA. PIHAK KEDUA wajib memperbaiki atau mengganti pekerjaan tersebut dalam jangka waktu yang disepakati oleh PARA PIHAK hingga produk yang di supply ke PIHAK PERTAMA telah memenuhi spesifikasi yang tercantum dalam perjanjian ini.</li>
                        <li>Tanggung Jawab Garansi: PIHAK KEDUA bertanggung bertanggung sepenuhnya terhadap perbaikan atau penggantian pekerjaan yang cacat selama periode garansi dan masa pemeliharaan serta menanggung segala biaya yang timbul dari perbaikan tersebut.</li>
                        <li>PIHAK KEDUA akan melakukan pekerjaan pemeliharaan selama 90 (Sembilan Puluh) hari kalender terhitung sejak dilakukannya Serah Terima Pekerjaan 100% (seratus persen) atau selesai dan bebas dari segala kerusakan sampai sekurang-kurangnya sampai dengan diterbitkannya Berita Acara Selesainya Masa Pemeliharaan/Defect Liability Certificate (DLC).</li>
                        <li>Apabila dalam masa pemeliharaan sebagaimana dimaksud dalam ayat 2.f terjadi kerusakan Pekerjaan Peningkatan Sarana Laboratorium sebagai akibat kesalahan teknis pelaksanaan atau kesalahan lainnya pada waktu pelaksanaan pekerjaan dikarenakan kelalaian PIHAK KEDUA, maka PIHAK KEDUA diwajibkan memperbaiki.</li>
                        <li>Apabila PIHAK KEDUA tidak melakukan perbaikan atau tidak mengganti kerusakan pekerjaan sebagaimana dimaksud dalam ayat 2.g pasal ini, maka PIHAK PERTAMA atau Direksi Pekerjaan</li>
                        <li>Perbaikan harus dilakukan 7 (tujuh) hari kalender sejak tanggal pemberitahuan.</li>
                        <li>Sanksi berupa blacklist bagi PIHAK KEDUA barang dan jasa apabila tidak melaksanakan eksekusi perbaikan maupun pemeliharaan perangkat terpasang.</li>
                        <li>Biaya-biaya yang diperlukan untuk perbaikan atau penggantian kerusakan sebagaimana dimaksud dalam ayat 2.g atau pasal 2.h menjadi beban dan tanggung jawab PIHAK KEDUA.</li>
                    </ol>
                </li>
            </ol>

            <div class="pasal-title">PASAL 16<br>WANPRESTASI, PENGHENTIAN SEMENTARA, PENGAKHIRAN DAN PEMUTUSAN PERJANJIAN</div>
            <ol>
                <li>Setiap wanprestasi yang dilakukan PIHAK KEDUA akan mengikuti ketentuan di bawah ini:
                    <ol class="alpha-list">
                        <li>Peristiwa Wanprestasi yang Tidak Dapat Diperbaiki oleh PIHAK KEDUA adalah sebagai berikut:
                            <ol class="roman-list">
                                <li>PIHAK KEDUA terbukti melakukan tindak pidana antara lain adanya pemalsuan surat / dokumen, praktek persekongkolan, kecurangan dan pemalsuan yang berkaitan dengan proses pengadaan, pelaksanaan Perjanjian dan pelaksanaan Pekerjaan.</li>
                                <li>Berdasarkan putusan Pengadilan yang telah mempunyai kekuatan hukum tetap, PIHAK KEDUA dinyatakan dalam keadaan pailit, pembubaran, likuidasi atau diberikan penundaan pembayaran hutang yang menyebabkan PIHAK KEDUA tidak dapat melakukan kewajibannya berdasarkan Perjanjian ini.</li>
                                <li>Penyedia terbukti dikenakan Sanksi Daftar Hitam sebelum penandatanganan Perjanjian.</li>
                                <li>Setiap pernyataan atau jaminan yang dibuat oleh PIHAK KEDUA di dalam Perjanjian ini yang berkaitan dengan pelaksanaan Pekerjaan terbukti tidak sah dan/atau tidak dilaksanakan oleh PIHAK KEDUA.</li>
                            </ol>
                        </li>
                        <li>Peristiwa Wanprestasi yang Dapat Diperbaiki oleh PIHAK KEDUA adalah sebagai berikut:
                            <ol class="roman-list">
                                <li>PIHAK KEDUA mengalihkan Pekerjaan baik sebagian atau seluruhnya atau hak atau kewajiban yang diatur dalam Perjanjian ini tanpa persetujuan tertulis dari PIHAK PERTAMA.</li>
                                <li>Apabila denda yang diatur dalam Perjanjian ini tidak dibayar oleh PIHAK KEDUA kepada PIHAK PERTAMA.</li>
                                <li>PIHAK KEDUA tidak memenuhi kewajibannya sesuai ketentuan yang diatur dalam Perjanjian ini.</li>
                            </ol>
                        </li>
                    </ol>
                </li>
                <li>Dalam hal terjadi Peristiwa Wanprestasi yang Tidak Dapat Diperbaiki oleh PIHAK KEDUA sebagaimana dimaksud Ayat (1) huruf a Pasal ini, maka PIHAK PERTAMA akan mengakhiri Perjanjian ini dengan memberikan surat pengakhiran Perjanjian kepada PIHAK KEDUA.</li>
                <li>Dalam hal terjadi Peristiwa Wanprestasi yang Dapat Diperbaiki oleh PIHAK KEDUA sebagaimana dimaksud Ayat (1) huruf b. Pasal ini, PIHAK PERTAMA berhak mengakhiri Perjanjian ini dengan memberikan surat peringatan, dengan ketentuan sebagai berikut:
                    <ol class="alpha-list">
                        <li>PIHAK PERTAMA akan memberikan PERINGATAN TERTULIS PERTAMA kepada PIHAK KEDUA dengan perintah pemulihan wajib diselesaikan oleh PIHAK KEDUA dalam waktu 10 (sepuluh) Hari Kalender setelah tanggal diterimanya peringatan PIHAK PERTAMA oleh PIHAK KEDUA dan PIHAK KEDUA wajib menyampaikan pemberitahuan tertulis yang wajib dilengkapi dengan bukti pendukung kepada PIHAK PERTAMA bahwa pemulihan atau perbaikan tersebut akan, sedang, atau telah dilaksanakan oleh PIHAK KEDUA.</li>
                        <li>Apabila PIHAK KEDUA tidak menyelesaikan pemulihan atau perbaikan dalam waktu 10 (sepuluh) Hari Kalender sesuai ayat (3) huruf a. Pasal ini, maka PIHAK PERTAMA akan memberikan PERINGATAN TERTULIS KEDUA kepada PIHAK KEDUA dengan perintah pemulihan wajib diselesaikan oleh PIHAK KEDUA dalam waktu 10 (sepuluh) Hari Kalender setelah tanggal diterimanya peringatan oleh PIHAK KEDUA dan PIHAK KEDUA wajib menyampaikan pemberitahuan tertulis yang wajib dilengkapi dengan bukti pendukung kepada PIHAK PERTAMA bahwa pemulihan atau perbaikan tersebut akan, sedang atau telah dilaksanakan oleh PIHAK KEDUA.</li>
                        <li>Apabila PIHAK KEDUA tidak menyelesaikan pemulihan atau perbaikan dalam waktu 10 (sepuluh) Hari Kalender sebagaimana dimaksud pada ayat (3) huruf b. Pasal ini, maka PIHAK PERTAMA akan memberikan PERINGATAN TERTULIS KETIGA kepada PIHAK KEDUA dengan perintah pemulihan wajib diselesaikan oleh PIHAK KEDUA dalam waktu 10 (sepuluh) Hari Kalender setelah tanggal diterimanya peringatan dan PIHAK KEDUA wajib menyampaikan pemberitahuan tertulis yang wajib dilengkapi dengan bukti pendukung kepada PIHAK PERTAMA bahwa pemulihan atau perbaikan tersebut akan, sedang atau telah dilaksanakan oleh PIHAK KEDUA.</li>
                    </ol>
                </li>
                <li>Dalam hal PIHAK KEDUA telah melakukan pemulihan atau perbaikan sebagaimana dimaksud pada ayat (3) huruf a Pasal ini, dan pemulihan atau perbaikan tersebut disetujui oleh PIHAK PERTAMA maka peringatan tertulis yang telah diterbitkan tersebut tidak akan diperhitungkan sebagai pemberian Peringatan yang berkelanjutan atau tidak berlaku kumulatif pada pemberian Peringatan berikutnya.</li>
                <li>Dalam hal terjadi Peristiwa Wanprestasi PIHAK KEDUA, maka PIHAK KEDUA akan dikenakan hukuman / denda sesuai ketentuan Perjanjian ini.</li>
                <li>PIHAK PERTAMA akan memberlakukan hukuman daftar hitam (blacklist) bagi setiap pengakhiran Perjanjian yang disebabkan karena wanprestasi PIHAK KEDUA sebagaimana diatur lebih lanjut dalam ketentuan yang berlaku pada PIHAK PERTAMA.</li>
                <li>Penghentian Sementara, Pengakhiran Dan Pemutusan Perjanjian:
                    <ol class="alpha-list">
                        <li>Perjanjian ini akan berakhir sesuai dengan jangka waktu yang telah ditetapkan atau setelah terpenuhinya seluruh Hak dan Kewajiban PARA PIHAK sebagaimana diatur dalam perjanjian ini.</li>
                        <li>Kesepakatan penghentian sementara Perjanjian (suspension of contract) atau kesepakatan pengakhiran Perjanjian dapat dilakukan dalam hal terjadi Keadaan Kahar (Force Majeure) atau terjadi keadaan lain yang mengakibatkan PARA PIHAK tidak dapat melaksanakan kewajibannya.</li>
                        <li>Pemutusan Perjanjian (termination of contract) dapat dilakukan dalam hal PARA PIHAK tidak memenuhi kewajiban dan tanggung jawabnya sebagaimana diatur dalam Perjanjian.</li>
                        <li>PIHAK PERTAMA dapat memutuskan Perjanjian secara sepihak, apabila besaran denda keterlambatan waktu pelaksanaan pekerjaan sudah melampaui 5% (lima persen) dari nilai Pekerjaan. PIHAK PERTAMA dapat mempertimbangkan pemberian kesempatan kepada PIHAK KEDUA untuk menyelesaikan Pekerjaan, namun dengan tetap mengenakan denda keterlambatan maksimal ditambah dengan denda sanksi K3 (apabila terjadi).</li>
                        <li>Pemutusan Perjanjian yang disebabkan oleh kesalahan PIHAK KEDUA, maka PIHAK KEDUA dapat dikenakan sanksi berupa kewajiban mengganti kerugian yang menimpa PIHAK PERTAMA sesuai dengan yang ditetapkan dalam Perjanjian.</li>
                        <li>Dalam hal terjadi pengakhiran sebagaimana yang dimaksud dalam Pasal 15 ini, maka pengakhiran tersebut tidak melepaskan kewajiban-kewajiban pada masing-masing pihak untuk memenuhi setiap dan seluruh kewajiban tertunggak atau yang belum diselesaikan kepada pihak lainnya sebelum pengakhiran berdasarkan Perjanjian ini. Dalam hal ini, PIHAK KEDUA berhak untuk mendapatkan pembayaran dari PIHAK PERTAMA atas Pekerjaan yang telah diselesaikan sampai dengan tanggal efektif pengakhiran Perjanjian ini.</li>
                    </ol>
                </li>
                <li>Atas setiap pengakhiran dari Perjanjian ini, seluruh kewajiban-kewajiban masing-masing pihak berdasarkan Perjanjian ini wajib berhenti, kecuali:
                    <ol class="alpha-list">
                        <li>Sehubungan dengan kewajiban-kewajiban pembayaran yang ditimbulkan dari tindakan-tindakan yang diambil sebelum pengakhiran tersebut (termasuk namun tidak terbatas pada hak normatif Pekerja PIHAK KEDUA).</li>
                        <li>Sebagaimana ditentukan lain dalam Perjanjian ini.</li>
                        <li>Pengakhiran tersebut tidak akan mengurangi setiap hak atas ganti rugi atau setiap perbaikan lainnya yang mungkin dimiliki oleh masing-masing pihak berdasarkan Perjanjian ini.</li>
                    </ol>
                </li>
                <li>Terhadap pengakhiran perjanjian ini, PARA PIHAK sepakat untuk tidak memberlakukan ketentuan Pasal 1266 dan 1267 Kitab Undang-Undang Hukum Perdata.</li>
            </ol>

            <div class="pasal-title">PASAL 17<br>DENDA DAN PENGENAAN SANKSI DAFTAR HITAM (BLACKLIST)</div>
            <ol>
                <li>Sanksi / Denda Keterlambatan Pelaksanaan Pekerjaan<br>
                    Dalam hal PIHAK KEDUA terlambat menyelesaikan pekerjaannya sesuai dengan batas waktu yang telah ditentukan, maka akan dikenakan denda keterlambatan sebesar 1‰ (satu per seribu) dari perjanjian / kontrak untuk setiap hari keterlambatan dan maksimum sebesar jaminan pelaksanaan atau 5% dari harga total pekerjaan.
                </li>
                <li>Sanksi sebagai mana ayat 1 pasal ini akan diberikan kepada PIHAK KEDUA apabila PIHAK KEDUA tidak menyelesaikan Pekerjaan sesuai dengan waktu pelaksanaan pekerjaan dalam ketentuan Perjanjian ini yang disebabkan kesalahan dari PIHAK KEDUA.</li>
                <li>Sanksi / Denda Atas Tidak Tercapainya TKDN<br>
                    Apabila dalam pelaksanaan pekerjaan tidak mencapai nilai TKDN yang telah ditetapkan dalam perjanjian / kontrak maka PIHAK KEDUA akan dikenakan sanksi TKDN yang berlaku di PT PLN (Persero) berupa :
                    <ol class="alpha-list">
                        <li>Pelaporan PT PLN (Persero) atas ketidakcapaian kepada Kemeterian / Lembaga terkait sesuai prosedure yang berlaku di PT PLN (Persero) dan/atau;</li>
                        <li>Penghentian pekerjaan yang dilaksanakan PIHAK KEDUA tersebut dan/atau;</li>
                        <li>Kewajiban PIHAK KEDUA untuk memperbaiki pekerjaan yang dilakukan sehingga dapat tercapai nilai TKDN sesuai dengn yang ditetapkan.</li>
                    </ol>
                </li>
                <li>Cara pembayaran sanksi dan denda keterlambatan oleh PIHAK KEDUA kepada PIHAK PERTAMA sebagaimana dimaksud pada ayat (1) Pasal ini adalah dengan cara memotong langsung dari jumlah pembayaran yang belum dilaksanakan oleh PIHAK PERTAMA kepada PIHAK KEDUA. Dalam hal tagihan PIHAK KEDUA tidak mencukupi, PIHAK PERTAMA berhak untuk mencairpkan Jaminan Pelaksanaan (apabila ada).</li>
                <li>Sanksi berupa denda keterlambatan dalam Pasal ini tidak diberlakukan apabila terjadinya Keadaan Kahar (Force Majeure) sebagaimana diatur di dalam ketentuan Perjanjian ini.</li>
                <li>Pelaksanaan sanksi denda sebagaimana dimaksud dalam Pasal ini tidak menimbulkan hak bagi PIHAK KEDUA untuk menuntut ganti rugi dalam bentuk apapun kepada PIHAK PERTAMA.</li>
                <li>Pengenaan Sanksi Daftar Hitam (Blacklist)</li>
                <li>PIHAK PERTAMA akan memberlakukan hukuman daftar hitam (blacklist) bagi setiap pengakhiran Perjanjian yang disebabkan karena wanprestasi PIHAK KEDUA sebagaimana diatur lebih lanjut dalam ketentuan yang berlaku pada PIHAK PERTAMA.</li>
                <li>Jenis dan tata cara pengenaan wanprestasi diatur dalam pasal lain dalam perjanjian ini.</li>
            </ol>

            <div class="pasal-title">PASAL 18<br>HARDSHIP / FORCE MAJEURE</div>
            <ol>
                <li>Dalam hal PIHAK KEDUA mengalami Keadaan Kahar, maka wajib:
                    <ol class="alpha-list">
                        <li>Memberitahukan secara lisan kepada PIHAK PERTAMA dalam jangka waktu paling lama 1x24 (satu kali dua puluh empat) jam sejak diketahui terjadinya peristiwa, Diikuti dengan pemberitahuan tertulis yang disertai dokumen atau bukti resmi dari instansi berwenang paling lambat 3 (tiga) Hari Kerja setelah pemberitahuan lisan tersebut.</li>
                        <li>PIHAK KEDUA wajib tetap berupaya melakukan tindakan mitigasi secara maksimal agar dampak Keadaan Kahar dapat diminimalkan, termasuk mempertahankan bagian pekerjaan yang masih dapat dilaksanakan.</li>
                        <li>Setelah menerima pemberitahuan dari PIHAK KEDUA, PIHAK PERTAMA wajib memberikan tanggapan tertulis paling lambat 7 (tujuh) Hari Kerja, termasuk mempertimbangkan penyesuaian jadwal, pengurangan lingkup kerja, atau langkah lain yang diperlukan dengan tetap mengedepankan prinsip keadilan dan keberlanjutan pelaksanaan pekerjaan.</li>
                        <li>Selama masa Keadaan Kahar berlangsung, keterlambatan pelaksanaan pekerjaan oleh PIHAK KEDUA yang dapat dibuktikan sebagai akibat langsung dari Keadaan Kahar tidak dikenakan sanksi atau denda keterlambatan.</li>
                        <li>Keadaan Kahar (Force Majeure) ini tidak termasuk hal-hal yang merugikan yang disebabkan oleh perbuatan atau kelalaian PARA PIHAK.</li>
                        <li>PIHAK KEDUA berhak mengajukan permohonan perpanjangan waktu pelaksanaan (time extension) secara tertulis kepada PIHAK PERTAMA dengan melampirkan dokumen pendukung, dan PIHAK PERTAMA wajib melakukan penilaian secara objektif terhadap permohonan tersebut.</li>
                        <li>Keterlambatan pelaksanaan pekerjaan yang diakibatkan oleh karena terjadinya Keadaan Kahar (Force Majeure) tidak dapat dikenai sanksi.</li>
                        <li>Setiap kerugian yang timbul akibat Keadaan Kahar akan menjadi tanggung jawab pihak yang mengalaminya dan tidak dapat dibebankan kepada pihak lainnya, kecuali ditentukan lain dalam addendum atau kesepakatan bersama secara tertulis.</li>
                    </ol>
                </li>
                <li>Dalam hal PIHAK KEDUA mengalami Keadaan Sulit/ Hardship, maka PIHAK KEDUA dapat melaksanakan permohonan penyesuaian perjanjian kepada PIHAK PERTAMA dengan Langkah sebagai berikut:
                    <ol class="alpha-list">
                        <li>PIHAK KEDUA Menyampaikan pemberitahuan tertulis kepada PIHAK PERTAMA disertai uraian lengkap dan bukti pendukung yang sah dan dapat dipertanggung jawabkan.</li>
                        <li>PIHAK KEDUA dapat Mengajukan usulan penyesuaian kontrak secara tertulis untuk pembaharuan harga satuan, perpanjangan waktu pekerjaan ataupun lingkup yang terdampak.</li>
                        <li>PIHAK PERTAMA wajib memberikan tanggapan tertulis paling lambat 14 (empat belas) Hari Kalender sejak tanggal diterimanya pemberitahuan. Tanggapan dapat berupa persetujuan, penolakan, atau permintaan klarifikasi tambahan.</li>
                        <li>Dalam hal PIHAK PERTAMA Menolak surat permohonan maka PIHAK KEDUA tetap melaksanakan pekerjaan sesuai dengan kontrak yang disepakati.</li>
                        <li>Dalam hal PIHAK PERTAMA menyetujui keadaan sulit / Hardship, maka PARA PIHAK dapat berunding untuk dilakukan penyesuaian perjanjian dan dituangkan kedalam addendum/amandemen perjanjian.</li>
                        <li>Dalam hal terjadi pembaharuan harga dilakukan sesuai kesepakatan antara PARA PIHAK berdasarkan harga pasar yang berlaku melalui proses Negosiasi.</li>
                        <li>Apabila dalam waktu 30 (tiga puluh) Hari Kalender sejak dimulainya negosiasi tidak tercapai kesepakatan maka selanjutnya akan diatur pada pasal lain dalam perjanjian ini (penyelesaian perselisihan).</li>
                    </ol>
                </li>
            </ol>

            <div class="pasal-title">PASAL 19<br>PERPANJANGAN JANGKA WAKTU PELAKSANAAN PEKERJAAN</div>
            <ol>
                <li>Perpanjangan jangka waktu pelaksanaan Pekerjaan dapat diberikan oleh PIHAK PERTAMA kepada PIHAK KEDUA atas pertimbangan yang layak dan wajar dan dapat dipertanggung jawabkan secara teknis dan administrasi.</li>
                <li>Yang dimaksud hal-hal yang layak dan wajar untuk perpanjangan jangka waktu pelaksanaan Pekerjaan adalah sebagai berikut:
                    <ol class="alpha-list">
                        <li>Terjadi pekerjaan tambah.</li>
                        <li>Terjadi perubahan desain.</li>
                        <li>Keadaan Kahar (Force Majeure)</li>
                        <li>Keadaan suli (hardship)</li>
                        <li>Keterlambatan yang disebabkan oleh PIHAK PERTAMA.</li>
                        <li>Masalah yang timbul di luar kendali PIHAK KEDUA yang dilengkapi dengan dokumen pendukung sebagai justifikasi dari Pihak Eksternal yang memiliki otoritas dan PIHAK PERTAMA dapat menyetujui perpanjangan jangka waktu pelaksanaan Perjanjian setelah melakukan penelitian dan evaluasi terhadap usulan tertulis yang diajukan oleh PIHAK KEDUA atau PIHAK PERTAMA yang dibuktikan dengan persetujuan secara tertulis selambat-lambatnya 7 (tujuh) hari kalender sejak diterimanya surat permohonan usulan perpanjangan jangka waktu.</li>
                        <li>Keadaan Kahar (Force Majeure).</li>
                    </ol>
                </li>
                <li>Pihak yang menghendaki perpanjangan jangka waktu pelaksanaan Perjanjian harus melakukan usulan secara tertulis kepada pihak lainnya dalam waktu yang cukup sebelum perubahan atau penambahan dengan menyampaikan alasan-alasan perpanjangan jangka waktu Perjanjian ini.</li>
                <li>PIHAK PERTAMA dapat menyetujui perpanjangan jangka waktu pelaksanaan Perjanjian untuk ayat (2) dan evaluasi terhadap usulan tertulis yang diajukan oleh PIHAK KEDUA atau PIHAK PERTAMA yang dibuktikan dengan persetujuan tertulis.</li>
                <li>PARA PIHAK harus membuat evaluasi secara teknis dan administrasi serta Berita Acara Evaluasi yang ditandatangani oleh wakil PARA PIHAK dalam hal ini untuk PIHAK PERTAMA oleh Direksi Pekerjaan.</li>
                <li>Apabila perpanjangan jangka waktu Perjanjian telah memenuhi ketentuan uraian yang diatur dalam Pasal ini, persetujuan perpanjangan jangka waktu pelaksanaan Perjanjian dituangkan di dalam Adendum / Amandemen Perjanjian dan harus ditandatangani oleh PARA PIHAK, yang merupakan satu kesatuan dengan Perjanjian ini.</li>
            </ol>

            <div class="pasal-title">PASAL 20<br>HAK PATEN, HAK CIPTA, HAK KEKAYAAN INTELEKTUAL, DAN MEREK</div>
            <p class="justify">Apabila diperlukan maka diatur sebagai berikut tetapi tidak terbatas pada:</p>
            <ol class="alpha-list">
                <li>Hak cipta dan/atau hak merek yang timbul dari pekerjaan yang dikerjakan atau hasil dari pekerjaan yang dilakukan oleh PIHAK KEDUA berdasarkan Perjanjian ini akan menjadi milik PIHAK PERTAMA. Namun, PIHAK KEDUA tetap memiliki hak untuk menggunakan dan memanfaatkan hak cipta dan/atau hak merek tersebut untuk tujuan yang relevan dengan pelaksanaan pekerjaan dan portofolio mereka, dengan persetujuan tertulis dari PIHAK PERTAMA.</li>
                <li>PIHAK KEDUA tidak akan mengklaim kepemilikan atas hak cipta dan/atau hak merek dari materi atau hasil kerja yang dihasilkan berdasarkan Perjanjian ini. PIHAK PERTAMA berhak untuk menggunakan hak-hak tersebut sesuai dengan tujuan dan kepentingan Perjanjian ini, sementara PIHAK KEDUA memiliki hak terbatas untuk penggunaan terkait portofolio dan penunjukan jasa, dengan persetujuan PIHAK PERTAMA.</li>
                <li>PARA PIHAK setuju bahwa hak kekayaan atas intelektual pada seluruh material atau dokumen yang ada akan dan tetap menjadi milik pihak yang berhak dan tidak ada satu ketentuan berdasarkan Perjanjian ini yang bermaksud untuk mengalihkan hak atas kekayaan intelektual (HAKI) dan hak cipta milik salah satu pihak kepada pihak lainnya.</li>
                <li>PARA PIHAK sepakat untuk tunduk pada ketentuan peraturan perundang-undangan yang berlaku terhadap Hak Atas Kekayaan Intelektual.</li>
                <li>Tanpa mengurangi ketentuan dalam ayat a. di atas, PIHAK KEDUA dan afiliasinya berhak untuk memasukkan pekerjaan yang dilaksanakan untuk PIHAK PERTAMA tersebut sebagai portofolio dari pekerjaan yang pernah dikerjakannya.</li>
                <li>PIHAK KEDUA menjamin bahwa seluruh maupun setiap bagian dari Pekerjaan bebas dari hal hal yang melanggar hukum dan/atau melanggar hak kekayaaan intelektual pihak manapun, dan dengan ini PIHAK KEDUA sepenuhnya bertanggung jawab dan membebaskan PIHAK PERTAMA atas setiap tuntutan dari pihak manapun, dan dalam bentuk apa pun sehubungan dengan Pekerjaan yang diatur di dalam Perjanjian ini.</li>
                <li>Apabila dibutuhkan untuk pendaftaran dan pengurusan Hak Kekayaan Intelektual ke Direktorat Jenderal Kekayaan Intelektual maka akan menjadi hak dan tanggungjawab PIHAK PERTAMA.</li>
            </ol>
            <p class="justify">Jika Afiliasi dari PIHAK PERTAMA ingin menggunakan Kekayaan Intelektual (KI) yang dihasilkan, mereka harus mencantumkan referensi yang sesuai dari PIHAK KEDUA dan tidak boleh menggunakan Kekayaan Intelektual (KI) untuk kepentingan komersial. Selain itu, afiliasi harus menunjuk dan menggunakan jasa PIHAK KEDUA untuk pemanfaatan dan penggunaan Kl, sesuai dengan kesepakatan antara PARA PIHAK.</p>

            <div class="pasal-title">PASAL 21<br>PERLINDUNGAN TERHADAP PENYALAHGUNAAN KONTRAK</div>
            <ol>
                <li>PARA PIHAK sepakat bahwa seluruh isi, ketentuan, dan dokumen dalam Perjanjian ini bersifat rahasia dan hanya dapat digunakan oleh PARA PIHAK untuk kepentingan pelaksanaan pekerjaan sebagaimana dimaksud dalam Perjanjian ini.</li>
                <li>PIHAK PERTAMA berhak untuk menjamin bahwa PIHAK KEDUA tidak menyalahgunakan informasi, dokumen, atau ketentuan dalam Perjanjian untuk tujuan yang bertentangan dengan kepentingan hukum dan komersial PIHAK PERTAMA, baik secara langsung maupun tidak langsung, selama dan setelah berakhirnya masa berlaku Perjanjian.</li>
                <li>PIHAK KEDUA berkewajiban untuk menjaga kerahasiaan dan tidak menyalahgunakan seluruh informasi, dokumen, data teknis, data komersial, isi kontrak, maupun hal lain yang diperoleh selama pelaksanaan Perjanjian, dan tidak mengalihkannya kepada pihak lain tanpa persetujuan tertulis dari PIHAK PERTAMA.</li>
                <li>Penyalahgunaan sebagaimana dimaksud dalam pasal ini termasuk namun tidak terbatas pada:
                    <ol class="alpha-list">
                        <li>Penggunaan isi Perjanjian untuk kepentingan pihak lain tanpa persetujuan,</li>
                        <li>Pengungkapan informasi kontrak kepada pihak ketiga tanpa dasar hukum yang sah,</li>
                        <li>Penggandaan, pengutipan, atau pendistribusian dokumen Perjanjian tanpa otorisasi,</li>
                        <li>Tindakan yang mengakibatkan kerugian reputasi atau finansial terhadap salah satu pihak.</li>
                    </ol>
                </li>
                <li>PIHAK PERTAMA berkewajiban memberikan informasi, dokumen, dan petunjuk pelaksanaan pekerjaan kepada PIHAK KEDUA secara transparan, dalam lingkup yang diperlukan untuk melaksanakan pekerjaan sesuai Perjanjian ini, dan dalam batas yang tidak melanggar kerahasiaan milik negara atau pihak ketiga lainnya.</li>
                <li>Jika PIHAK KEDUA terbukti melakukan penyalahgunaan sebagaimana dimaksud dalam pasal ini, maka:
                    <ol class="alpha-list">
                        <li>PIHAK KEDUA wajib bertanggung jawab penuh atas segala kerugian yang timbul, baik materiil maupun imateriil, yang diderita PIHAK PERTAMA;</li>
                        <li>PIHAK PERTAMA berhak untuk mengambil tindakan hukum, termasuk namun tidak terbatas pada pemutusan kontrak secara sepihak, tuntutan ganti rugi, dan pelaporan kepada pihak berwenang.</li>
                    </ol>
                </li>
                <li>Ketentuan dalam pasal ini tetap berlaku meskipun Perjanjian telah berakhir atau dihentikan, selama informasi atau dokumen yang diperoleh dari Perjanjian ini belum menjadi informasi publik secara sah.</li>
                <li>PARA PIHAK sepakat untuk tunduk pada seluruh ketentuan hukum yang berlaku di Republik Indonesia, termasuk peraturan perundang-undangan terkait kerahasiaan informasi, perdata, pidana, perlindungan data, dan hak kekayaan intelektual yang dapat berlaku dalam konteks penyalahgunaan kontrak.</li>
            </ol>

            <div class="pasal-title">PASAL 22<br>KESELAMATAN KESEHATAN KERJA, KESELAMATAN KETENAGALISTRIKAN</div>
            <ol>
                <li>Kegiatan Pencegahan Terjadinya Kecelakaan Kerja
                    <ol style="list-style-type: decimal;">
                        <li>Pencegahan Kondisi Berbahaya (Unsafe Condition)<br>
                            PIHAK KEDUA wajib melakukan pengendalian teknis terhadap adanya kondisi berbahaya (unsafe condition) pada tempat-tempat kerja yang berkaitan dengan perjanjian ini, antara lain:
                            <ol class="alpha-list">
                                <li>PIHAK KEDUA diwajibkan menaati peraturan Keselamatan dan Kesehatan Kerja (K3), yang berlaku di lingkungan PT PLN (Persero).</li>
                                <li>PIHAK KEDUA wajib memiliki dan menerapkan Standing Operation Procedure (SOP) sesuai pemerintah untuk setiap pekerjaan.</li>
                                <li>PIHAK KEDUA wajib menyediakan peralatan kerja dan APD yang sesuai dan layak (safety helmet, kacamata safety, pelindung telinga, pelindung pernapasan, sarung tangan, sepatu safety, safety body harness, rompi keselamatan) bagi tenaga kerja melaksanakan pekerjaan yang berpotensi bahaya.</li>
                                <li>PIHAK KEDUA wajib mengidentifikasi bahaya, penilaian resiko dan pengendalian resiko (IBPPR) pada tempat kerja yang berpotensi bahaya.</li>
                                <li>PIHAK KEDUA wajib membuat Job Safety Analysis (JSA) dan izin kerja (working permit) setiap pelaksanaan pekerjaan yang berpotensi bahaya.</li>
                                <li>PIHAK KEDUA wajib melakukan pemeriksaan kesehatan bagi tenaga kerjanya yang bekerja pada pekerjaan yang berpotensi bahaya.</li>
                            </ol>
                        </li>
                        <li>Pencegahan Tindakan Berbahaya (Unsafe Action)
                            <ol class="alpha-list">
                                <li>PIHAK KEDUA wajib menunjuk dan menetapkan Pengawas pekerjaan/Pengawas K3 yang memiliki kompetensi di bidang pekerjaannya.</li>
                                <li>PIHAK KEDUA wajib menggunakan sistem LOTO (Lock Out Tag Out) dan buddy system (tidak boleh bekerja seorang diri) pada saat pelaksanaan pekerjaan yang berpotensi bahaya.</li>
                                <li>Pelaksana pekerjaan dari PIHAK KEDUA wajib menggunakan peralatan kerja dan APD (safety helmet, kacamata safety, pelindung telinga, pelindung pernapasan, sarung tangan, sepatu safety, safety body harness, rompi keselamatan) sesuai standar pada pelaksanaan pekerjaan yang berpotensi bahaya.</li>
                                <li>PIHAK KEDUA wajib melakukan pengawasan terhadap perilaku Pekerja PIHAK KEDUA yang membahayakan bagi diri sendiri maupun orang lain, yang dapat menyebabkan terjadinya kecelakaan kerja;</li>
                                <li>PIHAK KEDUA wajib memberikan petunjuk dan arahan keselamatan (safety briefing) kepada Pelaksana Pekerjaan dan Pengawas Pekerjaan sebelum melaksanakan Pekerjaan yang berpotensi bahaya.</li>
                                <li>PIHAK KEDUA wajib bertanggung jawab atas keamanan barang dan peralatan yang dipergunakan atau yang ada dibawah tanggung jawab PIHAK KEDUA dari bahaya pencurian, pengrusakan, kebakaran dan bahaya lainnya.</li>
                            </ol>
                        </li>
                    </ol>
                </li>
                <li>Sertifikasi K3
                    <ol style="list-style-type: decimal;">
                        <li>PIHAK KEDUA wajib melakukan sertifikasi kompetensi bagi pengawas pekerjaan, pelaksana pekerjaan, dan tenaga teknik lainnya sesuai dengan bidang pekerjaannya.</li>
                        <li>PIHAK KEDUA wajib memiliki pengawas pekerjaan dan pelaksana pekerjaan yang telah memiliki kompetensi di bidang teknik sesuai dengan jenis pekerjaan.</li>
                        <li>PIHAK KEDUA wajib memberikan pendidikan dan pelatihan bagi pengawas pekerjaan, pelaksana pekerjaan dan tenaga teknik lainnya yang sesuai dengan bidang pekerjaannya.</li>
                    </ol>
                </li>
                <li>Sanksi K3
                    <ol style="list-style-type: decimal;">
                        <li>Apabila terjadi kecelakaan kerja akibat kelalaian PIHAK KEDUA dalam penerapan Sistem Manajemen Keselamatan dan Kesehatan Kerja, maka PIHAK KEDUA Bertanggung jawab secara penuh untuk menyelesaikan segala permasalahan yang ditimbulkan akibat kecelakaan tersebut.</li>
                        <li>Apabila terjadi kecelakaan kerja akibat kelalaian Pelaksana pekerjaan dari PIHAK KEDUA, maka Pelaksana pekerjaan tersebut bertanggung jawab secara penuh atas akibat kecelakaan tersebut.</li>
                        <li>Apabila terjadi kecelakaan kerja yang mengakibatkan luka berat, luka berat yang menyebabkan cacat dan meninggal dunia pada pelaksanaan pekerjaan dari PIHAK KEDUA sepanjang bukan disebabkan karena keadaan force majeure, maka:
                            <ol class="alpha-list">
                                <li>Pengawas Pekerjaan dan pelaksana pekerjaan yang melaksanakan pekerjaan tersebut dilarang untuk bekerja atau di-suspend selama 2 (dua) bulan pada pekerjaan teknis di lapangan</li>
                                <li>PIHAK KEDUA dikenakan denda maksimal 10% (sepuluh per seratus) dari nilai total tagihan.</li>
                            </ol>
                        </li>
                        <li>Apabila kecelakaan kerja terjadi pada masa transisi perjanjian kerja, maka untuk sanksi sesuai dengan Ayat (3) poin 3.3. akan tetap diberlakukan.</li>
                        <li>Apabila terjadi kecelakaan kerja akibat kelalaian PIHAK KEDUA dalam penerapan Sistem Manajemen Keselamatan dan Kesehatan Kerja, maka PIHAK PERTAMA berhak mengevaluasi, memutus perjanjian barang dan jasa yang sedang berlangsung secara sepihak serta memasukkan PIHAK KEDUA tersebut pada Daftar Hitam (Black List) perusahaan.</li>
                    </ol>
                </li>
            </ol>

            <div class="pasal-title">PASAL 23<br>KEPATUHAN TERHADAP ASPEK LINGKUNGAN HIDUP DAN PELESTARIAN FASILITAS</div>
            <ol>
                <li>PARA PIHAK wajib menjaga kelestarian lingkungan dan fasilitas di sekitar lokasi kerja selama masa pelaksanaan pekerjaan. Kewajiban ini mencakup, namun tidak terbatas pada:
                    <ol class="alpha-list">
                        <li>Menjaga kebersihan area kerja, termasuk melakukan penanganan dan pembuangan terhadap limbah, sisa material, kotoran, dan sampah secara tepat dan bertanggung jawab.</li>
                        <li>Melindungi dan memelihara vegetasi, tanaman, serta fasilitas umum yang berada di dalam atau di sekitar lokasi kerja.</li>
                        <li>Melakukan langkah-langkah pencegahan terhadap potensi pencemaran lingkungan (air, udara, dan tanah) yang mungkin timbul selama pelaksanaan kegiatan kerja.</li>
                    </ol>
                </li>
                <li>PIHAK KEDUA wajib menaati seluruh ketentuan dan kebijakan lingkungan hidup yang ditetapkan oleh PIHAK PERTAMA dan/atau yang diatur dalam peraturan perundang-undangan yang berlaku di Republik Indonesia.</li>
                <li>Untuk setiap jenis pekerjaan yang memiliki potensi dampak lingkungan, PIHAK KEDUA wajib melakukan identifikasi risiko lingkungan serta menetapkan langkah mitigasi yang sesuai dengan skala dan karakteristik pekerjaannya.</li>
                <li>Dalam hal kegiatan PIHAK KEDUA menghasilkan limbah, baik limbah domestik maupun limbah bahan berbahaya dan beracun (limbah B3), PIHAK KEDUA wajib melakukan pengelolaan secara bertanggung jawab sesuai ketentuan hukum yang berlaku.</li>
                <li>PIHAK KEDUA didorong untuk, dan dalam kondisi tertentu diwajibkan untuk, menggunakan teknologi, bahan, dan metode kerja yang ramah lingkungan serta minim dampak terhadap ekosistem.</li>
                <li>PIHAK KEDUA bertanggung jawab sepenuhnya atas dampak negatif terhadap lingkungan yang timbul akibat kelalaian, ketidaksesuaian prosedur, atau pelanggaran terhadap ketentuan dalam Pasal ini, termasuk namun tidak terbatas pada:
                    <ol class="alpha-list">
                        <li>Biaya penanggulangan dan pemulihan akibat pencemaran atau kerusakan lingkungan.</li>
                        <li>Kompensasi terhadap pihak ketiga atau masyarakat sekitar yang terdampak.</li>
                        <li>Sanksi administratif atau denda dari instansi berwenang.</li>
                    </ol>
                </li>
                <li>PIHAK PERTAMA berhak melakukan pemantauan, inspeksi, dan/atau audit secara berkala atau sewaktu-waktu terhadap pelaksanaan kewajiban PIHAK KEDUA dalam hal pengelolaan lingkungan.</li>
                <li>PIHAK PERTAMA berhak menghentikan sementara atau secara permanen sebagian atau seluruh kegiatan PIHAK KEDUA, apabila ditemukan pelanggaran yang berpotensi atau telah mengakibatkan pencemaran lingkungan, tanpa kewajiban membayar kompensasi apa pun kepada PIHAK KEDUA.</li>
                <li>Kewajiban dan tanggung jawab dalam Pasal ini tetap berlaku selama masa pelaksanaan pekerjaan serta tetap mengikat setelah berakhirnya perjanjian, sepanjang dampak lingkungan yang ditimbulkan belum tertangani secara tuntas.</li>
            </ol>

            <div class="pasal-title">PASAL 24<br>KERAHASIAAN INFORMASI DAN PERLINDUNGAN DATA</div>
            <ol>
                <li>PIHAK KEDUA berkewajiban untuk menjaga kerahasiaan seluruh data, dokumen, informasi, dan/atau pengetahuan lainnya yang diterima dari PIHAK PERTAMA atau yang timbul dalam rangka pelaksanaan Perjanjian ini, serta dilarang mengungkapkan sebagian atau seluruh Informasi Rahasia tersebut kepada pihak manapun tanpa persetujuan tertulis dari PIHAK PERTAMA, kecuali sebagaimana ditentukan dalam Pasal ini.</li>
                <li>PIHAK KEDUA wajib menerapkan langkah-langkah pengamanan dan tata kelola informasi yang memadai dan sesuai dengan ketentuan peraturan perundang-undangan yang berlaku, termasuk namun tidak terbatas pada Undang-Undang Nomor 27 Tahun 2022 tentang Perlindungan Data Pribadi, dalam melindungi setiap Informasi Rahasia dan/atau Data Pribadi milik PIHAK PERTAMA atau pihak ketiga yang berada dalam penguasaan PIHAK PERTAMA.</li>
                <li>PIHAK KEDUA tidak diperkenankan menggunakan Informasi Rahasia dan/atau Data Pribadi untuk tujuan lain selain pelaksanaan kewajiban berdasarkan Perjanjian ini. Penggunaan, pengolahan, atau penyebarluasan informasi tersebut untuk kepentingan di luar ruang lingkup pekerjaan hanya dapat dilakukan atas dasar persetujuan tertulis dari PIHAK PERTAMA.</li>
                <li>PIHAK PERTAMA berhak sewaktu-waktu melakukan evaluasi atau audit terhadap pelaksanaan perlindungan informasi dan data oleh PIHAK KEDUA, termasuk meminta penjelasan teknis, dokumentasi kebijakan perlindungan data, dan akses terbatas terhadap sistem pengelolaan data yang digunakan PIHAK KEDUA sepanjang berkaitan dengan pelaksanaan pekerjaan.</li>
                <li>PIHAK KEDUA hanya diperbolehkan mengungkapkan Informasi Rahasia kepada pihak ketiga dalam hal:
                    <ol class="alpha-list">
                        <li>Pengungkapan diwajibkan oleh instansi pemerintah, aparat penegak hukum, atau peraturan perundang-undangan yang berlaku;</li>
                        <li>Pengungkapan kepada konsultan hukum atau profesional lain yang secara sah ditunjuk dan terikat kewajiban kerahasiaan;</li>
                        <li>Pengungkapan kepada lembaga keuangan yang relevan dalam rangka pembiayaan atau administrasi pekerjaan, dengan syarat lembaga tersebut telah menandatangani pernyataan untuk menjaga kerahasiaan informasi dimaksud.</li>
                    </ol>
                </li>
                <li>Ketentuan kerahasiaan tidak berlaku terhadap informasi yang:
                    <ol class="alpha-list">
                        <li>Telah tersedia di domain publik bukan akibat pelanggaran salah satu PIHAK;</li>
                        <li>Telah sah dimiliki oleh PIHAK KEDUA sebelum diungkapkan oleh PIHAK PERTAMA;</li>
                        <li>Diperoleh dari pihak ketiga yang berwenang mengungkapkan informasi tersebut secara sah.</li>
                    </ol>
                </li>
                <li>PARA PIHAK sepakat untuk menjaga kerahasiaan seluruh isi dan substansi Perjanjian ini, dan tidak akan mempublikasikannya kepada pihak lain tanpa persetujuan tertulis dari PIHAK PERTAMA, kecuali untuk keperluan pelaksanaan Perjanjian atau untuk memenuhi kewajiban hukum sepanjang tidak melanggar hukum yang berlaku.</li>
                <li>Dalam hal PIHAK KEDUA melanggar ketentuan dalam Pasal ini, PIHAK KEDUA bertanggung jawab penuh atas segala bentuk kerugian, tuntutan, sanksi administratif, dan/atau konsekuensi hukum lainnya yang timbul, termasuk yang berkaitan dengan pelanggaran terhadap ketentuan perlindungan data pribadi sesuai peraturan perundang-undangan yang berlaku.</li>
            </ol>

            <div class="pasal-title">PASAL 25<br>PENYELESAIAN PERSELISIHAN</div>
            <ol>
                <li>Segala perselisihan yang timbul sehubungan dengan isi, penafsiran maupun pelaksanaan Perjanjian ini, sedapat mungkin diselesaikan oleh PARA PIHAK secara musyawarah untuk mencapai mufakat selambat-lambatnya 30 (tiga puluh) Hari Kalender sejak tanggal salah satu pihak meminta dilakukan musyawarah secara tertulis.</li>
                <li>Apabila penyelesaian secara musyawarah sebagaimana telah ditentukan pada ayat (1) Pasal ini tidak tercapai mufakat, maka PARA PIHAK sepakat untuk menyelesaikan perselisihan tersebut melalui Pengadilan Negeri Lubuk Pakam.</li>
                <li>Selama proses penyelesaian perselisihan, PARA PIHAK tetap berkewajiban melaksanakan seluruh hak dan kewajibannya sesuai ketentuan dalam Perjanjian ini.</li>
                <li>Apabila PARA PIHAK mencapai kesepakatan atas perselisihan sebagaimana dimaksud pada ayat 1 Pasal ini, maka kesepakatan perdamaian dimaksud wajib dibuat secara tertulis dan ditandatangani oleh PARA PIHAK dan/atau kuasa masing-masing pihak yang sah dan kesepakatan tersebut mengikat PARA PIHAK.</li>
                <li>Apabila timbul perselisihan hubungan industrial antara PIHAK KEDUA dan Pekerja PIHAK KEDUA, maka PIHAK KEDUA wajib dan bertanggung jawab sepenuhnya serta sepakat untuk menyelesaikan perselisihan tersebut tanpa melibatkan PIHAK PERTAMA.</li>
                <li>Dalam hal tidak tercapai kesepakatan dalam musyawarah, PARA PIHAK sepakat untuk menyelesaikan perselisihan tersebut melalui Pengadilan Negeri Lubuk Pakam.</li>
            </ol>

            <div class="pasal-title">PASAL 26<br>KEBERLAKUAN, KESATUAN PERJANJIAN, DAN ITIKAD BAIK</div>
            <ol>
                <li>Perjanjian akan tetap berlaku serta mengikat selama jangka waktu sebagaimana diatur dalam Perjanjian ini, termasuk seluruh pelaksanaan hak dan kewajiban PARA PIHAK, kecuali jika diakhiri lebih awal sesuai ketentuan yang berlaku dalam Perjanjian ini.</li>
                <li>Seluruh dokumen, surat menyurat, berita acara, amandemen/ adendum, dan lampiran yang ditandatangani atau disetujui oleh PARA PIHAK sehubungan dengan Perjanjian ini, merupakan bagian yang tidak terpisahkan dan memiliki kekuatan hukum yang sama dengan naskah utama Perjanjian.</li>
                <li>Dalam hal terdapat perbedaan penafsiran antara ketentuan dalam dokumen pendukung dengan isi Perjanjian ini, maka yang berlaku adalah ketentuan dalam naskah utama Perjanjian ini, kecuali jika secara tegas dinyatakan lain oleh PARA PIHAK dalam dokumen atau amandemen/adendum tertulis.</li>
                <li>PARA PIHAK sepakat untuk melaksanakan seluruh ketentuan dalam Perjanjian ini dengan itikad baik, profesionalisme, dan saling menghormati kepentingan masing-masing, serta berupaya secara aktif untuk menyelesaikan segala permasalahan yang timbul dalam pelaksanaan Perjanjian melalui cara musyawarah dan semangat kerja sama.</li>
                <li>PARA PIHAK bertindak berdasarkan asas kepercayaan (trust) yang disesuaikan dengan hak-hak yang terdapat dalam Perjanjian.</li>
                <li>PARA PIHAK setuju untuk melaksanakan Perjanjian dengan jujur tanpa menonjolkan kepentingan masing-masing pihak. Jika selama Perjanjian, salah satu pihak merasa dirugikan, maka diupayakan tindakan yang terbaik untuk mengatasi keadaan tersebut.</li>
            </ol>

            <div class="pasal-title">PASAL 27<br>PENGALIHAN TANGGUNG JAWAB DAN PEMBEBASAN DARI TUNTUTAN</div>
            <ol>
                <li>PIHAK KEDUA menjamin bahwa seluruh hasil pekerjaan, produk, dokumen, materi, atau hasil karya lainnya yang diserahkan kepada PIHAK PERTAMA dalam rangka pelaksanaan Perjanjian ini merupakan hasil yang sah dan tidak melanggar hak kekayaan intelektual, hak cipta, hak paten, hak desain, hak atas merek, hak atas rahasia dagang, maupun hak-hak hukum lainnya milik pihak ketiga.</li>
                <li>PIHAK KEDUA dengan ini membebaskan dan menjamin PIHAK PERTAMA dari segala bentuk tuntutan hukum, klaim, gugatan, maupun permintaan ganti rugi yang diajukan oleh pihak ketiga terhadap hasil pekerjaan yang telah diserahkan oleh PIHAK KEDUA kepada PIHAK PERTAMA, sepanjang tuntutan tersebut disebabkan oleh pelanggaran hak atas kekayaan intelektual atau hak hukum lain yang dilakukan oleh PIHAK KEDUA.</li>
                <li>Dalam hal PIHAK PERTAMA menerima tuntutan dari pihak ketiga sebagaimana dimaksud pada ayat (2) di atas, maka PIHAK KEDUA wajib bertanggung jawab penuh untuk menangani, menyelesaikan, dan menanggung seluruh konsekuensi hukum, termasuk namun tidak terbatas pada biaya perkara, ganti rugi, dan/atau kompensasi lainnya yang timbul atas tuntutan tersebut.</li>
                <li>PIHAK KEDUA berkewajiban untuk segera memberitahukan secara tertulis kepada PIHAK PERTAMA apabila mengetahui atau patut menduga adanya klaim, tuntutan, atau potensi sengketa dari pihak lain yang berkaitan dengan hasil pekerjaan yang telah diserahkan kepada PIHAK PERTAMA.</li>
                <li>PARA PIHAK sepakat untuk bekerja sama secara profesional dan berdasarkan itikad baik dalam menyelesaikan setiap tuntutan, klaim, atau sengketa sebagaimana dimaksud dalam Pasal ini, termasuk memberikan informasi, dokumen pendukung, dan bantuan yang diperlukan secara proporsional.</li>
            </ol>

            <div class="pasal-title">PASAL 28<br>KORESPONDENSI</div>
            <p class="justify">Segala bentuk surat menyurat antara PIHAK PERTAMA dan PIHAK KEDUA yang behubungan dengan Perjanjian ini akan dilaksanakan secara tertulis oleh PARA PIHAK dengan alamat:</p>
            
            <table class="tabel-biasa" style="margin-left: 20px;">
                <tr>
                    <td width="30%" class="bold">PIHAK PERTAMA</td>
                    <td width="5%"></td>
                    <td width="65%"></td>
                </tr>
                <tr>
                    <td>Nama Perusahaan</td>
                    <td>:</td>
                    <td>{{ $pt_pihak1 }}</td>
                </tr>
                <tr>
                    <td>u.p.</td>
                    <td>:</td>
                    <td>{{ strtoupper($jabatan1) }}</td>
                </tr>
                <tr><td colspan="3" style="height: 15px;"></td></tr>
                <tr>
                    <td class="bold">PIHAK KEDUA</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Nama Perusahaan</td>
                    <td>:</td>
                    <td>{{ $cv_pihak2 }}</td>
                </tr>
                <tr>
                    <td>u.p.</td>
                    <td>:</td>
                    <td>{{ strtoupper($jabatan2) }}</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>:</td>
                    <td>{{ $alamat_pihak2 }}</td>
                </tr>
            </table>

            <div class="page-break"></div>

            <div class="pasal-title">PASAL 29<br>PENUTUP</div>
            <ol>
                <li class="justify">PARA PIHAK telah membaca dan mengerti isi Perjanjian ini dan menyetujui bahwa Perjanjian ini merupakan bentuk pernyataan lengkap dan berlaku di antara PARA PIHAK mengenai isi Perjanjian ini menggantikan seluruh proposal, pengertian dan kesepakatan sebelumnya, baik lisan maupun tertulis, dan seluruh bentuk komunikasi di antara PARA PIHAK sehubungan dengan hal tersebut.</li>
                <li class="justify">PARA PIHAK menjamin bahwa pihak-pihak yang menandatangani Perjanjian ini memiliki kewenangan dan masing-masing pihak mempunyai kekuasaan dan kewenangan berdasarkan hukum untuk mengikatkan diri dan melaksanakan segala hak dan kewajibannya berdasarkan Perjanjian ini serta lampiran dan dokumen lainnya yang berhubungan dengan Perjanjian ini. PIHAK PERTAMA dan PIHAK KEDUA akan memberikan bukti sahnya mengenai hal ini apabila diminta oleh pihak yang lain.</li>
                <li class="justify">Perjanjian ini dibuat 2 (dua) rangkap diberi meterai secukupnya dan mempunyai kekuatan hukum yang sama untuk PARA PIHAK, serta ditandatangani pada hari dan tanggal Perjanjian ini.</li>
                <li class="justify">Apabila ternyata ada hal-hal lain yang belum tercantum di Perjanjian Kerjasama ini akan diselesaikan dengan cara musyawarah dan mufakat antara PARA PIHAK.</li>
            </ol>
    <table style="width: 100%; margin-top: 50px; text-align: center;">
        <tr>
            <td style="width: 50%; font-weight: bold; vertical-align: bottom;">
                PIHAK KEDUA<br>{{ strtoupper($cv_pihak2) }}<br><br><br><br><br>
                {{ strtoupper($nama_pejabat2) }}<br>{{ strtoupper($jabatan2) }}
            </td>
            <td style="width: 50%; font-weight: bold; vertical-align: bottom;">
                PIHAK PERTAMA<br>{{ strtoupper($pt_pihak1) }}<br><br><br><br><br>
                {{ strtoupper($nama_pejabat1) }}<br>{{ strtoupper($jabatan1) }}
            </td>
        </tr>
    </table>
</body>
</html>