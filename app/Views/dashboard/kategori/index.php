<?= $this->extend('layout\dashboard_template') ?>

<?= $this->section('content') ?>
    <div class="container-fluid px-4">
        <div class="row mt-4 mb-4">
            <div class="col-6">
                <h1><?= $title ?></h1>
            </div>
            <div class="col-6 text-end align-self-center">
                <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#modalTambahKategori">
                    <i class="fa fa-plus"></i> Tambah Kategori
                </button>
            </div>
            <div class="col-lg-12 mt-3">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Nama Kategori</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach($kategori_list as $data) : ?>
                        <tr>
                            <td class="text-center"><?= $i++; ?></td>
                            <td><?= $data['nama_kategori'] ?></td>
                            <td>
                                <button class="btn btn-secondary btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#modalUbahKategori-<?= $data['id_kategori'] ?>">Ubah</button>
                                <button class="btn btn-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#modalHapusKategori-<?= $data['id_kategori'] ?>">Hapus</button>
                            </td>
                        </tr>

                        <!-- Modal Ubah Kategori -->
                        <div class="modal fade" id="modalUbahKategori-<?= $data['id_kategori'] ?>" tabindex="-1" aria-labelledby="modalUbahKategoriLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalUbahKategoriLabel">Ubah Kategori</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="<?= base_url('/kategori-ubah'.'/'.$data['id_kategori']); ?>" method="POST">
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="nama_kategori" class="form-label">Nama Kategori</label>
                                                <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" value="<?= $data['nama_kategori'] ?>" placeholder="" required>
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

                        <!-- MODAL HAPUS KATEGORI -->
                        <div class="modal fade" id="modalHapusKategori-<?= $data['id_kategori'] ?>" tabindex="-1" aria-labelledby="modalHapusKategoriLabel" aria-hidden="true">
                            <div class="modal-dialog modal-sm modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger text-light">
                                        <h5 class="modal-title" id="modalHapusKategoriLabel">Hapus Kategori</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="<?= base_url('/kategori-hapus'.'/'.$data['id_kategori']); ?>" method="GET">
                                        <div class="modal-body">
                                            <p>Hapus Data <?= $data['nama_kategori'] ?> ?</p>
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
    <div class="modal fade" id="modalTambahKategori" tabindex="-1" aria-labelledby="modalTambahKategoriLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahKategoriLabel">Tambah Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url('/kategori-tambah') ?>" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_kategori" class="form-label">Nama Kategori</label>
                            <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" placeholder="" required>
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