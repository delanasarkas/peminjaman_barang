<?= $this->extend('layout\dashboard_template') ?>

<?= $this->section('content') ?>
    <?php if(session()->get('role') != 'teknisi') : ?>
    <style>
        .card-click {
            cursor: pointer;
        }

        .card-click:hover {
            background-color: #f0f0f0;
        }
    </style>
    <div class="container-fluid px-4">
        <h1 class="mt-4 mb-4"><?= $title ?></h1>

        <div class="row">
            <div class="col-lg-3 mb-2">
                <div class="card card-click" onclick="viewGrafik('karyawan')">
                    <div class="card-body text-center">
                        <h5>Total Teknisi</h5>
                        <h3><?= $count_teknisi ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 mb-2">
                <div class="card card-click" onclick="viewGrafik('barang')">
                    <div class="card-body text-center">
                        <h5>Total Barang</h5>
                        <h3><?= $count_barang; ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 mb-2">
                <div class="card card-click" onclick="viewGrafik('peminjaman')">
                    <div class="card-body text-center">
                        <h5>Peminjaman</h5>
                        <h3><?= $count_dipinjam; ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 mb-2">
                <div class="card card-click" onclick="viewGrafik('peminjaman')">
                    <div class="card-body text-center">
                        <h5>Selesai</h5>
                        <h3><?= $count_dikembalikan; ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-lg-12" id="grafik_peminjaman">
                <h5>Grafik Peminjaman & Selesai Hari ini</h5>
                <canvas id="chart_peminjaman" width="400" height="150"></canvas>
            </div>
            <div class="col-lg-12 d-none" id="grafik_karyawan">
                <h5>Grafik Teknisi Pinjam Barang</h5>
                <canvas id="chart_karyawan" width="400" height="150"></canvas>
            </div>
            <div class="col-lg-12 d-none" id="grafik_barang">
                <h5>Grafik Barang Berdasarkan Qty</h5>
                <canvas id="chart_barang" width="400" height="150"></canvas>
            </div>
        </div>
    </div>

    <script>
        function viewGrafik(type) {
            if(type == 'karyawan') {
                $('#grafik_peminjaman').addClass('d-none');
                $('#grafik_barang').addClass('d-none');
                $('#grafik_karyawan').removeClass('d-none');
                $('#grafik_karyawan').addClass('d-none');
            } else if(type == 'barang') {
                $('#grafik_peminjaman').addClass('d-none');
                $('#grafik_karyawan').addClass('d-none');
                $('#grafik_barang').removeClass('d-none');
            } else {
                $('#grafik_karyawan').addClass('d-none');
                $('#grafik_barang').addClass('d-none');
                $('#grafik_peminjaman').removeClass('d-none');
            }
        }
    </script>
    <?php else : ?>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4">
                <span id='time_users'></span>, 
                <span class="text-capitalize"><?= session()->get('nama') ?></span>
            </h1>
            <hr/>
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="text-start">List Barang</h3>
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Nama Barang</th>
                                <th>Deskripsi</th>
                                <th>Qty</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach($barang_list as $data) : ?>
                            <tr>
                                <td class="text-center"><?= $i++; ?></td>
                                <td><?= $data['nama_barang'] ?></td>
                                <td><?= $data['deskripsi_barang'] ?></td>
                                <td><?= $data['qty_barang'] ?></td>
                                <td>
                                    <?php if($data['qty_barang'] > 0) : ?>
                                        <span class="badge bg-success">
                                            Tersedia
                                        </span>
                                    <?php else : ?>
                                        <span class="badge bg-danger">
                                            Tidak tersedia
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($data['qty_barang'] > 0) : ?>
                                    <button class="btn btn-warning btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#modalRequestPermintaan-<?= $data['id_barang'] ?>">Request</button>
                                    <?php else : ?>
                                        -
                                    <?php endif; ?>
                                </td>
                            </tr>

                            <!-- Modal Request Pinjaman -->
                            <div class="modal fade" id="modalRequestPermintaan-<?= $data['id_barang'] ?>" tabindex="-1" aria-labelledby="modalRequestPermintaanLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalRequestPermintaanLabel">Request Permintaan Barang</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="<?= base_url('/permintaan-by-id') ?>" method="POST">
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="nama_barang" class="form-label">Nama Barang</label>
                                                    <input type="text" class="form-control" id="nama_barang" value="<?= $data['nama_barang'] ?>" name="nama_barang" placeholder="" readonly required>
                                                    <input type="hidden" class="form-control" id="id_barang" value="<?= $data['id_barang'] ?>" name="id_barang" placeholder="" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="jumlah" class="form-label">Jumlah</label>
                                                    <input type="number" class="form-control" id="jumlah" min="1" max="<?= $data['qty_barang'] ?>" value="1" name="jumlah" placeholder="" required>
                                                    <input type="hidden" class="form-control" id="jumlah_asli" value="<?= $data['qty_barang'] ?>" name="jumlah_asli" placeholder="" required>
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
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?= $this->endSection() ?>