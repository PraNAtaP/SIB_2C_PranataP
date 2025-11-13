<?php
/**
 * FILE: views/dashboard.php
 * FUNGSI: Menampilkan dashboard dengan data statistik
 */
include 'views/header.php';
?>

<h2>Dashboard Overview</h2>

<div class="dashboard-cards">
    <div class="card">
        <h3>Total Karyawan</h3>
        <div class="number"><?php echo $dashboard['total_employees']; ?></div>
    </div>
    <div class="card">
        <h3>Departemen</h3>
        <div class="number"><?php echo $dashboard['total_departments']; ?></div>
    </div>
    <div class="card">
        <h3>Proyek Aktif</h3>
        <div class="number"><?php echo $dashboard['active_projects']; ?></div>
    </div>
    <div class="card">
        <h3>Total Proyek</h3>
        <div class="number"><?php echo $dashboard['total_projects']; ?></div>
    </div>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1rem; margin: 2rem 0;">
    <div class="card">
        <h3>Gaji Rata-rata</h3>
        <div class="number">Rp <?php echo number_format($dashboard['company_avg_salary'], 0, ',', '.'); ?></div>
    </div>
    <div class="card">
        <h3>Gaji Tertinggi</h3>
        <div class="number">Rp <?php echo number_format($dashboard['highest_salary'], 0, ',', '.'); ?></div>
    </div>
    <div class="card">
        <h3>Gaji Terendah</h3>
        <div class="number">Rp <?php echo number_format($dashboard['lowest_salary'], 0, ',', '.'); ?></div>
    </div>
    <div class="card">
        <h3>Masa Kerja Rata-rata</h3>
        <div class="number"><?php echo $dashboard['avg_years_service']; ?> tahun</div>
    </div>
</div>

<div class="card">
    <h3>Total Budget Proyek</h3>
    <div class="number" style="font-size: 1.5rem;">
        Rp <?php echo number_format($dashboard['total_project_budget'], 0, ',', '.'); ?>
    </div>
    <p style="margin-top: 0.5rem; color: #666;">
        <?php echo $dashboard['active_projects']; ?> proyek aktif |
        <?php echo $dashboard['planning_projects']; ?> proyek dalam perencanaan
    </p>
</div>

<?php include 'views/footer.php'; ?>