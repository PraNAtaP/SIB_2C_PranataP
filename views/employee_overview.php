<?php
include 'views/header.php';

// Fetch data overview
$overview = $stats->fetch(PDO::FETCH_ASSOC);
?>

<h2>Ringkasan Overview Karyawan</h2>
<p style="margin-bottom: 2rem; color: #666;">
    Data ringkasan keseluruhan karyawan menggunakan fungsi agregat COUNT(), SUM(), dan AVG().
</p>

<?php if ($overview): ?>
    <!-- Main Statistics Cards -->
    <div class="dashboard-cards">
        <div class="card" style="border-left: 4px solid #3498db;">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <h3>👥 Total Karyawan</h3>
                    <div class="number" style="color: #3498db;">
                        <?php echo number_format($overview['total_employees']); ?>
                    </div>
                    <small style="color: #666;">Karyawan aktif</small>
                </div>
                <div style="font-size: 3rem; opacity: 0.1;">👥</div>
            </div>
        </div>
        
        <div class="card" style="border-left: 4px solid #27ae60;">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <h3>💰 Total Gaji/Bulan</h3>
                    <div class="number" style="color: #27ae60;">
                        Rp <?php echo number_format($overview['total_salary'], 0, ',', '.'); ?>
                    </div>
                    <small style="color: #666;">Budget gaji bulanan</small>
                </div>
                <div style="font-size: 3rem; opacity: 0.1;">💰</div>
            </div>
        </div>
        
        <div class="card" style="border-left: 4px solid #f39c12;">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <h3>📊 Rata-rata Gaji</h3>
                    <div class="number" style="color: #f39c12;">
                        Rp <?php echo number_format($overview['avg_salary'], 0, ',', '.'); ?>
                    </div>
                    <small style="color: #666;">Gaji rata-rata/karyawan</small>
                </div>
                <div style="font-size: 3rem; opacity: 0.1;">📊</div>
            </div>
        </div>
        
        <div class="card" style="border-left: 4px solid #9b59b6;">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <h3>⏱️ Rata-rata Masa Kerja</h3>
                    <div class="number" style="color: #9b59b6;">
                        <?php echo number_format($overview['avg_tenure_years'], 1); ?>
                    </div>
                    <small style="color: #666;">Tahun</small>
                </div>
                <div style="font-size: 3rem; opacity: 0.1;">⏱️</div>
            </div>
        </div>
    </div>

    <!-- Detail Statistics -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; margin-top: 2rem;">
        
        <!-- Gaji Statistics -->
        <div style="background: white; padding: 1.5rem; border-radius: 8px; border-left: 4px solid #27ae60;">
            <h4 style="margin-top: 0;">💵 Statistik Gaji</h4>
            <div style="margin: 1rem 0;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                    <span style="color: #666;">Gaji Terendah:</span>
                    <strong style="color: #e74c3c;">
                        Rp <?php echo number_format($overview['min_salary'], 0, ',', '.'); ?>
                    </strong>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                    <span style="color: #666;">Gaji Rata-rata:</span>
                    <strong style="color: #f39c12;">
                        Rp <?php echo number_format($overview['avg_salary'], 0, ',', '.'); ?>
                    </strong>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                    <span style="color: #666;">Gaji Tertinggi:</span>
                    <strong style="color: #27ae60;">
                        Rp <?php echo number_format($overview['max_salary'], 0, ',', '.'); ?>
                    </strong>
                </div>
                <hr style="margin: 1rem 0; border: none; border-top: 1px solid #eee;">
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: #666;"><strong>Total Budget:</strong></span>
                    <strong style="color: #27ae60; font-size: 1.1rem;">
                        Rp <?php echo number_format($overview['total_salary'], 0, ',', '.'); ?>
                    </strong>
                </div>
            </div>
            
            <!-- Visualisasi Range Gaji -->
            <div style="margin-top: 1.5rem;">
                <p style="font-size: 0.9rem; color: #666; margin-bottom: 0.5rem;">Range Gaji:</p>
                <div style="background: #f0f0f0; border-radius: 4px; height: 30px; position: relative; overflow: hidden;">
                    <div style="position: absolute; left: 0; width: 33.33%; height: 100%; background: linear-gradient(to right, #e74c3c, #f39c12);
                    display: flex; align-items: center; justify-content: center; color: white; font-size: 0.75rem; font-weight: bold;">
                        MIN
                    </div>
                    <div style="position: absolute; left: 33.33%; width: 33.33%; height: 100%; background: linear-gradient(to right, #f39c12, #27ae60);
                    display: flex; align-items: center; justify-content: center; color: white; font-size: 0.75rem; font-weight: bold;">
                        AVG
                    </div>
                    <div style="position: absolute; left: 66.66%; width: 33.34%; height: 100%; background: #27ae60;
                    display: flex; align-items: center; justify-content: center; color: white; font-size: 0.75rem; font-weight: bold;">
                        MAX
                    </div>
                </div>
            </div>
        </div>

        <!-- Masa Kerja Statistics -->
        <div style="background: white; padding: 1.5rem; border-radius: 8px; border-left: 4px solid #9b59b6;">
            <h4 style="margin-top: 0;">📅 Statistik Masa Kerja</h4>
            <div style="margin: 1rem 0;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                    <span style="color: #666;">Masa Kerja Terpendek:</span>
                    <strong style="color: #3498db;">
                        <?php echo number_format($overview['min_tenure_years'], 1); ?> tahun
                    </strong>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                    <span style="color: #666;">Masa Kerja Rata-rata:</span>
                    <strong style="color: #f39c12;">
                        <?php echo number_format($overview['avg_tenure_years'], 1); ?> tahun
                    </strong>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                    <span style="color: #666;">Masa Kerja Terlama:</span>
                    <strong style="color: #27ae60;">
                        <?php echo number_format($overview['max_tenure_years'], 1); ?> tahun
                    </strong>
                </div>
                <hr style="margin: 1rem 0; border: none; border-top: 1px solid #eee;">
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: #666;"><strong>Total Karyawan:</strong></span>
                    <strong style="color: #9b59b6; font-size: 1.1rem;">
                        <?php echo number_format($overview['total_employees']); ?> orang
                    </strong>
                </div>
            </div>
            
            <!-- Visualisasi Masa Kerja -->
            <div style="margin-top: 1.5rem;">
                <p style="font-size: 0.9rem; color: #666; margin-bottom: 0.5rem;">Distribusi Masa Kerja:</p>
                <div style="display: flex; gap: 0.5rem;">
                    <div style="flex: 1; text-align: center;">
                        <div style="background: #3498db; color: white; padding: 0.5rem; border-radius: 4px; font-size: 0.8rem; font-weight: bold;">
                            MIN
                        </div>
                        <div style="font-size: 0.75rem; color: #666; margin-top: 0.25rem;">
                            <?php echo number_format($overview['min_tenure_years'], 1); ?>th
                        </div>
                    </div>
                    <div style="flex: 1; text-align: center;">
                        <div style="background: #f39c12; color: white; padding: 0.5rem; border-radius: 4px; font-size: 0.8rem; font-weight: bold;">
                            AVG
                        </div>
                        <div style="font-size: 0.75rem; color: #666; margin-top: 0.25rem;">
                            <?php echo number_format($overview['avg_tenure_years'], 1); ?>th
                        </div>
                    </div>
                    <div style="flex: 1; text-align: center;">
                        <div style="background: #27ae60; color: white; padding: 0.5rem; border-radius: 4px; font-size: 0.8rem; font-weight: bold;">
                            MAX
                        </div>
                        <div style="font-size: 0.75rem; color: #666; margin-top: 0.25rem;">
                            <?php echo number_format($overview['max_tenure_years'], 1); ?>th
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Financial Overview -->
        <div style="background: white; padding: 1.5rem; border-radius: 8px; border-left: 4px solid #e74c3c;">
            <h4 style="margin-top: 0;">💼 Proyeksi Finansial</h4>
            <div style="margin: 1rem 0;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                    <span style="color: #666;">Budget/Bulan:</span>
                    <strong>Rp <?php echo number_format($overview['total_salary'], 0, ',', '.'); ?></strong>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                    <span style="color: #666;">Budget/Tahun:</span>
                    <strong style="color: #e74c3c;">
                        Rp <?php echo number_format($overview['total_salary'] * 12, 0, ',', '.'); ?>
                    </strong>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                    <span style="color: #666;">Biaya per Karyawan/Bulan:</span>
                    <strong>Rp <?php echo number_format($overview['avg_salary'], 0, ',', '.'); ?></strong>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                    <span style="color: #666;">Biaya per Karyawan/Tahun:</span>
                    <strong>Rp <?php echo number_format($overview['avg_salary'] * 12, 0, ',', '.'); ?></strong>
                </div>
            </div>
            
            <!-- Quick Info -->
            <div style="background: #fff3cd; padding: 0.75rem; border-radius: 4px; margin-top: 1rem; border-left: 3px solid #f39c12;">
                <strong style="color: #856404;">💡 Info:</strong>
                <p style="margin: 0.5rem 0 0 0; font-size: 0.9rem; color: #856404;">
                    Rata-rata biaya per karyawan adalah <strong>Rp <?php echo number_format($overview['avg_salary'], 0, ',', '.'); ?>/bulan</strong>
                </p>
            </div>
        </div>

    </div>

    <!-- Summary Table -->
    <div style="margin-top: 2rem;">
        <h3>📋 Ringkasan Lengkap</h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th colspan="2" style="text-align: center; background: #667eea; color: white;">
                        DATA KARYAWAN
                    </th>
                    <th colspan="2" style="text-align: center; background: #27ae60; color: white;">
                        DATA GAJI
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Total Karyawan</strong></td>
                    <td><?php echo number_format($overview['total_employees']); ?> orang</td>
                    <td><strong>Total Gaji/Bulan</strong></td>
                    <td>Rp <?php echo number_format($overview['total_salary'], 0, ',', '.'); ?></td>
                </tr>
                <tr>
                    <td><strong>Rata-rata Masa Kerja</strong></td>
                    <td><?php echo number_format($overview['avg_tenure_years'], 1); ?> tahun</td>
                    <td><strong>Rata-rata Gaji</strong></td>
                    <td>Rp <?php echo number_format($overview['avg_salary'], 0, ',', '.'); ?></td>
                </tr>
                <tr>
                    <td><strong>Masa Kerja Terpendek</strong></td>
                    <td><?php echo number_format($overview['min_tenure_years'], 1); ?> tahun</td>
                    <td><strong>Gaji Terendah</strong></td>
                    <td>Rp <?php echo number_format($overview['min_salary'], 0, ',', '.'); ?></td>
                </tr>
                <tr>
                    <td><strong>Masa Kerja Terlama</strong></td>
                    <td><?php echo number_format($overview['max_tenure_years'], 1); ?> tahun</td>
                    <td><strong>Gaji Tertinggi</strong></td>
                    <td>Rp <?php echo number_format($overview['max_salary'], 0, ',', '.'); ?></td>
                </tr>
                <tr style="background: #f8f9fa; font-weight: bold;">
                    <td colspan="2"></td>
                    <td><strong>Proyeksi Budget/Tahun</strong></td>
                    <td style="color: #e74c3c;">
                        Rp <?php echo number_format($overview['total_salary'] * 12, 0, ',', '.'); ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

