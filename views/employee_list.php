<?php
/**
 * FILE: views/employee_list.php
 * FUNGSI: Menampilkan daftar semua karyawan dalam bentuk tabel
 */
include 'views/header.php';
?>

<h2>Daftar Karyawan</h2>

<?php if (isset($_GET['message'])): ?>
    <div class="alert alert-success">
        <?php
        $messages = [
            'created' => 'Karyawan berhasil ditambahkan!',
            'updated' => 'Data karyawan berhasil diupdate!',
            'deleted' => 'Karyawan berhasil dihapus!'
        ];
        echo $messages[$_GET['message']] ?? 'Operasi berhasil!';
        ?>
    </div>
<?php endif; ?>

<div style="margin-bottom: 1rem;">
    <a href="index.php?action=create" class="btn btn-primary">Tambah Karyawan Baru</a>
</div>

<table class="data-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama Lengkap</th>
            <th>Email</th>
            <th>Departemen</th>
            <th>Posisi</th>
            <th>Gaji</th>
            <th>Tanggal Mulai</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($employees->rowCount() > 0): ?>
            <?php while ($row = $employees->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td>
                        <strong><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></strong>
                    </td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td>
                        <span style="padding: 0.25rem 0.5rem; background: #e9ecef; border-radius: 4px;">
                            <?php echo htmlspecialchars($row['department']); ?>
                        </span>
                    </td>
                    <td><?php echo htmlspecialchars($row['position']); ?></td>
                    <td>
                        <strong>Rp <?php echo number_format($row['salary'], 0, ',', '.'); ?></strong>
                    </td>
                    <td><?php echo date('d/m/Y', strtotime($row['hire_date'])); ?></td>
                    <td>
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="index.php?action=edit&id=<?php echo $row['id']; ?>" class="btn btn-edit" title="Edit karyawan">
                                Edit
                            </a>
                            <a href="index.php?action=delete&id=<?php echo $row['id']; ?>" class="btn btn-delete" title="Hapus karyawan"
                               onclick="return confirm('Apakah Anda yakin ingin menghapus karyawan <?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?>?')">
                                Hapus
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="8" style="text-align: center; padding: 2rem;">
                    <p>Tidak ada data karyawan.</p>
                    <a href="index.php?action=create" class="btn btn-primary">Tambah Karyawan Pertama</a>
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<div style="margin-top: 1rem; padding: 1rem; background: #f8f9fa; border-radius: 5px;">
    <strong>Total Data:</strong> <?php echo $employees->rowCount(); ?> karyawan
</div>

<?php include 'views/footer.php'; ?>