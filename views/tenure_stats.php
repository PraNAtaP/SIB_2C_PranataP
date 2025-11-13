<?php
include 'views/header.php';
?>

<h2>Statistik Masa Kerja Karyawan</h2>
<p style="margin-bottom: 2rem; color: #666;">
    Data statistik berikut menggunakan query dengan fungsi agregat COUNT(), CASE WHEN, AVG(), SUM(), dan GROUP BY.
</p>

<?php if ($stats->rowCount() > 0): ?>
    <?php
    // Fetch semua data
    $stats->execute();
    $all_stats = $stats->fetchAll(PDO::FETCH_ASSOC);

    // Hitung total keseluruhan
    $total_employees = array_sum(array_column($all_stats, 'total_employees'));
    $total_salary_budget = array_sum(array_column($all_stats, 'total_salary_budget'));
    
    // Prepare data per level
    $level_data = [];
    foreach ($all_stats as $stat) {
        $level_data[$stat['tenure_level']] = $stat;
    }
    ?>

    <!-- Cards Summary per Level -->
    <div class="dashboard-cards">
        <div class="card" style="border-left: 4px solid #3498db;">
            <h3>Junior (&lt;1 tahun)</h3>
            <div class="number">
                <?php echo isset($level_data['Junior']) ? $level_data['Junior']['total_employees'] : 0; ?> orang
            </div>
            <small style="color: #666;">
                <?php 
                if (isset($level_data['Junior']) && $total_employees > 0) {
                    $pct = ($level_data['Junior']['total_employees'] / $total_employees * 100);
                    echo number_format($pct, 1) . '% dari total';
                }
                ?>
            </small>
        </div>
        
        <div class="card" style="border-left: 4px solid #f39c12;">
            <h3>Middle (1-3 tahun)</h3>
            <div class="number">
                <?php echo isset($level_data['Middle']) ? $level_data['Middle']['total_employees'] : 0; ?> orang
            </div>
            <small style="color: #666;">
                <?php 
                if (isset($level_data['Middle']) && $total_employees > 0) {
                    $pct = ($level_data['Middle']['total_employees'] / $total_employees * 100);
                    echo number_format($pct, 1) . '% dari total';
                }
                ?>
            </small>
        </div>
        
        <div class="card" style="border-left: 4px solid #27ae60;">
            <h3>Senior (&gt;3 tahun)</h3>
            <div class="number">
                <?php echo isset($level_data['Senior']) ? $level_data['Senior']['total_employees'] : 0; ?> orang
            </div>
            <small style="color: #666;">
                <?php 
                if (isset($level_data['Senior']) && $total_employees > 0) {
                    $pct = ($level_data['Senior']['total_employees'] / $total_employees * 100);
                    echo number_format($pct, 1) . '% dari total';
                }
                ?>
            </small>
        </div>
        
        <div class="card" style="border-left: 4px solid #9b59b6;">
            <h3>Total Keseluruhan</h3>
            <div class="number"><?php echo $total_employees; ?> orang</div>
            <small style="color: #666;">Semua level</small>
        </div>
    </div>

    <!-- Tabel Statistik Detail -->
    <table class="data-table">
        <thead>
            <tr>
                <th>Level Masa Kerja</th>
                <th>Kriteria</th>
                <th>Jumlah Karyawan</th>
                <th>Persentase</th>
                <th>Gaji Rata-rata</th>
                <th>Total Budget</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $colors = [
                'Junior' => '#3498db',
                'Middle' => '#f39c12',
                'Senior' => '#27ae60'
            ];
            
            $criteria = [
                'Junior' => '< 1 tahun',
                'Middle' => '1 - 3 tahun',
                'Senior' => '> 3 tahun'
            ];
            
            foreach ($all_stats as $stat): 
                $percentage = $total_employees > 0 ? ($stat['total_employees'] / $total_employees * 100) : 0;
            ?>
                <tr>
                    <td>
                        <strong style="color: <?php echo $colors[$stat['tenure_level']]; ?>;">
                            <?php echo htmlspecialchars($stat['tenure_level']); ?>
                        </strong>
                    </td>
                    <td style="color: #666;">
                        <?php echo $criteria[$stat['tenure_level']]; ?>
                    </td>
                    <td style="text-align: center;">
                        <span style="padding: 0.25rem 0.75rem; background: <?php echo $colors[$stat['tenure_level']]; ?>; color: white; border-radius: 20px;">
                            <?php echo $stat['total_employees']; ?>
                        </span>
                    </td>
                    <td style="text-align: center;">
                        <strong><?php echo number_format($percentage, 1); ?>%</strong>
                    </td>
                    <td>
                        <strong>Rp <?php echo number_format($stat['avg_salary'], 0, ',', '.'); ?></strong>
                    </td>
                    <td>
                        <strong style="color: #27ae60;">
                            Rp <?php echo number_format($stat['total_salary_budget'], 0, ',', '.'); ?>
                        </strong>
                    </td>
                </tr>
            <?php endforeach; ?>
            <tr style="background: #f8f9fa; font-weight: bold;">
                <td colspan="2">TOTAL</td>
                <td style="text-align: center;">
                    <span style="padding: 0.25rem 0.75rem; background: #9b59b6; color: white; border-radius: 20px;">
                        <?php echo $total_employees; ?>
                    </span>
                </td>
                <td style="text-align: center;">100%</td>
                <td>
                    Rp <?php echo $total_employees > 0 ? number_format($total_salary_budget / $total_employees, 0, ',', '.') : 0; ?>
                </td>
                <td>
                    <strong style="color: #27ae60;">
                        Rp <?php echo number_format($total_salary_budget, 0, ',', '.'); ?>
                    </strong>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Visualisasi Data -->
    <div style="margin-top: 3rem;">
        <h3>Visualisasi Data</h3>

        <!-- Chart Distribusi Karyawan -->
        <div style="background: white; padding: 1.5rem; border-radius: 8px; margin: 1rem 0; border-left: 4px solid #9b59b6;">
            <h4>Distribusi Karyawan Berdasarkan Masa Kerja</h4>
            <?php foreach ($all_stats as $stat): 
                $percentage = $total_employees > 0 ? ($stat['total_employees'] / $total_employees * 100) : 0;
            ?>
                <div style="margin: 0.5rem 0;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.25rem;">
                        <span>
                            <strong style="color: <?php echo $colors[$stat['tenure_level']]; ?>;">
                                <?php echo $stat['tenure_level']; ?>
                            </strong>
                            (<?php echo $criteria[$stat['tenure_level']]; ?>)
                        </span>
                        <span>
                            <strong><?php echo $stat['total_employees']; ?> orang</strong>
                            <span style="color: #666;"> (<?php echo number_format($percentage, 1); ?>%)</span>
                        </span>
                    </div>
                    <div style="background: #f0f0f0; border-radius: 4px; height: 25px;">
                        <div style="background: <?php echo $colors[$stat['tenure_level']]; ?>; height: 100%; border-radius: 4px; width: <?php echo $percentage; ?>%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 0.85rem;">
                            <?php if ($percentage > 15) echo number_format($percentage, 1) . '%'; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Chart Gaji Rata-rata -->
        <div style="background: white; padding: 1.5rem; border-radius: 8px; margin: 1rem 0; border-left: 4px solid #e74c3c;">
            <h4>Gaji Rata-rata Berdasarkan Masa Kerja</h4>
            <?php 
            $max_salary = max(array_column($all_stats, 'avg_salary'));
            foreach ($all_stats as $stat): 
                $salary_percentage = $max_salary > 0 ? ($stat['avg_salary'] / $max_salary * 100) : 0;
            ?>
                <div style="margin: 0.5rem 0;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.25rem;">
                        <span>
                            <strong style="color: <?php echo $colors[$stat['tenure_level']]; ?>;">
                                <?php echo $stat['tenure_level']; ?>
                            </strong>
                        </span>
                        <span>Rp <?php echo number_format($stat['avg_salary'], 0, ',', '.'); ?></span>
                    </div>
                    <div style="background: #f0f0f0; border-radius: 4px; height: 25px;">
                        <div style="background: <?php echo $colors[$stat['tenure_level']]; ?>; height: 100%; border-radius: 4px; width: <?php echo $salary_percentage; ?>%;"></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Pie Chart Representation -->
        <div style="background: white; padding: 1.5rem; border-radius: 8px; margin: 1rem 0; border-left: 4px solid #34495e;">
            <h4>Komposisi Karyawan</h4>
            <div style="display: flex; align-items: center; gap: 2rem; flex-wrap: wrap;">
                <div style="flex: 1; min-width: 200px;">
                    <?php foreach ($all_stats as $stat): 
                        $percentage = $total_employees > 0 ? ($stat['total_employees'] / $total_employees * 100) : 0;
                    ?>
                        <div style="margin: 1rem 0;">
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <div style="width: 20px; height: 20px; background: <?php echo $colors[$stat['tenure_level']]; ?>; border-radius: 3px;"></div>
                                <div style="flex: 1;">
                                    <div style="font-weight: bold;"><?php echo $stat['tenure_level']; ?></div>
                                    <div style="color: #666; font-size: 0.9rem;">
                                        <?php echo $stat['total_employees']; ?> orang (<?php echo number_format($percentage, 1); ?>%)
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div style="flex: 1; min-width: 200px;">
                    <div style="background: #f8f9fa; padding: 1rem; border-radius: 8px;">
                        <h5 style="margin-top: 0;">📊 Insight</h5>
                        <?php
                        // Find dominant level
                        $sorted_stats = $all_stats;
                        usort($sorted_stats, function($a, $b) {
                            return $b['total_employees'] - $a['total_employees'];
                        });
                        $dominant = $sorted_stats[0];
                        $dominant_pct = $total_employees > 0 ? ($dominant['total_employees'] / $total_employees * 100) : 0;
                        ?>
                        <p style="margin: 0.5rem 0; font-size: 0.95rem;">
                            Level <strong style="color: <?php echo $colors[$dominant['tenure_level']]; ?>;">
                            <?php echo $dominant['tenure_level']; ?></strong> mendominasi 
                            dengan <strong><?php echo number_format($dominant_pct, 1); ?>%</strong> 
                            dari total karyawan.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php else: ?>
    <div style="text-align: center; padding: 3rem; background: #f8f9fa; border-radius: 8px;">
        <p style="font-size: 1.2rem; color: #666;">
            📊 Tidak ada data statistik masa kerja yang tersedia
        </p>
        <p style="color: #999;">
            Pastikan sudah ada data karyawan dengan kolom <code>hire_date</code> di database.
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
        Data ini di-generate secara real-time menggunakan query SQL dengan fungsi agregat dan conditional logic:
    </p>
    <ul style="margin: 0.5rem 0 0 1.5rem;">
        <li><code>CASE WHEN</code> - Mengkategorikan masa kerja berdasarkan <code>hire_date</code></li>
        <li><code>COUNT(*)</code> - Menghitung jumlah karyawan per level</li>
        <li><code>AVG(salary)</code> - Menghitung rata-rata gaji per level</li>
        <li><code>SUM(salary)</code> - Menghitung total budget per level</li>
        <li><code>GROUP BY</code> - Mengelompokkan berdasarkan level masa kerja</li>
    </ul>
    <div style="margin-top: 1rem; padding: 0.75rem; background: white; border-radius: 4px;">
        <strong>Kategori Masa Kerja:</strong>
        <ul style="margin: 0.5rem 0 0 1.5rem;">
            <li><strong style="color: #3498db;">Junior</strong>: Masa kerja kurang dari 1 tahun</li>
            <li><strong style="color: #f39c12;">Middle</strong>: Masa kerja 1 sampai 3 tahun</li>
            <li><strong style="color: #27ae60;">Senior</strong>: Masa kerja lebih dari 3 tahun</li>
        </ul>
    </div>
</div>

<?php include 'views/footer.php'; ?>