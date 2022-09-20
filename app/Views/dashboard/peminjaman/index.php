<?= $this->extend('layout\dashboard_template') ?>

<?= $this->section('content') ?>
    <div class="container-fluid px-4">
        <div class="row mt-4 mb-4">
            <div class="col-lg-12">
                <h1><?= $title ?></h1>
            </div>
            <div class="col-lg-12 mt-3">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Kode Permintaan</th>
                            <th>Teknisi</th>
                            <th>Barang</th>
                            <th>Diterima</th>
                            <th>Dialihkan</th>
                            <th>Dikembalikan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach($peminjaman_list as $data) : ?>
                        <tr>
                            <td class="text-center"><?= $i++; ?></td>
                            <td>
                                <?= $data['id_permintaan'] ?>
                            </td>
                            <td><?= $data['nama'] ?></td>
                            <td><?= $data['nama_barang'] ?> (<?= $data['jumlah'] ?>)</td>
                            <td><?= date('d F Y', strtotime($data['tgl_diterima'])) ?></td>
                            <td><?= $data['tgl_dialihkan'] != null ? date('d F Y', strtotime($data['tgl_dialihkan'])) : '-' ?></td>
                            <td><?= $data['tgl_dikembalikan'] != null ? date('d F Y', strtotime($data['tgl_dikembalikan'])) : '-' ?></td>
                            <td>
                                <?php
                                    $bgBadge;

                                    if($data['status'] == 'diterima') {
                                        $bgBadge = 'bg-success';
                                    } else if($data['status'] == 'proses dialihkan') {
                                        $bgBadge = 'bg-secondary';
                                    } else if($data['status'] == 'dialihkan') {
                                        $bgBadge = 'bg-info';
                                    } else {
                                        $bgBadge = 'bg-danger';
                                    }
                                ?>
                                <span class="badge <?= $bgBadge ?>">
                                    <?= $data['status'] ?>
                                </span>
                                <?php foreach($data_all_users as $user) : ?>
                                    <?php if($user['id_users'] == $data['id_dialihkan']) : ?>
                                        <br/><span class="badge bg-dark">kepada <?= $user['nama'] ?></span>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </td>
                            <td>
                                <?php if($data['status'] == 'diterima' || $data['status'] == 'proses dialihkan' || $data['status'] == 'dialihkan' || $data['status'] == 'dialihkan' || $data['status'] == 'tolak dialihkan') : ?>
                                    <?php if(session()->get('role') == 'teknisi') : ?>
                                        <?php if($data['status'] == 'diterima' || $data['status'] == 'tolak dialihkan') : ?>
                                            <?php if($data['user'] == session()->get('id_users')) : ?>
                                                <button class="btn btn-warning btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#modalAlihkan-<?= $data['id_peminjaman'] ?>">Alihkan</button>
                                            <?php else : ?>
                                                -
                                            <?php endif; ?>
                                        <?php elseif($data['status'] != 'dialihkan') : ?>
                                            <button class="btn btn-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#modalBatal-<?= $data['id_peminjaman'] ?>">Batal</button>
                                        <?php else : ?>
                                            -
                                        <?php endif; ?>
                                    <?php else : ?>
                                        <?php if($data['status'] == 'proses dialihkan') : ?>
                                            <button class="btn btn-warning btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#modalKelolaPeminjaman-<?= $data['id_peminjaman'] ?>">Kelola</button>
                                        <?php elseif($data['status'] == 'diterima' || $data['status'] == 'tolak dialihkan') : ?>
                                            <button class="btn btn-success btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#modalSelesai-<?= $data['id_peminjaman'] ?>">Selesai</button>
                                        <?php else : ?>
                                            -
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php else : ?>
                                    -
                                <?php endif; ?>
                            </td>
                        </tr>

                        <!-- MODAL KELOLA PEMINJAMAN -->
                        <div class="modal fade modal-alihkan" id="modalKelolaPeminjaman-<?= $data['id_peminjaman'] ?>" tabindex="-1" aria-labelledby="modalKelolaPeminjamanLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalKelolaPeminjamanLabel">Kelola Pengalihan Peminjaman</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="<?= base_url('/peminjaman-kelola'.'/'.$data['id_peminjaman']); ?>" method="POST">
                                        <div class="modal-body text-center">
                                            <?php foreach($data_all_users as $user) : ?>
                                                <?php if($user['id_users'] == $data['id_dialihkan']) : ?>
                                                    <p class="mb-0">Peminjaman ingin di alihkan ke <strong><?= $user['nama'] ?></strong></p>
                                                <?php endif; ?>
                                            <?php endforeach; ?>

                                            <input type="hidden" name="id_permintaan" value="<?= $data['id_permintaan'] ?>">
                                            <input type="hidden" name="id_users" value="<?= $data['id_dialihkan'] ?>">

                                            <div class="form-check form-check-inline mt-2">
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

                        <!-- MODAL ALIHKAN -->
                        <div class="modal fade modalAlihkan" id="modalAlihkan-<?= $data['id_peminjaman'] ?>" aria-labelledby="modalAlihkanLabel">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalAlihkanLabel">Alihkan Pinjaman</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="<?= base_url('/peminjaman-alihkan'.'/'.$data['id_peminjaman']); ?>" method="POST">
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="basic-usage2" class="form-label">Pilih nama yang ingin di alihkan</label>
                                                <select class="form-select" name="id_users" data-placeholder="Pilih" required>
                                                    <option value="">Pilih</option>
                                                    <?php foreach($data_users as $data2) : ?>
                                                        <option value="<?= $data2['id_users'] ?>"><span class="text-capitalize"><?= $data2['nama'] ?></span></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <input type="hidden" name="id_permintaan" value="<?= $data['id_permintaan'] ?>">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-transparent" data-bs-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-warning">Oke, alihkan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- MODAL SELESAI -->
                        <div class="modal fade" id="modalSelesai-<?= $data['id_peminjaman'] ?>" tabindex="-1" aria-labelledby="modalSelesaiLabel" aria-hidden="true">
                            <div class="modal-dialog modal-sm modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-success text-light">
                                        <h5 class="modal-title" id="modalSelesaiLabel">Selesaikan Pinjaman</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="<?= base_url('/peminjaman-selesai'.'/'.$data['id_peminjaman']); ?>" method="POST">
                                        <div class="modal-body">
                                            <p>Selesaikan <strong><?= $data['id_permintaan'] ?></strong></p>
                                            <input type="hidden" name="id_permintaan" value="<?= $data['id_permintaan'] ?>">
                                            <input type="hidden" name="id_users" value="<?= $data['id_users'] ?>">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-transparent" data-bs-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-success">Selesaikan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- MODAL BATAL -->
                        <div class="modal fade" id="modalBatal-<?= $data['id_peminjaman'] ?>" tabindex="-1" aria-labelledby="modalBatalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-sm modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger text-light">
                                        <h5 class="modal-title" id="modalBatalLabel">Batalkan Pengalihan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="<?= base_url('peminjaman-batal'.'/'.$data['id_peminjaman']); ?>" method="POST">
                                        <div class="modal-body">
                                            <p>Batalkan Pengalihan <br/> <strong><?= $data['id_permintaan'] ?></strong>?</p>
                                            <input type="hidden" name="id_permintaan" value="<?= $data['id_permintaan'] ?>">
                                            <input type="hidden" name="id_users" value="<?= $data['id_users'] ?>">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-transparent" data-bs-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-danger">Batalkan</button>
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
<?= $this->endSection() ?>