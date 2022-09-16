<?= $this->extend('layout\dashboard_template') ?>

<?= $this->section('content') ?>
    <div class="container-fluid px-4">
        <div class="row mt-4 mb-4">
            <div class="col-12">
                <h1><?= $title ?></h1>
            </div>
            <div class="col-lg-12 mt-3">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Nama Karyawan</th>
                            <th>Keterangan</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach($data_activity as $data) : ?>
                        <tr>
                            <td class="text-center"><?= $i++; ?></td>
                            <td><?= $data['nama'] ?></td>
                            <td><?= $data['keterangan_aktivitas'] ?></td>
                            <td><?= date('d F Y H:i A', strtotime($data['tgl_aktivitas'])) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>