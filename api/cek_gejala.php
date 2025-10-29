<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pastikan ada data gejala dikirim
    if (! isset($_POST['gejala']) || empty($_POST['gejala'])) {
        echo "<h3 style='color:gray;'>❌ Tidak ada gejala yang dipilih.</h3>";
        exit();
    }

    $gejala = $_POST['gejala'];
    // Ambil biodata dari POST
    $nama          = $_POST['nama'];
    $umur          = $_POST['umur'];
    $berat_badan   = $_POST['berat_badan'];
    $tinggi_badan  = $_POST['tinggi_badan'];
    $jenis_kelamin = $_POST['jenis_kelamin'];

    $totalSkor = 0;

    // Loop untuk ambil angka dari teks seperti "(+3)"
    foreach ($gejala as $item) {
        if (preg_match('/\(\+(\d+)\)/', $item, $match)) {
            $totalSkor += (int) $match[1];
        }
    }

    // Tentukan warna, ikon, dan progress bar berdasarkan kategori
    if ($totalSkor <= 5) {
        $kategori  = '🟢 Risiko Rendah';
        $pesan     = 'Belum terindikasi cacingan.';
        $warna     = '#d4edda';
        $teksWarna = '#155724';
        $progress  = 30;
        $aksiTeks  = 'Tetap Jaga Kebersihan';
        $link      = '#';
    } elseif ($totalSkor <= 10) {
        $kategori  = '🟡 Risiko Sedang';
        $pesan     = 'Perhatikan kebersihan dan pola hidup sehat.';
        $warna     = '#fff3cd';
        $teksWarna = '#856404';
        $progress  = 60;
        $aksiTeks  = 'Pelajari Tips Sehat';
        $link      = 'https://www.halodoc.com/artikel/tips-mencegah-cacingan';
    } else {
        $kategori  = '🔴 Risiko Tinggi';
        $pesan     = 'Terindikasi cacingan. Segera minum obat cacing sesuai anjuran dokter.';
        $warna     = '#f8d7da';
        $teksWarna = '#721c24';
        $progress  = 100;
        $aksiTeks  = 'Konsultasi Dokter';
        $link      = 'https://www.halodoc.com/';
    }

    echo "
<style>

.hasil-text { flex:1; text-align:left; }
.hasil-actions { display:flex; gap:10px; flex-wrap:wrap; justify-content:flex-end; }
.progress-bar {
    height: 8px;
    width: 100%;
    background: rgba(0,0,0,0.1);
    border-radius: 10px;
    margin-top:10px;
    overflow:hidden;
}
.progress-fill {
    width: {$progress}%;
    height: 100%;
    background: linear-gradient(90deg,#28a745,#ffc107,#dc3545);
    transition: width 1s ease;
}
.action-btn {
    background:#fff;
    color:{$teksWarna};
    padding:10px 18px;
    border-radius:25px;
    text-decoration:none;
    font-weight:bold;
    border:2px solid {$teksWarna};
    transition: all 0.3s;
}
.action-btn:hover {
    background:{$teksWarna};
    color:#fff;
}
.back-btn {
    background:transparent;
    color:{$teksWarna};
    padding:10px 18px;
    border-radius:25px;
    border:2px solid {$teksWarna};
    text-decoration:none;
    font-weight:bold;
    transition:all 0.3s;
}
.back-btn:hover {
    background:{$teksWarna};
    color:#fff;
}
</style>

<div id='hasil-box' class='hasil-container' style='font - family: Arial, sans - serif;
border-radius: 25px;
background: #099aa7;
color:#ffffff;
padding: 50px;
max-width:1200px;
display: flex;
justify-content: space-between;
align-items: flex-start;
gap: 40px;
flex-wrap:wrap;
'>
  <div class='hasil-text'>
    <h3 style = 'flex:1; margin-bottom:8px;font-weight:700; font-size:40px; color: #ffffff'
>👤 Biodata Pemeriksaan</h3>
      <p style = 'margin-top:10px; font-size:20px; font-weight: 500;'
><strong>Nama:</strong> {$nama}</p>
      <p style = 'margin-top:10px; font-size:20px;'
><strong>Umur:</strong> {$umur} tahun</p>
      <p style='margin-top:10px; font-size:20px;'><strong>Berat Badan:</strong> {$berat_badan} kg</p>
      <p style = 'margin-top:10px; font-size:20px;'
><strong>Tinggi Badan:</strong> {$tinggi_badan} cm</p>
      <p style = 'margin-top:10px; font-size:20px;'
><strong>Jenis Kelamin:</strong> {$jenis_kelamin}</p>
</div>

<div class='hasil-risiko' style = 'flex: 1; background-color: #099aa7; border-radius: 15px; color: #fff;'>
      <h3 style='margin-top:0px; margin-bottom:8px; font-size:40px; color: #ffffff; font-weight:700;'>{$kategori}</h3>
      <p style='margin:0; font-size:30px; font-weight: 500;'>{$pesan}</p>
      <p style='margin-top:10px; font-size:20px;'><strong>Total Skor:</strong> {$totalSkor}</p>
      <div class='progress-bar'>
          <div class='progress-fill'></div>
      </div>
      <p style='margin-top:10px; font-size:25px;'>Tingkat Risiko <strong>{$progress} %
</strong></p>
</div>
  </div>
</div>

<script>
    setTimeout(() => {
        const box = document.getElementById('hasil-box');
        if (box) {
            box.style.opacity = '1';
            box.style.transform = 'translateY(0)';
        }
    }, 100);
</script>
";
} else {
    echo 'Akses tidak valid.';
}
