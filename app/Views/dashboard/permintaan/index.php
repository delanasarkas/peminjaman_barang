<?= $this->extend('layout\dashboard_template') ?>

<?= $this->section('content') ?>
    <div class="container-fluid px-4">
        <div class="row mt-4 mb-4">
            <div class="col-6">
                <h1><?= $title ?></h1>
            </div>
            <?php if(session()->get('role') == 'teknisi') : ?>
            <div class="col-6 text-end align-self-center">
                <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#modalTambahRequest">
                    <i class="fa fa-plus"></i> Request
                </button>
            </div>
            <?php endif; ?>
            <div class="col-lg-12 mt-3">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Kode Permintaan</th>
                            <th>Teknisi</th>
                            <th>Tgl Permintaan</th>
                            <th>Barang</th>
                            <th>Jumlah</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach($permintaan_list as $data) : ?>
                        <tr>
                            <td class="text-center"><?= $i++; ?></td>
                            <td><?= $data['id_permintaan'] ?></td>
                            <td><?= $data['nama'] ?></td>
                            <td><?= date('d F Y', strtotime($data['tgl_permintaan'])) ?></td>
                            <td><?= $data['nama_barang'] ?></td>
                            <td><?= $data['jumlah'] ?></td>
                            <td><?= $data['keterangan'] ?></td>
                            <td>
                                <span class="badge <?= $data['status'] == 'proses' ? 'bg-warning' : 'bg-danger' ?>">
                                    <?= $data['status'] ?>
                                </span>
                            </td>
                            <td>
                                <?php if(session()->get('role') == 'admin') : ?>
                                    <?php if($data['status'] == 'proses') : ?>
                                        <button class="btn btn-success btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#modalKelolaPermintaan-<?= $data['id_permintaan'] ?>">Kelola</button>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                <?php else : ?>
                                    <?php if($data['status'] == 'ditolak') : ?>
                                        <button class="btn btn-warning btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#modalUlangPermintaan-<?= $data['id_permintaan'] ?>">Request Ulang</button>
                                        <button class="btn btn-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#modalHapusPermintaan-<?= $data['id_permintaan'] ?>">Hapus</button>
                                    <?php else : ?>
                                        <button class="btn btn-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#modalBatalPermintaan-<?= $data['id_permintaan'] ?>">Batal</button>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                        </tr>

                        <!-- MODAL ULANG PERMINTAAN -->
                        <div class="modal fade" id="modalUlangPermintaan-<?= $data['id_permintaan'] ?>" tabindex="-1" aria-labelledby="modalUlangPermintaanLabel" aria-hidden="true">
                            <div class="modal-dialog modal-sm modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-warning text-light">
                                        <h5 class="modal-title" id="modalUlangPermintaanLabel">Request Ulang</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="<?= base_url('/permintaan-ulang'.'/'.$data['id_permintaan']); ?>" method="POST">
                                        <div class="modal-body text-center">
                                            <p class="mb-0"><strong><?= $data['id_permintaan'] ?></strong></p>
                                            <input type="hidden" name='jumlah' value="<?= $data['jumlah'] ?>">
                                            <input type="hidden" name='id_barang' value="<?= $data['id_barang'] ?>">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-transparent" data-bs-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-warning">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- MODAL BATAL PERMINTAAN -->
                        <div class="modal fade" id="modalBatalPermintaan-<?= $data['id_permintaan'] ?>" tabindex="-1" aria-labelledby="modalBatalPermintaanLabel" aria-hidden="true">
                            <div class="modal-dialog modal-sm modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger text-light">
                                        <h5 class="modal-title" id="modalBatalPermintaanLabel">Batalkan Request</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="<?= base_url('/permintaan-batal'.'/'.$data['id_permintaan']); ?>" method="POST">
                                        <div class="modal-body text-center">
                                            <p class="mb-0"><strong><?= $data['id_permintaan'] ?></strong></p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-transparent" data-bs-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-danger">Batalkan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- MODAL HAPUS PERMINTAAN -->
                        <div class="modal fade" id="modalHapusPermintaan-<?= $data['id_permintaan'] ?>" tabindex="-1" aria-labelledby="modalHapusPermintaanLabel" aria-hidden="true">
                            <div class="modal-dialog modal-sm modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger text-light">
                                        <h5 class="modal-title" id="modalHapusPermintaanLabel">Batalkan Request</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="<?= base_url('/permintaan-hapus'.'/'.$data['id_permintaan']); ?>" method="GET">
                                        <div class="modal-body text-center">
                                            <p class="mb-0"><strong><?= $data['id_permintaan'] ?></strong></p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-transparent" data-bs-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- MODAL KELOLA PERMINTAAN -->
                        <div class="modal fade" id="modalKelolaPermintaan-<?= $data['id_permintaan'] ?>" tabindex="-1" aria-labelledby="modalKelolaPermintaanLabel" aria-hidden="true">
                            <div class="modal-dialog modal-sm modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-success text-light">
                                        <h5 class="modal-title" id="modalKelolaPermintaanLabel">Kelola Permintaan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="<?= base_url('/permintaan-kelola'.'/'.$data['id_permintaan']); ?>" method="POST">
                                        <div class="modal-body text-center">
                                            <p class="mb-2"><strong><?= $data['id_permintaan'] ?></strong></p>
                                            <input type="hidden" name='jumlah' value="<?= $data['jumlah'] ?>">
                                            <input type="hidden" name='id_barang' value="<?= $data['id_barang'] ?>">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" value='tolak' name="status_selected" id="status_selected1" checked>
                                                <label class="form-check-label text-danger" for="status_selected1">
                                                    Tolak
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" value='terima' name="status_selected" id="status_selected2">
                                                <label class="form-check-label text-success" for="status_selected2">
                                                    Terima
                                                </label>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-transparent" data-bs-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-success">Submit</button>
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

    <!-- Modal Tambah Request -->
    <div class="modal fade" id="modalTambahRequest" aria-labelledby="modalTambahRequestLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahKategoriLabel">Request Permintaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url('/permintaan-tambah') ?>" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="basic-usage" class="form-label">Pilih Barang</label>
                            <select class="form-select" id="basic-usage" name="id_barang" data-placeholder="Pilih" onchange="setMaxSum()" required>
                                <option></option>
                                <?php foreach($data_barang as $data) : ?>
                                    <option value="<?= $data['id_barang'] ?>" id='<?= $data['qty_barang'] ?>'><span class="text-capitalize"><?= $data['nama_barang'] ?> (<?= $data['qty_barang'] ?>)</span></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Jumlah</label>
                            <input type="number" class="form-control" id="jumlah" name="jumlah" min="1" max="1" value="1" placeholder="" required>
                        </div>

                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control" id="keterangan" rows="3" name="keterangan" placeholder="Untuk apa?" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-transparent" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Request</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>