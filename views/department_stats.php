<?php
/**
 * FILE: views/department_stats.php
 * FUNGSI: Menampilkan statistik karyawan per departemen menggunakan VIEW database
 */
include 'views/header.php';
?>

<h2>Statistik Departemen</h2>
<p style="margin-bottom: 2rem; color: #666;">
    Data statistik berikut diambil dari VIEW <code>department_stats</code> di database PostgreSQL.
</p>

<?php if ($stats->rowCount() > 0): ?>
    <?php
    // Hitung total statistics
    // Kita perlu fetch all dulu untuk menghitung total dan untuk looping nanti
    $stats->execute();
    $all_stats = $stats->fetchAll(PDO::FETCH_ASSOC);
    
    $total_employees = array_sum(array_column($all_stats, 'total_employees'));
    $total_salary_budget = array_sum(array_column($all_stats, 'total_salary_budget'));
    $avg_salary_all = ($total_employees > 0) ? ($total_salary_budget / $total_employees) : 0;
    
    // Ambil nilai max untuk normalisasi bar chart
    $max_avg_salary = max(array_column($all_stats, 'avg_salary'));
    $max_total_employees = max(array_column($all_stats, 'total_employees'));
    ?>

    <div class="dashboard-cards">
        <div class="card">
            <h3>Total Departemen</h3>
            <div class="number"><?php echo count($all_stats); ?></div>
        </div>
        <div class="card">
            <h3>Total Karyawan</h3>
            <div class="number"><?php echo $total_employees; ?></div>
        </div>
        <div class="card">
            <h3>Total Budget Gaji</h3>
            <div class="number">Rp <?php echo number_format($total_salary_budget, 0, ',', '.'); ?></div>
        </div>
        <div class="card">
            <h3>Rata-rata Gaji</h3>
            <div class="number">Rp <?php echo number_format($avg_salary_all, 0, ',', '.'); ?></div>
        </div>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>Departemen</th>
                <th>Jumlah Karyawan</th>
                <th>Gaji Rata-rata</th>
                <th>Gaji Terendah</th>
                <th>Gaji Tertinggi</th>
                <th>Total Budget</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($all_stats as $dept): ?>
                <tr>
                    <td>
                        <strong><?php echo htmlspecialchars($dept['department']); ?></strong>
                    </td>
                    <td style="text-align: center;">
                        <span style="padding: 0.25rem 0.75rem; background: #667eea; color: white; border-radius: 20px;">
                            <?php echo $dept['total_employees']; ?>
                        </span>
                    </td>
                    <td>
                        <strong>Rp <?php echo number_format($dept['avg_salary'], 0, ',', '.'); ?></strong>
                    </td>
                    <td>Rp <?php echo number_format($dept['min_salary'], 0, ',', '.'); ?></td>
                    <td>Rp <?php echo number_format($dept['max_salary'], 0, ',', '.'); ?></td>
                    <td>
                        <strong style="color: #27ae60;">
                            Rp <?php echo number_format($dept['total_salary_budget'], 0, ',', '.'); ?>
                        </strong>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div style="margin-top: 3rem;">
        <h3>Visualisasi Data</h3>
        
        <div style="background: white; padding: 1.5rem; border-radius: 8px; margin: 1rem 0; border-left: 4px solid #667eea;">
            <h4>Gaji Rata-rata per Departemen</h4>
            <?php foreach ($all_stats as $dept): ?>
                <div style="margin: 0.5rem 0;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.25rem;">
                        <span><?php echo htmlspecialchars($dept['department']); ?></span>
                        <span>Rp <?php echo number_format($dept['avg_salary'], 0, ',', '.'); ?></span>
                    </div>
                    <div style="background: #f0f0f0; border-radius: 4px; height: 20px;">
                        <div style="background: #667eea; height: 100%; border-radius: 4px; width: <?php echo ($dept['avg_salary'] / $max_avg_salary) * 100; ?>%;"></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div style="background: white; padding: 1.5rem; border-radius: 8px; margin: 1rem 0; border-left: 4px solid #27ae60;">
            <h4>Jumlah Karyawan per Departemen</h4>
            <?php foreach ($all_stats as $dept): ?>
                <div style="margin: 0.5rem 0;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.25rem;">
                        <span><?php echo htmlspecialchars($dept['department']); ?></span>
                        <span><?php echo $dept['total_employees']; ?> orang</span>
                    </div>
                    <div style="background: #f0f0f0; border-radius: 4px; height: 20px;">
                        <div style="background: #27ae60; height: 100%; border-radius: 4px; width: <?php echo ($dept['total_employees'] / $max_total_employees) * 100; ?>%;"></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

<?php else: ?>
    <div style="text-align: center; padding: 3rem; background: #f8f9fa; border-radius: 8px;">
        <p style="font-size: 1.2rem; color: #666;">X Tidak ada data statistik departemen.</p>
        <p style="color: #999;">Pastikan sudah ada data karyawan dan VIEW <code>department_stats</code> sudah dibuat di database.</p>
        <a href="index.php?action=create" class="btn btn-primary" style="margin-top: 1rem;">Tambah Data Karyawan</a>
    </div>
<?php endif; ?>

<div style="margin-top: 2rem; padding: 1rem; background: #e7f3ff; border-radius: 5px;">
    <strong>Informasi:</strong>
    Data ini di-generate secara real-time dari VIEW PostgreSQL yang menggunakan fungsi agregat
    <code>COUNT()</code>, <code>AVG()</code>, <code>MIN()</code>, <code>MAX()</code>, dan <code>SUM()</code>.
</div>

<?php include 'views/footer.php'; ?>