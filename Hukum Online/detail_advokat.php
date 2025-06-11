<?php
session_start();
// PENTING: Implementasi Pengecekan Login Admin di Sini (jika belum ada)
/*
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_role'] !== 'admin') {
    header("Location: ../login_admin.php"); // Atau ke halaman login admin Anda
    exit;
}
*/

// Ganti include 'koneksi.php'; dengan koneksi langsung
$conn = new mysqli("localhost", "root", "", "layanan_hukum");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$id = $_GET['id'] ?? 0;
// Ambil semua kolom yang diperlukan, termasuk email, pendidikan, keahlian, pengalaman, jenis_konsultasi
$advokat = $conn->query("SELECT id, nama, email, spesialisasi, pendidikan, keahlian, pengalaman, jenis_konsultasi, foto FROM advokat WHERE id = $id")->fetch_assoc();

if (!$advokat) {
    echo "Data advokat tidak ditemukan.";
    exit;
}

// Catatan: Asumsi tabel 'artikel' dan 'layanan' memiliki kolom 'advokat_id'
$artikel_result = $conn->query("SELECT id, judul, isi, gambar FROM artikel WHERE advokat_id = $id ORDER BY id DESC");
$layanan_result = $conn->query("SELECT id, nama_layanan, deskripsi, harga FROM layanan WHERE advokat_id = $id ORDER BY id DESC");
$ulasan_result = $conn->query("SELECT id, nama, rating, layanan, pesan FROM ulasan WHERE id_advokat = $id ORDER BY id DESC");

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Detail Advokat: <?= htmlspecialchars($advokat['nama']) ?></title>
    <style>
        /* CSS Umum untuk Admin Panel (Sama dengan admin_dashboard.php, kelola_pembayaran.php, kelola_advokat.php) */
        body { font-family: Arial, sans-serif; margin: 0; background-color: #f4f7f6; color: #333; }
        .header-admin { background-color: #34495e; color: white; padding: 20px; text-align: center; }
        .header-admin h1 { margin: 0; font-size: 28px; }
        .header-admin nav ul { list-style: none; padding: 0; margin: 10px 0 0; display: flex; justify-content: center; gap: 20px; }
        .header-admin nav a { color: white; text-decoration: none; font-weight: bold; padding: 5px 10px; border-radius: 4px; transition: background-color 0.3s ease; }
        .header-admin nav a:hover { background-color: #2c3e50; } /* Tidak perlu active di sub-halaman */

        .container { max-width: 900px; margin: 30px auto; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #2c3e50; margin-bottom: 30px; }

        .profile-detail {
            display: flex;
            align-items: flex-start;
            gap: 30px;
            margin-bottom: 30px;
            padding: 20px;
            border: 1px solid #eee;
            border-radius: 8px;
            background-color: #fcfcfc;
        }
        .profile-detail .foto-container {
            flex-shrink: 0;
            text-align: center;
        }
        .profile-detail .foto-container img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #007bff;
        }
        .profile-detail .info {
            flex-grow: 1;
        }
        .profile-detail .info h3 { margin-top: 0; color: #2c3e50; font-size: 24px; }
        .profile-detail .info p { margin-bottom: 8px; line-height: 1.6; color: #555; }
        .profile-detail .info p strong { color: #333; }

        .section-heading { text-align: center; color: #2c3e50; margin-top: 40px; margin-bottom: 20px; font-size: 22px; }

        .artikel-grid, .layanan-grid, .ulasan-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.08);
            padding: 20px;
            transition: transform 0.2s ease;
        }
        .card:hover { transform: translateY(-5px); }

        .artikel-card img {
            max-width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .artikel-card h4 { margin-top: 0; font-size: 1.1em; color: #007bff; }
        .artikel-card p { font-size: 0.9em; color: #666; }

        .layanan-card h4 { margin-top: 0; font-size: 1.1em; color: #2c3e50; }
        .layanan-card p { font-size: 0.9em; color: #666; }
        .layanan-card .harga { font-weight: bold; color: #28a745; margin-top: 10px; }

        .ulasan-card .rating { color: #ffc107; font-size: 1.2em; margin-bottom: 5px; }
        .ulasan-card h4 { margin-top: 0; font-size: 1em; color: #007bff; }
        .ulasan-card p { font-size: 0.9em; color: #666; margin-bottom: 10px; }
        .ulasan-card .nama-ulasan { font-size: 0.8em; color: #888; text-align: right; }

        .empty-state { text-align: center; color: #777; padding: 20px; border: 1px dashed #ddd; border-radius: 8px; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="header-admin">
        <h1>Admin Panel</h1>
        <nav>
            <ul>
                <li><a href="admin_dashboard.php">Dashboard</a></li>
                <li><a href="kelola_pembayaran.php">Kelola Pembayaran</a></li>
                <li><a href="kelola_advokat.php">Kelola Advokat</a></li>
                <li><a href="kelola_layanan.php">Kelola Layanan</a></li>
                <li><a href="kelola_users.php">Kelola Pengguna</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </nav>
    </div>

    <div class="container">
        <h2>Detail Advokat</h2>

        <div class="profile-detail">
            <div class="foto-container">
                <?php
                    $photo_path = !empty($advokat['foto']) ? '../uploads/' . htmlspecialchars($advokat['foto']) : '../uploads/default.png';
                    if (!file_exists($photo_path) || is_dir($photo_path)) {
                        $photo_path = '../uploads/default.png';
                    }
                ?>
                <img src="<?= $photo_path ?>" alt="Foto Advokat">
            </div>
            <div class="info">
                <h3><?= htmlspecialchars($advokat['nama']) ?></h3>
                <p><strong>Email:</strong> <?= htmlspecialchars($advokat['email'] ?? 'Tidak Tersedia') ?></p>
                <p><strong>Spesialisasi:</strong> <?= htmlspecialchars($advokat['spesialisasi']) ?></p>
                <p><strong>Pendidikan:</strong> <?= nl2br(htmlspecialchars($advokat['pendidikan'])) ?></p>
                <p><strong>Keahlian:</strong> <?= nl2br(htmlspecialchars($advokat['keahlian'])) ?></p>
                <p><strong>Pengalaman:</strong> <?= htmlspecialchars($advokat['pengalaman']) ?></p>
                <p><strong>Jenis Konsultasi:</strong> <?= htmlspecialchars($advokat['jenis_konsultasi']) ?></p>
                <p>
                    <a href="edit_advokat.php?id=<?= htmlspecialchars($advokat['id']) ?>" class="btn-action btn-primary" style="background-color: #007bff; color:white; padding: 8px 15px; border-radius: 5px; text-decoration: none;">Edit Advokat</a>
                </p>
            </div>
        </div>

        <h3 class="section-heading">Artikel Terkait</h3>
        <div class="artikel-grid">
            <?php if ($artikel_result->num_rows > 0): ?>
                <?php while ($a = $artikel_result->fetch_assoc()): ?>
                    <div class="card artikel-card">
                        <?php
                            $artikel_gambar_path = !empty($a['gambar']) ? '../gambar/' . htmlspecialchars($a['gambar']) : '../gambar/default_artikel.png';
                            if (!file_exists($artikel_gambar_path) || is_dir($artikel_gambar_path)) {
                                $artikel_gambar_path = '../gambar/default_artikel.png';
                            }
                        ?>
                        <img src="<?= $artikel_gambar_path ?>" alt="<?= htmlspecialchars($a['judul']) ?>">
                        <h4><a href="../artikel.php?id=<?= htmlspecialchars($a['id']) ?>" style="text-decoration:none; color:inherit;"><?= htmlspecialchars($a['judul']) ?></a></h4>
                        <p><?= htmlspecialchars(substr($a['isi'], 0, 100)) ?>...</p>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="empty-state">Tidak ada artikel terkait.</div>
            <?php endif; ?>
        </div>

        <h3 class="section-heading">Layanan yang Ditawarkan</h3>
        <div class="layanan-grid">
            <?php if ($layanan_result->num_rows > 0): ?>
                <?php while ($l = $layanan_result->fetch_assoc()): ?>
                    <div class="card layanan-card">
                        <h4><?= htmlspecialchars($l['nama_layanan']) ?></h4>
                        <p><?= htmlspecialchars($l['deskripsi']) ?></p>
                        <p class="harga">Harga: Rp<?= number_format($l['harga'], 0, ',', '.') ?></p>
                        <form action="../pembayaran.php" method="GET" style="margin-top: 15px;">
                            <input type="hidden" name="advokat_id" value="<?= htmlspecialchars($advokat['id']) ?>">
                            <input type="hidden" name="layanan_id" value="<?= htmlspecialchars($l['id']) ?>">
                            <input type="hidden" name="harga_layanan" value="<?= htmlspecialchars($l['harga']) ?>">
                            <input type="hidden" name="harga_konsultasi" value="350000"> <button type="submit" style="background-color: #004aad; color:white; padding:8px 16px; border:none; border-radius:5px; cursor:pointer;">Pesan Sekarang</button>
                        </form>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="empty-state">Tidak ada layanan yang ditawarkan oleh advokat ini.</div>
            <?php endif; ?>
        </div>

        <h3 class="section-heading">Ulasan Klien</h3>
        <div class="ulasan-grid">
            <?php if ($ulasan_result->num_rows > 0): ?>
                <?php while ($u = $ulasan_result->fetch_assoc()): ?>
                    <div class="card ulasan-card">
                        <div class="rating"><?= str_repeat("⭐", (int)$u['rating']) ?></div>
                        <h4><?= htmlspecialchars($u['layanan']) ?></h4>
                        <p><?= htmlspecialchars($u['pesan']) ?></p>
                        <span class="nama-ulasan">-- <?= htmlspecialchars($u['nama']) ?></span>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="empty-state">Belum ada ulasan untuk advokat ini.</div>
            <?php endif; ?>
        </div>

        <div style="text-align: center; margin-top: 40px;">
            <a href="kelola_advokat.php" style="text-decoration: none; background-color: #6c757d; color: white; padding: 10px 20px; border-radius: 5px;">Kembali ke Kelola Advokat</a>
        </div>
    </div>
</body>
</html>