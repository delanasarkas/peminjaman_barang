<?= $this->extend('layout\dashboard_template') ?>

<?= $this->section('content') ?>
    <div class="container-fluid px-4">
        <div class="row mt-4 mb-4">
            <div class="col-6">
                <h1><?= $title ?></h1>
            </div>
            <div class="col-6 text-end align-self-center">
                <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#modalTambahKaryawan">
                    <i class="fa fa-plus"></i> Tambah Karyawan
                </button>
            </div>
            <div class="col-lg-12 mt-3">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Nama Karyawan</th>
                            <th>Email</th>
                            <th>No Telepon</th>
                            <th>Alamat</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach($users_list as $data) : ?>
                        <tr>
                            <td class="text-center"><?= $i++; ?></td>
                            <td><?= $data['nama'] ?></td>
                            <td><?= $data['email'] ?></td>
                            <td><?= $data['no_telepon'] ?></td>
                            <td><?= $data['alamat'] ?></td>
                            <td><?= $data['role'] ?></td>
                            <td>
                                <div class="badge <?= $data['status'] == '1' ? 'bg-success' : 'bg-danger' ?>">
                                    <?= $data['status'] == '1' ? 'Aktif' : 'Tidak aktif' ?>
                                </div>
                            </td>
                            <td>
                                <button class="btn btn-secondary btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#modalUbahKaryawan-<?= $data['id_users'] ?>">Ubah</button>
                                <button class="btn btn-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#modalHapusKaryawan-<?= $data['id_users'] ?>">Hapus</button>
                            </td>
                        </tr>

                        <!-- Modal Ubah Karyawan -->
                        <div class="modal fade" id="modalUbahKaryawan-<?= $data['id_users'] ?>" tabindex="-1" aria-labelledby="modalUbahKaryawanLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalUbahKaryawanLabel">Ubah Karyawan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="<?= base_url('/karyawan-ubah'.'/'.$data['id_users']); ?>" method="POST">
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="nama" class="form-label">Nama Karyawan</label>
                                                        <input type="text" class="form-control" id="nama" name="nama" value="<?= $data['nama'] ?>" placeholder="" required>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="email" class="form-label">Email</label>
                                                        <input type="email" class="form-control" id="email" name="email" value="<?= $data['email'] ?>" placeholder="" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="no_telepon" class="form-label">No Telp</label>
                                                <input type="number" class="form-control" id="no_telepon" name="no_telepon" value="<?= $data['no_telepon'] ?>" placeholder="" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="alamat" class="form-label">Alamat</label>
                                                <textarea class="form-control" id="alamat" rows="3" name="alamat" required><?= $data['alamat'] ?></textarea>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="role" class="form-label">Role</label>
                                                        <select class="form-select" aria-label="Default select example" id="role" name="role" required>
                                                            <option value="">Pilih Kategori</option>
                                                            <option value="admin" <?= $data['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                                                            <option value="teknisi" <?= $data['role'] == 'teknisi' ? 'selected' : '' ?>>Teknisi</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="status" class="form-label">Status</label>
                                                        <select class="form-select" aria-label="Default select example" id="status" name="status" required>
                                                            <option value="">Pilih Status</option>
                                                            <option value="1" <?= $data['status'] == '1' ? 'selected' : '' ?>>Aktif</option>
                                                            <option value="0" <?= $data['status'] == '0' ? 'selected' : '' ?>>Tidak Aktif</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-transparent" data-bs-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-primary">Ubah</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- MODAL HAPUS KARYAWAN -->
                        <div class="modal fade" id="modalHapusKaryawan-<?= $data['id_users'] ?>" tabindex="-1" aria-labelledby="modalHapusKaryawanLabel" aria-hidden="true">
                            <div class="modal-dialog modal-sm modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger text-light">
                                        <h5 class="modal-title" id="modalHapusKaryawanLabel">Hapus Karyawan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="<?= base_url('/karyawan-hapus'.'/'.$data['id_users']); ?>" method="GET">
                                        <div class="modal-body">
                                            <p>Hapus Data <?= $data['nama'] ?> ?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-transparent" data-bs-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Kategori -->
    <div class="modal fade" id="modalTambahKaryawan" tabindex="-1" aria-labelledby="modalTambahKaryawanLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahKaryawanLabel">Tambah Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url('/karyawan-tambah') ?>" method="POST">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Karyawan</label>
                                    <input type="text" class="form-control" id="nama" name="nama" placeholder="" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="no_telepon" class="form-label">No Telp</label>
                            <input type="number" class="form-control" id="no_telepon" name="no_telepon" placeholder="" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" id="alamat" rows="3" name="alamat" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="role" class="form-label">Role</label>
                                    <select class="form-select" aria-label="Default select example" id="role" name="role" required>
                                        <option value="" selected>Pilih Kategori</option>
                                        <option value="admin">Admin</option>
                                        <option value="teknisi">Teknisi</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" aria-label="Default select example" id="status" name="status" required>
                                        <option value="" selected>Pilih Status</option>
                                        <option value="1">Aktif</option>
                                        <option value="0">Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="text" class="form-control" id="password" name="password" placeholder="" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-transparent" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>