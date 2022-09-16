<?= $this->extend('layout\dashboard_template') ?>

<?= $this->section('content') ?>
    <div class="container-fluid px-4">
        <div class="row mt-4 mb-4">
            <div class="col-lg-12">
                <h1><?= $title ?></h1>
            </div>
            <div class="col-lg-6 mt-3">
                <ul class="list-group">
                    <?php foreach($data_activity as $data) : ?>
                    <li class="list-group-item">
                        <p class="mb-0"><strong>Keterangan:</strong> <?= $data['keterangan_aktivitas'] ?></p>
                        <p class="mb-0"><strong>Tanggal:</strong> <?= date('d F Y H:i A', strtotime($data['tgl_aktivitas'])) ?></p>
                    </li>
                    <?php endforeach ?>
                </ul>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>