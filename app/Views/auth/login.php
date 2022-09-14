<?= $this->extend('layout\login_template') ?>

<?= $this->section('content') ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-4">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <?php if(session()->get('error')) : ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= session()->get('error') ?>
                        <a href="javascript:void(0)" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></a>
                    </div>
                    <?php endif; ?>
                    <div class="card-header text-center">
                        <img src="<?= base_url('/assets/img/logo.jpg') ?>" alt="logo">
                        <h5>Sistem Peminjaman Barang</h5>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?= base_url('/login/submit'); ?>">
                            <div class="form-floating mb-3">
                                <input class="form-control" id="inputEmail" type="email" name="email" placeholder="name@example.com" />
                                <label for="inputEmail">Email address</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" id="password" type="password" name="password" placeholder="Password" />
                                <label for="password">Password</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="showPassword">
                                <label class="form-check-label" for="showPassword">
                                    Show Password
                                </label>
                            </div>
                            <div class="d-grid gap-2 mt-3">
                                <button class="btn btn-dark" type="submit">Login</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center py-3">
                        <div class="text-muted">Copyright &copy; 2022</div>
                        <div class="text-muted">PT.Surya Kontruksindo Utama</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>