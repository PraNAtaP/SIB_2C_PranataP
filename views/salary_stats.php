<?php
include 'views/header.php';
?>

<h2>Statistik Gaji per Departemen</h2>
<p style="margin-bottom: 2rem; color: #666;">
    Data statistik berikut diambil dari data table employees
    menggunakan fungsi agregat AVG(), MAX(), MIN(), dan GROUP BY.
</p>

<?php if ($stats->rowCount() > 0): ?>
    <?php
    // Fetch semua data untuk perhitungan
    $stats->execute();
    $all_stats = $stats->fetchAll(PDO::FETCH_ASSOC);

    $avg_salary_all = count($all_stats) > 0
        ? array_sum(array_column($all_stats, 'avg_salary')) / count($all_stats)
        : 0;

    $all_max_salary = max(array_column($all_stats, 'max_salary'));
    $all_min_salary = min(array_column($all_stats, 'min_salary'));
    ?>

    <!-- Cards Summary -->
    <div class="dashboard-cards">
        <div class="card">
            <h3>Total Departemen</h3>
            <div class="number"><?php echo count($all_stats); ?></div>
        </div>
        <div class="card">
            <h3>Rata-rata Semua Gaji</h3>
            <div class="number">Rp <?php echo number_format($avg_salary_all, 0, ',', '.'); ?></div>
        </div>
        <div class="card">
            <h3>Gaji Tertinggi</h3>
            <div class="number">Rp <?php echo number_format($all_max_salary, 0, ',', '.'); ?></div>
        </div>
        <div class="card">
            <h3>Gaji Terendah</h3>
            <div class="number">Rp <?php echo number_format($all_min_salary, 0, ',', '.'); ?></div>
        </div>
    </div>

    <!-- Tabel Statistik Detail -->
    <table class="data-table">
        <thead>
            <tr>
                <th>Departemen</th>
                <th>Gaji Rata-rata</th>
                <th>Gaji Terendah</th>
                <th>Gaji Tertinggi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($all_stats as $dept): ?>
                <tr>
                    <td>
                        <strong><?php echo htmlspecialchars($dept['department']); ?></strong>
                    </td>
                    <td>
                        <strong>Rp <?php echo number_format($dept['avg_salary'], 0, ',', '.'); ?></strong>
                    </td>
                    <td>Rp <?php echo number_format($dept['min_salary'], 0, ',', '.'); ?></td>
                    <td>Rp <?php echo number_format($dept['max_salary'], 0, ',', '.'); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Visualisasi Data -->
    <div style="margin-top: 3rem;">
        <h3>Visualisasi Data</h3>

        <!-- Chart Gaji Rata-rata -->
        <div style="background: white; padding: 1.5rem; border-radius: 8px; margin: 1rem 0; border-left: 4px solid #667eea;">
            <h4>Gaji Rata-rata per Departemen</h4>
            <?php
            $max_avg_salary = max(array_column($all_stats, 'avg_salary'));
            foreach ($all_stats as $dept):
                $percentage = $max_avg_salary > 0 ? ($dept['avg_salary'] / $max_avg_salary * 100) : 0;
            ?>
                <div style="margin: 0.5rem 0;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.25rem;">
                        <span><?php echo htmlspecialchars($dept['department']); ?></span>
                        <span>Rp <?php echo number_format($dept['avg_salary'], 0, ',', '.'); ?></span>
                    </div>
                    <div style="background: #f0f0f0; border-radius: 4px; height: 20px;">
                        <div style="background: #667eea; height: 100%; border-radius: 4px; width: <?php echo $percentage; ?>%;"></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

<?php else: ?>
    <div style="text-align: center; padding: 3rem; background: #f8f9fa; border-radius: 8px;">
        <p style="font-size: 1.2rem; color: #666;">
            📊 Tidak ada data statistik gaji yang tersedia
        </p>
        <p style="color: #999;">
            Pastikan sudah ada data karyawan sudah dibuat di database.
        </p>
        <a href="index.php?action=create" class="btn btn-primary" style="margin-top: 1rem;">
            Tambah Data Karyawan
        </a>
    </div>
<?php endif; ?>

<!-- Informasi Footer -->
<div style="margin-top: 2rem; padding: 1rem; background: #e7f3ff; border-radius: 5px; border-left: 4px solid #3498db;">
    <strong>ℹ️ Informasi:</strong>
    <p style="margin: 0.5rem 0 0 0;">
        Data ini di-generate secara real-time dari query PostgreSQL
        yang menggunakan fungsi agregat:
    </p>
    <ul style="margin: 0.5rem 0 0 1.5rem;">
        <li><code>AVG(salary)</code> - Menghitung rata-rata gaji</li>
        <li><code>MIN(salary)</code> - Mencari gaji terendah</li>
        <li><code>MAX(salary)</code> - Mencari gaji tertinggi</li>
        <li><code>GROUP BY department</code> - Mengelompokkan per departemen</li>
    </ul>
</div>

<?php include 'views/footer.php'; ?>