<?php else: ?>
    <div style="text-align: center; padding: 3rem; background: #f8f9fa; border-radius: 8px;">
        <p style="font-size: 1.2rem; color: #666;">
            📊 Tidak ada data karyawan yang tersedia
        </p>
        <p style="color: #999;">
            Silakan tambahkan data karyawan terlebih dahulu.
        </p>
        <a href="index.php?action=create" class="btn btn-primary" style="margin-top: 1rem;">
            Tambah Data Karyawan
        </a>
    </div>
<?php endif; ?>

<!-- Informasi Footer -->
<div style="margin-top: 2rem; padding: 1rem; background: #e7f3ff; border-radius: 5px; border-left: 4px solid #3498db;">
    <strong>ℹ️ Informasi Query SQL:</strong>
    <p style="margin: 0.5rem 0 0 0;">
        Data ringkasan ini menggunakan fungsi agregat SQL:
    </p>
    <ul style="margin: 0.5rem 0 0 1.5rem;">
        <li><code>COUNT(*)</code> - Menghitung total karyawan</li>
        <li><code>SUM(salary)</code> - Menjumlahkan total gaji per bulan</li>
        <li><code>AVG(salary)</code> - Menghitung rata-rata gaji</li>
        <li><code>AVG(EXTRACT(YEAR FROM AGE(CURRENT_DATE, hire_date)))</code> - Menghitung rata-rata masa kerja</li>
        <li><code>MIN(salary)</code> & <code>MAX(salary)</code> - Mencari gaji terendah & tertinggi</li>
        <li><code>MIN(tenure)</code> & <code>MAX(tenure)</code> - Mencari masa kerja terpendek & terlama</li>
    </ul>
</div>

<?php include 'views/footer.php'; ?>