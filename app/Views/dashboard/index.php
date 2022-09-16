<?= $this->extend('layout\dashboard_template') ?>

<?= $this->section('content') ?>
    <div class="container-fluid px-4">
        <h1 class="mt-4 mb-4"><?= $title ?></h1>

        <div class="row">
            <div class="col-lg-3 mb-2">
                <div class="card">
                    <div class="card-body text-center">
                        <h5>Total Barang</h5>
                        <h3>12</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 mb-2">
                <div class="card">
                    <div class="card-body text-center">
                        <h5>Total Karyawan</h5>
                        <h3>12</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 mb-2">
                <div class="card">
                    <div class="card-body text-center">
                        <h5>Barang Dipinjam</h5>
                        <h3>12</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 mb-2">
                <div class="card">
                    <div class="card-body text-center">
                        <h5>Barang Kembali</h5>
                        <h3>12</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-lg-12">
                <canvas id="myChart" width="400" height="150"></canvas>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>