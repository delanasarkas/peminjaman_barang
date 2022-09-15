<?= $this->extend('layout\dashboard_template') ?>

<?= $this->section('content') ?>
    <div class="container-fluid px-4">
        <div class="row mt-4 mb-4">
            <div class="col-6">
                <h1><?= $title ?></h1>
            </div>
            <div class="col-6 text-end align-self-center">
                <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#modalTambahBarang">
                    <i class="fa fa-plus"></i> Tambah Barang
                </button>
            </div>
            <div class="col-lg-12 mt-3">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Qty</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach($barang_list as $data) : ?>
                        <tr>
                            <td class="text-center"><?= $i++; ?></td>
                            <td><?= $data['nama_barang'] ?></td>
                            <td><?= $data['nama_kategori'] ?></td>
                            <td><?= $data['qty_barang'] ?></td>
                            <td><?= $data['deskripsi_barang'] ?></td>
                            <td>
                                <button class="btn btn-secondary btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#modalUbahBarang-<?= $data['id_barang'] ?>">Ubah</button>
                                <button class="btn btn-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#modalHapusBarang-<?= $data['id_barang'] ?>">Hapus</button>
                            </td>
                        </tr>

                        <!-- Modal Ubah Barang -->
                        <div class="modal fade" id="modalUbahBarang-<?= $data['id_barang'] ?>" tabindex="-1" aria-labelledby="modalUbahBarangLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalUbahBarangLabel">Ubah Barang</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="<?= base_url('/barang-ubah'.'/'.$data['id_barang']); ?>" method="POST">
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="kategori" class="form-label">Kategori</label>
                                                        <select class="form-select" aria-label="Default select example" id="kategori" name="kategori" required>
                                                            <option value="" selected>Pilih Kategori</option>
                                                            <?php foreach($kategori_list as $data2) : ?>
                                                                <option value="<?= $data['id_kategori'] ?>" <?= $data2['id_kategori'] == $data['id_kategori'] ? 'selected' : '' ?>><?= $data['nama_kategori'] ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="nama_barang" class="form-label">Nama Barang</label>
                                                        <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="<?= $data['nama_barang'] ?>" placeholder="" required>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="mb-3">
                                                <label for="qty" class="form-label">QTY</label>
                                                <input type="number" class="form-control" id="qty" name="qty" value="<?= $data['qty_barang'] ?>" placeholder="" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="deskripsi" class="form-label">Deksripsi</label>
                                                <textarea class="form-control" id="deskripsi" rows="3" name="deskripsi" required><?= $data['deskripsi_barang'] ?></textarea>
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

                        <!-- MODAL HAPUS BARANG -->
                        <div class="modal fade" id="modalHapusBarang-<?= $data['id_barang'] ?>" tabindex="-1" aria-labelledby="modalHapusBarangLabel" aria-hidden="true">
                            <div class="modal-dialog modal-sm modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger text-light">
                                        <h5 class="modal-title" id="modalHapusBarangLabel">Hapus Barang</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="<?= base_url('/barang-hapus'.'/'.$data['id_barang']); ?>" method="GET">
                                        <div class="modal-body">
                                            <p>Hapus Data <?= $data['nama_barang'] ?> ?</p>
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

    <!-- Modal Tambah Barang -->
    <div class="modal fade" id="modalTambahBarang" tabindex="-1" aria-labelledby="modalTambahBarangLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahBarangLabel">Tambah Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url('/barang-tambah') ?>" method="POST">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="kategori" class="form-label">Kategori</label>
                                    <select class="form-select" aria-label="Default select example" id="kategori" name="kategori" required>
                                        <option value="" selected>Pilih Kategori</option>
                                        <?php foreach($kategori_list as $data) : ?>
                                            <option value="<?= $data['id_kategori'] ?>"><?= $data['nama_kategori'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="nama_barang" class="form-label">Nama Barang</label>
                                    <input type="text" class="form-control" id="nama_barang" name="nama_barang" placeholder="" required>
                                </div>
                            </div>
                        </div>


                        <div class="mb-3">
                            <label for="qty" class="form-label">QTY</label>
                            <input type="number" class="form-control" id="qty" name="qty" placeholder="" required>
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deksripsi</label>
                            <textarea class="form-control" id="deskripsi" rows="3" name="deskripsi" required></textarea>
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